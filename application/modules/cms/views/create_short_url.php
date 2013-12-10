<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Short URL</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Full URL Path</label>
                <div class="controls">
                  <input type="text" class="span10" name="shorturl[long_url]" placeholder="http://www.maybank2u.com.my/">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea class="span10" name="shorturl[description]"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Campaign</label>
                <div class="controls">
                    <select id="uniqueSelect" name="shorturl[campaign_id]">
                    	<?php if($campaigns): ?>
                    		<?php $i=1;?>
                    		<?php foreach($campaigns as $v): ?>
                    			<option id="opt<?php echo $i?>" value="<?php echo $v->id?>"><?php echo $v->campaign_name ?></option>
                    		<?php endforeach; ?>
                    	<?php endif; ?>
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
                <label class="control-label">Short URL</label>
                <div class="controls">
                  http://maybk.co/<input type="text" class="span10" style="width: 100px;" value="<?php echo $code['shortcode']?>"/>
                  <input type="hidden" name="shorturl[id]" value="<?php echo $code['url_id']?>" />
                </div>
            </div>
            <div class="control-group">
                <div class="pull-left">
                    <button class="btn btn-primary" type="button">Create</button>
                </div>
                <div class="pull-right">
                    <button class="btn " type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>