<fieldset>
    <label>
        <?=$this->lang->line('common_left_bar_user_name_prefix');?>
        <strong></strong>
        <?=$this->lang->line('common_left_bar_user_name_postfix');?>
    </label>
    <label><a href="<?=$this->config->config['mypage_url']?>"><?=$this->lang->line('common_label_user_info');?></a></label>
    <label><a href="<?=$this->config->config['logout_url']?>"><?=$this->lang->line('common_label_logout');?></a></label>
</fieldset>