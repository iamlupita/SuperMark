<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->get_title();?></title>
</head>
<body style="background-color: #CCCCCC;">

<style type="text/css">
.config-outer
{
	width:400px;
	height:210px; 
	border:1px solid #666666;
	margin:0 auto; 
	background-color: #ECECEC;
	margin-top: 200px;
	padding: 10px 0;
}
.config-outer-table
{
	margin: 0px auto;
	width: 340px;
	height: 200px;
}
.config-outer-table td
{
	font-size: 14px;
}
.completed
{
	text-align: center; 
	margin-top:80px;
}
.completed a
{
	color: green;
}
.configure-input
{
	border:1px solid #CCCCCC;
	padding: 5px 0px;
}
.configure-mandatory
{
	color: red;
	padding-left: 5px;
	font-size: 14px;
}
</style>

<div class="config-outer">
	
	<?php 
	
	
	
if($this->get_variable('success') != 1)
{
?>
	
<form action="<?php $this->make_url("index/index")?>" method="post">
<table cellpadding="0" cellspacing="0" class="config-outer-table">

<tr><td colspan="3" height="30px" align="center"><?php echo $this->get_label("configure login details");?></td></tr>

<tr><td colspan="3" height="10px"></td></tr>

<tr>
<td width="60px"><?php echo $this->get_label("username"); ?></td>
<td width="20px"></td>
<td ><input  name="username" id="username" type="text" value="<?php echo $this->get_variable('username');?>" class="configure-input"/><font class="configure-mandatory">*</font></td>
</tr>

<tr><td colspan="3" height="10px"></td></tr>

<tr>
<td><?php echo $this->get_label("password"); ?></td>
<td></td>
<td><input  name="password" id="password" type="password" value="" class="configure-input" /><font class="configure-mandatory">*</font></td>
</tr>

<tr><td colspan="3" height="10px"></td></tr>


<tr>
<td><?php echo $this->get_label("email"); ?></td>
<td></td>
<td><input  name="email" id="email" type="text" value="<?php echo $this->get_variable('email');?>" class="configure-input" /><font class="configure-mandatory">*</font></td>
</tr>

<tr><td colspan="3" height="10px"></td></tr>

<tr>
<td></td>
<td></td>
<td>
<input type="submit"  name="submit" id="submit" value="<?php echo $this->get_label("submit");?>" />
</td>
</tr>
	
<tr><td colspan="3" height="10px"></td></tr>


<tr>
<td></td>
<td></td>
<td class="configure-mandatory"><?php if($this->get_variable('error') != ""){echo $this->get_variable('error');}?></td>
</tr>
</table>
</form>
<?php 
}
else
{
?>
<div class="completed">
<?php 
		echo $this->get_label("installation completed")."<br/>";
		echo "<a href=".$this->make_base_url("index",ADMIN_DIR).">".$this->get_label("go")."</a><br/>";
		die;
?>
</div>
<?php 	
}
?>
</div>
</body>
</html>