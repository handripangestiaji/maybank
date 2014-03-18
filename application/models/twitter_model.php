<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class twitter_model extends CI_Model
{
    private $connection ;
    
   public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
        $this->load->library('Twitteroauth');
        $this->config->load('twitter');
        $this->load->model('case_model');
                
    }
    /*
    * Initialize connection properties
    * $access_secret : Twitter Access Secret
    * $access_token : Twitter Access Token
    *
    * return NULL
    */
    public function InitConnection($access_token, $access_secret){
        $this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'),$this->config->item('twitter_consumer_secret'),$access_token,$access_secret);
    }
    
    /*
    * Get Mentions from twitter directly based on channel defined (statused/mentions_timeline)
    * $channel = Current Channel
    **/
    public function Mentions($channel){
        $result = $this->connection->get('statuses/mentions_timeline',
                                         array("count" => 200));
       
        if(is_array($result)){
            foreach($result as $tweet){
                $this->SaveTwitterUsers($tweet->user);
                $mentions = $this->SaveTweets($tweet, $channel, "mentions");
                echo "<pre>";
                print_r($mentions);
                echo "</pre>";
            }
        }
    }
    
    
    public function OwnPost($channel){
        $result = $this->connection->get('statuses/user_timeline',
                    array(
                        "user_id" => $channel->social_id,
                        "count" => 200
                    ));
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        if(is_array($result)){
            foreach($result as $tweet){
                $this->SaveTwitterUsers($tweet->user);
                $this->SaveTweets($tweet, $channel, "user_timeline");
            }
        }
    }
    
    public function HomeFeed($channel){
        $result = $this->connection->get('statuses/home_timeline',
                    array(
                        "user_id" => $channel->social_id
                    ));
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        if(is_array($result)){
            foreach($result as $tweet){
                $this->SaveTwitterUsers($tweet->user);
                $this->SaveTweets($tweet, $channel, "home_feed");
            }
        }
    }
    
    public function DirectMessage($channel){
        $result = $this->connection->get('direct_messages',
                array(
                        "count" => 200
                ));
        $result2 = $this->connection->get('direct_messages/sent',
                array(
                        "count" => 200
                ));
        echo "<pre>";
        print_r($result2);
        echo "</pre>";
        if(is_array($result)){
            foreach($result as $dm){
                $this->SaveTwitterUsers($dm->sender);
                $this->SaveTwitterUsers($dm->recipient);
                $this->SaveDirectMessages($dm, $channel);
            }
        }
        if(is_array($result2)){
            foreach($result2 as $dm){
                $this->SaveTwitterUsers($dm->sender);
                $this->SaveTwitterUsers($dm->recipient);
                $this->SaveDirectMessages($dm, $channel);
            }
        }
        
    }
    
    
    /*
    * Saving each tweet retrieved from twitter
    * $tweet = Tweet Object
    * $channel = Current Channel
    * $come_from = mentions/home_feed/user_timeline
    */
    public function SaveTweets($tweet, $channel, $come_from = "mentions"){
        $this->db->trans_start();
        $timezone = new DateTimeZone("Europe/London");
        $created_at = new DateTime($tweet->created_at, $timezone);
        $retrieved_at = new DateTime(date("Y-m-d H:i:s e"), $timezone);
        $post_id = $this->GetTweetId($tweet->id_str, "twitter", $channel->channel_id, $come_from);
        $in_reply_to = $this->GetTweetId($tweet->in_reply_to_status_id_str, "twitter", $channel->channel_id);
        $social_stream = array(
	    "post_stream_id" => $tweet->id_str,
	    "channel_id" => $channel->channel_id,
	    "type" => "twitter",
	    "retrieved_at" => $retrieved_at->format("Y-m-d H:i:s"),
	    "created_at" => $created_at->format("Y-m-d H:i:s")
	);
        
        $tweet_to_save = array(
            "type" => $come_from,
            "retweeted" => $tweet->retweeted,
            "favorited" =>  $tweet->favorited,
            "in_reply_to" => $in_reply_to == null ? NULL : $in_reply_to->post_id,
            "twitter_entities" => $tweet->entities == "" ? "" : json_encode($tweet->entities),
            "text" =>htmlentities( $tweet->text, ENT_NOQUOTES, 'UTF-8'),
            "retweet_count" => $tweet->retweet_count,
            "geolocation" => json_encode($tweet->place),
            "source" => $tweet->source,
            "twitter_user_id" => $tweet->user->id_str,
            "is_following" => $tweet->user->following,
            "created_at" => $created_at->format("Y-m-d H:i:s")
        );
        
        if($post_id == null){
            $this->db->insert("social_stream", $social_stream);
            $post_id = $this->db->insert_id();
            $tweet_to_save['post_id'] = $post_id;
            $this->db->insert("social_stream_twitter", $tweet_to_save);
        }
        else{
            $this->db->where("post_id", $post_id->post_id);
            $this->db->update("social_stream", $social_stream);
            $this->db->where("post_id", $post_id->post_id);
            $this->db->update("social_stream_twitter", $tweet_to_save);
            $tweet_to_save['post_id'] = $post_id->post_id;
        }
        $this->db->trans_complete();
        return array($tweet_to_save, $social_stream);
    }
    
    public function CreateTwitterReplyNotification($tweet){
        $this->db->select("*");
        $this->db->from("twitter_reply");
        $this->db->where("response_post_id", $tweet['in_reply_to']);
        $result = $this->db->get()->result();
        //print_r($result);
        foreach($result as $row){
            $notification = array(
                "social_stream_post_id" => $tweet['post_id'],
                "is_read" => 0,
                "created_at" => date("Y-m-d H:i:s"),
                "read_at" => null,
                "user_id" => $row->user_id
            );
            $this->db->insert("social_stream_notification", $notification);
        }
    }
    
    public function SaveDirectMessages($direct_message, $channel){
        $timezone = new DateTimeZone("Europe/London");
        $created_at = new DateTime($direct_message->created_at, $timezone);
        $retrieved_at = new DateTime(date("Y-m-d H:i:s e"), $timezone);
        $this->db->trans_start();
        $post = $this->GetTweetId($direct_message->id_str, "twitter_dm", $channel->channel_id);
        
        $social_stream = array(
	    "post_stream_id" => $direct_message->id_str,
	    "channel_id" => $channel->channel_id,
	    "type" => "twitter_dm",
	    "retrieved_at" => $retrieved_at->format("Y-m-d H:i:s"),
	    "created_at" => $created_at->format("Y-m-d H:i:s")
	);
        $dm_saved = array(
            "entities" => json_encode($direct_message->entities),
            "text" => $direct_message->text,
            "sender" => $direct_message->sender_id,
            "recipient" => $direct_message->recipient_id,
            "type" => $direct_message->sender_id == $channel->social_id ? "outbox" : "inbox"
        );
        
        if($post == null){
            $this->db->insert("social_stream", $social_stream);
            $post = new stdClass();
            $dm_saved['post_id'] = $this->db->insert_id();
            $this->db->insert("twitter_direct_messages", $dm_saved);
        }
        else{
            $this->db->where('post_id', $post->post_id);
            $this->db->update("social_stream", $social_stream);
            $this->db->where('post_id', $post->post_id);
            $this->db->update("twitter_direct_messages", $dm_saved);
            $dm_saved['post_id'] = $post->post_id;
        }
        
        $this->db->trans_complete();
        return array($dm_saved, $social_stream);
    }
    
    public function SaveTwitterUsers($user){
        $timezone = new DateTimeZone("Europe/London");
        $created_at = new DateTime($user->created_at, $timezone);
        $retrieved_at = new DateTime(date("Y-m-d H:i:s e"), $timezone);
        $user_to_save = array(
            "twitter_user_id" => $user->id_str,
            "screen_name" => $user->screen_name,
            "profile_image_url" => $user->profile_image_url_https,
            "name" => $user->name,
            "url" => $user->url,
            "description" => $user->description,
            "location" => $user->location,
            "statuses_count" => $user->statuses_count,
            "friends_count" => $user->friends_count,
            "followers_count" => $user->followers_count,
            "verified_account" => $user->verified, 
            "time_zone" => $user->time_zone,
            "following" => $user->following,
            "created_at" => $created_at->format("Y-m-d H:i:s") ,
            "retrieved_at" => $retrieved_at->format("Y-m-d H:i:s")
        );
        
        if($this->GetTwitterUsers($user->id_str) == null){
            $this->db->insert("twitter_user_engaged", $user_to_save);
        }
        else{
            $this->db->where("twitter_user_id", $user->id_str);
            unset($user_to_save['twitter_user_id']);
            $this->db->update("twitter_user_engaged", $user_to_save);
        }
    }
    
    public function GetTwitterUsers($id){
        $this->db->select("twitter_user_id");
        $this->db->where("twitter_user_id", $id);
        $this->db->from("twitter_user_engaged");
        return $this->db->get()->row();
    }
    
    public function GetTweetId($post_stream_id, $type = "twitter", $channel_id, $detail_type = "mentions"){
        $this->db->select("a.post_id");
        $filter = array(
                    "post_stream_id" => $post_stream_id,
                    "a.type" => $type,
                    "channel_id" => $channel_id
             );
        if($type == "twitter"){
            $this->db->from("social_stream a left join social_stream_twitter b on a.post_id = b.post_id");
            $filter['b.type'] = $detail_type;
        }
        else{
            $this->db->from("social_stream a");
            
        }
        $this->db->where($filter);
        return $this->db->get()->row();
    }

    
    public function ReadTweetFromDb($channel_id, $type = "mentions"){
        $query = $this->db->query("call sp_ReadTweetFromDb(?,?)", array($channel_id, $type));
        
        return $query->result();
    }
    
    public function ReadDMFromDb($filter,$limit = false){
        $filter['b.type'] = 'inbox';
         $this->db->select("f.social_id, a.post_id as social_stream_post_id, a.channel_id, a.is_read, a.post_stream_id, a.retrieved_at, a.created_at as social_stream_created_at, b.text as dm_text, b.*,c.*, e.*, a.type as social_stream_type");
         $this->db->from("social_stream a inner join twitter_direct_messages b on a.post_id = b.post_id
            LEFT OUTER JOIN twitter_user_engaged c ON c.twitter_user_id=b.sender 
            LEFT JOIN twitter_reply e on a.post_id = e.reply_to_post_id  inner join channel f on f.channel_id = a.channel_id
            "); 
        if(count($filter) > 0)
        {
            if(isset($filter['case'])){
                unset($filter['case']);
                $this->db->where('a.post_id IN (SELECT `post_id` FROM `case`)', NULL, FALSE);
            }
	    $this->db->where($filter);
        }
        if($limit){
             $this->db->limit($limit);
        }
        
         $this->db->order_by('a.created_at','desc');
         $result = $this->db->get()->result();
        
        for($i=0;$i<count($result);$i++){
            $result[$i]->sender = $this->ReadTwitterUserFromDb($result[$i]->sender);
            $result[$i]->reply_post = $this->GetReplyPost(array('reply_to_post_id'=> $result[$i]->social_stream_post_id));
            $result[$i]->channel_action = $this->GetChannelAction(array('a.post_id'=>$result[$i]->social_stream_post_id));
            $result[$i]->case = $this->case_model->LoadCase(array('a.post_id'=>$result[$i]->social_stream_post_id));
        }
        return $result;
    }
    
    public function ReadTwitterUserFromDb($user_id){
        $this->db->select("*");
        $this->db->from("twitter_user_engaged");
        $this->db->where("twitter_user_id", $user_id);
        return $this->db->get()->row();
    }
    
    
    public function ReadTwitterData($filter,$limit = false){
        $this->db->select("e.social_id, a.channel_id, a.post_stream_id, a.retrieved_at, a.created_at as social_stream_created_at, a.type as social_stream_type, a.replied_count,
                            b.*, c.screen_name, c.profile_image_url, c.name, c.description, c.following, a.is_read, a.post_id as social_stream_post_id");
        $this->db->from("social_stream a INNER JOIN social_stream_twitter b ON a.post_id = b.post_id 
                        INNER JOIN twitter_user_engaged c ON
                        c.twitter_user_id = b.twitter_user_id INNER JOIN channel e on e.channel_id = a.channel_id");
        if(count($filter) > 0){
            if(isset($filter['case'])){
                unset($filter['case']);
                $this->db->where('a.post_id IN (SELECT `post_id` FROM `case`)', NULL, FALSE);
            }
            $this->db->where($filter);
        }
        if($limit){
            $this->db->limit($limit);
        }
        
        $this->db->order_by('a.post_stream_id','desc ');
        
        $result = $this->db->get()->result();
        
        foreach($result as $row){

            $row->reply_post = $this->GetReplyPost(array('reply_to_post_id'=> $row->social_stream_post_id));
            $row->channel_action = $this->GetChannelAction(array('a.post_id'=>$row->social_stream_post_id));
            $row->case = $this->case_model->LoadCase(array('a.post_id'=>$row->social_stream_post_id));
        }
        
        return $result;
    }
    
    public function CountTwitterData($filter){
        $this->db->select("count(b.post_id) as count_post_id");
        $this->db->from("social_stream a INNER JOIN social_stream_twitter b ON a.post_id = b.post_id 
                        INNER JOIN twitter_user_engaged c ON
                        c.twitter_user_id = b.twitter_user_id left join `case` d on d.post_id = a.post_id");
        if(count($filter) > 0){
            if(isset($filter['case'])){
                unset($filter['case']);
                $this->db->where('a.post_id IN (SELECT `post_id` FROM `case`)', NULL, FALSE);
            }
	    $this->db->where($filter);
        }
        $this->db->order_by('b.created_at','desc');           
        return $this->db->get()->result();
    }
    
    public function CountUnread(){
        $this->db->select("SELECT a.`type`, SUM(a.is_read)");
        $this->db->from("social_stream a INNER JOIN social_stream_twitter b ON a.post_id = b.post_id 
                        INNER JOIN twitter_user_engaged c ON
                        c.twitter_user_id = b.twitter_user_id left join `case` d on d.post_id = a.post_id");
        $this->db->group_by("a.type");
        return $this->db->get()->result();
    }
    
    
    public function CreateReply($reply, $tweet_replied, $channel, $type = "reply"){
        if(isset($tweet_replied->id_str)){
            $this->db->trans_start();
            if($type == 'reply')
                $saved_tweet = $this->SaveTweets($tweet_replied, $channel, "user_timeline");
            else
                $saved_tweet = $this->SaveDirectMessages($tweet_replied, $channel);
            if(isset($saved_tweet)){
                $reply['created_at'] = date("Y-m-d H:i:s");
                $reply['response_post_id'] = isset($saved_tweet[0]['post_id']) ? $saved_tweet[0]['post_id'] : $saved_tweet['post_id'];
                $channel_action = array(
                    'action_type' => "twitter_".$type,
                    'channel_id' => $channel->channel_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'post_id' => $reply['reply_to_post_id'],
                    'created_by' => $reply['user_id'],
                    'log_text' => $reply['text']
                );
                $this->db->insert('channel_action', $channel_action);
                $this->db->insert('twitter_reply',$reply);
                $insert_id = $this->db->insert_id();
                $this->db->where($saved_tweet[0]['post_id']);
                $this->db->query('call sp_SocialStreamUpdate(?)',$reply['reply_to_post_id']);
                
                $this->db->trans_complete();
                return $insert_id;    
            }
            else{
                $this->db->trans_complete();
                return null;
            }
        }

        return null;
    }
    
    /*
     * Create Following on Twitter Channel based on Twitter Post Object
     * $twitter_post:  post variable that inidicated from which post request was made. 
    */
    public function CreateFriends($twitter_post, $created_by, $is_removed = false){
        if($this->connection != null){
            $this->db->trans_start();
            $twitter_user_friends = array(
                'channel_id' => $twitter_post->channel_id,
                'twitter_user_id'=>$twitter_post->twitter_user_id,
                'is_following' => $is_removed ? 0 : 1
            );
            
            $channel_action = array(
                'action_type' => "twitter_".($is_removed ? 'unfollow' : 'follow'),
                'channel_id' => $twitter_post->channel_id,
                'created_at' => date("Y-m-d H:i:s"),
                'post_id' => $twitter_post->post_id,
                'created_by' => $created_by
            );
            $current_relation = $this->GetRelation($twitter_post->channel_id, $twitter_post->twitter_user_id);
            if(!$is_removed)
                $return = $this->connection->post('friendships/create', array('user_id' => $twitter_post->twitter_user_id));
            else
                $return = $this->connection->post('friendships/destroy', array('user_id' => $twitter_post->twitter_user_id));
            if($current_relation == null){
                $twitter_user_friends['is_follower'] = 0;
                $this->db->insert('twitter_user_relation', $twitter_user_friends);
                $twitter_user_friends['relation_id'] = $this->db->insert_id();
            }
            else{
                $this->db->where('relation_id', $current_relation->relation_id);
                $this->db->update('twitter_user_relation', $twitter_user_friends);
                $twitter_user_friends['is_follower'] = $current_relation->is_follower;
                $twitter_user_friends['relation_id'] = $current_relation->relation_id;
            }
            $twitter_user_friends['twitter_response'] = $return;
            $channel_action['stream_id_response'] = $return->id_str;
            $this->db->where('twitter_user_id', $twitter_post->twitter_user_id);
            $this->db->update('social_stream_twitter', array('is_following' => $is_removed ? 0 : 1));
            $this->db->trans_complete();
            return $twitter_user_friends;
        }
        else
            return null;
    }
    
    
    /*
     * Destroy Following on Twitter Channel based on Twitter Post Object. This action is commonly called 'Unfollow'
     * $twitter_post: post variable that inidicated from which post request was made. 
    */
    public function RemoveFriends($twitter_post, $created_by){
        if($this->connection != null){
            $return = $this->CreateFriends($twitter_post, $created_by, true);
            
            return $return;
        }
    }
    
    
    /*
     * Get existing relation based on twitter user id and channel
     *
     * $channel_id = CHANNEL ID from [CHANNEL] table
     * $twitter_user_id = USER ID from [twitter_user_enganged] table
    */
    public function GetRelation($channel_id, $twitter_user_id){
        $this->db->select('*');
        $this->db->from('twitter_user_relation');
        $this->db->where(array(
            'channel_id' => $channel_id,
            'twitter_user_id' => $twitter_user_id
        ));
        $this->db->get()->row();
    }
    
    /*
     * Logging all interaction from user to database
     * $action = Channel action object which is ready to store into database
    */
    function CreateChannelAction($action){
	$this->db->insert('channel_action',$action);
	return $this->db->insert_id();
    }
    
    /*
     * Get Action from database
    */
    function GetChannelAction($filter){
        $this->db->select("a.*, b.username, b.display_name, c.text, d.messages, d.assign_to, e.display_name as assign_name, f.display_name as solved_name, d.solved_message");
        $this->db->from("channel_action a INNER JOIN
			user b on b.user_id = a.created_by LEFT JOIN
			twitter_reply c on c.reply_to_post_id = a.post_id LEFT JOIN
			`case` d on d.case_id = a.case_id LEFT JOIN
			user e on e.user_id = d.assign_to LEFT JOIN
                        user f on f.user_id = d.solved_by");
        $this->db->order_by('a.created_at','desc');
        $this->db->where($filter);
        return $this->db->get()->result();
    }
    
    /*
     *Get Reply Post
    */
    function GetReplyPost($filter){
        $this->db->select('b.*, a.*');
        $this->db->from('twitter_reply a inner join user b on a.user_id = b.user_id');
        $this->db->where($filter);
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }
    
    function DeletePost($post_stream_id, $channel_id, $user_id, $status = 1){
        $this->db->trans_start();
        if($status == 1)
            $data = $this->ReadTwitterData(
                array('post_stream_id' => $post_stream_id)
            );
        else
            $data = $this->ReadDMFromDb(
                array('post_stream_id' => $post_stream_id)
            );
        
        $channel_action = array(
            'action_type' => "twitter_delete",
            'channel_id' => $channel_id,
            'created_at' => date("Y-m-d H:i:s"),
            'post_id' => NULL,
            'created_by' => $user_id,
            'log_text' => json_encode($data)
        );
        $this->db->insert('channel_action', $channel_action);
        $this->db->where(array(
            'post_stream_id' => $post_stream_id,
        ));        
        $return = $this->db->delete('social_stream');
        $this->db->trans_complete();
        return $return;
    }
    
    
}
