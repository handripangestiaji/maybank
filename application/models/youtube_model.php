<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
class youtube_model extends CI_Model
{
    
    function __construct(){
        $this->load->model("facebook_model");
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
    
    
    
}