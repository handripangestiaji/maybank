<?php


class case_model extends CI_Model{
        
    function __construct(){
        parent::__construct();
    }
        
        
    function LoadCase($filter = array()){
        $this->load->model('account_model');
        $this->db->select("a.*, b.channel_id, b.post_stream_id, b.type");
        $this->db->from("`case` a inner join social_stream b on a.post_id = b.post_id");
        $this->db->where($filter);
        $this->db->order_by("created_at", "desc");
        $result = $this->db->get()->result();
        foreach($result as $eachrow){
            $user = $this->ReadAllUser(
                array("user_id" => $eachrow->created_by)
            );
            $eachrow->created_by = $user;
            $eachrow->assign_to = $this->ReadAllUser(
                array('user_id' => $eachrow->assign_to)  
            );
            $eachrow->content_products_id = $this->ReadAllProducts(
                array("id" => $eachrow->content_products_id)  
            );
            $eachrow->channel = $this->account_model->GetChannel(array(
                'channel_id' => $eachrow->channel_id
            ));
            if(count($eachrow->channel) > 0){
                $eachrow->channel = $eachrow->channel[0];
            }
            
            if($eachrow->solved_by)
                $eachrow->solved_by = $this->ReadAllUser(
                    array('user_id' => $eachrow->solved_by)  
                );
        }
        
        return $result;
    }
    
    
    function LoadAssign()
    {
        $this->db->where('created_by',$this->session->userdata('user_id'));
        $this->db->where('status','pending');
        return $this->db->get('case');
    }
    
    function LoadAssign1($filter = array())
    {
        $this->db->from("`case` a inner join social_stream b on a.post_id = b.post_id");
        $this->db->where($filter);
        $result = $this->db->get()->result();
        foreach($result as $eachrow){
            $user = $this->ReadAllUser(
                array("user_id" => $eachrow->created_by)
            );
            $eachrow->created_by = $user;
            $eachrow->assign_to = $this->ReadAllUser(
                array('user_id' => $eachrow->assign_to)  
            );
            $eachrow->content_products_id = $this->ReadAllProducts(
                array("id" => $eachrow->content_products_id)  
            );
        }
        return $result;
    }
    
