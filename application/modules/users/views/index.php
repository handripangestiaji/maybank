<div class="row-fluid" style="width: 80%; margin: 0px auto;">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn btn-primary" type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <div style="float: left;">
                <h5>User List</h5>
            </div>
            <div style="float: right;">
                <input class="btn btn-primary" onclick="btn_add()" type="button" name="btn_new" value="+ New User" />
            </div>
            
            <div style="clear: both"></div>
            <hr style="margin-top: 0px;">
            <div style="float: left; margin-top: -10px;">
                <table>
                    <tr>
                        <td>Show :</td>
                        <td>&nbsp;</td>
                        <td>
                            <select>
                                <option>All User Role</option>
                                <option>Super Admin</option>
                                <option>Administrator</option>
                                <option>Manager</option>
                                <option>Author</option>
                                <option>Viewer</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="float: right; margin-top: -10px;">
                <input type="text" placeholder="Search User name, Email or ID" />
            </div>
            <div style="clear: both"></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Group</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Creator</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01</td>
                        <td>User1</td>
                        <td>asd@gmail.com</td>
                        <td>Admin</td>
                        <td>all My</td>
                        <td>Active</td>
                        <td>18-11-2013</td>
                        <td>Azahan</td>
                        <td><a href="<?php echo site_url();?>users/edit"><span><i class="icon-pencil"></i></span></a></td>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>User1</td>
                        <td>asd@gmail.com</td>
                        <td>Admin</td>
                        <td>all My</td>
                        <td>Active</td>
                        <td>18-11-2013</td>
                        <td>Azahan</td>
                        <td><a href=""><span><i class="icon-pencil"></i></span></a></td>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>User1</td>
                        <td>asd@gmail.com</td>
                        <td>Admin</td>
                        <td>all My</td>
                        <td>Active</td>
                        <td>18-11-2013</td>
                        <td>Azahan</td>
                        <td><a href=""><span><i class="icon-pencil"></i></span></a></td>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>User1</td>
                        <td>asd@gmail.com</td>
                        <td>Admin</td>
                        <td>all My</td>
                        <td>Active</td>
                        <td>18-11-2013</td>
                        <td>Azahan</td>
                        <td><a href=""><span><i class="icon-pencil"></i></span></a></td>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>User1</td>
                        <td>asd@gmail.com</td>
                        <td>Admin</td>
                        <td>all My</td>
                        <td>Active</td>
                        <td>18-11-2013</td>
                        <td>Azahan</td>
                        <td><a href=""><span><i class="icon-pencil"></i></span></a></td>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>User1</td>
                        <td>asd@gmail.com</td>
                        <td>Admin</td>
                        <td>all My</td>
                        <td>Active</td>
                        <td>18-11-2013</td>
                        <td>Azahan</td>
                        <td><a href=""><span><i class="icon-pencil"></i></span></a></td>
                    </tr>
                </tbody>
            </table>
            <div class="page pull-right" style="margin-top: 30px;">
                <a href="#">First</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">Last</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function btn_add()
    {
        window.location.href = "<?php echo site_url();?>users/create";
    }
    
    function menu_role()
    {
        window.location.href = "<?php echo site_url();?>users/menu_role";
    }
</script>