<?php $this->load->view('templates/header.php', $header); ?>

<div class="container">

    <div class="span4 offset4">
        <h2><?=$this->lang->line('account_label_signup')?></h2>
        <form name="signup" action="<?=/*$this->config->config['create_account_url']*/"https://twitter.com/account/create"?>" method="POST" >
            <div class="control-group">
                <label class="control-label" for="inputEmail"><?=$this->lang->line('common_label_email');?></label>
                <div class="controls">
                    <input name="email" type="text" id="inputEmail" placeholder="abc@example.com">
                    <span><?=$this->lang->line('account_description_email_authentication_mail_sent');?></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputNickname"><?=$this->lang->line('common_label_nickname');?></label>
                <div class="controls">
                    <input name="nickname" type="text" id="inputNickname" placeholder="<?=$this->lang->line('account_placeholder_nickname')?>">
                    <span><?=$this->lang->line('account_description_nickname')?></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword"><?=$this->lang->line('common_label_password')?></label>
                <div class="controls">
                    <input name="password" type="password" id="inputPassword" placeholder="<?=$this->lang->line('account_placeholder_password')?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPasswordConfirm"><?=$this->lang->line('account_label_password_confirmation')?></label>
                <div class="controls">
                    <input name="password_confirm" type="password" id="inputPasswordConfirm" placeholder="">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn"><?=$this->lang->line('account_label_signup_button')?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('templates/footer.php');?>