    function CreateCase($case, $created_by){
        $related_conversation = $case['related_conversation'];
        $conv = explode(',', $related_conversation);
        $conv_type = explode(',', $case['related_conversation_type']);
        unset($case['related_conversation']);
        unset($case['related_conversation_type']);
        $case['related_conversation_count'] = count($conv);
        $this->db->trans_start();
        $this->db->insert('case', $case);
        $insert_id = $this->db->insert_id();
        if($related_conversation != ''){
            for($d = 0; $d< count($conv); $d++){
                if($conv[$d] != '' && $conv_type[$d] != 'facebook_conversation')
                    $this->db->insert('case_related_conversation',
                                array(
                                    "social_stream_id" => $conv[$d],
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "case_id" => $insert_id
                                ));
                else if($conv[$d] != '' && $conv_type[$d] == 'facebook_conversation'){
                     $this->db->insert('case_related_conversation',
                                array(
                                    "fb_conversation_detail_id" => $conv[$d],
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "case_id" => $insert_id
                                ));
                }
            }
        }
        $this->load->config('mail_config');
        $mail_provider = $this->config->item('mail_provider');
        $this->load->library('email', $mail_provider);
	$mail_from = $this->config->item('mail_from');
        $this->email->initialize();
        $this->email->from($mail_from['address'], $mail_from['name']);
        $this->email->cc($case['email']);
        $this->email->bcc($mail_from['cc']);
        $user = $this->ReadAllUser(
            array(
                "user_id" => $case['assign_to']
            )
        );
        $user = is_array($user) && count($user) > 0 ? $user[0] : $user;
        if($case['email'])
            $this->email->to($case['email']);
        
        if($user)
            $this->email->to($user->email);
        
        $email_separated = explode(',', $case['email']);
        
        foreach($email_separated as $email){
            $user_assign_detail = $this->ReadAllUser(
                array(
                    "email" => $email
                )
            );
            if($user_assign_detail != null && is_array($user_assign_detail))
                $user_assign_detail = count($user_assign_detail) > 0 ? $user_assign_detail[0] : null;
                
            $assign_detail_case = array(
                'case_id' => $insert_id,
                'type' => 'user',
                'email' => $email,
                'user_id' => isset($user_assign_detail->user_id) ? $user_assign_detail->user_id : null,
                'is_group_assign' => false
            );
            $email_store = array(
                'email' => $email,
                'created_at' => date("Y-m-d H:i:s")
            );
            
            $this->db->insert('case_assign_detail', $assign_detail_case);
            $this->db->insert('email_store', $email_store);
            
        }
        
        $solved_case = $this->LoadCase(array('case_id' => $insert_id));
        if(count($solved_case) > 0){
            $this->load->model('account_model');
            $solved_case = $solved_case[0];
            $channel_action = array(
                'action_type' => "case_created",
                'channel_id' => $solved_case->channel_id,
                'created_at' => date("Y-m-d H:i:s"),
                'post_id' => $solved_case->post_id,
                'created_by' => $created_by,
                'case_id' => $insert_id
            );
            $solved_case->action_id = $this->account_model->CreateChannelAction($channel_action);
        }
        $this->db->trans_complete();
        $content_email = curl_get_file_contents(site_url('mail_template/AssignCase/newcase/'.$insert_id));
        $this->email->subject('Maybank DCMS Case #'.$insert_id);
        $this->email->message($content_email);
        $this->email->send();
        //print_r($this->email->print_debugger());
        return $insert_id;
    }
    
    
    function ReadAllUser($filter = array()){
        $filter['a.is_active'] = 1;
        if(count($filter) > 0){
            if(isset($filter['user_id']))
            {
                $filter['a.user_id'] = $filter['user_id'];
                unset($filter['user_id']);
            }
            if(isset($filter['country_code'] )){
                if($filter['country_code'] != null)
                    $filter['a.country_code'] = $filter['country_code'];
            }
            unset($filter['country_code']);
            $this->db->where($filter);
        }
        
        $this->db->select("*, a.country_code as user_country_code");
        $this->db->from("user a inner join user_group b on a.group_id = b.group_id inner join role_collection c on a.role_id = c.role_collection_id");
        $this->db->order_by('group_name','asc');
        $query_result = $this->db->get();
        if($query_result->num_rows() > 1){
            $result = $query_result->result();
            foreach($result as $row){
                $this->db->select("b.app_role_id, b.role_friendly_name, b.role_group");
                $this->db->from("role_collection_detail a inner join application_role b on a.app_role_id = b.app_role_id");
                $this->db->where("a.role_collection_id", $row->role_id);
                $row->role_detail = $this->db->get()->result();
            }
            return $result;
        }
        else
            return $query_result->row();
    }
    
    function ReadAllProducts($filter = array()){
        if(count($filter) > 0){
            $this->db->where($filter);
        }
        $this->db->select("*");
        $this->db->from("content_products");
        $query_result = $this->db->get();
        if($query_result->num_rows() > 1)
            return $query_result->result();
        else
            return $query_result->row();
    }
    
    function GetReplyNotification($user_id){
        $this->db->select("*");
        $this->db->from("social_stream_notification a inner join social_stream b on a.social_stream_post_id = b.post_id");
        $this->db->where("a.user_id", $user_id);
        $this->db->where("a.is_read", 0);
        return $this->db->get()->result();
    }
    
