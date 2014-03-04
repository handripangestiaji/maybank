<?php 
for($i=0;$i<count($this->user_role);$i++){
    if($this->user_role[$i]->role_friendly_name=='Content Management_Short_URL_Create'){    
?>
<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Short URL</h4>    
</div>
<?php }}?>
<?php $tab = $this->uri->segment(4) ? $this->uri->segment(4): 'firstTab'; ?>

    <!-- ==================== TAB ROW ==================== -->
<div class="row-fluid">
        <!-- ==================== TAB NAVIGATION ==================== -->
	<?php for($x=0;$x<count($this->user_role);$x++){
	    if($this->user_role[$x]->role_friendly_name=='Content Management_Short_URL_Create'){    
	?>
        <ul class="nav nav-tabs">
            <?php if($this->session->userdata('role_id') != '4'){ ?>
            <li class="<?php echo $tab=='firstTab'?"active":"" ?>"><a href="#firstTab">Campaign</a></li>
            <li class="<?php echo $tab=='secondTab'?"active":"" ?>"><a href="#secondTab">Non Campaign</a></li>
            <?php } else { ?>
            <li class="active"><a href="#secondTab">Non Campaign</a></li>
            <?php } ?>
        </ul>
	<?php }}?>
        <!-- ==================== END OF TAB NAVIGATIION ==================== -->

        <div class="container-fluid">
            <!-- ==================== FIRST TAB CONTENT ==================== -->
            <div class="tabContent" id="firstTab" <?php if($this->session->userdata('role_id') == '4'){echo 'style="display:none;"';}else{echo 'style="display:block;"';} ?>>
		<?php for($x=0;$x<count($this->user_role);$x++){
		    if($this->user_role[$x]->role_friendly_name=='Content Management_Short_URL_Create'){    
		?>
               <div class="floatingBox span12">
                    <div class="container-fluid campaignForm">
			
                        <form class="form-horizontal contentForm" method="post" action="<?php echo site_url('cms/create_short_url')?>">
                            <div class="control-group">
                                <label class="control-label">Full URL Path<span class="redText"> *</span></label>
                                <div class="controls">
                                  <input type="text" class="span10" name="shorturl[long_url]" placeholder="" />
                                  <?php echo "<br />".$this->session->userdata('message')?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                  <textarea class="span10" name="shorturl[description]"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Campaign<span class="redText"> *</span></label>
                                <div class="controls">
                                    <select id="uniqueSelect" name="shorturl[campaign_id]">
                                        <option value="">--Select A Campaign--</option>
                                        <?php if($campaigns): ?>
                                                <?php $i=1;?>
                                                <?php foreach($campaigns as $v): ?>
                                                        <option id="opt<?php echo $i?>" value="<?php echo $v->id?>"><?php echo $v->campaign_name ?></option>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
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
                              </div>
                            </div>
                            <!--
                            <div class="control-group">
                                <label class="control-label">Product</label>
                                <div class="controls">
                                    <select id="multipleSelect" multiple="multiple">
                                        <option value="opt7">First Option</option>
                                        <option value="opt8">Second Option</option>
                                        <option value="opt9">Third Option</option>
                                        <option value="opt10">Fourth Option</option>
                                        <option value="opt11">Fifth Option</option>
                                        <option value="opt12">Sixth Option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tag</label>
                                <div class="controls">
                                  <input type="text" class="span10">
                                </div>
                            </div>
                            -->
                            <div class="control-group">
                                <label class="control-label">Short URL
                                <p style="font-size: 7pt;">Customize your short URL</p></label>
                                <div class="controls">
                                    http://maybk.co/<input type="text" class="span10" name="shorturl[short_code]" style="width: 100px;" value="<?php echo $code?>" maxlength="6"/>
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
                    <h4>Short URL List</h4>    
                </div>                                
                <div class="floatingBox table">
                    <div class="table-head row-fluid">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Full Url Path</th>
                                <th>Short Code</th>
                                <th>Total Used</th>
                                <th>Date Created</th>
                                <th>Creator</th>
                                <th>&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php if($shorturls): ?>
                                <?php foreach($shorturls as $v): ?>
                                        <tr>
                                                <td><?php echo $v->long_url ?></td>
                                                <td><a href="<?php echo site_url('cms/url/'.$v->short_code) ?>" target="_blank" ><?php echo $v->short_code ?></a></td>
                                                <td><?php echo $v->increment ?></td>
                                                <td><?php echo date('M d, Y', strtotime($v->created_at)) ?></td>
                                                <td><?php echo $v->display_name ?></td>
                                                <td>
                                                <a href="<?php echo site_url('cms/create_short_url?action=delete&id='.$v->id)?>" class="btn btn-mini btn-danger pull-right">delete</a>
                                                <!-- <button id="delete_btn" class="btn btn-mini btn-danger pull-right" type="button">delete</button> -->
                                                </td>
                                                        </tr>
                                <?php endforeach; ?>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                     <div class="page pull-right">
                     <?php echo $pagination ?>
                    </div>
                </div>
            </div>
            <!-- ==================== END OF FIRST TAB CONTENT ==================== -->

            <!-- ==================== SECOND TAB CONTENT ==================== -->
            <div class="tabContent" id="secondTab" <?php if($this->session->userdata('role_id') == '4'){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?>>
                <div class="floatingBox span12">
                    <div class="container-fluid campaignForm">
                        <form class="form-horizontal contentForm" method="post" action="<?php echo site_url('cms/create_short_url_non_campaign')?>">
                            <div class="control-group">
                                <label class="control-label">Full URL Path<span class="redText"> *</span></label>
                                <div class="controls">
                                  <input type="text" class="span10" name="shorturl[long_url]">
                                  <?php echo "<br />".$this->session->userdata('message')?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                  <textarea class="span10" name="shorturl[description]"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Product<span class="redText"> *</span></label>
                                <div class="controls">
                                    <select name="shorturl[product_id]">
                                        <option value="">--None Selected--</option>
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
                                                      <option value="<?php echo '-'.$v->id ?>"><?php echo $v->tag_name ?></option>
                                              <?php endforeach; ?>
                                      <?php else: ?>
                                              <option>Please add Tag first</option>
                                      <?php endif;?>
                                  </select>
                              </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Short URL
                                <p style="font-size: 7pt;">Customize your short URL</p></label>
                                <div class="controls">
                                  http://maybk.co/<input type="text" class="span10" name="shorturl[short_code]" style="width: 100px;" value="<?php echo $code?>" maxlength="6"/>
                                <br><br>
                    <span class="redText">* required</span>
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
                    <h4>Short URL List</h4>    
                </div>                                
                <div class="floatingBox table">
                    <div class="table-head row-fluid">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Full Url Path</th>
                                <th>Short Code</th>
                                <th>Total Used</th>
                                <th>Date Created</th>
                                <th>Creator</th>
                                <th>&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php if($shorturls): ?>
                                <?php foreach($shorturls as $v): ?>
                                        <tr>
                                                <td><?php echo $v->long_url ?></td>
                                                <td><a href="<?php echo site_url('cms/url/'.$v->short_code) ?>" target="_blank" ><?php echo $v->short_code ?></a></td>
                                                <td><?php echo $v->increment ?></td>
                                                <td><?php echo date('M d, Y', strtotime($v->created_at)) ?></td>
                                                <td><?php echo $v->display_name ?></td>
                                                <td>
                                                <a href="<?php echo site_url('cms/create_short_url?action=delete&id='.$v->id)?>" class="btn btn-mini btn-danger pull-right">delete</a>
                                                <!-- <button id="delete_btn" class="btn btn-mini btn-danger pull-right" type="button">delete</button> -->
                                                </td>
                                                        </tr>
                                <?php endforeach; ?>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                     <div class="page pull-right">
                     <?php echo $pagination ?>
                    </div>
            </div>
            <!-- ==================== END OF SECOND TAB CONTENT ==================== -->
        </div>
    </div>
</div>
<!-- ==================== END OF TAB ROW ==================== -->
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
