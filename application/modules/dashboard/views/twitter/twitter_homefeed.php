<?php 
	if(is_array($twitter)):
?>
<?php
for($i=0;$i<count($twitter);$i++){
echo
'<li>
    <div class="circleAvatar"><img src="'.$twitter[$i]->user->profile_image_url.'" alt=""></div>
    <p class="headLine">
        <span class="author">'.$twitter[$i]->user->name.'</span>
        <i class="icon-circle"></i>
        <span>mentions</span>
        <i class="icon-circle"></i>
        <span>'.str_replace('+0000','',$twitter[$i]->created_at).'</span>
        <i class="icon-play-circle moreOptions pull-right"></i>
    </p>
    <p>'.$twitter[$i]->text.'</p>
    <p><button type="button" class="btn btn-warning btn-mini">OPEN</button></p>
    <p><a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-eye-open"></i> Engagement</a> | <a data-toggle="modal" role="button" href="#modalDialog"><i class="icon-retweet greyText"></i>'.$twitter[$i]->retweeted.' re-tweets</a></p>
    <h4 class="filled">
        <a role="button" href="#"><i class="icon-trash greyText"></i></a>
        <div class="pull-right">
            <button type="button" class="btn btn-primary"><i class="icon-mail-reply"></i></button>
            <button type="button" class="btn btn-primary"><i class="icon-retweet"></i></button>
            <button type="button" class="btn btn-primary"><i class="icon-envelope"></i></button>
            <button type="button" class="btn btn-primary"><i class="icon-star"></i></button>
            <button type="button" class="btn btn-primary"><i class="icon-user"></i></button>
            <button type="button" class="btn btn-danger"><i class="icon-plus"></i> CASE</button>
        </div>
        <br clear="all" />
    </h4>
    <div class="reply filled hide">
        <form class="contentForm">
            <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
            <textarea style="width: 95%;" rows="9" id="mailContent"></textarea>
            <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
    <div class="assign filled hide">
        <form class="contentForm">
             <div class="controlButton pull-right"><i class="icon-remove-sign hide-form"></i></div>
             <div class="control-group">
                <label class="control-label">Assign To</label>
                <div class="controls">
                    <select id="uniqueSelect">
                        <option id="opt1" value="opt1">John Doe</option>
                        <option id="opt2" value="opt2">May Bankette</option>
                        <option id="opt3" value="opt3">Jane Doyen</option>
                    </select>
                </div>
            </div>
            <div class="control-group last">
                <label class="control-label">Remarks <span class="label label-important">Not Public</span></label>
                <div class="controls">
                  <textarea class="span10"></textarea>
                </div>
            </div>
            <button style="clear: both;" type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</li>';
}
?>
<?php 
	else: 
		echo "<li>".$twitter->errors[0]->message."</li>";
?>
<?php endif;?>
