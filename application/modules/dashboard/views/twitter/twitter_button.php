
<?php
    $allowed['home_feed']  = array("reply", "retweet", "favorite",  "direct_message" , "follow", "case");
    $allowed['mentions']  = array("reply", "retweet", "favorite", "direct_message","follow",  "case");
    $allowed['direct_messages']  = array("direct_message", "follow", "case");
    $allowed['user_timeline'] = array("favorite");

    $buttonItems= array(
        "reply" => '<button class="btn btn-reply btn-primary" data-toggle="modal" value="'.$post->social_stream_post_id. '"><i class="icon-mail-reply"></i></button> ',
        "retweet" => $post->retweeted == 1 ? '<button type="button" class="retweet unretweet btn btn-inverse" value="'.$post->social_stream_post_id.'"><i class="icon-retweet"><span></span></i></button> ' :
                    '<button type="button" class="retweet btn btn-primary" value="'.$post->social_stream_post_id.'"><i class="icon-retweet"><span></span></i></button> ',
        "direct_message" => '<button class="btn btn-dm btn-primary" data-toggle="modal"><i class="icon-envelope"></i></button> ',
        "follow" => $post->social_id != $post->twitter_user_id ?
                    ($post->is_following == 1 ? '<button type="button" class="follow unfollow btn btn-inverse"  value="'.$post->twitter_user_id.'"><i class="icon-user"></i><span></span></button> ' :
                     '<button type="button" class="follow btn"  value="'.$post->twitter_user_id.'"><i class="icon-user"></i><span></span></button> ')
                    : "",
        "favorite" => $post->favorited == 1 ? '<button type="button" class="favorit unfavorit btn btn-inverse"><i class="icon-star">&nbsp;</i></button> ' :
                    '<button type="button" class="btn btn-primary favorit"><i class="icon-star">&nbsp;</i><span></span></button>     ',
        "case" => !$post->case_id ? '<button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> <span>CASE</span></button> ' :
                '<button type="button" class="btn btn-purple btn-resolve" name="action" value="'.$post->case_id.'"><i class="icon-check"></i> <span>RESOLVE</span></button> '
    );
    
    foreach($allowed[$come_from] as $state)
    {
        echo $buttonItems[$state];
    }
    
?>