<form name="login" action="#">
    <fieldset>
        <input type="text" placeholder="<?=$this->lang->line('common_label_email')?>">
        <input type="password" placeholder="<?=$this->lang->line('common_label_password')?>">
        <label class="checkbox">
            <input type="checkbox"> <?=$this->lang->line('common_label_auto_login')?>
        </label>
        <button type="submit" class="btn btn-mini"><?=$this->lang->line('common_label_login')?></button>
        <label href="#"><a href="#"><?=$this->lang->line('common_link_resend_password')?></a></label>
        <label><a href="<?=$this->config->config['signup_url']?>"><?=$this->lang->line('common_link_sign_up')?></a></label>
    </fieldset>
</form>