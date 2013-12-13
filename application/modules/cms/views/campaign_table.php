<div class="floatingBox table">
    <div class="container-fluid">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Campaign</th>
              <th>Products</th>
              <th>Date Created</th>
              <th>Created By</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
          <?php if ($campaigns): ?>
          
          	<?php foreach ($campaigns as $v): ?>
          	
          		<tr class="table-head-tr">
	          		<td><?php echo $v['campaign_name']; ?></td>
	          		<td><?php echo isset($v['product_name']) ? implode(" , ",$v['product_name']) : ""; ?></td>
	          		<td><?php echo $v['created_at']; ?></td>
	          		<td><?php echo $v['display_name']; ?></td>
	          		<td><button class="btn btn-mini btn-primary pull-right table-btn-show-sub" type="button">Show <i class="icon-caret-down"></i></button></td>
          		</tr>
          		
          		<tr class="table-sub-tr">
	                <td colspan="5" class="table-sub-td" style="background-color: #7F7B96; padding: 15px;">
	                    <div class="pull-left" style="width: 70%; color: #FFFFFF;">
	                        <p><span style="font-weight: bold">TAG: <?php echo isset($v['tag_name']) ? implode(" , ",$v['tag_name']) : ""; ?></span></p>
	                        <p><span style="font-weight: bold">Description:</span> <?php echo $v['description']?></p>
	                        <p><span style="font-weight: bold">Total Clicks:</span> <?php echo $v['total_clicks']?> Clicks &nbsp;&nbsp;&nbsp; <span style="font-weight: bold">Total URL Created:</span> <?php echo count(isset($v['short_urls']) ? $v['short_urls'] : 0) ?></p>
	                    </div>
	                    <div class="pull-right" style="width: 25%; text-align: right">
	                        <p>
	                        <!--
	                        <button class="btn btn-success" type="button">Download</button>
	                        <button class="btn btn-danger" type="button">Delete</button>    
	                        -->
	                        </p>
	                    </div>
	                    <br clear="all" />
	                    <div class="floatingBox table">
	                        <div class="table-sub row-fluid">
	                            <table class="table table-striped">
	                                <thead>
	                                  <tr>
	                                    <th>Short URL</th>
	                                    <th>URL</th>
	                                    <th>Date Created</th>
	                                    <th>Clicks</th>
	                                    <th>Created By</th>
	                                    <th>QR Code</th>
	                                  </tr>
	                                </thead>
	                                <tbody>
	                                <?php if(isset($v['short_urls'])): ?>
	                                	<?php foreach($v['short_urls'] as $x): ?>
	                                		<tr>
		                                		<td><a href="<?php echo site_url('cms/url/'.$x['short_code'])?>" target="_blank"><?php echo $x['short_code']?></a></td>
		                                		<td><?php echo $x['long_url']?></td>
		                                		<td><?php echo $x['created_at']?></td>
		                                		<td><?php echo $x['increment']?></td>
		                                		<td><?php echo $x['display_name']?></td>
		                                		<td><a href="#">view</a></td>
	                                		</tr>
	                                	<?php endforeach;?>
	                                <?php endif; ?>
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
	                </td>
				</tr>
          	
          	<?php endforeach; ?>
          	
          <?php endif; ?>
          
          </tbody>
        </table>  
    </div>
</div>
<div class="page pull-right">
    <a href="#">First</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">Last</a>
</div>