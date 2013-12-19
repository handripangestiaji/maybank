<?php
    for($i=0;$i<count($this->user_role);$i++){
	if($this->user_role[$i]->role_friendly_name=='Content Management_Campaign_Create'){
?>

<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Campaign</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form method="post" action="<?php echo site_url('cms/create_campaign') ?>" class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Campaign Name</label>
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
                <label class="control-label">Product</label>
                <div class="controls">
                    <select id="multipleSelect" multiple="multiple" name="products_id[]">
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
                <label class="control-label">Tag</label>
                <div class="controls">
                  <select id="multipleSelect" multiple="multiple" name="tag_id[]">
                    	<?php if($tags): ?>
                    		<?php foreach($tags as $v): ?>
                    			<option value="<?php echo $v->id ?>"><?php echo $v->tag_name ?></option>
                    		<?php endforeach; ?>
                    	<?php else: ?>
                    		<option>Please add Tag first</option>
                    	<?php endif;?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="pull-left">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
                <div class="pull-right">
                    <button class="btn " type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
 <?php }}?>
<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Campaign List</h4>    
</div>
<div class="floatingBox table">
    <div class="table-head row-fluid">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Campaign</th>
                <th>Description</th>
                <th>Product</th>
                <th>Total Used</th>
                <th>Creator</th>
		<?php
		    for($i=0;$i<count($this->user_role);$i++){
			if($this->user_role[$i]->role_friendly_name=='Content Management_Campaign_Delete'){
		?>
                <th>&nbsp;</th>
		<?php }}?>
              </tr>
            </thead>
            <tbody>
            <?php if($campaigns): ?>
            	<?php foreach($campaigns as $v): ?>
            		<tr>
		                <td><?php echo $v['campaign_name']; ?></td>
		                <td><?php ?></td>
		                <td><?php echo implode(" , ",$v['product_name']); ?></td>
		                <td><?php echo "0" ?></td>
		                <td><?php echo $v['display_name']; ?></td>
				<?php
				    for($i=0;$i<count($this->user_role);$i++){
					if($this->user_role[$i]->role_friendly_name=='Content Management_Campaign_Delete'){
				?>
		                <td>
		                	<a href="<?php echo site_url('cms/create_campaign?action=delete&id='.$v['id'])?>" class="btn btn-mini btn-danger pull-right">delete</a>
		                	<!--<button class="btn btn-mini btn-danger pull-right" type="button">delete</button>-->
		                </td>
				<?php }}?>
					</tr>
            	<?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
     <div class="page pull-right">
     	<?php echo $pagination ?>
     </div>
</div>