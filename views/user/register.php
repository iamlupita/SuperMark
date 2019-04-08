<?php 
$this->dispatch("layout/header");


?>
<script type="text/javascript">
function trim(stringData)
{
return stringData.replace(/(^\s*|\s*$)/, "");
}

function loadTerms()
{
	window.open("<?php echo $this->make_url("index/terms"); ?>","popup","menubar=1,resizable=1,width=900,height=500,scrollbars=1");
}

function checkavailable()
{
	var username=trim($('#email').val());

   if(username =="")
   return;	
  
   $.ajax(
			{
			type: "GET",
			url: "<?php echo $this->make_url("user/email_check/");?>"+username,
			success: function(msg)
				{
				
				if(msg=="error")
				{
					$("#check").removeClass("available").addClass("unavailable");
					$("#check").html("<?php echo $this->get_message('email format');?>");
				}
				else if(msg=="available")
				{
					$("#check").removeClass("unavailable").addClass("available");
					$("#check").html("<?php echo $this->get_message('email available');?>");
				}
				else if(msg=="unavailable")
				{
					$("#check").removeClass("available").addClass("unavailable");
					$("#check").html("<?php echo $this->get_message('email not available');?>");
				}
				
			    }
			});	
	
}


</script>
<?php
$validate=array(

	"email"=>array(
		"notNull"=>array($this->get_message("mandatory")),
		"isEmail"=>array($this->get_message("email format"))
	),
	"pwd"=>array(
			"notNull"=>array($this->get_message("mandatory")),
			"minLength"=>array($this->get_variable('min_pass_len'),$this->get_message("password length"))
			),
	"rpwd"=>array(
			"notNull"=>array($this->get_message("mandatory")),
			"isSame"=>array('pwd',$this->get_message("password mismatch"))
			),
	"name"=>array(
			"notNull"=>array($this->get_message("mandatory")),
			)
	);


$form=$this->create_form();
$form->start("register",$this->make_url("user/register"),"post",$validate); ?>





<div class="container">



<div class="register-main-div">


<div class="register-heading-div"><?php echo $this->get_label('sign up');?>
	<span class="register-heading-span">
		<?php echo $this->get_label('already registered');?> <a href="<?php echo $this->make_url('user/login');?>" class="login-link"><?php echo $this->get_label('signin');?></a>
	</span>
</div>

<div class="register-content-left">

<div class="register-label1">
	<?php echo $this->get_label('email'); ?><span class="mandatory_new">*</span>
    
    </div>


	<div class="width-height-40">
    <input class="form_txt_box" name="email" type="text" id="email" value="<?php echo $this->get_variable('email'); ?>" onblur="javascript:checkavailable();"/>
    
    <div id="check" class="available"></div>
    </div>
    
  
 <div class="register-cpass-label">
  <?php echo $this->get_label('confirm password'); ?><span class="mandatory_new">*</span>
  </div>
  
  <div class="width-height-40">
   <input class="form_txt_box" name="rpwd" type="password" id="rpwd" value="<?php echo $this->get_variable('rpwd'); ?>">
   </div>
   
   
   <div class="register-compulsory-label">	
                            
	<?php echo $this->get_label('compulsory message');?>

	</div>
</div>
   
   

   <div class="register-content-right">  
   
   
   <div class="register-label1">
    <?php echo $this->get_label('pwd'); ?><span class="mandatory_new">*</span>
    </div>
    
    <div class="width-height-40">
    <input class="form_txt_box" name="pwd" type="password" id="pwd" value="<?php echo $this->get_variable('pwd'); ?>">
    </div>
    
    
   <div class="max-width">
    <div class="warning1">[<?php echo $this->get_label('minimum password length is',array('x'=>$this->get_variable('min_pass_len'))); ?>]</div></div>
   
   
   
   
   
   <div class="register-label1">
   
    <?php echo $this->get_label('your name'); ?><span class="mandatory_new">*</span></div>
    
    <div class="width-height-40">
   <input class="form_txt_box" name="name" type="text" id="name" value="<?php echo $this->get_variable('name'); ?>" onblur="javascript:checkuseravailable();"/>
    </div>
    
    
    <div class="register-terms-label">
    <input type="checkbox" name="terms" id="terms" value="1" style="vertical-align: middle;" /><a href="javascript:void(0);" onclick="loadTerms()" class="register-terms-link"><?php echo $this->get_label('terms conditions');?></a><span class="mandatory_new">*</span>
    </div>
    
    
    
    </div>
    

    <div class="register-submit-div">
    <input class="register-submit-btn" type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" />
    </div>
    
    
                           
 
 </div> </div>    
 <?php $form->end(); ?>            
           
<?php 
$this->dispatch("layout/footer");
?>