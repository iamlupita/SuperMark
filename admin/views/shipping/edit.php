<?php $this->dispatch("layout/header/2/_22");
$validate=array(
	    "shipping"=>array(
			"notNull"=>array($this->get_message("mandatory"))
		),
		"url"=>array(
				"notNull"=>array($this->get_message("mandatory"))
				
		)
		
	);



	$id=$this->get_variable('id');
	$shipping=$this->get_variable('shipping');
	$url=$this->get_variable('url');
	
$form=$this->create_form();
$form->start("add_plan",$this->make_url("shipping/edit"),"post",$validate);
?>

<div class="sub_menu"><?php echo $this->get_label('edit shipping');?></div>



<table style="width: 100%" cellpadding="0" cellspacing="0">
 
 
  <tr>
    <td ></td>
    <td width="150px"><?php echo $this->get_label('shipping company');?></td>
    <td><input name="shipping" type="text" id="shipping" value="<?php echo $shipping; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label('shipping company'); ?>"><span class="mandatory">*</span></td>
    <td>&nbsp;</td>
  </tr>
   
  <tr><td colspan="4" height="10px"></td></tr>
  
      <tr>
    <td>&nbsp;</td>
    <td ><?php echo $this->get_label('tracking url'); ?></td>
    <td><input name="url" type="text" id="url" value="<?php echo $url; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label('url'); ?>"><span class="mandatory">*</span></td>
    <td>&nbsp;</td>
  </tr>
  
  
    <tr><td colspan="4" height="10px"></td></tr>
  
  
 
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>
    <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
    <input type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" class="btn btn-default"></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php $form->end(); ?>
<?php $this->dispatch("layout/footer");?>
<script language="javascript" type="text/javascript">
function setcategories(cat_type)
{
//alert(cat_type);
	if(cat_type==1)
	{
			$("#categories").show("slow");
	} 
	else
	{
			$("#categories").hide("slow");
	}
}
$("#cat_type").change(function()
{
	setcategories($("#cat_type").val());
})
//alert($("#cat_type").val());
//setcategories(<?php echo $this->get_variable('cat_type'); ?>);
</script>