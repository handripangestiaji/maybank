<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class youtube_model extends CI_Model
{
    
    function __construct(){
        $this->load->model("facebook_model");
        $this->load->model("case_model");
    }
    
    function SaveYouTubePost($post, $channel_id){
        if(!is_array($post)){
            $stream = $this->facebook_model->IsStreamIdExists($post->data->stream_id, "youtube_post");
            $created_at_date = new DateTime($post->data->uploaded);
            $social_stream_post = array(
                "post_stream_id" => $post->data->stream_id,
                "channel_id" => $channel_id,
                "type" => "youtube_post",
                "retrieved_at" => date("Y-m-d H:i:s"),
                "created_at" => $created_at_date->format("Y-m-d H:i:s")
            );            
            $social_stream_youtube = array(
                "title" => $post->data->title,
                "description" => $post->data->description,
                "category" => $post->data->category,
                "title" => $post->data->title,
                "thumbnail_default"  => $post->data->thumbnail->sqDefault,
                "thumbnail_high" => $post->data->thumbnail->hqDefault,
                "video_id" => $post->data->id,
                "player_web" => $post->data->player->default,
                "player_mobile" => $post->data->player->mobile,
                "rating" => isset($post->data->rating) ? $post->data->rating : 0,
                "rating_count" => isset($post->data->ratingCount) ? $post->data->ratingCount : 0,
                "favorite_count" => isset($post->data->favoriteCount) ? $post->data->favoriteCount : 0,
                "like_count" => isset($post->data->likeCount) ? $post->data->likeCount : 0,
                "view_count" => $post->data->viewCount,
                "comment_count" => $post->data->commentCount,
                "etag" => $post->data->etag
            );
            if($stream){
                $this->db->where('post_id', $stream->post_id);
                $this->db->update('social_stream', $social_stream_post);
                $this->db->where('post_id', $stream->post_id);
                $this->db->update('social_stream_youtube', $social_stream_youtube);
                
            }else{
                $this->db->insert("social_stream", $social_stream_post);
                $social_stream_youtube['post_id'] = $this->db->insert_id();
                $this->db->insert("social_stream_youtube", $social_stream_youtube);
            }
           
        }
    }
    function SaveYoutubeComment($comment_list, $channel_id){
        if(!is_array($comment_list)) return;
        foreach($comment_list as $comment){
            $this->db->trans_start();
            $stream = $this->facebook_model->IsStreamIdExists($comment->id, "youtube_comment");
            $created_at_date = new DateTime($comment->created_at);
            $social_stream_post = array(
                "post_stream_id" => $comment->id,
                "channel_id" => $channel_id,
                "type" => "youtube_comment",
                "retrieved_at" => date("Y-m-d H:i:s"),
                "created_at" => $created_at_date->format("Y-m-d H:i:s")
            );
            $youtube_post = $this->ReadYoutubePost(array(
               "video_id" => $comment->video_id 
            ));
            if(count($youtube_post) == 0)
                $this->db->rollback();
            else{
                $social_stream_youtube_comment = array(
                    "created_at" => $created_at_date->format("Y-m-d H:i:s"),
                    "google_user_id" => $comment->google_plus_user_id,
                    "title" => $comment->title,
                    "text" => $comment->content,
                    "name" => $comment->author_name,
                    "user_id" => $comment->user_id,
                    "video_id" => $comment->video_id,
                    "created_at" => $created_at_date->format("Y-m-d H:i:s"),
                    "youtube_post_id" => $youtube_post[0]->post_id
                );
            
                if($stream){
                    $this->db->where('post_id', $stream->post_id);
                    $this->db->update('social_stream', $social_stream_post);
                    $this->db->where('post_id', $stream->post_id);
                    $this->db->update('social_stream_youtube_comment', $social_stream_youtube_comment);
                }
                else{
                    $this->db->insert("social_stream", $social_stream_post);
                    $social_stream_youtube_comment['post_id'] = $this->db->insert_id();
                    $this->db->insert("social_stream_youtube_comment", $social_stream_youtube_comment);
                }
                $this->db->trans_complete();
            }
            
        }
        
    }
    
    function ReadYoutubePost($filter = array(), $page = 1){
        $this->db->select("a.*, b.*, a.post_id as social_stream_post_id, c.name as channel_name, c.oauth_secret");
        $this->db->from("social_stream_youtube b inner join social_stream a on a.post_id = b.post_id inner join channel c on c.channel_id = a.channel_id");
        if(isset($filter['channel_id'])){
            $filter['a.channel_id'] = $filter['channel_id'];
            unset($filter['channel_id']);    
        }
        $this->db->where($filter);
        $this->db->order_by('created_at', 'desc');
        
        $results = $this->db->get()->result();
        
        foreach($results as $result){
            $result->case = $this->case_model->LoadCase(
                array(
                    "a.post_id" => $result->social_stream_post_id
                )
            );
        }
        
        return $results;
    }
    
    function ReadYoutubeComment($filter = array(), $page = 1){
        $this->db->select("a.*, b.*, a.post_id as social_stream_post_id");
        $this->db->from("social_stream_youtube_comment b inner join social_stream a on a.post_id = b.post_id");
        if(isset($filter['channel_id'])){
            $filter['a.channel_id'] = $filter['channel_id'];
            unset($filter['channel_id']);    
        }
        $this->db->where($filter);
        $this->db->order_by('a.created_at', 'desc');
        
        $results = $this->db->get()->result();
        
        foreach($results as $result){
            $result->case = $this->case_model->LoadCase(
                array(
                    "a.post_id" => $result->social_stream_post_id
                )
            );
        }
        
        return $results;
    }
    
    
}