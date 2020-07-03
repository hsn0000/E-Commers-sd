<div class="control-group">
    <label for="" class="control-label {{ $val->parent_id > 0 ? 'label-child' : 'label-parent' }}">{{ $val->mod_name }}</label>
</div>

<div class="control-group" id=""> 
        
    <div class="controls">
        <label class="control-input-content"> View 
            <div class="switch">
                <input type="checkbox" class="toggle-switch-checkbox toggle-switch-primary" id="{{ 'view-'.$val->modid }}" data-parent="{{ $val->parent_id }}" is-parent="{{ $val->parent_id == 0 ? 'true' : 'false' }}" {{ $val->parent_id == 0 ? '' : 'disabled' }} name="module[view][{{ $val->modid }}]" {{ old('module.view.'.$val->modid) || ($_roles!==null && isset($_roles->view) && in_array($val->modid, explode(',',$_roles->view))) ? 'checked' : '' }}>
                <span class="slider"></span>
            </div>
        </label>
        @if($val->mod_permalink)

        <label class="control-input-content"> Create 
            <div class="switch">
                <input type="checkbox" class="toggle-switch-checkbox toggle-switch-success" id="{{ 'create-'.$val->modid }}" data-parent="{{ $val->parent_id }}" name="module[create][{{ $val->modid }}]" disabled {{ old('module.create.'.$val->modid) || ($_roles!=null && isset($_roles->create) && in_array($val->modid, explode(',',$_roles->create))) ? 'checked' : '' }}>
                <span class="slider"></span>
            </div>
        </label>

        
        <label class="control-input-content"> Alter 
            <div class="switch">
                <input type="checkbox" class="toggle-switch-checkbox toggle-switch-warning" id="{{ 'alter-'.$val->modid }}" data-parent="{{ $val->parent_id }}" name="module[alter][{{ $val->modid }}]" disabled {{ old('module.alter.'.$val->modid) || ($_roles!=null && isset($_roles->alter) && in_array($val->modid, explode(',',$_roles->alter))) ? 'checked' : '' }}>
                <span class="slider"></span>
            </div>
        </label>

        <label class="control-input-content"> Drop 
            <div class="switch">
                <input type="checkbox" class="toggle-switch-checkbox toggle-switch-danger" id="{{ 'drop-'.$val->modid }}" data-parent="{{ $val->parent_id }}" name="module[drop][{{ $val->modid }}]" disabled {{ old('module.drop.'.$val->modid) || ($_roles!=null && isset($_roles->drop) && in_array($val->modid, explode(',',$_roles->drop))) ? 'checked' : '' }}>
                <span class="slider"></span>
            </div>
        </label>
    
         @endif
    </div>
</div>




  