    function CaseRelatedConversationItems($filter){
        $this->load->model('facebook_model');
        $this->db->select('a.*,b.comment_content,c.name,d.type');
        $this->db->from("case_related_conversation a LEFT OUTER JOIN 
                         social_stream_fb_comments b ON b.id=a.social_stream_id LEFT OUTER JOIN
                         `fb_user_engaged` c ON c.facebook_id=b.from LEFT OUTER JOIN
                         social_stream d ON d.`post_id`=b.`id`");	
        if(count($filter) > 0){
            $this->db->where($filter);
        }
        $this->db->order_by('a.created_at');
    	$result= $this->db->get()->result();
        
        foreach($result as $row){
            $row->reletad = $this->facebook_model->RetriveCommentPostFb(array('a.post_id'=>$row->social_stream_id),array());
        }
        return $result;
    }

    function TwitterRelatedConversation($case_id){
        $this->db->select('b.*');
        $this->db->from("case_related_conversation a inner join social_stream b on a.social_stream_id = b.post_id");
        $this->db->where('a.case_id', $case_id);
        
        $result = $this->db->get()->result();
        
        foreach($result as $row){
            if($row->type == 'twitter'){
                $row->twitter_data = $this->twitter_model->ReadTwitterData(array('a.post_id' => $row->post_id));
            }
            else{
                $row->twitter_data = $this->twitter_model->ReadDMFromDb(array('a.post_id' => $row->post_id));
            }
        }
        return $result;
    }
        
    function FacebookRelatedConversation($case_id){
        $this->load->model('facebook_model');
        $this->db->select('b.*, a.fb_conversation_detail_id');
        $this->db->from("case_related_conversation a left join social_stream b on a.social_stream_id = b.post_id");
        $this->db->where('a.case_id', $case_id);
        $this->db->limit(100);
        $result = $this->db->get()->result();
        
        foreach($result as $row){
            if($row->fb_conversation_detail_id == null){
                if($row->type == 'facebook_conversation')
                    $row->facebook_data = $this->ReadSimpleConversation($row->post_id, "facebook_conversation_snippet");
                else if($row->type == 'facebook_comment')
                    $row->facebook_data = $this->ReadSimpleConversation($row->post_id, "facebook_comment");
                else
                    $row->facebook_data = $this->ReadSimpleConversation($row->post_id, "facebook");
            }
            else
                $row->facebook_data = $this->ReadSimpleConversation($row->fb_conversation_detail_id, "facebook_conversation");
                
            if(isset($row->facebook_data->attachment))
                $row->facebook_data->attachment = json_decode($row->facebook_data->attachment);
        }
        
        return $result;
    }
    
    function ReadSimpleConversation($post_id, $type){
        $table_loaded = "";
        $where = "";
        $limit = 100;
        if($type =='facebook_conversation'){
            $table_loaded = "social_stream_facebook_conversation_detail a inner join fb_user_engaged c on a.sender = c.facebook_id";
            $where = "a.detail_id = ".$post_id;
        }
        else if($type =='facebook_conversation_snippet'){
            $table_loaded = "social_stream_facebook_conversation_detail a inner join fb_user_engaged c on a.sender = c.facebook_id";
            $where = "a.conversation_id = ".$post_id;
            $limit = 1;
            $order_by = 'a.created_at';
        }
        else if($type == 'facebook'){
            $table_loaded = "social_stream_fb_post a inner join fb_user_engaged c on a.author_id = c.facebook_id";
            $where = "post_id = ".$post_id;
        }
        else if($type=='facebook_comment'){
            $table_loaded = "social_stream_fb_comments a inner join fb_user_engaged c on a.from = c.facebook_id ";
            $where = "id = ".$post_id;
        }
        else
            return null;
        
        $this->db->select("*");
        $this->db->from($table_loaded);
        $this->db->where($where);
        $this->db->limit($limit);
        if(isset($order_by))
            $this->db->order_by($order_by, 'desc');
        $row = $this->db->get()->row();
        
        return $row;
    }

    
    function FindFacebookRelatedConversation($facebook_id, $channel_id){
        $this->db->select("a.post_id as social_stream_post_id, post_content as content, b.created_at, attachment,b.type");
        $this->db->from("social_stream_fb_post a inner join social_stream b on a.post_id = b.post_id");
        $this->db->where(array(
           "author_id" => $facebook_id,
           "channel_id" => $channel_id
        ));
        $facebook_post = $this->db->get()->result();
        
        $this->db->select("id as social_stream_post_id, comment_content as content, b.created_at, attachment,b.type");
        $this->db->from("social_stream_fb_comments a inner join social_stream b on a.id = b.post_id");
        $this->db->where(array(
           "from" => $facebook_id,
           "channel_id" => $channel_id
        ));
        $facebook_comment = $this->db->get()->result();
        
        $this->db->select("detail_id as social_stream_post_id, messages as content, b.created_at, attachment, b.type");
        $this->db->from("social_stream_facebook_conversation_detail a inner join social_stream b on a.conversation_id = b.post_id");
        $this->db->where(array(
           "sender" => $facebook_id,
           "channel_id" => $channel_id
        ));

        $facebook_conversation = $this->db->get()->result();
        
        $related_conversation = array_merge($facebook_post, $facebook_comment, $facebook_conversation);
        $timezone = new DateTimeZone($this->session->userdata('timezone'));
        foreach($related_conversation as $conversation){
            $created_at = new DateTime($conversation->created_at." UTC", $timezone);
            $conversation->created_at = $created_at->format("d-M-Y h:i A");
        }
        
        return $related_conversation;
    }
    
    
    
    function ResolveCase($case_id, $solved_by,$solved_message, $is_solved = true){
        $this->db->where('case_id', $case_id);
        $this->db->update('case', array(
            'status' => $is_solved == true ? 'solved' : 'reassign',
            'solved_by' => $solved_by,
            'solved_message' => $solved_message,
            'solved_at' => date("Y-m-d H:i:s")
        ));
        $solved_case = $this->LoadCase(array('case_id' => $case_id));
        if(count($solved_case) > 0){
            $this->load->model('account_model');
            $solved_case = $solved_case[0];
            $channel_action = array(
                'action_type' => $is_solved == true ?  'solved' : 'reassign',
                'channel_id' => $solved_case->channel_id,
                'created_at' => date("Y-m-d H:i:s"),
                'post_id' => $solved_case->post_id,
                'created_by' => $solved_by,
                'case_id' => $case_id
            );
            $solved_case->action_id = $this->account_model->CreateChannelAction($channel_action);
            return $solved_case;
        }
        else
            return null;
    }
    
    function chackAssignCase($filter = array()){
        $this->db->select("`a`.*, `b`.`channel_id`, `b`.`post_stream_id`,`c`.`display_name`,c.full_name, `d`.`display_name` AS resolve_by, e.full_name AS `send_by`");
        $this->db->from("`case` a INNER JOIN social_stream b ON a.post_id = b.post_id LEFT OUTER JOIN `user` c ON c.user_id=a.assign_to LEFT OUTER JOIN `user` d ON d.user_id=a.solved_by LEFT OUTER JOIN `user` e ON e.user_id=a.created_by");
        $this->db->where($filter);
        $result = $this->db->get()->result();
        return $result;
    }
    
    
    function UpdateReadStatus($case_id, $status = 1){
        $this->db->where('case_id', $case_id);
        return $this->db->update('case',
                        array('read' => $status));
    }
    
    function chackCase($filter = array()){
        
        $this->db->select("*");
        $this->db->from("case");
        $this->db->where($filter);
        $result = $this->db->get()->result();
        return $result;
        
    }
    
    function reassign($post_id){
          $this->db->where('post_id', $post_id);
          $this->db->where('status', 'pending');
	      $this->db->update('case', array('status' => 'reassign',  'solved_at' => date("Y-m-d H:i:s")));   
    }
    
    
    function SearchUserByEmail($email, $country_code = null){
        $this->db->select('email, username, role_id, is_hidden');
        $this->db->from('user');
        $this->db->like('email', $email);
        $this->db->or_like('username', $email);
        if($country_code != null)
            $this->db->where('country_code', $country_code);
        $this->db->where('is_hidden', 0);
        $result = $this->db->get()->result();
        foreach($result as $row){
            $this->db->select("b.app_role_id, b.role_friendly_name, b.role_group");
            $this->db->from("role_collection_detail a inner join application_role b on a.app_role_id = b.app_role_id");
            $this->db->where("a.role_collection_id", $row->role_id);
            $row->role_detail = $this->db->get()->result();
        }
        return $result;
    }
}


?>
