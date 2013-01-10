<?php
$login = array(
    'name'  => 'email',
    'id'    => 'email',
    'maxlength' => 80,
    'placeholder' => $this->lang->line('common_label_email'),
);
$password = array(
    'name'	=> 'password',
    'id'	=> 'password',
    'placeholder'=> $this->lang->line('common_label_password'),
);
$remember = array(
    'name'  => 'remember',
    'id'    => 'remember',
);

$submit = array(
    'name'=>'submit',
    'class'=>'btn btn-mini',
    'value'=>$this->lang->line('common_label_login'),
);

?>

<?php echo form_open($this->config->config['login_url'], array('name'=>'login'));?>
    <fieldset>
        <?php echo form_input($login); ?>
        <?php echo form_password($password); ?>
        <?php echo form_label(
                form_checkbox($remember).$this->lang->line('common_label_auto_login'), 
                $remember['id'], 
                array('class'=>'checkbox')
                );
        ?>
        <?php echo form_submit($submit); ?>
        
        <label><a href="<?=$this->config->config['forgot_password_url']?>"><?=$this->lang->line('common_label_forgot_password')?></a></label>
        <label><a href="<?=$this->config->config['register_url']?>"><?=$this->lang->line('common_label_register')?></a></label>
        <input type="hidden" name="return_url" value="<?=$this->uri->uri_string();?>" />
    </fieldset>
<?php echo form_close(); ?>