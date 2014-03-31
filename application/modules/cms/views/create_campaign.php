<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Campaign</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form method="post" action="<?php echo site_url('cms/create_campaign') ?>" class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Campaign Name<span class="redText"> *</span></label>
                <div class="controls">
                  <input type="text" class="span10" name="campaign[campaign_name]">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea class="span10" name="campaign[description]"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Product<span class="redText"> *</span></label>
                <div class="controls">
                    <select class="multipleSelect" multiple="multiple" name="products_id[]">
                    	<?php foreach($product_list as $product):?>
			    <?php
				if(isset($product->child)){ ?>
				    <optgroup label="<?=$product->product_name?>"></optgroup>
				<?php }
				else{ ?>
				    <option value="<?=$product->id?>"><?=$product->product_name?></option>
				<?php }
			    
				if(isset($product->child)){
				    foreach($product->child as $child){ ?>
				    <option value="<?=$child->id?>">-&nbsp;&nbsp;<?=$child->product_name?></option> 
				    <?php }
				} ?>
			<?php endforeach?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tag<span class="redText"> *</span></label>
                <div class="controls">
                  <select class="multipleSelect" multiple="multiple" name="tag_id[]">
                    	<?php if($tags): ?>
                    		<?php foreach($tags as $v): ?>
                    			<option value="<?php echo $v->id ?>"><?php echo $v->tag_name ?></option>
                    		<?php endforeach; ?>
                    	<?php else: ?>
                    		<option>Please add Tag first</option>
                    	<?php endif;?>
                    </select>
                  <br><br>
                    <span class="redText">* required</span>
                </div>
            </div>
            <div class="control-group">
                <div class="pull-left">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>