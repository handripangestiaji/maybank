<!-- ==================== SIDEBAR COLLAPSED ==================== -->
<div id="collapsedSidebarContent">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent">
        <ul class="collapsedSidebarMenu">
            <li><a href="#tasksContent" class="sidebar">Tasks <div class="notifyCircle cyan">3</div><i class="icon-chevron-sign-right"></i></a></li>
            <li><a href="#profileContent" class="sidebar">Adrian Lee<i class="icon-chevron-sign-right"></i></a></li>
            <li class="sublevel"><a href="#">edit profile<i class="icon-user"></i></a></li>
            <li class="sublevel"><a href="#">change password<i class="icon-lock"></i></a></li>
            <li class="sublevel"><a href="#">logout<i class="icon-off"></i></a></li>
        </ul>
    </div>   
</div>
<!-- ==================== END OF SIDEBAR COLLAPSED ==================== -->

<!-- ==================== SIDEBAR TASKS ==================== -->
<div id="tasksContent">
    <div class="sidebarDivider"></div>
    <div class="sidebarContent">
        <div class="sidebarHead pull-left">
            <?php if(isset($count_new_cases)):?>
            <p class="title pull-left">NOTIFICATION&nbsp;<span class="badge">Total <?php echo $count_new_cases + $count_replies; ?></span></p>
            <?php endif;?>
        </div>
        <span class="btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        <br clear="all" />
        <div class="sidebarLine"></div>
        <div class="sidebarInfo">
            <?php if(isset($count_replies)):?>
            <div class="replies"><span class="badge cyan"><?php echo $count_replies; ?></span> Replies</div>
            <div class="newCases"><span class="badge purple"><?php echo $count_new_cases; ?></span> New Cases</div>
            <?php endif;?>
        </div>
        <div class="sidebarLine"></div>
        <ul class="tasksList">
            <li>
                <div class="notifHead purple">
                    CASE ID: #A123
                </div>
                <div class="notifBody">
                    Oct 11, 2013, 12:09 AM
                </div>
            </li>
            <li>
                <div class="notifHead cyan">
                    CASE ID: #A123
                </div>
                <div class="notifBody">
                    Oct 11, 2013, 12:09 AM
                </div>
            </li>
            <li>
                <div class="notifHead cyan">
                    CASE ID: #A123
                </div>
                <div class="notifBody">
                    Oct 11, 2013, 12:09 AM
                </div>
            </li>
            <li>
                <div class="notifHead purple">
                    CASE ID: #A123
                </div>
                <div class="notifBody">
                    Oct 11, 2013, 12:09 AM
                </div>
            </li>
            <li>
                <div class="notifHead purple">
                    CASE ID: #A123
                </div>
                <div class="notifBody">
                    Oct 11, 2013, 12:09 AM
                </div>
            </li>
            <li>
                <div class="notifHead cyan">
                    CASE ID: #A123
                </div>
                <div class="notifBody">
                    Oct 11, 2013, 12:09 AM
                </div>
            </li>
        </ul>
    </div>   
</div>
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
            <p>Email : <span class="cyanText"><?php echo $this->session->userdata('web_address'); ?></span></p>
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
<div id="updatePassword" class="hide">
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
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn sidebar-btn-cancel" type="button">Cancel</button>
            </form>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR UPDATE PASSWORD ==================== -->

<!-- ==================== SIDEBAR UPDATE PROFILE ==================== -->
<div id="updateProfile" class="hide">
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
            <form method='post' action='<?php echo site_url("users/update_user_login");?>'>
            <input type='hidden' value='<?php echo $this->session->userdata('user_id'); ?>' name='user_id' />
            <p><strong>Display Name</strong></p>
            <input type="text" name="display-name" value='<?php echo $this->session->userdata('display_name'); ?>'/>
            <p><strong>About Me</strong></p>
            <textarea class="about-me" name="about-me" placeholder="Compose Message"><?php echo $this->session->userdata('description'); ?></textarea>

            <div class="sidebarLine"></div>
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn sidebar-btn-cancel" type="button">Cancel</button>
            </form>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR UPDATE PROFILE ==================== -->

<script type="text/javascript">
    function logout()
    {
        window.location = "<?php echo site_url('users/logout');?>";
    }
</script>