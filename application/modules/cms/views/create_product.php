<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Product</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form method="post" action="<?php echo site_url('cms/create_product')?>" class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Product Name</label>
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
 <div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Product List</h4>    
</div>
<div class="floatingBox table">
    <div class="table-head row-fluid">
        <table class="table table-striped">
            <thead>
              <tr>
                <th>Products</th>
                <th>Description</th>
                <th>Total Used</th>
                <th>Creator</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            <?php if($products): ?>
            	<?php foreach($products as $v): ?>
            		<tr>
		                <td><?php echo $v->product_name; ?></td>
		                <td><?php echo $v->description; ?></td>
		                <td><?php echo $v->increment; ?></td>
		                <td><?php echo $v->display_name; ?></td>
		                <td>
		                	<a href="<?php echo site_url('cms/create_product?action=delete&id='.$v->id)?>" onclick="return window.confirm('Are you sure want to delete this record?')" class="btn btn-mini btn-danger pull-right">delete</a>
		                	<!--<button class="btn btn-mini btn-danger pull-right" type="button">delete</button>-->
		                </td>
					</tr>
            	<?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
     <div class="page pull-right">
            <a href="#">First</a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">Last</a>
        </div>
</div>