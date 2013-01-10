<div class="account_content">
    <h2><?=$this->lang->line('account_label_forgot_password')?></h2>
    <?php echo form_open($this->uri->uri_string()); ?>
        <div class="control-group">
            <label class="control-label" for="email"><?=$this->lang->line('common_label_email');?></label>
            <div class="controls">
                <div class="sidetip"><?=$this->lang->line('');?></div>
                <input name="email" type="text" id="email" placeholder="abc@example.com">
            </div>
        </div>
    
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn"><?=$this->lang->line('account_label_forgot_password_submit')?></button>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
