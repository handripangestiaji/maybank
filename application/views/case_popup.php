<div id="caseNotification" class="modal modalDialog hide fade" tabindex="1" role="dialog" aria-hidden="true" style="display: none;z-index: 10099" >
    <div class="modal-header" style="padding-bottom: 0px;">
        <h3 style=" float: left;width: 200px;">Case #<span class="case-id"></span></h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        
        <br clear="all" />
    </div>
    <div class="modal-body" style="padding: 10px 0px 10px 15px;">
        <h4 style="text-transform: capitalize;" class="type-post"></h4>
        
        <table>
            <tr><td style="width:20%">Assign By</td><td>:</td><td class="assign-by"></td></tr>
            <tr><td>Date</td><td>:</td><td class="assign-date"></td></tr>
            <tr><td colspan="3" class="assign-message">
                
            </td></tr>
        </table>
        
        <h4>Related Conversation</h4>
        <ol style="margin: 0;padding: 0;" class="related-conversation-list">
        </ol>
        <div class="action">
            
        </div>
    </div>
    <div class="modal-footer" style="">
        <button class="btn btn-purple reply" >Reply</button>
        
        
        <button type="button" class="btn btn-orange btn-resolve popup" name="action" value=""><i class="icon-check"></i> <span>RESOLVE</span></button>
        
        <button type="button" class="btn btn-danger btn-case" name="action" value="reassign"><i class="icon-plus"></i>
            <span>ReAssign</span>
        </button>
    </div>
</div>