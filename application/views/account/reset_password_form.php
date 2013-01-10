<div class="account_content">
    <h2><?=$this->lang->line('account_label_reset_password')?></h2>
    <?php echo form_open($this->uri->uri_string()); ?>
        <div class="control-group">
            <label class="control-label" for="new_password"><?=$this->lang->line('account_label_new_password');?></label>
            <div class="controls">
                <div class="sidetip"><?=$this->lang->line('');?></div>
                <input name="new_password" type="password" id="new_password" placeholder="<?=$this->lang->line('account_placeholder_password')?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="confirm_new_password"><?=$this->lang->line('account_label_confirm_new_password');?></label>
            <div class="controls">
                <div class="sidetip"><?=$this->lang->line('');?></div>
                <input name="confirm_new_password" type="password" id="confirm_new_password" placeholder="">
            </div>
        </div>
    
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn"><?=$this->lang->line('account_label_reset_password_submit')?></button>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>