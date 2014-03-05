<?php
$is = validation_errors();
if($is){ ?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
    <strong>Something Wrong.</strong> <?php echo validation_errors(); ?>
</div>
<?php } ?>
<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Edit Product</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form method="post" action="<?php echo site_url('cms/update_product')?>" class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                <input type="hidden" name="id" value="<?php echo set_value('id',isset($row->id) ? $row->id : '') ?>">
                  <input type="text" class="span10" name="name" value="<?php echo set_value('name',isset($row->product_name) ? $row->product_name : '') ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea class="span10" name="description"><?php echo set_value('description',isset($row->description) ? $row->description : '') ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Parent</label>
                <div class="controls">
                    <?php
                        $options = array();
                        foreach($products_avail as $product){
                            $options[$product->id] = $product->product_name;
                        }
                        echo form_dropdown('parent_id', $options, $row->parent_id);
                    ?>
                </div>
            </div>
            <?php if($this->session->userdata('country') == 'All'){ ?>
            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    <?php
                        $options_country = array();
                        foreach($countries as $country){
                            $options_country[$country->code] = $country->name;
                        }
                        echo form_dropdown('country_code', $options_country, $row->country_code);
                    ?>
                </div>
            </div>
            <?php } else { ?>
                <input type="hidden" name="country_code" value="<?php echo $this->session->userdata('country') ?>">
            <?php }?>
            <div class="control-group">
                <div class="pull-left">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
                <div class="pull-left" style="margin-left: 5px;">
                    <a href="<?php echo site_url().'cms/create_product' ?>"><button class="btn " type="button">Cancel</button></a>
                </div>
            </div>
        </form>
    </div>
</div>