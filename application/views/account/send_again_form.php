<div class="account_content">
    <h4>인증 메일 재발송</h4>
    <?php echo form_open($this->uri->uri_string()); ?>
    <div class="control-group">
        <label class="control-label" for="email"><?=$this->lang->line('common_label_email');?></label>
        <div class="controls">
            <div class="sidetip"><?=$this->lang->line('account_description_email')?></div>
            <input name="email" type="text" id="email" placeholder="<?=$this->lang->line('account_placeholder_email')?>">
        </div>
    </div>
    <button type="submit" class="btn"><?=$this->lang->line('account_label_resend_button')?></button>
    <?php echo form_close(); ?>
</div>
