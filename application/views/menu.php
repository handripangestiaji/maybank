<div class="container-fluid">
    <ul class="nav">
        <li class="collapseMenu"><a href="#"><i class="icon-double-angle-left"></i>hide menu<i class="icon-double-angle-right deCollapse"></i></a></li>
        <li class="divider-vertical firstDivider"></li>
        <li class="left-side active" id="dashboard"><a href="index.html"><i class="icon-dashboard"></i> DASHBOARD</a></li>
        <li class="divider-vertical"></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="formElements"><i class="icon-list"></i> CHANNELS <span class="label label-pressed">4</span></a>
            <ul class="dropdown-menu">
                <li><a tabindex="-1" href="common-form.html">FACEBOOK</a></li>
                <li><a tabindex="-1" href="validation-form.html">YOUTUBE</a></li>
                <li><a tabindex="-1" href="form-wizard.html">TWITTER</a></li>
            </ul>
        </li>
        <li class="divider-vertical"></li>
        <li class="dropdown">
            <a href="#" id="interface"><i class="icon-pencil"></i> URL SHORTENER</a>
        </li>
        <?php if($this->_access_level == 1) { ?>
        <li class="divider-vertical"></li>
        <li class="dropdown">
            <a href="#" id="interface"><i class="icon-user"></i> MANAGE USERS</a>
        </li>
        <?php } ?>
        <li class="divider-vertical"></li>
        <li class="dropdown">
            <a href="#" id="interface"><i class="icon-building"></i> MANAGE CHANNELS</a>
        </li>
    </ul>
</div>