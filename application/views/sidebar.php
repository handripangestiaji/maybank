
<!-- ==================== SIDEBAR COLLAPSED ==================== -->
<div id="collapsedSidebarContent">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent">
        <ul class="collapsedSidebarMenu">
            <li><a href="#tasksContent" class="sidebar">Notification <div class="notifyCircle cyan"></div><i class="icon-chevron-sign-right"></i></a></li>
            <li><a href="#profileContent" class="sidebar"><?php echo $this->session->userdata('display_name'); ?><i class="icon-chevron-sign-right"></i></a></li>
            <!--
            <li class="sublevel"><a href="#">edit profile<i class="icon-user"></i></a></li>
            <li class="sublevel"><a href="#">change password<i class="icon-lock"></i></a></li>
            <li class="sublevel"><a href="#">logout<i class="icon-off"></i></a></li>
            !-->
        </ul>
    </div>   
</div>
<!-- ==================== END OF SIDEBAR COLLAPSED ==================== -->

<!-- ==================== SIDEBAR TASKS ==================== -->
<?php
if(IsRoleFriendlyNameExist($this->user_role, "Social Stream_Notification")):?>
<div id="tasksContent">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent" style="overflow-y: scroll;">
        <div class="sidebarHead pull-left">
            <?php
            /*print_r($case);*/ 
            if(isset($case)):?>
            <p class="title pull-left total-case">NOTIFICATION&nbsp;<span class="badge">Total </span></p>
            <?php endif;?>
        </div>
        <span class="btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        <br clear="all" />
        <div class="sidebarLine"></div>
        
        <div class="sidebarInfo">
            <?php if(isset($case)):?>
            <!--div class="replies"><span class="badge cyan"><?php echo count($reply_pending); ?></span> Replies</div-->
            <div class="newCases"><span class="badge purple"><?php echo count($case)+$count_assign; ?></span> New Cases</div>
            <?php endif;?>
        </div>
        <div class="sidebarLine"></div>
        <div class="task">
        <ul class="tasksList" style="height: 100%">
            <?php foreach($case as $each_case):
              $type = explode("_", $each_case->type);?>
            <li class="pointerCase" onclick="window.location='<?=base_url('dashboard/socialmedia').'#case/'.$type[0].'/'.$each_case->post_id?>'" >
                <input type="hidden" name="pointer" class="pointer-case" value="<?php echo $each_case->case_id?>" />
                
                <div class="notifHead <?=$each_case->read == 1 ? "purple" : "red"?>" >
                    CASE ID: #<?php echo $each_case->case_id?>
                </div>
                <div class="notifBody">
                    <?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date = new DateTime($each_case->created_at, $timezone);
                        echo $date->format("M d, Y, h:i A");
                    ?>
                </div>
            </li>
            <?php endforeach?>
            <?php foreach($reply_pending as $pending):?>
            <!--li>
                <div class="notifHead purple">
                    New Reply POST ID : #<?php echo $pending->id?>
                </div>
                <div class="notifBody">
                    <?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date = new DateTime($each_case->created_at, $timezone);
                        echo $date->format("M d, Y, h:i A");
                    ?>
                </div>
            </li-->
            <?php endforeach;?>
        </ul>
        <?php if($count_assign!=0){?>
        <ul class="tasksList" style="height: 100%">
            <?php foreach($assign1 as $each_case):?>
            <li class="pointerCase" >
                <input type="hidden" name="pointer" class="pointer-case" value="<?php echo $each_case->case_id?>" />
                <div class="notifHead <?=$each_case->read == 1 ? "purple" : "red"?>" onclick="window.location='<?=base_url('dashboard/socialmedia').'#case/'.$each_case->type.'/'.$each_case->post_id?>'">
                    CASE ID: #<?php echo $each_case->case_id?>
                </div>
                <div class="notifBody">
                    <?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date = new DateTime($each_case->created_at, $timezone);
                        echo $date->format("M d, Y, h:i A");
                        
                    ?>
                    <p><?=$each_case->messages?></p>
                </div>
            </li>
            <?php endforeach?>
            <?php foreach($reply_pending as $pending):?>
            <!--li>
                <div class="notifHead purple">
                    New Reply POST ID : #<?php echo $pending->id?>
                </div>
                <div class="notifBody">
                    <?php
                        $timezone = new DateTimeZone($this->session->userdata('timezone'));
                        $date = new DateTime($each_case->created_at, $timezone);
                        echo $date->format("M d, Y, h:i A");
                    ?>
                </div>
            </li-->
            <?php endforeach;?>
        </ul>
        <?php }?>
        </div>
    </div>  
</div>
<?php endif?>

<!-- ==================== END OF SIDEBAR TASKS ==================== -->

