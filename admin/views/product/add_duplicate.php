<?php 
$this->dispatch("layout/header/8/_02");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$availmsg=$this->get_message('available');
$notavailmsg=$this->get_message('not available');
?>

<script type="text/javascript" src='<?php echo BASE?>library/tinymce/jscripts/tiny_mce/tiny_mce.js'></script>

<script type="text/javascript">
	tinyMCE.init({
		mode :             "exact",                 // only one textarea id may be replaced
		plugins : "paste",
		elements:         "description1",    
		theme : "simple",
		content_css:"<?php echo COMMON_DIR_PATH; ?>css/tinymce.css",
		

paste_preprocess : function(pl, o) {
			  o.content = strip_tags( o.content,'<b><u><i>' );
			},

			
	});

	</script>
<?php
$validate=array(

		"category_0"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),
		/*"code"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),*/
		"stock"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"desc"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),
		"mrp"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),
		"saleprice"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),
		"shipping_class"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"dynamic_form_fields"=>array(
				"dynamicNotNull"=>array($this->get_message("mandatory"))
				)
);




$form=$this->create_form();
$form->start("product_add",$this->make_url("product/add"),"post",$validate);
?>


<div class="sub_menu"><?php echo $this->get_label('add duplicate');?></div>

<table cellpadding="0" cellspacing="0" style="width: 100%">

<tr><td colspan="3" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td width="180px"><?php echo $this->get_label("select category");?></td>
<td width="20px">:</td>
<td>
<select id="category_0" name="category_0" data-size="12"><?php echo $this->get_variable('categories');?></select><span class="compulsory" style="padding-top: 40px;">*</span>

</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td width="180px"><?php echo $this->get_label("select brand");?></td>
<td width="20px">:</td>
<td>
<select name="brand" id="brand"></select>
<div id="brandmsg" style="display: none;"><?php echo $this->get_message("no brands available")?></div>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
<td ></td>
<td><?php echo $this->get_label("product name");?></td>
<td>:</td>
<td><input type="text" name="name" id="name" onchange="checkprodname(this.value)"  value="<?php echo $this->get_variable('name');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("product name");?>"><span class="compulsory">*</span> 
&nbsp;&nbsp;&nbsp;<span id="msge"><?php echo $this->get_label('change product name');?></span>
<div class="notification">[<?php echo $this->get_label('maximum title length is',array('x'=>Settings::get_instance()->read('max_ad_title_length'))); ?>]</div>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr style="display:none;">
<td ></td>
<td><?php echo $this->get_label("product code");?></td>
<td>:</td>
<td><input type="text" name="code" id="code" onchange="check_product_code(this.value)" value="<?php echo $this->get_variable('code');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("product code");?>"><span class="compulsory">*</span><label id="availability2"></label></td>
<td></td>
</tr>
<tr style="display:none;"><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("stock");?></td>
<td>:</td>
<td><input type="text" name="stock" id="stock" onkeyup="this.value = this.value.replace(/[^0-9]/g,'');"  value="<?php echo $this->get_variable('stock');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("stock");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("warranty description");?></td>
<td>:</td>
<td><textarea name="warranty_description" id="warranty_description" style="width:230px;height:100px;font-size:13px;font-family: Arial, Helvetica, sans-serif;" class="textStylePadding"><?php echo $this->get_variable('warranty_description');?></textarea></td>
<td></td>
</tr> 
 
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("description");?><span class="compulsory">*</span></td>
<td>&nbsp;</td>
<td><div class="notification">[<?php echo $this->get_label('maximum description length is',array('x'=>Settings::get_instance()->read('max_ad_description_length'))); ?>]</div></td>

</tr>
<tr><td colspan="5" >
<textarea name="description1" id="description1" style="width:650px;height:250px" ><?php echo  $this->get_variable('desc');?></textarea>
</td></tr>
  
 
 
<tr><td colspan="5" height="10px"></td></tr>



<tr><td colspan="5" height="10px">
<div class="sub_menu"><?php echo $this->get_label('pricing details');?></div>
</td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("mrp");?> (<?php echo Settings::get_instance()->read('currency_symbol');?>)</td>
<td>:</td>
<td><input type="text" name="mrp" id="mrp" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php echo $this->get_variable('mrp');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("mrp");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("offer price");?> (<?php echo Settings::get_instance()->read('currency_symbol');?>)</td>
<td>:</td>
<td><input type="text" name="saleprice" id="saleprice" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');"  value="<?php echo $this->get_variable('saleprice');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("offer price");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>




<tr>
<td ></td>
<td><?php echo $this->get_label("special offer price");?> (<?php echo Settings::get_instance()->read('currency_symbol');?>)</td>
<td>:</td>
<td><input type="text" name="offerprice" id="offerprice" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');"  value="<?php echo $this->get_variable('offerprice');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("special offer price");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<?php if($this->get_variable('offerpricefrom') >0)
  {
	  $td=date('d',$this->get_variable('offerpricefrom'));
	  $tm=date('m',$this->get_variable('offerpricefrom'));
	  $ty=date('Y',$this->get_variable('offerpricefrom'));
  } ?>

<tr>
<td ></td>
<td><?php echo $this->get_label("special offer from");?></td>
<td>:</td>
<td><input type="text" name="offerpricefrom" id="offerpricefrom" value="<?php if($this->get_variable('offerpricefrom')>0){echo $td.'/'.$tm.'/'.$ty;}?>" class="textStylePadding" placeholder="<?php echo $this->get_label("special offer from");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<?php if($this->get_variable('offerpriceto') >0)
  {
	  $td=date('d',$this->get_variable('offerpriceto'));
	  $tm=date('m',$this->get_variable('offerpriceto'));
	  $ty=date('Y',$this->get_variable('offerpriceto'));
  } ?>
