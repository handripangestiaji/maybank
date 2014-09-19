<?php 
    if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Create'))
    {
?>
<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Product</h4>    
</div>
<div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form method="post" action="<?php echo site_url('cms/create_product')?>" class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Product Name<span class="redText"> *</span></label>
                <div class="controls">
                  <input type="text" class="span10" name="product[product_name]">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea class="span10" name="product[description]"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Parent</label>
                <div class="controls">
                <select name="product[parent_id]">
                    <option value="">- This is a Parent Product -</option>
                    <?php foreach($products_avail as $product){ ?>
                        <option value="<?php echo $product->id ?>"><?php echo $product->product_name ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <?php if($this->session->userdata('country') == 'All'){ ?>
            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    <select name="product[country_code]">
                        <?php foreach($countries as $country){ ?>
                            <option value="<?php echo $country->code ?>"><?php echo $country->name ?></option>
                        <?php } ?>
                    </select>
		    <br><br>
                    <span class="redText">* required</span>
                </div>
            </div>
            <?php }
            else{ ?>
                <input type="hidden" name="product[country_code]" value="<?php echo $this->session->userdata('country') ?>">
            <?php }?>
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
 <?php }?>
 <div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Product List</h4>    
</div>
<div class="floatingBox table">
    <div class="table-head row-fluid">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Products</th>
                <th>Sub Products</th>
                <th>Description</th>
                <th>Total Used</th>
                <th>Creator</th>
		<?php
		    if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Edit')){
		    ?>
                <th>&nbsp;</th>
                <?php }?>
                <?php
		    if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Delete')){
		    ?>
                <th>&nbsp;</th>
		<?php }?>
		<?php
		    if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_View')){
		    ?>
                <th>&nbsp;</th>
		<?php }?>
	      </tr>
            </thead>
	    <tbody>
	    <?php if ($products): ?>
		<?php foreach($products as $v): ?>
		<?php if($v->parent_id == null){ ?>
		<tr class="table-head-tr">
		    <td><?php echo $v->product_name; ?></td>
		    <td>
		    <?php
			$r=0;
			foreach($v->children as $child){
			    if($r!=0){
				echo ', ';
			    }
			    echo $child->product_name;
			    $r++;
			}
		    ?>
		    </td>
		    <td><?php echo $v->description; ?></td>
		    <td><?php echo $v->increment; ?></td>
		    <td><?php echo $v->display_name; ?></td>
		    <?php
			if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Edit')){
			?>
		    <td>
			<a href="<?php echo site_url('cms/edit_product/'.$v->id)?>" class="btn btn-mini btn-primary pull-right">edit</a>
		    </td>
		    <?php }?>
		    <?php
			if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Delete')){
			?>
		    <td>
			<a href="<?php echo site_url('cms/create_product?action=delete&id='.$v->id)?>" onclick="return confirm('Are you sure want to delete this product?');" class="btn btn-mini btn-danger pull-right">delete</a>
		    </td>
		    <?php }?>
		    <?php
			if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_View')){
			?>
	            <td>
			<button class="btn btn-mini btn-primary pull-right table-btn-show-sub" type="button">Show <i class="icon-caret-down"></i></button>
		    </td>
                    <?php }?>
		</tr>
		
		<tr class="table-sub-tr">
		<td colspan="12" class="table-sub-td" style="background-color: #7F7B96; padding: 15px;">
		    <div class="floatingBox table">
			<div class="table-sub row-fluid">
			    <table class="table table-striped">
				<thead>
				  <tr>
				    <th>Sub Products</th>
				    <th>Description</th>
				    <th>Total Used</th>
				    <th>Creator</th>
				    <?php
					if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Edit')){
					?>
				    <th>&nbsp;</th>
				    <?php }?>
				    <?php
					if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Delete')){
					?>
				    <th>&nbsp;</th>
				    <?php }?>
				  </tr>
				</thead>
				<tbody>
				<?php if($v->children): ?>
				    <?php foreach($v->children as $child): ?>
					<tr>
					    <td><?php echo $child->product_name; ?></td>
					    <td><?php echo $child->description; ?></td>
					    <td><?php echo $child->increment; ?></td>
					    <td><?php echo $child->display_name; ?></td>
					    <?php
						if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Edit')){
						?>
					    <td>
						<a href="<?php echo site_url('cms/edit_product/'.$child->id)?>" class="btn btn-mini btn-primary pull-right">edit</a>
					    </td>
					    <?php }?>
					    <?php
						if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Product_All_Country_Delete')){
					    ?>
					    <td>
						<a href="<?php echo site_url('cms/create_product?action=delete&id='.$child->id)?>" onclick="return confirm('Are you sure want to delete this product?');" class="btn btn-mini btn-danger pull-right">delete</a>
					    </td>
					    <?php }?>
					</tr>
				    <?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			    </table>
			</div>
		    </div>
		</td>
	    </tr>
	    <?php } ?>
	<?php endforeach; ?>
  <?php endif; ?>
  </tbody>
</table>  
</div>
</div>
     <div class="page pull-right">
     	<?php echo $pagination; ?>
     </div>
</div>