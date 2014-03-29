<?php $tab = $this->uri->segment(4) ? $this->uri->segment(4): 'firstTab'; ?>
<ul class="nav nav-tabs">
                <li class="<?php echo $tab=='firstTab'?"active":"" ?>"><a href="#firstTab">Campaign</a></li>
                <li class="<?php echo $tab=='secondTab'?"active":"" ?>"><a href="#secondTab">Short URL</a></li>
</ul>
<div class="container-fluid">
                <div class="tabContent" id="firstTab" style="display: block;">
                                <div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
                                    <h4>Campaign List</h4>    
                                </div>
                                <div class="floatingBox table">
                                    <div class="container-fluid">
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th>Campaign</th>
                                              <th>Products</th>
                                              <th>Date Created</th>
                                              <th>Creator</th>
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
                                                                <?php if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Edit')){ ?>
                                                                <a href="cms/edit_campaign/<?php echo $v['id']; ?>"><button class="btn btn-primary btn-small" type="button">Edit</button></a>
                                                                <?php } ?>
                                                                <?php if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Download')){ ?>
                                                                <a href="cms/cms_ci/download_campaign/<?php echo $v['id']; ?>"><button class="btn btn-success btn-small" type="button">Download</button></a>
                                                                <?php } ?>
                                                                <?php if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Campaign_Delete')){ ?>
                                                                <a href="cms/delete_campaign/<?php echo $v['id']; ?>" onclick="return confirm('Are you sure want to delete this campaign?');"><button class="btn btn-danger btn-small" type="button">Delete</button></a>
                                                                <?php } ?>
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
                                                                            <th>Creator</th>
                                                                            <th>QR Code</th>
                                                                            <th>&nbsp;</th>
                                                                          </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if(isset($v['short_urls'])): ?>
                                                                                <?php foreach($v['short_urls'] as $x):?>
                                                                                        <tr>
                                                                                                <td><a href="<?php echo site_url('cms/url/'.$x['short_code'])?>" target="_blank">http://maybk.co/<?php echo $x['short_code']?></a></td>
                                                                                                <td><?php echo '<p>'.$x['description'].'</p><p>'.addDashForLongText($x['long_url']).'</p>'?></td>
                                                                                                <td><?php echo $x['created_at']?></td>
                                                                                                <td><?php echo $x['increment']?></td>
                                                                                                <td><?php echo $x['display_name']?></td>
                                                                                                <td>
                                                                                                        <a href="#modal-<?php echo $x['short_code'] ?>" data-toggle='modal'>view</a>
                                                                                        <div id="modal-<?php echo $x['short_code'] ?>" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                            <img src="<?php echo base_url('media/dynamic/qrcode/'.$x['qrcode_image'])?>" style="padding: 0px 25px;"/>
                                                                                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                                                                                            </div>
                                                                                                                                </td>
                                                                                                <td>
                                                                                                <?php if(IsRoleFriendlyNameExist($this->user_role,'Content Management_Short_URL_Campaign')){ ?>
                                                                                                <a href="cms/delete_campaign_url/<?php echo($x['content_campaign_url_id']) ?>" onclick="return confirm('Are you sure want to delete short url from campaign?');" class="redText"><i class="icon-remove"></i></a>
                                                                                                <?php } ?>
                                                                                                </td>
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
                                    <?php echo $pagination ?>
                                </div>
                </div>
                <div class="tabContent" id="secondTab" style="display: none;">
                                <div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
                                                <h4>Short URL List</h4>    
                                            </div>                                
                                            <div class="floatingBox table">
                                                <div class="table-head row-fluid">
                                                    <table class="table table-striped">
                                                        <thead>
                                                          <tr>
                                                            <th>Short URL</th>
                                                            <th>URL</th>
                                                            <th>Date Created</th>
                                                            <th>Clicks</th>
                                                            <th>Creator</th>
                                                            <th>QR Code</th>
                                                            <th>&nbsp;</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if($shorturls): ?>
                                                            <?php foreach($shorturls as $v): ?>
                                                                    <tr>
                                                                                <td><a href="<?php echo site_url('cms/url/'.$x['short_code'])?>" target="_blank">http://maybk.co/<?php echo $v->short_code ?></a></td>
                                                                                <td><?php echo '<p>'.$v->description.'</p><p>'.addDashForLongText($v->long_url).'</p>'?></td>
                                                                                <td><?php echo date('M d, Y', strtotime($v->created_at)) ?></td>
                                                                                <td><?php echo $v->increment ?></td>
                                                                                <td><?php echo $v->display_name?></td>
                                                                                <td>
                                                                                                <a href="#modal-<?php echo $v->short_code ?>x" data-toggle='modal'>view</a>
                                                                                        <div id="modal-<?php echo $v->short_code ?>x" class="attachment-modal modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                            <img src="<?php echo base_url('media/dynamic/qrcode/'.$v->qrcode_image)?>" style="padding: 0px 25px;"/>
                                                                                            <button type="button" class="close " data-dismiss="modal"><i class="icon-remove"></i></button>
                                                                                            </div>
                                                                                </td>
                                                                                <td>
                                                                                <a href="<?php echo site_url('cms/delete_short_url/'.$v->id)?>" onclick="return confirm('Are you sure want to delete this short url?');" class="btn btn-mini btn-danger pull-right">delete</a>
                                                                                <!-- <button id="delete_btn" class="btn btn-mini btn-danger pull-right" type="button">delete</button> -->
                                                                                </td>     
                                                                        </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                 <div class="page pull-right">
                                                 <?php echo $pagination2 ?>
                                                </div>
                                        </div>
                </div>
</div>
<script src="<?php echo base_url('media/js/vendor/jquery-1.9.1.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var tab = '<?php echo $tab ?>';
		
		if(tab!='')
		{
			if(tab == 'secondTab')
			{
				$('#secondTab').show();
				$('#firstTab').hide();
			}
		}
	});
</script>