<!-- ==================== SIDEBAR PROFILE ==================== -->
<div id="profileContent">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent">
        <div class="sidebarHead pull-left">
            <p class="title pull-left">MY ACCOUNT</p>
            
        </div>
        <span class="btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        <br clear="all" />
        <div class="sidebarLine"></div>
        <div>
            <?php if(($this->session->userdata('image_url'))!= NULL) {?>
            <div><img src="<?php echo base_url().$this->session->userdata('image_url'); ?>" /></div>
            <?php }?>
        </div>
        <div class="profileInfo">
            <p>User Id : <?php echo $this->session->userdata('username'); ?></p>
            <p>Full Name : <?php echo $this->session->userdata('full_name'); ?></p>
            <p>Display Name : <?php echo $this->session->userdata('display_name'); ?></p>
            <p>Role : <?php echo $this->session->userdata('role_name'); ?></p>
            <p>Email : <span class="cyanText"><?php echo $this->session->userdata('email'); ?></span></p>
            <p>Timezone : <?php echo $this->session->userdata('timezone')?></p>
            <p>Country : <?php echo $this->session->userdata('country')?></p>
            <br/>
            <p><strong>About Me</strong></p>
            <p>
                <?php echo $this->session->userdata('description'); ?>
            </p>
        </div>
        <footer>
            <div class="profileSettingBlock updateProfile"><i class="icon-user"></i>edit profile</div>
            <div class="profileSettingBlock changePassword"><i class="icon-lock"></i>change password</div>
            <div class="profileSettingBlock logout"><i class="icon-off" onclick="logout()"></i>logout</div>
        </footer>
    </div>
</div>
<!-- ==================== END OF SIDEBAR PROFILE ==================== -->

<!-- ==================== SIDEBAR UPDATE PASSWORD ==================== -->
<div id="updatePassword">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent">
         <div class="sidebarHead pull-left">
            <p class="title pull-left">Update Password</p>
        </div>
        <span class="btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        <br clear="all" />
        <div class="profileInfo">
            <form method='post' action='<?php echo site_url("users/update_password");?>' class='update_password'>
            
            <div class="message"></div>
            <p>Existing Password</p>
            <input type='password' value='<?php echo set_value('exist');?>' style='width: 175px;' name='exist' />
            <span style="color:red" class="error-exist"><?php echo form_error('exist'); ?></span>
            
            <p>New Password</p>
            <input type='password' value='<?php echo set_value('pass');?>' style='width: 175px;' name='pass' />
            <span style="color:red" class="error-pass"><?php echo form_error('pass'); ?></span>
            
            <p>Confirm Password</p>
            <input type='password' value='<?php echo set_value('cpass');?>' style='width: 175px;' name='cpass' />
            <span style="color:red" class="error-cpass"><?php echo form_error('cpass'); ?></span>
            
            <div class="sidebarLine"></div>
            <button id='btn_update' class="btn btn-primary" type="submit">Save</button>
            <button id='' class="btn sidebar-btn-cancel" type="button">Cancel</button>
            </form>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR UPDATE PASSWORD ==================== -->

<!-- ==================== SIDEBAR UPDATE PROFILE ==================== -->
<div id="updateProfile">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent">
        <div class="sidebarHead pull-left">
            <p class="title pull-left">UPDATE PROFILE</p>
        </div>
        <span class="btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        <br clear="all" />
        <div class="sidebarLine"></div>
        <div class="profileInfo">
            <p>User Id : <?php echo $this->session->userdata('username'); ?></p>
            <p>Full Name : <?php echo $this->session->userdata('full_name'); ?></p>
            <!--<p>Display Name : <?php //echo $this->session->userdata('display_name'); ?></p>-->
            <p>Role : <?php echo $this->session->userdata('role_name'); ?></p>
            <p>Email : <span class="cyanText"><?php echo $this->session->userdata('web_address'); ?></span></p>
            <br/>
            <form method='post' action='<?php echo base_url("users/update_user_login");?>' class='update_profile'>
            
            <div class="yes_update"></div>
            
            <input type='hidden' value='<?php echo $this->session->userdata('user_id'); ?>' name='user_id'/>
            <p><strong>Display Name</strong></p>
            <input type="text" name="display-name" value='<?php echo $this->session->userdata('display_name'); ?>' style="width: 175px;" />
            <p><strong>Timezone</strong></p>
            <select name='timezone' class='timezone' style="width: 175px;">
                <?php
                    $timezone = get_timezone_list();
                    $value = array_keys($timezone);
                    foreach($value as $x)
                    {
                        if($x==$this->session->userdata('timezone')){
                ?>
                    <option selected='selected' value='<?php echo $x;?>'><?php echo $timezone[$x];?></option>
                <?php }
                    else
                    {
                ?>
                    <option value='<?php echo $x;?>'><?php echo $timezone[$x];?></option>
                <?php
                    }
                }?>
            </select>
            <p><strong>About Me</strong></p>
            <textarea class="about-me" name="about-me" placeholder="Compose Message"><?php echo $this->session->userdata('description'); ?></textarea>

            <div class="sidebarLine"></div>
            <input  class="btn btn-primary" type="submit" value="Save">
            <input class="btn sidebar-btn-cancel" type="button" value="Cancel">
            </form>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR UPDATE PROFILE ==================== -->
<style type='text/css'>
    #btn_update
    {
        margin-top: 0px;
    }
</style>
<script type="text/javascript">
    function logout()
    {
        window.location = "<?php echo site_url('users/logout');?>";
    }
</script>
