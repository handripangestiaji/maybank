<?php
    $buttonItems = array();
    $buttonItems['reply'] = IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Current_Take Action','Social Stream_All_Take Action' )) ?
                                                    '<button type="button" class="btn btn-primary btn-reply"><i class="icon-mail-reply"></i></button>' :
                                                    '';
    if(count($post->case) == 0){
        $buttonItems['case'] = (IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Current_Assign_Case','Social Stream_All_Assign_Case')) ?
                                '<button type="button" class="btn btn-danger btn-case" name="action" value="case"><i class="icon-plus"></i> <span>CASE</span></button> ' : '');
    }
    else{
        if($post->case[0]->status == 'pending'){
            $buttonItems['case'] = (IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Current_Resolve_Case', 'Social Stream_All_Resolve_Case')) ?
            '<button type="button" class="btn btn-purple btn-resolve" name="action" value="'.$post->case[0]->case_id.'">
            <i class="icon-check"></i> <span>RESOLVE</span></button> <button type="button" class="btn btn-danger btn-case" name="action" value="reassign">
            <i class="icon-plus"></i> <span>ReAssign</span></button>' : '' );
        }
        else{
            $buttonItems['case'] = (IsRoleFriendlyNameExist($this->user_role, array('Social Stream_Current_Assign_Case', 'Social Stream_All_Assign_Case')) ?
                                    '<button type="button" class="btn btn-danger btn-case" name="action" value="new_case">
                                    <i class="icon-plus"></i> <span>Case</span></button> ' : '');
        }
    }
    
    foreach($buttonItems as $item)
        echo $item.' ';
?>
