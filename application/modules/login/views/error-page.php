<?php



$header_words['404'] = 'Sorry, the URL doesn\'t exist.';
$content_words['404'] = 'The maybk.co domain is used to access web pages created by Maybank Group. We shorten our URLs not only for aesthetic purposes, but also to make them memorable and easily reproducible in all communications. ';
$header_words['500'] = "Internal Server Errors";
$content_words['500'] = 'There is something error on web server, please comeback later.  ';
?>
<div id="login_form" class="form-signin" style="max-width: 500px">
    <h1><?php echo $header_words[$heading]?></h1>
    <p><?php echo $content_words[$heading]?></p>
</div>

<div class="signInRow" style="max-width: 550px">
    <?php if(!$this->input->get('user_id')):?>
    <div style="float:left"><button class="btn-inverse btn" onclick="window.open('','_self').close()">Close Window</button></div>
    <?php else:?>
    <div style="float:left"><button class="btn-inverse btn" onclick="window.history.back()">Back</button></div>
    <?php endif?>
    <!--div class="term"><a href="<?php echo site_url('login/terms');?>">Terms of Use</a></div-->
</div>