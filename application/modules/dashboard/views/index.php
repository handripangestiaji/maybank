<!-- COMPOSE -->
<div class="row-fluid">
    <div style="width: 100%; height: 40px;">
        <div style="float:left;">
            <button type="button" style="float: left;"><i class="icon-rotate-right"></i></button>
            <input type="text" placeholder="Compose Message" style="width:400px; float: left; margin-left: 20px;">
            <button type="button" style="float: left;"><i class="icon-calendar"></i></button>
        </div>
        <div style="float:right;">
            <select style="width: 100px; float: left;">
                <option style="display:none">Type</option>
                <option value="user">User</option>
                <option value="keyword">Keyword</option>
            </select>
            <input type="text" placeholder="Search" style="width:200px; float: left; margin-left: 2px;">
            <a href="" style="float: left; height: 14px;">
                <span class="add-on" style="background-color: black;color: white;margin-left: -1px; display: inline-block; white-space: nowrap; padding: 5px 6px; font-size: 14px;"><i class="icon-search"></i></span></a>
        </div>
    </div>
</div>


<div class="row-fluid">
<?php
    echo $this->load->view('dashboard/facebook/facebook_stream');
    echo $this->load->view('dashboard/twitter/twitter_stream');
    echo $this->load->view('dashboard/youtube/youtube_stream');
?>
</div>