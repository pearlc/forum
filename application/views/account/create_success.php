<?php $this->load->view('templates/header.php', $header); ?>

<div class="container">

    <div class="span4 offset4">
        <p>
            <?=$this->lang->line('account_message_welcome_to_prefix');?><?=$nickname?> <?=$this->lang->line('account_message_welcome_to_postfix');?>
        </p>
        <p>
            <?=$this->lang->line('account_message_authentication_mail_sent_prefix');?> <?=$email?><?=$this->lang->line('account_message_authentication_mail_sent_postfix');?>
        </p>
        <p>
            <?=$this->lang->line('account_message_please_finish_signup_checking_mail');?>
        </p>
    </div>
</div>
<?php $this->load->view('templates/footer.php');?>