<div class="account_content">
    <h2><?=$this->lang->line('account_label_signup')?></h2>
    <?php echo form_open($this->config->config['register_url']); ?>
        <div class="control-group">
            <label class="control-label" for="email"><?=$this->lang->line('common_label_email');?></label>
            <div class="controls">
                <div class="sidetip"><?=$this->lang->line('account_description_email_authentication_mail_sent');?></div>
                <input name="email" type="text" id="email" placeholder="abc@example.com">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="username"><?=$this->lang->line('common_label_username');?></label>
            <div class="controls">
                <div class="sidetip"><?=$this->lang->line('account_description_username')?></div>
                <input name="username" type="text" id="username" placeholder="<?=$this->lang->line('account_placeholder_username')?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="password"><?=$this->lang->line('common_label_password')?></label>
            <div class="controls">
                <div class="sidetip"></div>
                <input name="password" type="password" id="password" placeholder="<?=$this->lang->line('account_placeholder_password')?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="confirm_password"><?=$this->lang->line('account_label_confirm_password')?></label>
            <div class="controls">
                <div class="sidetip"></div>
                <input name="confirm_password" type="password" id="confirm_password" placeholder="">
            </div>
        </div>
        
        <div class="control-group">
            <label id="refresh_recaptcha"><a href="javascript:Recaptcha.reload()"><?=$this->lang->line('account_description_get_another_captcha')?></a></label>
            <label class="control-label" for="recaptcha_response_field"><?=$this->lang->line('account_label_recaptcha')?></label>
            
            <div id="recaptcha_image"></div>
            <div class="controls">
                <div class="sidetip"><?php echo form_error('recaptcha_response_field'); ?></div>
                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                <?php echo $recaptcha_html; ?>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn"><?=$this->lang->line('account_label_signup_button')?></button>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
