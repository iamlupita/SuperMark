<script language="javascript" type="text/javascript">
function popitup(url) 
{
	newwindow=window.open(url,'name','height=650,width=850,top=200,left=400');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>


<div style="width:100%;">

<?php 

if(Settings::get_instance()->read('fb_login_enabled') ==1){?>
 <div style="width:100%; height:50px;">
	<a href="<?php echo $this->make_base_url("layout/facebooklogin");?>" style="color:#489CDF !important;" onclick="return popitup('<?php echo $this->make_base_url("layout/facebooklogin");?>')"><img style="width:210px;" src="images/fb.png"  /></a> 
</div>

<?php } if(Settings::get_instance()->read('gp_login_enabled') ==1){?>

<div style="width:100%;">
	<a href="<?php echo $this->make_base_url("layout/googlelogin");?>" style="color:#489CDF !important;" onclick="return popitup('<?php echo $this->make_base_url("layout/googlelogin");?>')"><img style="width:210px;" src="images/gp.png"  /></a>
</div>

<?php }?>

</div>