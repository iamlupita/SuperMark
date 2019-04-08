<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->get_label("reset password");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 

$validate=array(
		"email"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("invalid email address"))

		)
);
$form=$this->create_form();
$form->start("reset_password",$this->make_url("index/reset_password"),"post",$validate);



$email_current=$this->get_variable("email");
?>

<div class="logindiv" style="height: 165px;">
<table cellpadding="0" cellspacing="0" class="loginbox">

<tr><td colspan="3" height="15px"></td></tr>

<tr>
<td colspan="2"></td>
<td  style="height: 30px;font-size: 16px;"><?php echo $this->get_label('reset password');?></td></tr>
<tr><td height="10px"></td></tr>

<tr >
<td width="10px"></td>
<td width="100px"><?php echo $this->get_label('email address');?></td>
<td width="280px"><input type="text" name="email" id="email" value="<?php echo $email_current;?>"  class="textStylePadding" placeholder="<?php echo $this->get_label('email address');?>"><span class="mandatory">*</span></td>
</tr>

<tr>
<td height="10px"></td>
</tr>

<tr>
<td></td>
<td></td>
<td><input type ="submit" value ="<?php echo $this->get_label('submit');?>" class="btn btn-default">
&nbsp;
<br><br>
<a href="<?php echo $this->make_url("index/index");?>"><?php echo $this->get_label('login');?></a>

</td>
</tr>

<tr><td colspan="3" height="25px"></td></tr>

</table>
</div>
<?php $form->end(); ?>