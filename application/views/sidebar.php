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
            <p class="title pull-left">NOTIFICATION&nbsp;<span class="badge">Total <?php if(isset($count_new_cases)){echo ($count_new_cases + $count_replies);} else {echo 0;}?></span></p>
        </div>
        <span class="btn-close pull-right">Close <i class="icon-remove-sign"></i></span>
        <br clear="all" />
        <div class="sidebarLine"></div>
        <div class="sidebarInfo">
            <div class="replies"><span class="badge cyan"><?php if(isset($count_new_cases)){echo $count_replies;} else {echo 0;}?></span> Replies</div>
            <div class="newCases"><span class="badge purple"><?php if(isset($count_new_cases)){echo $count_new_cases;} else {echo 0;}?></span> New Cases</div>
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
         <div class="profilePhoto">
            <div class="usernameHolder">Ah Hong, Tew</div>
        </div>
        <div class="profileInfo">
            <p>User Id : 0008288</p>
            <p>Full Name : Ah Hong, Tew</p>
            <p>Display Name : Tew</p>
            <p>Role : Manager</p>
            <p>Email : <span class="cyanText">ahhong.tew@maybank.com.my</span></p>
            <br/>
            <p><strong>About Me</strong></p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </p>
            <br />
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
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
            <form method='post' action='<?php echo site_url();?>/users/update_password'>
            <p>Existing Password</p>
            <input type='password' style='width: 175px;' name='existing_password' />
            <p>New Password</p>
            <input type='password' style='width: 175px;' name='new_password' />
            <p>Confirm Password</p>
            <input type='password' style='width: 175px;' name='confirm_password' />
            </form>
            <div class="sidebarLine"></div>
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn sidebar-btn-cancel" type="button">Cancel</button>
            </div
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
            <p>User Id : 0008288</p>
            <p>Full Name : Ah Hong, Tew</p>
            <p>Display Name : Tew</p>
            <p>Role : Manager</p>
            <p>Email : <span class="cyanText">ahhong.tew@maybank.com.my</span></p>
            <br/>
            <p><strong>Display Name</strong></p>
            <input type="text" name="display-name"/>
            <p><strong>About Me</strong></p>
            <textarea class="about-me" name="about-me" placeholder="Compose Message"></textarea>
            Count: 500
            <div class="sidebarLine"></div>
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn sidebar-btn-cancel" type="button">Cancel</button>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR UPDATE PROFILE ==================== -->

<script type="text/javascript">
    function logout()
    {
        window.location = "<?php echo site_url();?>/users/logout";
    }
</script>