<?php
$this->dispatch("layout/header");

$validate=array(
		"username"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("invalid email address"))
		)
);


$username=$this->get_variable("username");

?>

<div class="container height-300">

<div class="reset-pass-main-div">



<h1 class="reset-pass-head-h1"><?php echo $this->get_label('reset password');?>
<span class="reset-pass-heading-span">
		<?php echo $this->get_label('already registered');?> <a href="<?php echo $this->make_url('user/login');?>" class="reset-pass-login-link"><?php echo $this->get_label('signin');?></a>
</span>
</h1>
            
            

<?php 
$form=$this->create_form();
$form->start("forget_password",$this->make_url("user/reset_password"),"post",$validate); 
?>

<div class="reset-pass-email-label">
<?php echo $this->get_label('email');?><span class="mandatory">*</span>
</div>


<div class="reset-pass-email-value">
<input class="textStyle" style="width: 220px;" type="text" name="username" id="username" value="<?php echo $username;?>" >
</div>

<div class="reset-pass-submit-div">
<input class="reset-pswd-btn" type ="submit" value ="<?php echo $this->get_label('submit');?>">
</div>

<?php $form->end(); ?>

</div></div>

<?php $this->dispatch("layout/footer");?>