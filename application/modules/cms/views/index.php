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
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <a href="<?php echo base_url('cms'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-building"></i> View Campaigns & URL</button></a>
	    <?php if((IsRoleFriendlyNameExist($this->user_role, 'Content Management_Short_URL_Own_Country_Create')) ||
		     (IsRoleFriendlyNameExist($this->user_role, 'Content Management_Short_URL_All_Country_Create'))):?>
	    <a href="<?php echo base_url('cms/create_short_url'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-code"></i> Create Short URL</button></a>
	    <?php endif;?>
            <?php if((IsRoleFriendlyNameExist($this->user_role, 'Content Management_Campaign_Own_Country_Create')) ||
		     (IsRoleFriendlyNameExist($this->user_role, 'Content Management_Campaign_All_Country_Create'))):?>
	    <a href="<?php echo base_url('cms/create_campaign'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-bullhorn"></i> Create Campaign</button></a>
            <?php endif;?>
            <?php if((IsRoleFriendlyNameExist($this->user_role, 'Content Management_Product_All_Country_View'))) :?>
	    <a href="<?php echo base_url('cms/create_product'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-gift"></i> Product</button></a>
            <?php endif;?>
            <?php if((IsRoleFriendlyNameExist($this->user_role, 'Content Management_TAG_All_Country_View'))):?>
	    <a href="<?php echo base_url('cms/create_tag'); ?>"><button class="btn btn-inverse" type="button"><i class="icon-tag"></i> Tag</button></a>
	    <?php endif;?>
            
        </div>
        <div class="cms-table pull-right">
            <?php
            	if(isset($data)){
                    $this->load->view($cms_view,$data);
                }
                else{
                    $this->load->view($cms_view);        
                }
            ?>
        </div>
    </div>
</div>