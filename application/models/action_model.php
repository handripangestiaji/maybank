<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author fitrazh
 * @copyright 2013
 */
 
 class action_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('basic');
    }
    
    
    /* Save LOG facebook and twitter
     * $user : parsed user object from feeds
     * $action_type, 
     * $channel_id, 
     * $created_at, 
     * $stream_id,
     * $stream_id_response,
     * $post_id,
     * $created_by
     */
    public function actionLog($action_type, $channel_id, $created_at, $stream_id,$stream_id_response,$post_id, $created_by)
    {
        $data = array(
           'action_type'=> $action_type,
           'channel_id'=> $channel_id,
           'created_at'=> $created_at,
           //'stream_id'=> $stream_id,
           'stream_id_response'=> $stream_id_response,
           'post_id'=> $post_id,
           'created_by'=> $created_by
        );
        $return=$this->db->insert('channel_action', $data); 
        return $return;
     }
    
     public function actionReplyLog($array){
     
        $data = array(
            'case_id'=>$case_id,
            'channel'=>$channel,
            'url'=>$url,
            'message'=>$message,
            //'stream_id'=>$stream_id,
            'comment_id'=>$comment_id,
            'conversation_detail_id'=>$conversation_detail_id,
            'type'=>$type,
            'post_at'=>$post_at,
            'created_at'=>$created_at
        );
        $return=$this->db->insert('page_reply', $data); 
        return $return;
    }
       
}



?>