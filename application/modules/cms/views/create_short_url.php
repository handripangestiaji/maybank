<div class="row-fluid" style="border-bottom: solid 1px #C9C9C9; margin-bottom: 10px;">
    <h4>Create Short URL</h4>    
</div>
 <div class="floatingBox">
    <div class="container-fluid campaignForm">
        <form class="form-horizontal contentForm">
            <div class="control-group">
                <label class="control-label">Full URL Path</label>
                <div class="controls">
                  <input type="text" class="span10">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description</label>
                <div class="controls">
                  <textarea class="span10"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Campaign</label>
                <div class="controls">
                    <select id="uniqueSelect">
                        <option id="opt1" value="opt1">First Option</option>
                        <option id="opt2" value="opt2">Second Option</option>
                        <option id="opt3" value="opt3">Third Option</option>
                        <option id="opt4" value="opt4">Fourth Option</option>
                        <option id="opt5" value="opt5">Fifth Option</option>
                        <option id="opt6" value="opt6">Sixth Option</option>
                    </select>
                </div>
            </div>
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
            <div class="control-group">
                <label class="control-label">Short URL</label>
                <div class="controls">
                  http://maybk.co/<input type="text" class="span10" style="width: 100px;" value="<?php echo $code?>"/>
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