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
        <a href="#collapsedSidebarContent" class="showCollapsedSidebarMenu"><i class="icon-chevron-sign-left"></i><h1> Notification</h1></a>
        <div class="sidebarHead">
            <p class="title pull-left">NOTIFICATION&nbsp;<span class="notifTotal">Total 8</span></p>
        </div>
        <br clear="all" />
        <div class="sidebarLine"></div>
        <div class="sidebarInfo">
            <div class="replies"><span class="cyan">5</span> Replies</div>
            <div class="newCases"><span class="purple">3</span> New Cases</div>
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
        <a href="#collapsedSidebarContent" class="showCollapsedSidebarMenu"><i class="icon-chevron-sign-left"></i><h1> My account</h1></a>
        <h1>My account</h1>
        <div class="profileBlock">
            <div class="profilePhoto">
                <div class="usernameHolder">Adrian Lee</div>
            </div>
            <div class="profileInfo">
                <p><i class="icon-map-marker"></i> Piestany, SK</p>
                <p><i class="icon-envelope-alt"></i> ici.kamarel@tattek.com</p>
                <p><i class="icon-globe"></i> tattek.com</p>
                <p class="aboutMe">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
            <footer>
                <div class="profileSettingBlock editProfile"><i class="icon-user"></i>edit profile</div>
                <div class="profileSettingBlock changePassword"><i class="icon-lock"></i>change password</div>
                <div class="profileSettingBlock logout"><i class="icon-off" onclick="logout()"></i>logout</div>
            </footer>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR PROFILE ==================== -->
<script type="text/javascript">
    function logout()
    {
        window.location = "<?php echo site_url();?>/users/logout";
    }
</script>