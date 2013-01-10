<fieldset>
    <?php echo form_open($this->config->config['logout_url'], array('name'=>'logout')); ?>
    <label>
        <?=$this->lang->line('common_left_bar_user_name_prefix');?>
        <strong><?=$this->session->userdata('username')?></strong>
        <?=$this->lang->line('common_left_bar_user_name_postfix');?>
    </label>
    <label><a href="<?=$this->config->config['mypage_url']?>"><?=$this->lang->line('common_label_user_info');?></a></label>
    <input type="hidden" name="return_url" value="<?=$this->uri->uri_string();?>" />
    <label><a onclick="javascript:document.logout.submit();"><?=$this->lang->line('common_label_logout');?></a></label>
    <?php echo form_close(); ?>
    
</fieldset>