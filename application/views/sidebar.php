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
        <a href="#collapsedSidebarContent" class="showCollapsedSidebarMenu"><i class="icon-chevron-sign-left"></i><h1> Tasks</h1></a>
        <h1>Tasks</h1>
        <div class="sidebarInfo">
            <div class="progressTasks"><span class="label">11</span> tasks in progress</div>
            <div class="newTasks"><span class="label cyan">3</span> new tasks</div>
        </div>
        <ul class="tasksList">
            <li class="new">
                <h3>Facebook User 1 - Can I have my bank account details please?</h3>
                <div class="progress progress-striped active">
                  <div class="bar"></div>
                </div>
                <div class="appendedTags">
                    <div class="tag priority red">High priority</div>
                    <div class="tag status cyan">New task</div>
                </div>    
            </li>
            <li class="new">
                <h3>Twitter User 1 - Where to print my latest bank statement?</h3>
                <div class="progress progress-striped active">
                  <div class="bar"></div>
                </div>
                <div class="appendedTags">
                    <div class="tag priority orange">Normal priority</div>
                    <div class="tag status cyan">New task</div>
                </div>  
            </li> 
            <li class="new">
                <h3>Google + User - Do you have a branch in Kuching?</h3>
                <div class="progress progress-striped active">
                  <div class="bar"></div>
                </div>
                <div class="appendedTags">
                    <div class="tag priority green">Low priority</div>
                    <div class="tag status cyan">New task</div>
                </div> 
            </li> 
        </ul>
        <button class="btn btn-primary">View all</button>
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
                <div class="profileSettingBlock logout"><i class="icon-off"></i>logout</div>
            </footer>
        </div>
    </div>
</div>
<!-- ==================== END OF SIDEBAR PROFILE ==================== -->