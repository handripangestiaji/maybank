<div class="row-fluid" style="width: 100%; margin: 0px auto;">
    <div class="row-fluid" >
        <div class="pull-left">
            <input type="text" placeholder="Search" style="width:175px; float: left; margin-left: 2px;">
            <a href="" style="float: left; height: 14px;">
                <span class="add-on" style="background-color: black;color: white;margin-left: -1px; display: inline-block; white-space: nowrap; padding: 5px 6px; font-size: 14px;"><i class="icon-search"></i></span></a>
        </div>
        <div class="pull-right">
            <a href="<?php echo base_url('cms/create_short_url'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-code"></i> Create Short URL</button></a>
            <a href="<?php echo base_url('cms/create_campaign'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-bullhorn"></i> Create Campaign</button></a>
            <a href="<?php echo base_url('cms/create_product'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-gift"></i> Create Product</button></a>
            <a href="<?php echo base_url('cms/create_tag'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-tag"></i> Create Tag</button></a>
        </div>
    </div>
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <h5>Filter :</h5>
                <select>
                    <option value="user">Campaign</option>
                </select>
                <select>
                    <option value="user">Product</option>
                </select>
                <select>
                    <option value="user">Tag</option>
                </select>
        </div>
        <div class="cms-table pull-right">
            <?php
            	$data['campaigns'] = $campaigns ? $campaigns:'';
            	$data['products'] = $products ? $products:'';
            	$data['tags'] = $tags ? $tags:'';
            	$data['urls'] = $urls ? $urls:'';
                $this->load->view($cms_view, $data);
            ?>
        </div>
    </div>
</div>