<?php 
	if($directmessage):
?>
<?php
    for($i=0;$i<count($directmessage);$i++){
    echo
    '<li>
        <div class="circleAvatar"><img src="'.$directmessage[$i]->sender->profile_image_url.'" alt=""></div>
        <p class="headLine">
            <span class="author">'.$directmessage[$i]->sender->name.'</span>
            <i class="icon-circle"></i>
            <span>mentions</span>
            <i class="icon-circle"></i>
            <span>'.str_replace('+0000','',$directmessage[$i]->created_at).'</span>
            <i class="icon-play-circle moreOptions pull-right"></i>
        </p>
        <p>'.$directmessage[$i]->text.'</p>
        <p><button type="button" class="btn btn-warning btn-mini">OPEN</button></p>
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
		echo $directmessage->errors[0]->message;
?>
<?php endif; ?>