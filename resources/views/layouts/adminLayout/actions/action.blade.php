@if(isset($toolbar) && $toolbar == true) 
    <div class="actions">
        @if($page->fetch_role('drop', $module) == true )
        <a href="javascript:" class="action-hedaer btn-delete" data-link="{{ $module->permalink.'/delete' }}"><i class="icon icon-trash"></i> </a>
        @endif
        @if($page->fetch_role('alter', $module) == true )
        <a href="javascript:" class="action-hedaer btn-edit" data-link="{{ $module->permalink.'/edit' }}"><i class="icon icon-pencil"></i> </a>
        @endif
        @if($page->fetch_role('create', $module) == true)
        <a href="javascript:" class="action-hedaer btn-add" data-link="{{ $module->permalink.'/add' }}" ><i class="icon icon-plus"></i> </a>
        @endif
    </div>
@endif
@if(isset($toolbar_save) && $toolbar_save == TRUE) 
    <div class="actions">
        <a href="javascript:" class="action-hedaer btn-cancel" data-link="{{ $module->permalink }}">
            <i href="javascript:" class="icon-remove-sign"></i>
        </a>
        @if($page->fetch_role('create', $module) == TRUE || $page->fetch_role('alter', $module) == TRUE)
        <a href="javascript:" class="action-hedaer {{ isset($btn_save) ? $btn_save : 'btn-save' }}">
            <i class="icon icon-save"></i>
        </a>
        @endif
    </div>
@endif