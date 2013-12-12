<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class twitter_model extends CI_Model
{
    private $connection ;
    
   public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
        $this->load->library('Twitteroauth');
        $this->config->load('twitter');
                
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
            $this->CreateTwitterReplyNotification($tweet_to_save);
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
            
        }
        $this->db->trans_complete();
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
    
    public function ReadDMFromDb($filter,$limit){
         $this->db->select("a.channel_id, a.is_read, a.post_stream_id, a.retrieved_at, a.created_at,b.*,c.*");
         $this->db->from("social_stream a inner join twitter_direct_messages b on a.post_id = b.post_id LEFT OUTER JOIN twitter_user_engaged c ON c.twitter_user_id=b.sender left join `case` d on d.post_id = a.post_id"); 
         if(count($filter) > 0)
	     $this->db->where($filter);
         $this->db->limit($limit);           
         $this->db->order_by('a.created_at','desc');
         $result = $this->db->get()->result();
        
        for($i=0;$i<count($result);$i++){
            $result[$i]->sender = $this->ReadTwitterUserFromDb($result[$i]->sender);
        }
        return $result;
    }
    
    public function ReadTwitterUserFromDb($user_id){
        $this->db->select("*");
        $this->db->from("twitter_user_engaged");
        $this->db->where("twitter_user_id", $user_id);
        return $this->db->get()->row();
    }
    
    
    public function ReadTwitterData($filter,$limit){
        $this->db->select("a.channel_id, a.post_stream_id, a.retrieved_at, a.created_at as social_stream_created_at, a.type as social_stream_type, 
                            b.*, c.screen_name, c.profile_image_url, c.name, c.description, c.following, a.is_read, d.*,a.post_id, e.response_post_id");
        $this->db->from("social_stream a INNER JOIN social_stream_twitter b ON a.post_id = b.post_id 
                        INNER JOIN twitter_user_engaged c ON
                        c.twitter_user_id = b.twitter_user_id LEFT JOIN
                         `case` d on d.post_id = a.post_id LEFT JOIN `twitter_reply` e on e.reply_to_post_id = a.post_id");
        if(count($filter) > 0)
	    $this->db->where($filter);
        $this->db->limit($limit);
        $this->db->order_by('a.post_stream_id','desc ');           
        return $this->db->get()->result();
    }
    
    public function CountTwitterData($filter){
        $this->db->select("count(b.post_id) as count_post_id");
        $this->db->from("social_stream a INNER JOIN social_stream_twitter b ON a.post_id = b.post_id 
                        INNER JOIN twitter_user_engaged c ON
                        c.twitter_user_id = b.twitter_user_id left join `case` d on d.post_id = a.post_id");
        if(count($filter) > 0)
	    $this->db->where($filter);
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
    
    
    public function CreateReply($reply, $tweet_replied, $channel, $type = "twitter"){
        if(isset($tweet_replied->id_str)){
            $saved_tweet = $this->SaveTweets($tweet_replied, $channel, "user_timeline");
            if(isset($saved_tweet)){
                $reply['created_at'] = date("Y-m-d H:i:s");
                $reply['response_post_id'] = $saved_tweet[0]['post_id'];
                $this->db->insert('twitter_reply',$reply);
                return $this->db->insert_id();    
            }
            else{
                return null;
            }
        }
        return null;
        
    }
    
}
