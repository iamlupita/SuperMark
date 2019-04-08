<?php 
$this->dispatch("layout/header/8/_02");
$uid=$this->get_variable('uid');
$addimage=$this->get_variable('addimage');
?>
<script type="text/javascript">
function makeimagefeatured(imageid,pid)
{

 	$.ajax(
	{
		type: "GET",
		url: "<?php echo $this->make_url("product/make_image_featured/");?>"+imageid+"/"+pid,
		success: function(msg)
			{
				 set_jnotice(1,'<?php echo $this->get_message('image status updated');?>');
				 window.location.reload();			
			}
	});
}
function delete_image(imageid,pid)
{

 	$.ajax(
	{
		type: "GET",
		url: "<?php echo $this->make_url("product/delete_image/");?>"+imageid+"/"+pid,
		success: function(msg)
			{
				 set_jnotice(1,'<?php echo $this->get_message('image deleted');?>');
				 $('#image_'+imageid).remove();	 	
				 window.location.reload();
			}
	});
}
function loadImage()
{
	$("#imgpop").show();
	$("#back").show();

	var ie=document.all && !window.opera;
	var iebody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body ;

	ht=(ie)? iebody.clientHeight: window.innerHeight ;
	wt=(ie)? iebody.clientWidth : window.innerWidth ;
	

	$("#imgpop").css('top',ht/2-150 +'px');
	$("#imgpop").css('left',wt/2-250 +'px');
}
function closeImage()
{
	$("#imgpop").hide();
	$("#back").hide();
}
</script>
<div class="sub_menu"><?php echo $this->get_label('product details');?>

 <?php 
 
    	if($this->get_variable('status')!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("product/activate/".$this->get_variable('pid'));?>" style="margin-left: 10px;"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
	
	    if($this->get_variable('status')!=0) 
	    {
	    ?><a href="<?php echo $this->make_url("product/block/".$this->get_variable('pid'));?>" style="margin-left: 10px;"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
	    <?php 
	    }
?>
 <a href="<?php echo $this->make_url("product/edit/".$this->get_variable('pid'));?>" style="margin-left: 21px;"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>
  
  <a href="<?php echo $this->make_url("product/delete/".$this->get_variable('pid'));?>" style="margin-left: 10px;" onclick="return confirm('Do you really want to delete item?')"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
  
  <a href="<?php echo $this->make_url("product/add_duplicate/".$this->get_variable('pid'));?>" style="margin-left: 10px;"><img alt="<?php echo $this->get_label('duplicate'); ?>" src="images/l_to_r.png" title="<?php echo $this->get_label('add duplicate'); ?>" /></a>
  
  
  
  
  

</div>



<table cellpadding="0" cellspacing="0" style="width: 100%;" >

<tr>
<td ></td>
<td><?php echo $this->get_label("category");?></td>
<td>:</td>
<td><?php echo $this->get_variable('category'); ?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
  <td></td>
  <td><?php echo $this->get_label("brand");?></td>
  <td>:</td>
  <td><?php if($this->get_variable('brand')!=""){echo $this->get_variable('brand');}else{echo $this->get_label('na');}?></td>
  <td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
	<td></td>
	<td width="35%"><?php echo $this->get_label("product name");?></td>
	<td width="8%">:</td>
	<td><?php echo $this->get_variable('title'); ?></td>
	<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr style="display:none;">
<td></td>
<td><?php echo $this->get_label("product code");?></td>
<td>:</td>
<td><?php echo $this->get_variable('code');?></td>
<td></td>
</tr>
<tr style="display:none;"><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("stock");?></td>
<td>:</td>
<td><?php echo $this->get_variable('stock');?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label("warranty description");?></td>
<td>:</td>
<td><?php if($this->get_variable('warranty_description')!=""){echo $this->get_variable('warranty_description');}else{echo $this->get_label('na');}?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label("item desc");?></td>
<td>:</td>
<td><div class="description-special"><?php if($this->get_variable('description')!=""){echo $this->get_variable('description');}else{echo $this->get_label('na');}?></div></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>




<tr>
<td></td>
<td><?php echo $this->get_label("featured");?></td>
<td>:</td>
<td><?php echo $this->get_featured_status($this->get_variable('featured')); ?></td>
<td></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>

<tr><td colspan="5" height="10px">
<div class="sub_menu"><?php echo $this->get_label('seo details');?></div>
</td></tr>

<tr>
  <td></td>
  <td><?php echo $this->get_label("page title");?></td>
  <td>:</td>
  <td><?php if($this->get_variable('pagetitle')!=""){echo $this->get_variable('pagetitle');}else{echo $this->get_label('na');} ?></td>
  <td></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>
<tr>
  <td></td>
  <td><?php echo $this->get_label("meta keywords");?></td>
  <td>:</td>
  <td><?php if($this->get_variable('metakeywords')!=""){echo $this->get_variable('metakeywords');}else{echo $this->get_label('na');}?></td>
  <td></td>
</tr>

<tr><td colspan="5" height="10px"></td></tr>

<tr>
  <td></td>
  <td><?php echo $this->get_label("meta description");?></td>
  <td>:</td>
  <td><?php if($this->get_variable('metadescrip')!=""){echo $this->get_variable('metadescrip');}else{echo $this->get_label('na');}?></td>
  <td></td>
</tr>


<tr><td colspan="5" height="10px"></td></tr>





<tr><td colspan="5" height="10px">
<div class="sub_menu"><?php echo $this->get_label('pricing details');?></div>
</td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("mrp");?></td>
<td>:</td>
<td><?php if($this->get_variable('mrp')!="" && $this->get_variable('mrp')!=0){echo $this->get_money_format($this->get_variable('mrp'));}else{echo $this->get_label('na');}?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("sale price");?></td>
<td>:</td>
<td><?php if($this->get_variable('sale_price')!="" && $this->get_variable('sale_price')!=0){echo $this->get_money_format($this->get_variable('sale_price'));}else{echo $this->get_label('na');}?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("special offer price");?></td>
<td>:</td>
<td><?php if($this->get_variable('special_offer_price')!="" && $this->get_variable('special_offer_price')!=0){echo $this->get_money_format($this->get_variable('special_offer_price'));}else{echo $this->get_label('na');}?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("gift wrapping");?></td>
<td>:</td>
<td><?php echo $this->get_featured_status($this->get_variable('wrap_status'));?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td><?php echo $this->get_label("special offer from");?></td>
<td>:</td>
<td><?php if($this->get_variable('special_offer_from')!="" && $this->get_variable('special_offer_from')!=0){echo $this->get_date_format(3,$this->get_variable('special_offer_from'));}else{echo $this->get_label('na');}?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
<td ></td>
<td><?php echo $this->get_label("special offer to");?></td>
<td>:</td>
<td><?php if($this->get_variable('special_offer_to')!="" && $this->get_variable('special_offer_to')!=0){echo $this->get_date_format(3,$this->get_variable('special_offer_to'));}else{echo $this->get_label('na');}?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>




<tr>
<td ></td>
<td><?php echo $this->get_label("shipping class");?></td>
<td>:</td>
<td><?php echo $this->escape($this->get_shipping_class($this->get_variable('shipping_class')));?></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>




<tr><td colspan="5" height="10px"></td></tr>
<tr><td colspan="5" height="10px"><?php echo $this->get_customfield_values_from_admin($this->get_variable('pid'),$this->get_variable('catid'));?></td></tr>


<?php
$res1=$this->get_result('res');
if(count($res1)>0){
?>
<tr><td colspan="5" height="10px">

<div class="sub_menu"><?php echo $this->get_label('product images');?></div>
</td></tr>
<?php }?>

</table>


<table style="width: 100%">
<tr><td>
<?php 

foreach ($res1 as $key=>$value)
{ 
	list($widthimage,$heightimage) = @getimagesize('../'.DATA_DIR."/prodimages/".$this->get_variable('pid')."/s_".$value['pro_image_file']);
	$dimension=$this->get_image_dimension($widthimage,$heightimage,6);
	$dimensionarray=explode('_',$dimension);
?>

<div class="divouter">
<div class="divinner_image">
<div>

<img style="width: <?php echo $dimensionarray[0];?>px;height: <?php echo $dimensionarray[1];?>px;"  src="../<?php echo DATA_DIR;?>/prodimages/<?php echo $this->get_variable('pid')."/s_".$value['pro_image_file']; ?>" />

</div>

</div>
<div class="divinner_action">

<?php if($value['preview']==1){?><img alt="<?php echo $this->get_label('featured'); ?>" src="images/star-gold24.png" title="<?php echo $this->get_label('Featured'); ?>" /><?php }else{ ?>
  <span onclick="makeimagefeatured(<?php echo $value['id'].','.$this->get_variable('pid')?>)"><img alt="<?php echo $this->get_label('makefeatured'); ?>" src="images/star-white24.png" title="<?php echo $this->get_label('makefeatured'); ?>" /></span><?php }?>

  &nbsp;&nbsp;&nbsp;
    <span onclick="delete_image(<?php echo $value['id'].','.$this->get_variable('pid')?>)"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></span>
     
</div>
</div>
<?php 
}
?>
</td></tr>
</table>



<?php 

if($addimage==1){?>

<script type="text/javascript">
$(document).ready(function(){
	$(".closeButton").click(function(){

		$("#images_div").hide('slow');
	});
	
});
</script>

<?php 
$img_count=$this->get_variable('img_count');
$max_image=$this->get_variable('max_images');
?>
<div id="images_div" >
<div class="behind_div">
<div class="popups">
<div class="sub_menu"><?php echo $this->get_label('product images');?>

<span style="margin-left:35px;" ><?php echo $this->get_label('maximum images',array('x'=>$max_image));?>
<a href="<?php echo $this->make_url("product/details/".$this->get_variable('pid'));?>" style="margin-left: 10px;"><?php echo $this->get_label('continue');?></a></span>



<a class="closeButton">X</a>
</div>

<table style="width: 100%">
<tr><td>
<?php 
$res1=$this->get_result('res');
foreach ($res1 as $key=>$value)
{ 
	list($widthimage,$heightimage) = @getimagesize('../'.DATA_DIR."/prodimages/".$this->get_variable('pid')."/s_".$value['pro_image_file']);
	$dimension=$this->get_image_dimension($widthimage,$heightimage,6);
	$dimensionarray=explode('_',$dimension);
?>

<div class="divouter" id="image_<?php echo $value['id'] ?>">
<div class="divinner_image">
<div>

<img style="width: <?php echo $dimensionarray[0];?>px;height: <?php echo $dimensionarray[1];?>px;"  src="../<?php echo DATA_DIR;?>/prodimages/<?php echo $this->get_variable('pid')."/s_".$value['pro_image_file']; ?>" />

</div>

</div>
<div class="divinner_action">

<span onclick="delete_image(<?php echo $value[id].','.$this->get_variable('pid')?>)"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></span>
</div>
</div>

<?php 
}
?>
</td></tr>
</table>
<?php 


if($img_count < $max_image)
{
$form=$this->create_form();
$form->start("product_add",$this->make_url("product/manage_image/".$this->get_variable("pid")."/2/1"),"post");	

?>
<div class="sub_menu"><?php echo $this->get_label('add product images');?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $this->get_label('image max dimension',array('x'=>Settings::get_instance()->read('img_maxwt'),'y'=>Settings::get_instance()->read('img_maxht')));?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $this->get_label('image max size',array('x'=>Settings::get_instance()->read('img_maxsize')));?>

</div>
<table style="width: 100%;">
<tr><td>
<?php

for($i=$max_image-$img_count;$i>0;$i--) {?>
<div class="upload_div"><input name="image[]" type="file" size="10" /></div>
<?php }?>

</td></tr></table>

<div height="10px" style="margin-top: 10px;">&nbsp;</div>
<input type="submit" class="btn btn-default" name="submit" value="<?php echo $this->get_label('upload');?>" >
<?php
$form->end();
 
}
?>


</div></div></div>
<?php 
}
?>
<?php 
$this->dispatch("layout/footer");?>