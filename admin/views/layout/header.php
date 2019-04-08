<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-ui-1.8.23.custom.min.js' ></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/common.js'></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE.ADMIN_DIR.'/';?>css/jquery.selectBoxIt.css" />
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery.selectBoxIt.min.js'></script>

<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon"> 
<link rel="icon" href="../images/favicon.ico" type="image/x-icon">

<script type="text/javascript">
$(document).ready(function() {
	$('select').selectBoxIt({
	    showEffect: "fadeIn",
	    showEffectSpeed: 400,
	    hideEffect: "fadeOut",
	    hideEffectSpeed: 400});	
});
</script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> 
<?php 
if($this->get_title('')=="")
echo Settings::get_instance()->read('engine_name');
else
echo Settings::get_instance()->read('engine_name')." - ".$this->get_title();
?>
</title>
</head>
<body>

<?php 
$pageid=$this->get_variable("pageid");
$subid=$this->get_variable("subid");

?>


<div id="header">
<div id="header_insider"  style="width:950px;">
<a href="<?php echo $this->make_url("index/index");?>"><img src="images/logo.png" id="logo"></a>
<div id="top_menus">

<?php 
if(!DEMO_MODE)
{
?>
<a href="<?php echo $this->make_url("index/change_password");?>"><?php echo $this->get_label('Change password');?></a>
 |  
<?php 
}
?>
 
 
<a href="<?php echo $this->make_url("index/logout");?>"><?php echo $this->get_label('logout');?></a>
 |  
<a target="_blank" href="http://xyzscripts.com/php-scripts/xyz-cart/"><?php echo $this->get_label('about us');?></a>
 |  
<a target="_blank" href="http://xyzscripts.com/support/"><?php echo $this->get_label('support');?></a>





</div> <!-- top_menus -->
</div> <!-- header_insider -->
</div> <!-- header -->

<div id="website" style="width:950px;">
<div id="web">
<div id="left">







<div id="widget_left">
<h2><?php echo $this->get_label("dashboard");?></h2>
<ul>
<li><a href="<?php echo $this->make_url("system/home");?>"><img src="images/home.png"><span><?php echo $this->get_label('home');?></span></a></li>

<li><a href="<?php echo $this->make_url("system/todo"); ?>"><img src="images/todo.png"><span><?php echo $this->get_label("todo");?></span></a></li>
<li><a href="<?php echo $this->make_url("user/manage");?>"><img src="images/user.png"><span><?php echo $this->get_label('manage users');?></span></a></li>

