<?php for($x=0;$x<count($this->user_role);$x++):
        if($this->user_role[$x]->role_friendly_name=='Social Channel Management_Add'):
?>
<div class="row-fluid" style="width: 80%; margin: 0px auto;" id="channelMg">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <a class="btn btn-primary" href="#facebook">Facebook</a>
            <a class="btn" href="#twitter">Twitter</a>
            <a class="btn" href="#youtube">YouTube</a>
            
        </div>
         <div class="cms-table pull-right">
         </div>
    </div>
</div>
<?php    
    if($this->input->get('FacebookConfirm') == 'yes' && $this->session->userdata('fb_token')):
        $fb_token = $this->session->userdata('fb_token');
        $account_manage = facebook_page_manage($fb_token);
?>
<div class="container-fluid">
    <div class="modal-backdrop fade in"></div>
    <div id="addFbStream" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Pick Page(s) to control.</h3>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label">Your Authenticated Account has <?=count($account_manage)?> page(s) to manage</label>
                <div class="controls">
                    <?php foreach($account_manage as $account):?>
                        <input id="chk_<?=$account->id?>" value="<?=$account->name?>" class="css-checkbox" type="checkbox"/>
                        <label for="chk_<?=$account->id?>" class="css-label"><?=$account->name?></label>
                    <?php endforeach;?>
                </div>
                <?php if(IsRoleFriendlyNameExist($this->user_role, 'Regional_User')):?>
                <label class="control-label">Select Country :</label>
                <select name="country">
                    <?php
                    $country_list = $this->users_model->get_country_list();
                        foreach($country_list as $country):
                    ?>
                        <option value="<?=$country->code?>"><?=$country->name?></option>
                    <?php endforeach;?>
                </select>
                <?php endif;?>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn" data-dismiss="modal" aria-hidden="true" onclick="window.reload()">Close</button>
            <button class="btn btn-inverse save-changes">Save changes</button>
        </div>
    </div>
</div>
<?php endif; endif;endfor?>