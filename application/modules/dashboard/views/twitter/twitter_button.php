
<?php
    $allowed['home_feed']  = array("reply", "retweet", "favorite",  "direct_message" , "follow", "case");
    $allowed['mentions']  = array("reply", "retweet", "favorite", "direct_message","follow",  "case");
    $allowed['direct_messages']  = array("direct_message", "case");
    $allowed['user_timeline'] = array("favorite");
    
    $buttonItems= array(
        "reply" => '<button class="btn btn-reply btn-primary" data-toggle="modal" value="'.$post->social_stream_post_id. '"><i class="icon-mail-reply"></i></button> ',
        "retweet" => isset($post->retweeted) ? ($post->retweeted == 1 ? '<button type="button" class="retweet unretweet btn btn-inverse" value="'.$post->social_stream_post_id.'"><i class="icon-retweet"><span></span></i></button> ' :
                    '<button type="button" class="retweet btn btn-primary" value="'.$post->social_stream_post_id.'"><i class="icon-retweet"><span></span></i></button> ') : '',
        "direct_message" => '<button class="btn btn-dm btn-primary" data-toggle="modal"><i class="icon-envelope"></i></button> ',
    );
    
    if(count($post->case) == 0){
        $buttonItems['case'] = '<button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> <span>CASE</span></button> ';
    }
    else{
        if($post->case[0]->status == 'pending'){
            $buttonItems['case'] = 
            '<button type="button" class="btn btn-purple btn-resolve" name="action" value="'.
            $post->case[0]->case_id.'"><i class="icon-check"></i> <span>RESOLVE</span></button>
            <button type="button" class="btn btn-danger btn-case" name="action" value="reassign"><i class="icon-plus"></i>
            <span>ReAssign</span></button>';
        }
        else{
            $buttonItems['case'] = '<button type="button" class="btn btn-danger btn-case" name="action" value="new_case"><i class="icon-plus"></i> <span>Case</span></button> ';
        }
    }
    
    if($come_from != 'direct_messages'){
        $buttonItems['follow'] = $post->social_id != $post->twitter_user_id ?
                    ($post->is_following == 1 ? '<button type="button" class="follow unfollow btn btn-inverse"  value="'.$post->twitter_user_id.'"><i class="icon-user"></i><span></span></button> ' :
                     '<button type="button" class="follow btn"  value="'.$post->twitter_user_id.'"><i class="icon-user"></i><span></span></button> ')
                    : "";
        $buttonItems["favorite"] = $post->favorited == 1 ? '<button type="button" class="favorit unfavorit btn btn-inverse"><i class="icon-star">&nbsp;</i></button> ' :
                    '<button type="button" class="btn btn-primary favorit"><i class="icon-star">&nbsp;</i><span></span></button> ';
    }
    else{
        if($dm_type == 'outbox')
            $allowed['direct_messages'] = array();
    }
    
    
    if($this->session->userdata('country') == $post->country_code){
        if(isset($buttonItems['reply']))
            $buttonItems['reply'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Channel_General_Function_Own_Country_Reply',
                                                                                 'Social Stream_Channel_General_Function_All_Country_Reply')) ?
                                $buttonItems['reply'] : '';
        if(isset($buttonItems['direct_message']))
            $buttonItems['direct_message'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Channel_General_Function_Own_Country_Reply',
                                                                                 'Social Stream_Channel_General_Function_All_Country_Reply')) ?
                                $buttonItems['direct_message'] : '';
        if(isset($buttonItems['retweet']))
            $buttonItems['retweet'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Twitter_Own_Country_Retweet',
                                                                                 'Social Stream_Twitter_All_Country_Retweet')) ?
                                $buttonItems['retweet'] : '';
        if(isset($buttonItems['follow']))
            $buttonItems['follow'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Twitter_Own_Country_Follow',
                                                                                 'Social Stream_Twitter_All_Country_Follow')) ?
                                $buttonItems['follow'] : '';
        if(isset($buttonItems['favorite']))
            $buttonItems['favorite'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Twitter_Own_Country_Favorite',
                                                                                 'Social Stream_Twitter_All_Country_Favorite')) ?
                                $buttonItems['favorite'] : '';
        if(isset($buttonItems['case']))
            $buttonItems['case'] = IsRoleFriendlyNameExist($this->user_role, array ('Social Stream_Case_All_Country_AssignReassignResolved',
                                                                                'Social Stream_Case_Own_Country_AssignReassignResolved')) ?
                                $buttonItems['case'] : '';
    }
    else{
        if(isset($buttonItems['reply']))
            $buttonItems['reply'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_All_Country_Reply') ?
                            $buttonItems['reply'] : '';
        if(isset($buttonItems['direct_message']))
            $buttonItems['direct_message'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Channel_General_Function_All_Country_Reply') ?
                                $buttonItems['direct_message'] : '';
        if(isset($buttonItems['retweet']))
            $buttonItems['retweet'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Twitter_All_Country_Retweet') ?
                                $buttonItems['retweet'] : '';
        if(isset($buttonItems['case']))
            $buttonItems['case'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Case_All_Country_AssignReassignResolved') ?
                                $buttonItems['case'] : '';
        if(isset($buttonItems['follow']))                                
            $buttonItems['follow'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Twitter_All_Country_Follow') ?
                                $buttonItems['follow'] : '';
        if(isset($buttonItems['favorite']))
            $buttonItems['favorite'] = IsRoleFriendlyNameExist($this->user_role, 'Social Stream_Twitter_All_Country_Favorite') ?
                                $buttonItems['favorite'] : '';
    }
    
    foreach($allowed[$come_from] as $state)
    {
        echo $buttonItems[$state].' ';
    }
    
    
?>