<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Edit Campaign</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form method="post" action="<?php echo site_url('cms/update_campaign') ?>" class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Campaign Name<span class="redText"> *</span></label>
                <div class="controls">
                <input type="hidden" name="id" value="<?php echo set_value('id',isset($row->id) ? $row->id : '') ?>">
                <input type="text" class="span10" name="name" value="<?php echo set_value('name',isset($row->campaign_name) ? $row->campaign_name : '') ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea class="span10" name="description"><?php echo set_value('description',isset($row->description) ? $row->description : '') ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Product<span class="redText"> *</span></label>
                <div class="controls">
		    <select class="shorturl-tags" multiple="multiple" name="product[]">
                    	<?php foreach($product_list as $product):?>
			    <?php
				if(isset($product->child)){ ?>
				    <optgroup label="<?=$product->product_name?>"></optgroup>
				<?php }
				else{ ?>
				    <option value="<?=$product->id?>" <?php if(in_array($product->id,$product_selected)){echo 'selected="selected"';} ?>><?=$product->product_name?></option>
				<?php }
			    
				if(isset($product->child)){
				    foreach($product->child as $child){ ?>
				    <option value="<?=$child->id?>" <?php if(in_array($child->id,$product_selected)){echo 'selected="selected"';} ?>>-&nbsp;&nbsp;<?=$child->product_name?></option> 
				    <?php }
				} ?>
			<?php endforeach?>
		    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tag<span class="redText"> *</span></label>
                <div class="controls">
                  <?php
                        $new_tags = array();
                        foreach($tags_selected as $ts){
                            $new_tags[] = $ts->id;
                        }
                        $options = array();
                        foreach($tags as $tag){
                            $options[$tag->id] = $tag->tag_name;
                        }
                        echo form_multiselect('tag[]', $options, $new_tags, 'class="shorturl-tags" multiple="multiple"');
                    ?>
                    <br><br>
                <span class="redText">* required</span>
                </div>
            </div>
            <div class="control-group">
                <div class="pull-left">
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
                <div class="pull-right">
                    <a href="<?php echo base_url() ?>cms"><button class="btn " type="button">Cancel</button></a>
                </div>
            </div>
        </form>
    </div>
</div>