<li>
<div class="div_first" ><img class="down_menu" id="aa_8" src="images/down.png"/><img src="images/products.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('manage products');?></span></div>
<div class="div_second" id="_8">
<a  <?php if($subid=='_01') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("product/add"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("add products");?></a>
<a  <?php if($subid=='_02') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("product/manage"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage products");?></a>
<a  <?php if($subid=='_03') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("product/add_banner"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("add banner");?></a>
<a  <?php if($subid=='_05') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("product/manage_banners"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage banners");?></a>
<a  <?php if($subid=='_06') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("product/manage_special_offers"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage special offers");?></a>
<a <?php if($subid=='_07') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("product/manage_stock"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage stock");?></a>
<a <?php if($subid=='_08') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("product/pending_review"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("pending reviews");?></a>

</div>
</li>


<li>
<div class="div_first" ><img class="down_menu" id="aa_7" src="images/down.png"/><img src="images/display.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('manage brands');?></span></div>
<div class="div_second" id="_7">
<a <?php if($subid=='_71') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("product/add_brand")?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label('add brand');?></a>
<a <?php if($subid=='_72') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("product/manage_brands")?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label('manage brands');?></a>
</div>
</li>


</ul>
</div> <!-- widget_left -->

<div id="widget_left">
<h2><?php echo $this->get_label("configurations");?></h2>
<ul>



<li>
<div class="div_first" ><img class="down_menu" id="aa_3" src="images/down.png"/><img src="images/advancedsettings.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('settings');?></span></div>
<div class="div_second" id="_3">
<a  <?php if($subid=='_31') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("system/configure/1"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("configure");?></a>
<a  <?php if($subid=='_32') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("system/format"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("format settings");?></a>

<a  <?php if($subid=='_33') {?>class="div_second_selected"<?php }?>   href="<?php echo $this->make_url("emailtemplate/manage"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("email templates");?></a>

</div>


</li>



<li>
<div class="div_first" ><img class="down_menu" id="aa_4" src="images/down.png"/><img src="images/terms.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('site content');?></span></div>
<div class="div_second" id="_4">
<a <?php if($subid=='_34') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("system/about_us"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("about us");?></a>

<a <?php if($subid=='_44') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("system/privacy"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("privacy policy");?></a>

<a <?php if($subid=='_41') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("system/meta"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("meta data");?></a>
<a <?php if($subid=='_42') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("system/terms"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("terms & conditions");?></a>
</div>
</li>



<li>
<div class="div_first" ><img class="down_menu" id="aa_1" src="images/down.png"/><img src="images/category.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('categories');?></span></div>
<div class="div_second" id="_1">
<a <?php if($subid=='_11') {?>class="div_second_selected"<?php }?>  href="<?php echo $this->make_url("category/add")?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label('add cat');?></a>
<a <?php if($subid=='_12') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("category/manage")?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label('manage cat');?></a>
</div>
</li>






<li>
<div class="div_first" ><img class="down_menu" id="aa_6" src="images/down.png"/><img src="images/custom.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('custom fields');?></span></div>
<div class="div_second" id="_6">
<a <?php if($subid=='_61') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("custom/add_group"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("add custom field group");?></a>
<a <?php if($subid=='_62') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("custom/manage_group"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage custom field group");?></a>
<a <?php if($subid=='_63') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("custom/add"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("add custom fields");?></a>
<a <?php if($subid=='_64') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("custom/manage"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage custom fields");?></a>
</div>
</li>







<li>
<div class="div_first" ><img class="down_menu" id="aa_2" src="images/down.png"/><img src="images/shipment1.png" style="margin-left: -17px;"><span style="margin-top: 10px;"><?php echo $this->get_label('manage shipping');?></span></div>
<div class="div_second" id="_2">
<a <?php if($subid=='_21') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("shipping/add"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("add shipping");?></a>
<a <?php if($subid=='_22') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("shipping/manage"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage shipping companies");?></a>
<a <?php if($subid=='_23') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("shipping/add_shipping_class"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("add shipping class");?></a>
<a <?php if($subid=='_24') {?>class="div_second_selected"<?php }?> href="<?php echo $this->make_url("shipping/manage_shipping_classes"); ?>"><img class="header_img" src="images/arrow-icon.png" /><?php echo $this->get_label("manage shipping classes");?></a>
</div>
</li>



</ul>
</div> <!-- widget_left -->


<div id="widget_left">
<h2><?php echo $this->get_label("sales");?></h2>
<ul>


<li>
<a href="<?php echo $this->make_url("sales/manage"); ?>"><img class="header_img" src="images/sales.png" /><span><?php echo $this->get_label("manage orders");?></span></a>
</li>

<li>
<a href="<?php echo $this->make_url("sales/returns"); ?>"><img class="header_img" src="images/returns.png" /><span><?php echo $this->get_label("manage returns");?></span></a>
</li>

<li>
<a href="<?php echo $this->make_url("sales/payments"); ?>"><img class="header_img" src="images/payment.png" /><span><?php echo $this->get_label("payments");?></span></a>
</li>


</ul>
</div>


<div id="widget_left">
<h2><?php echo $this->get_label("accounts");?></h2>
<ul>

<?php 
if(!DEMO_MODE)
{
?>
<li><a href="<?php echo $this->make_url("index/change_password"); ?>"><img src="images/changepwd.png"><span><?php echo $this->get_label("Change password");?></span></a></li>
<?php 
}
?>

<li><a href="<?php echo $this->make_url("index/logout"); ?>"><img src="images/logout.png"><span><?php echo $this->get_label("logout");?></span></a></li>
</ul>
</div> <!-- widget_left -->



<div id="widget_left">
<h2><?php echo $this->get_label("help");?></h2>
<ul>

<li><a target="_blank" href="http://help.xyzscripts.com/docs/xyz-shopping-cart/user-guide/"><img  src="images/help.png" /><span><?php echo $this->get_label("user guide");?></span></a></li>
<li><a target="_blank" href="http://help.xyzscripts.com/docs/xyz-shopping-cart/faq/"><img  src="images/help_guide.png" /><span><?php echo $this->get_label("knowledge base");?></span></a></li>

</ul>
</div> <!-- widget_left -->




</div> <!-- left -->
<div id="right">


<script type="text/javascript">


$(document).ready(function() {
	  $('img').hover(function(){
          var thisWidth=$(this).outerWidth()/2;
          var offset=$(this).position();
          var thisHeight=$(this).outerHeight();
          var tool_topPos=offset.top;
          var tool_leftPos=offset.left; 
          var tool_rtPos=($(window).width()-tool_leftPos)-$(this).outerWidth(); 
          var tooltip_msg=$(this).attr('title');
          if ($(this).attr('title'))
          {
	          $(this).attr('title',"");
	          var elmt="<span class='xyz-info'><strong>"+tooltip_msg+"</strong><b>&nbsp</b></span>";
	          $(this).after(elmt); 
	          $(".xyz-info").css({left:tool_leftPos+"px",maxWidth:"300px"});
	          var tooltipheight=$(this).next(".xyz-info").height();
	          var tipheight=$(this).next(".xyz-info b").height()+10;
	          var hltooltipwidth=$(this).next(".xyz-info").outerWidth()/2;
	          var tooltipwidth=($(this).next(".xyz-info").outerWidth()/2)-thisWidth;
	          var finalTop=(tool_topPos-tooltipheight)-($(this).outerHeight()+5);
	          var finalTop2 =tool_topPos+thisHeight+tipheight;
	         
	          if ( (tool_leftPos < hltooltipwidth) && (tool_topPos-tooltipheight)<0)
	          {
	             $(".xyz-info").css({left:tool_leftPos+"px",top:finalTop2+20+"px",marginLeft:+"0px",opacity:"0",zIndex:9999});
	               $(".xyz-info").animate({top:finalTop2+"px",opacity:"1"},200); 
	             $(".xyz-info b").addClass("top-lft");  
	          }
	          
	         if (tool_leftPos < hltooltipwidth && (tool_topPos-tooltipheight)>0)
	          {
	              $(".xyz-info").css({left:tool_leftPos+"px", top:finalTop-tipheight+"px",marginLeft:-tooltipwidth+"px",opacity:"0",zIndex:9999});
	              $(".xyz-info").animate({top:finalTop+"px",opacity:"1"},200);  
	              $(".xyz-info b").addClass("lft");
	          }
	          
	          
	        if ( (tool_leftPos > hltooltipwidth)&&(tool_topPos-tooltipheight)<0 )
	          {
	             $(".xyz-info").css({top:finalTop2+20+"px",marginLeft:-tooltipwidth+"px",opacity:"0",zIndex:9999});
	               $(".xyz-info").animate({top:finalTop2+"px",opacity:"1"},200); 
	             $(".xyz-info b").addClass("top");
	          }
	          
	         if( (tool_leftPos > hltooltipwidth) && (tool_topPos-tooltipheight)>0 )
	          {
	    
	          $(".xyz-info").css({top:finalTop-tipheight+"px",marginLeft:-tooltipwidth+"px",opacity:"0",zIndex:9999});
	          $(".xyz-info").animate({top:finalTop+"px",opacity:"1"},200);  
	          }
          }
    },function(){
        var tooltip_msg_rtn=$(this).next('.xyz-info').children("strong").html();
        $(".xyz-info").remove();
        $(this).attr('title',tooltip_msg_rtn);
        });
/////////////
	pageids=0;
	pageids=<?php echo $pageid;?>;

	if(pageids >0)
	{
		$("#_1").hide("slow");
		$("#_2").hide("slow");
		$("#_3").hide("slow");
		$("#_4").hide("slow");
		$("#_5").hide("slow");
		$("#_6").hide("slow");
		$("#_7").hide("slow");
		$("#_8").hide("slow");

		//$("#_"+pageids).show("slow");

		$("#_"+pageids).slideDown("slow");

		$("#aa_"+pageids).attr("src","images/up-arrow.png");
	}





	  $(function(){
          this. onclick = function(event) 
          {
           if (!event) 
           event = window.event;
           var target = (event.target) ? event.target : event.srcElement;






if(target.id =="aa_1" && $("#aa_1").attr("src") == "images/up-arrow.png")
{
	$("#_1").slideUp("slow");
	$("#aa_1").attr("src","images/down.png");
}	
else if(target.id =="aa_2" && $("#aa_2").attr("src") == "images/up-arrow.png")
{
	$("#_2").slideUp("slow");
	$("#aa_2").attr("src","images/down.png");
}
else if(target.id =="aa_3" && $("#aa_3").attr("src") == "images/up-arrow.png")
{
	$("#_3").slideUp("slow");
	$("#aa_3").attr("src","images/down.png");
}
else if(target.id =="aa_4" && $("#aa_4").attr("src") == "images/up-arrow.png")
{
	$("#_4").slideUp("slow");
	$("#aa_4").attr("src","images/down.png");
}
else if(target.id =="aa_5" && $("#aa_5").attr("src") == "images/up-arrow.png")
{
	$("#_5").slideUp("slow");
	$("#aa_5").attr("src","images/down.png");
}
else if(target.id =="aa_6" && $("#aa_6").attr("src") == "images/up-arrow.png")
{
	$("#_6").slideUp("slow");
	$("#aa_6").attr("src","images/down.png");
}
else if(target.id =="aa_7" && $("#aa_7").attr("src") == "images/up-arrow.png")
{
	$("#_7").slideUp("slow");
	$("#aa_7").attr("src","images/down.png");
}
else if(target.id =="aa_8" && $("#aa_8").attr("src") == "images/up-arrow.png")
{
	$("#_8").slideUp("slow");
	$("#aa_8").attr("src","images/down.png");
}
else if(target.id =="aa_1")
{


	$("#_2").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_7").slideUp("slow");
	$("#_8").slideUp("slow");
	
	$("#_1").slideDown("slow");


	$("#aa_2").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	
	
    $("#aa_1").attr("src","images/up-arrow.png");
	
}
else if(target.id =="aa_2")
{
	$("#_1").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_7").slideUp("slow");
	$("#_8").slideUp("slow");
	
	$("#_2").slideDown("slow");


	$("#aa_1").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	

	$("#aa_2").attr("src","images/up-arrow.png");

}
else if(target.id =="aa_3")
{
	$("#_1").slideUp("slow");
	$("#_2").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_7").slideUp("slow");
	$("#_8").slideUp("slow");
	
	$("#_3").slideDown("slow");

	$("#aa_1").attr("src","images/down.png");
	$("#aa_2").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	

	$("#aa_3").attr("src","images/up-arrow.png");
	
}  
else if(target.id =="aa_4")
{
	$("#_1").slideUp("slow");
	$("#_2").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_7").slideUp("slow");
	$("#_8").slideUp("slow");
	
	$("#_4").slideDown("slow");

	$("#aa_1").attr("src","images/down.png");
	$("#aa_2").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	

	$("#aa_4").attr("src","images/up-arrow.png");
	
} 
else if(target.id =="aa_5")
{
	$("#_1").slideUp("slow");
	$("#_2").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_7").slideUp("slow");
	$("#_8").slideUp("slow");
	
	$("#_5").slideDown("slow");

	$("#aa_1").attr("src","images/down.png");
	$("#aa_2").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	

	$("#aa_5").attr("src","images/up-arrow.png");
	
}
else if(target.id =="aa_6")
{
	$("#_1").slideUp("slow");
	$("#_2").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_7").slideUp("slow");
	$("#_8").slideUp("slow");
	
	$("#_6").slideDown("slow");

	$("#aa_1").attr("src","images/down.png");
	$("#aa_2").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	

	$("#aa_6").attr("src","images/up-arrow.png");
	
}
else if(target.id =="aa_7")
{
	$("#_1").slideUp("slow");
	$("#_2").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_7").slideDown("slow");
	$("#_8").slideUp("slow");

	$("#aa_1").attr("src","images/down.png");
	$("#aa_2").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_8").attr("src","images/down.png");
	

	$("#aa_7").attr("src","images/up-arrow.png");
	
}
else if(target.id =="aa_8")
{
	$("#_1").slideUp("slow");
	$("#_2").slideUp("slow");
	$("#_3").slideUp("slow");
	$("#_4").slideUp("slow");
	$("#_5").slideUp("slow");
	$("#_6").slideUp("slow");
	$("#_8").slideDown("slow");
	$("#_7").slideUp("slow");

	$("#aa_1").attr("src","images/down.png");
	$("#aa_2").attr("src","images/down.png");
	$("#aa_3").attr("src","images/down.png");
	$("#aa_4").attr("src","images/down.png");
	$("#aa_5").attr("src","images/down.png");
	$("#aa_6").attr("src","images/down.png");
	$("#aa_7").attr("src","images/down.png");
	

	$("#aa_8").attr("src","images/up-arrow.png");
	
}
	}
       
      });
	
	


	

});

</script>
