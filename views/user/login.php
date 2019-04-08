<?php $this->dispatch("layout/header");?>
<?php
$validate=array(
		"username"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("email format"))
		),
		"password"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)

);


$form=$this->create_form();
$form->start("user_login",$this->make_url("user/login"),"post",$validate);
?>
<div class="container login-container-div">

<div class="login-space-header-div">

<div class="login-heading-div">


<div class="login-heading-left-div"></div>
<div class="login-heading-center-div"><?php echo $this->get_label('signin');?></div>
<div class="login-heading-left-div"></div>



</div>


<div class="login-content-left">


<div class="login-content-left-label">

<?php echo $this->get_label("login email");?></div>

<div class="login-content-left-value">

<input class="textStyle width-220" type="text" name="username" id="username" value="<?php echo $this->get_variable('username'); ?>"></div>

<div class="login-content-left-label">
<?php echo $this->get_label("pwd");?></div>

<div class="login-content-left-value">
<input class="textStyle width-220" type="password" name="password" id="password" value="<?php echo $this->get_variable('password'); ?>"></div>


<div class="login-content-left-label-submit">&nbsp;</div>

<div class="login-content-left-value-submit">

<input style="padding:6px 10px; font-size:12px; cursor:pointer;" type="submit" name="submit" value="<?php echo $this->get_label("submit");?>">
<a href="<?php echo $this->make_base_url("user/reset_password");?>" style="padding-left:10px;"><?php echo $this->get_label('forgot password'); ?></a></div>





</div>


<div class="login-content-center">

<div class="login-content-center-subdiv1"></div>



<div class="login-content-center-subdiv2"><?php echo $this->get_label('or');?></div>

<div class="login-content-center-subdiv3"></div>


</div>

<div class="login-content-right">




<div class="login-content-right-subdiv">

<?php $this->dispatch("layout/socialmedia");  ?>
<div style="margin-top:30px;">
<?php echo $this->get_label("don't have an account");?><a href="<?php echo $this->make_base_url("user/register");?>" style="padding-left:5px;"><?php echo $this->get_label('register here'); ?></a>
</div>


</div>



</div>          
           
            
        </div>
    </div>
   
   
<?php $form->end(); ?> 

<?php $this->dispatch("layout/footer");?>