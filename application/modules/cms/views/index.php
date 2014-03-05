<?php
    if($this->session->flashdata('message_type')){
        if($this->session->flashdata('message_type') == 'success') {?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <strong>Success.</strong> <?php echo $this->session->flashdata('message_body'); ?>
    </div>
<?php } else { ?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <strong>Error.</strong> <?php echo $this->session->flashdata('message_body'); ?>
    </div>
<?php }
}?>
<div class="row-fluid" style="width: 100%; margin: 0px auto;">
    <div class="row-fluid" >
        <div class="pull-left">
            <!--input type="text" placeholder="Search" style="width:175px; float: left; margin-left: 2px;">
            <a href="" style="float: left; height: 14px;">
                <span class="add-on" style="background-color: black;color: white;margin-left: -1px; display: inline-block; white-space: nowrap; padding: 5px 6px; font-size: 14px;"><i class="icon-search"></i></span></a!-->
        </div>
        <div class="pull-right">
            
            <?php if(IsRoleFriendlyNameExist($this->user_role, 'Content Management_Short_URL_View')):?>
		<a href="<?php echo base_url('cms/create_short_url'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-code"></i> Create Short URL</button></a>
	    <?php endif;?>
            <?php if(IsRoleFriendlyNameExist($this->user_role, 'Content Management_Campaign_View')){?>
	    <a href="<?php echo base_url('cms/create_campaign'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-bullhorn"></i> Create Campaign</button></a>
            <?php } if(IsRoleFriendlyNameExist($this->user_role, 'Content Management_Product_View')){?>
            <a href="<?php echo base_url('cms/create_product'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-gift"></i> Create Product</button></a>
                <?php } if(IsRoleFriendlyNameExist($this->user_role, 'Content Management_TAG_View')):?>
            <a href="<?php echo base_url('cms/create_tag'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-tag"></i> Create Tag</button></a>
	    <?php endif;?>
            
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
            	$data['pagination'] = $pagination ? $pagination : '';
                $this->load->view($cms_view, $data);
            ?>
        </div>
    </div>
</div>