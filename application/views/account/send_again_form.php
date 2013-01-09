<div class="account_content">
    <h4>인증 메일 재발송</h4>
    <?php echo form_open($this->uri->uri_string()); ?>
    <button type="submit" class="btn"><?=$this->lang->line('account_label_resend_button')?></button>
    <?php echo form_close(); ?>
</div>
