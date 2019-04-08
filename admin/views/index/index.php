<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->get_label("index title");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 
$username=$this->get_variable("username");
$password=$this->get_variable("password");

$validate=array(
		"username"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"password"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);



$form=$this->create_form();
$form->start("loginadmin",$this->make_url("index/index"),"post",$validate);
?>
<div class="logindiv">
<table cellpadding="0" cellspacing="0" class="loginbox">

<tr><td colspan="5" height="15px"></td></tr>

<tr>
<td colspan="3"></td>
<td colspan="2" style="height: 30px;font-size: 16px;"><?php echo $this->get_label("index title");?></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td width="20px"></td>
<td width="80px"><?php echo $this->get_label("usr");?></td>
<td width="20px">:</td>
<td width="180px"><input type="text" name="username" id="username" value="<?php echo $username;?>" class="textStylePadding" placeholder="<?php echo $this->get_label("usr");?>"></td>
<td width="20px"></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>




<tr>
<td></td>
<td><?php echo $this->get_label("pwd");?></td>
<td>:</td>
<td><input type="password" name="password" id="password" value="<?php echo $password;?>" class="textStylePadding" placeholder="<?php echo $this->get_label("pwd");?>"></td>
<td></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>




<tr>
<td></td>
<td></td>
<td></td>
<td><input type="submit" name="submit" value="<?php echo $this->get_label("login");?>" class="btn btn-default">
<?php 
if(!DEMO_MODE)
{
?>
&nbsp;<a href="<?php echo $this->make_url("index/reset_password");?>"><?php echo $this->get_label('forgot password');?></a>
<?php 
}
?>


</td>
<td></td>
</tr>

<tr><td colspan="5" height="25px"></td></tr>

</table>
</div>
<?php $form->end(); ?>
</body>
</html>