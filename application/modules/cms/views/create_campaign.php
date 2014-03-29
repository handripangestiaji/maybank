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
                    	<?php if($products): ?>
                    		<?php foreach($products as $v): ?>
                    			<option value="<?php echo $v->id ?>"><?php echo $v->product_name ?></option>
                    		<?php endforeach; ?>
                    	<?php else: ?>
                    		<option>Please add Product first</option>
                    	<?php endif;?>
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