<tr>
<td ></td>
<td><?php echo $this->get_label("special offer to");?></td>
<td>:</td>
<td><input type="text" name="offerpriceto" id="offerpriceto" value="<?php if($this->get_variable('offerpriceto')>0){echo $td.'/'.$tm.'/'.$ty;}?>" class="textStylePadding" placeholder="<?php echo $this->get_label("special offer to");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("gift wrapping");?></td>
<td>:</td>
<td><select name="wrap_status" id="wrap_status">
<option value="0" <?php if($this->get_variable('wrap_status')==0) echo "selected";?>>No</option>
<option value="1" <?php if($this->get_variable('wrap_status')==1) echo "selected";?>>Yes</option>

</select></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("shipping class");?></td>
<td>:</td>
<td>
<select name="shipping_class" id="shipping_class">
<option value="" selected="selected"><?php echo $this->get_label('select');?></option>
<?php 
$sh_res=$this->get_result('res1');
foreach ($sh_res as $key=>$value)
{
?>
<option value="<?php echo $value['id'];?>" <?php if($this->get_variable('shipping_class')==$value['id']){?>selected="selected" <?php }?>><?php echo $value['class_name'];?></option>
<?php } ?>
</select>
<span class="compulsory" style="padding-top: 20px;">*</span>
</td>
<td></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>


<tr><td colspan="5" height="10px">
<div class="sub_menu"><?php echo $this->get_label('seo details');?></div>
</td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("page title");?></td>
<td>:</td>
<td><input type="text" name="ptitle" id="ptitle" value="<?php echo $this->get_variable('ptitle');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("page title");?>"></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("meta keywords");?></td>
<td>:</td>
<td><input type="text" name="mkey" id="mkey" value="<?php echo $this->get_variable('mkey');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("meta keywords");?>"></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("meta description");?></td>
<td>:</td>
<td><input type="text" name="mdesc" id="mdesc" value="<?php echo $this->get_variable('mdesc');?>" class="textStylePadding" placeholder="<?php echo $this->get_label("meta description");?>"></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr><td colspan="5" height="10px"><div id="custom"></div></td></tr>

<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td></td>
<td></td>
<td><input type="hidden" value="<?php echo $this->get_variable('pid');?>" name="proid">
</td>
<td ><input type="submit" name="submit" value="<?php echo $this->get_label("submit");?>" class="btn btn-default"></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
</table>


<?php
$form->end();
?>



<?php 

$this->dispatch("layout/footer");?>

<script type="text/javascript">


$(document).ready(function() {
	$("#offerpricefrom").datepicker({dateFormat : 'dd/mm/yy'});
	$("#offerpriceto").datepicker({dateFormat : 'dd/mm/yy'});
	
	var cat_id=<?php echo $this->get_variable('cat_id');?>;
	
	 if(cat_id!="" && cat_id!=0)
	 loadBrands(cat_id);

	 $("#category_0").change(function()
				{
				if(this.value!="")
			     loadBrands(this.value);
				});
	

});


function loadBrands(selected)
{
	catid=selected;
    if(catid =="")
   	catid=0;
    brand="<?php echo $this->get_variable('brand');?>";
    $.ajax(
    		{
    		type: "GET",
    		url: "<?php echo $this->make_url("product/show_brands/");?>"+catid+"/"+brand,
    		success: function(msg)
    			{
    			$("#brand").empty().selectBoxIt("refresh");
    			if(msg=="" && catid!=0)
    			{
	    			$("#brandmsg").show();
	    			$("#brand").hide(); 
	    		}
    			else	
    			{	
    				$("#brandmsg").hide();
	    			$("#brand").show().html(msg);
	    			$("#brand").selectBoxIt("refresh");
    			}	
    			}
    		});

    loadcustom(selected);
}

function loadcustom(selected)
{
	cat=selected;
	var pid=<?php echo $this->get_variable('pid');?>;
	if(cat!="")
	{
		$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("product/get_customfield_values_edit/");?>"+cat+"/"+pid,
		cache:false,
		success: function(msg)
			{
			 var tmp = msg.split("#<>#");
			  $("#dynamic_form_fields").val(tmp[1]);
			  $("#custom").html(tmp[0]);
			  $('.numbersOnly').keyup(function () {
				    this.value = this.value.replace(/[^0-9\.]/g,'');
				});
			}
		});
	} 
	else
	{
		 $("#custom").html("");
	}
}

var availmsg='<?php echo $availmsg?>';
var notavailmsg='<?php echo $notavailmsg?>';

function checkprodname(prodname)
{
    if(prodname!="")
   	{
    $.ajax(
    		{
    			type: "POST",cache: false,
    			url: "<?php echo $this->make_url("product/check_product_name");?>",
    			async: false,
             	data: {
	                "prodname": prodname
	             	},
	    		success: function(msg)
    			{
    				$("#msge").show();
    				if(msg==0)
    				{
    					$("#msge").html(availmsg);
        			}	
    				else
    				{
    					$('#name').val("");
    					$('#name').focus();
    					$("#msge").html(notavailmsg);
    				}	
    			}
    		});
   	}
    else
    {
		$('#name').focus();
		alert('<?php echo $this->get_message("mandatory");?>');
    }
}

function check_product_code(name)
{
	if(trim(name)=='')
	{
		$('#availability2').text(""); 
	}
	else
	{
	$.ajax(
			{
			type: "GET",
			url: "<?php echo $this->make_url("product/check_product_code/");?>"+name,
			success: function(msg)
				{
				 if(msg==1)
						$('#availability2').text(availmsg); 
				 else
				 {
					$('#code').val(""); 
					$('#code').focus();
					$('#availability2').text(notavailmsg); 
				 }
				}
			});
	}
}
</script>
					