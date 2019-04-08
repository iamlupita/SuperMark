<?php
$this->dispatch("layout/header");

$validate=array(
		"email"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("email format"))
		),
		"subject"=>array(
				"notNull"=>array($this->get_message("mandatory")),

		),
		"query"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				)
);

$form=$this->create_form();
$form->start("contact",$this->make_url("user/contact_us"),"post",$validate);
$res=$this->get_result('res');
$uid=$this->get_variable('uid');
?>

<div class="container mtop-20 mbot-30" style="min-height: 375px;position: relative;">
                
	<h1 class="titleh1"><?php echo $this->get_label('contact us');?></h1>

	
	<div class="mtop-20" style="text-align: justify;height: auto;">	
		
		<div class="contactus_sep_div"><?php echo $this->get_label('compulsory message');?></div>
		
		<div class="contactus_sep_div"></div>
				
<?php 
if(LoginHelper::validate_user_login()==0)
{
?>
	<div class="contactus_label"><?php echo $this->get_label('email'); ?></div>
	<div class="contactus_value"><input class="textStyle" name="email" type="text" id="email" value="<?php echo $this->get_variable('emailenter'); ?>" style="width: 275px;" ><span class="mandatory">*</span></div>
<?php 
}
else
{
?>	
<div><input type="hidden" name="email" id="email" value="<?php echo $this->get_user_email($uid);?>" /></div>		
<?php } ?>

<div class="contactus_sep">&nbsp;</div>

<div class="contactus_label"><?php echo $this->get_label('subject'); ?></div>
<div class="contactus_value"><input class="textStyle" type="text" name="subject" id="subject" value="<?php echo $this->get_variable("subject");?>" style="width: 275px;"><span class="mandatory">*</span></div>

<div class="contactus_sep">&nbsp;</div>

<div class="contactus_label"><?php echo $this->get_label('message'); ?></div>
<div class="contactus_value"><textarea class="textStyle contactus_txtare"  name="query" id="query"><?php echo $this->get_variable("query");?></textarea><span class="mandatory">*</span></div>

<div class="contactus_sep">&nbsp;</div>

<div class="contactus_label">&nbsp;</div>
<div class="contactus_value"><input type ="submit" value ="<?php echo $this->get_label('submit');?>" /></div>


</div>


</div>

<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>