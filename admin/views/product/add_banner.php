<?php 
$this->dispatch("layout/header/8/_03");

$name=$this->get_variable('name');
$catid=$this->get_variable('catid');
$proid=$this->get_variable('proid');
$type=$this->get_variable('type');
$bannersize=$this->get_variable('bannersize');
$small_banner_width=$this->get_variable('small_banner_width');
$small_banner_height=$this->get_variable('small_banner_height');
$banner_img_maxwt=$this->get_variable('banner_img_maxwt');
$banner_img_maxht=$this->get_variable('banner_img_maxht');
$horizontal_banner_width=$this->get_variable('horizontal_banner_width');
$horizontal_banner_height=$this->get_variable('horizontal_banner_height');
$bannerposition=$this->get_variable('bannerposition');
?>
<script type="text/javascript">
function ClosePopUp()
{
	$('#products').hide();
}
function SelectProduct(id)
{
	$("#products").hide();
	$("#selectedproduct").val(id);
	var name=$("#li_"+id).html();
	$("#selectedproductname").show().html(name);
}
function show_products()
{
	cat=$("#category_0").val();
	if(cat!="")
	{
		$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("product/show_products/");?>"+cat,
		success: function(msg)
			{
			  $("#products").html(msg);
			  $("#products").show();
			 }
		});
	}
	else
	{
		alert("<?php echo $this->get_message('select a category');?>");
	} 
}
</script>

<?php 


$validate=array(
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),
		"category_0"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				),
		"image"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				)
);

$form=$this->create_form();
$form->start("brand_add",$this->make_url("product/add_banner"),"post",$validate);

?>


<div class="sub_menu"><?php echo $this->get_label('add banner');?></div>

<table cellpadding="0" cellspacing="0" style="width: 100%">

<tr><td colspan="3" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>

<tr><td colspan="5" height="10px"></td></tr>




<tr>
<td ></td>
<td style="width: 120px;"><?php echo $this->get_label("banner type");?></td>
<td style="width: 20px;">:</td>
<td>

<input type="radio" name="bannersize" id="big" value="1" <?php if($bannersize ==1){?> checked="checked"<?php }?> onclick="LoadDimension(1);" /><?php echo $this->get_label("home banner big");?>
&nbsp;&nbsp;
<input type="radio" name="bannersize" id="small" value="2" <?php if($bannersize ==2){?> checked="checked"<?php }?> onclick="LoadDimension(2);" /><?php echo $this->get_label("home banner small");?>
&nbsp;&nbsp;
<input type="radio" name="bannersize" id="horizontal" value="3" <?php if($bannersize ==3){?> checked="checked"<?php }?> onclick="LoadDimension(3);" /><?php echo $this->get_label("horizontal banner");?>

</td>
<td></td>
</tr>


<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("banner name");?></td>
<td>:</td>
<td><input type="text" name="name" id="name" value="<?php echo $name;?>" class="textStylePadding" placeholder="<?php echo $this->get_label("banner name");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>






<tr class="horizontal-dropdown" style="display: none;">
<td ></td>
<td><?php echo $this->get_label("banner position");?></td>
<td>:</td>
<td>
<?php 
$featuredquery=$this->get_result('featuredquery');
?>
<select name="bannerposition" id="bannerposition">
<option value="-1" <?php if($bannerposition ==-1){?>selected="selected"<?php }?> ><?php echo $this->get_label("featured product");?></option>
<option value="-2" <?php if($bannerposition ==-2){?>selected="selected"<?php }?> ><?php echo $this->get_label("recent product");?></option>

<?php 
foreach($featuredquery as $key123=>$value123)
{
?>
<option value="<?php echo $value123['id'];?>" <?php if($bannerposition ==$value123['id']){?>selected="selected"<?php }?> ><?php echo $value123['name'];?></option>
<?php }?>
</select>
</td>
<td></td>
</tr>
<tr class="horizontal-dropdown" style="display: none;"><td colspan="5" height="10px"></td></tr>





<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label('upload an image');?></td>
<td>:</td>									
<td><input name="image" type="file" size="11"/><span class="compulsory">*</span>
<br>
<span class="notification" id="big-banner">[<?php echo $this->get_label('max banner dimension',array('x'=>$banner_img_maxwt,'y'=>$banner_img_maxht));?>]</span>	
<span class="notification" id="small-banner" style="display: none;">[<?php echo $this->get_label('max banner dimension',array('x'=>$small_banner_width,'y'=>$small_banner_height));?>]</span>	
<span class="notification" id="horizontal-banner" style="display: none;">[<?php echo $this->get_label('max banner dimension',array('x'=>$horizontal_banner_width,'y'=>$horizontal_banner_height));?>]</span>	

</td>
</tr>


<tr><td colspan="5" height="10px"></td></tr>












<tr>
<td ></td>
<td style="font-weight: bold;text-decoration: underline;"><?php echo $this->get_label("url settings");?></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("banner for");?></td>
<td>:</td>
<td><input type="radio" name="type" id="type" value="2" <?php if($type==2){?> checked="checked"<?php }?> onclick="$('#showprod').hide();$('#selectedproductname').hide();"><?php echo $this->get_label('category');?>
<input type="radio" name="type" id="type" value="1" <?php if($type==1){?>checked="checked" <?php }?> onclick="$('#showprod').show();"><?php echo $this->get_label('product');?>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("select category");?></td>
<td>:</td>
<td>
<select id="category_0" name="category_0" data-size="12"><?php echo $this->get_variable('categories');?></select><span class="compulsory">*</span>
</td>
<td></td>
</tr>



<tr><td colspan="5" height="10px"></td></tr>


<tr id="showprod" style="display: none;" >
<td ></td>
<td><?php echo $this->get_label("selected product");?></td>
<td>:</td>
<td>
<label id="selectedproductname" style="color: green;font-size:12px;font-weight:bold;"></label>
<input type="button" onclick="show_products()" id="showproducts" value="<?php echo $this->get_label('show products');?>" class="btn btn-default">
<div id="products" style="display: none;" >
</div>

</td>
<td></td>
</tr>

			
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td></td>
<td></td>
<td><input type="hidden" name="selectedproduct" id="selectedproduct" value="0"></td>
<td ><input type="submit" name="submit" value="<?php echo $this->get_label("submit");?>" class="btn btn-default"></td>
<td></td>
</tr>
</table>


<?php
$form->end();
$this->dispatch("layout/footer");?>
<script type="text/javascript">
function LoadDimension(type)
{
	if(type ==1)
	{
		$('#big-banner').show();
		$('#small-banner').hide();
		$('#horizontal-banner').hide();
		$('.horizontal-dropdown').hide();
	}
	else if(type ==2)
	{
		$('#small-banner').show();
		$('#big-banner').hide();
		$('#horizontal-banner').hide();
		$('.horizontal-dropdown').hide();
	}
	else if(type ==3)
	{
		$('#small-banner').hide();
		$('#big-banner').hide();
		$('#horizontal-banner').show();
		$('.horizontal-dropdown').show();
	}
}

$(document).ready(function() 
{
	type=$('input[name=type]:checked').val();
	if(type ==1)
	$('#showprod').show();

	LoadDimension($('input[name=bannersize]:checked').val());
});
</script>