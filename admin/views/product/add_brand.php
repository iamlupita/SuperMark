<?php 
$this->dispatch("layout/header/7/_71");


$validate=array(
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);

if($_POST)
{
	$field_name=$this->get_variable('name');
}
else
{
	$field_name="";
}

$form=$this->create_form();
$form->start("brand_add",$this->make_url("product/add_brand"),"post",$validate);

?>


<div class="sub_menu"><?php echo $this->get_label('add brand');?></div>

<table cellpadding="0" cellspacing="0" style="width: 100%">

<tr><td colspan="3" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>

<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("brand name");?></td>
<td>:</td>
<td><input type="text" name="name" id="name" value="" class="textStylePadding" placeholder="<?php echo $this->get_label("brand name");?>"><span class="compulsory">*</span></td>
<td></td> <td>
</td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td></td>
<td></td>
<td></td>
<td ><input type="submit" name="submit" value="<?php echo $this->get_label("submit");?>" class="btn btn-default"></td>
<td></td>
</tr>
</table>


<?php
$form->end();
$this->dispatch("layout/footer");?>