<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Short URL</h4>    
</div>
<?php $tab = $this->uri->segment(4) ? $this->uri->segment(4): 'secondTab'; ?>
    <!-- ==================== TAB ROW ==================== -->
<div class="row-fluid">
        <!-- ==================== TAB NAVIGATION ==================== -->
	<ul class="nav nav-tabs">
            <?php if ((IsRoleFriendlyNameExist($this->user_role, 'Content Management_Short_URL_Own_Country_Create')) ||
		      (IsRoleFriendlyNameExist($this->user_role, 'Content Management_Campaign_Own_Country_Create')) ||
		      (IsRoleFriendlyNameExist($this->user_role, 'Content Management_Short_URL_All_Country_Create')) ||
		      (IsRoleFriendlyNameExist($this->user_role, 'Content Management_Campaign_All_Country_Create'))
		      ): ?><li class="<?php echo $tab=='firstTab'?"active":"" ?>">
            <a href="#firstTab">Campaign</a>
            </li>
            <?php endif;?>
            <li class="<?php echo $tab=='secondTab'?"active":"" ?>"><a href="#secondTab">Non Campaign</a></li>      
        </ul>
	<!-- ==================== END OF TAB NAVIGATIION ==================== -->

        <div class="container-fluid">
            <!-- ==================== FIRST TAB CONTENT ==================== -->
            <div class="tabContent" id="firstTab">
               <div class="floatingBox span12">
                    <div class="container-fluid campaignForm">
                        <form class="form-horizontal contentForm" method="post" action="<?php echo site_url('cms/new_create_short_url')?>">
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
                                <select class="shorturl-tags" multiple="multiple" name="tag_id[]">
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
                            </div>
                        </form>
                    </div>
               </div>
            </div>
            <!-- ==================== END OF FIRST TAB CONTENT ==================== -->
            
            <!-- ==================== SECOND TAB CONTENT ==================== -->
            <div class="tabContent" id="secondTab" style="display: none">
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
                                <select class="shorturl-tags" multiple="multiple" name="tag_id[]">
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ==================== END OF SECOND TAB CONTENT ==================== -->
            </div>
            
    </div>
</div>
<!-- ==================== END OF TAB ROW ==================== -->
<!--script src="<?php echo base_url('media/js/vendor/jquery-1.9.1.min.js')?>"></script!-->
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