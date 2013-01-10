<div class="account_content">
<?php echo form_open($this->uri->uri_string()); ?>
    <div class="control-group">
        <label class="control-label" for="email"><?=$this->lang->line('common_label_email');?></label>
        <div class="controls">
            <div class="sidetip"><?=$this->lang->line('');?></div>
            <input name="email" type="text" id="email" placeholder="abc@example.com">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="password"><?=$this->lang->line('common_label_password')?></label>
        <div class="controls">
            <div class="sidetip"></div>
            <input name="password" type="password" id="password" placeholder="<?=$this->lang->line('account_placeholder_password')?>">
        </div>
    </div>

    <?php if ( isset($show_captcha) && $show_captcha) { ?>
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
    <?php } ?>
    <div class="control-group">
        <label for="remember" class="checkbox">
            <input type="checkbox" name="remember" value="" id="remember">
            <?=$this->lang->line('common_label_auto_login')?>
        </label>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=$this->lang->line('common_label_login')?></button>
        </div>
    </div>
<?php echo form_close(); ?>
</div>