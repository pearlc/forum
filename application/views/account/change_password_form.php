<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
?>
<div class="account_content">
<?php echo form_open($this->uri->uri_string()); ?>
    
    <div class="control-group">
        <label class="control-label" for="old_password"><?=$this->lang->line('account_label_old_password');?></label>
        <div class="controls">
            <div class="sidetip"></div>
            <input name="old_password" type="password" id="old_password">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="new_password"><?=$this->lang->line('account_label_new_password');?></label>
        <div class="controls">
            <div class="sidetip"></div>
            <input name="new_password" type="password" id="new_password">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="confirm_new_password"><?=$this->lang->line('account_label_confirm_new_password');?></label>
        <div class="controls">
            <div class="sidetip"></div>
            <input name="confirm_new_password" type="password" id="confirm_new_password">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=$this->lang->line('common_label_ok')?></button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>