<?php 
$this->dispatch("layout/header/6/_62");

$id=$this->get_variable('id');	
$group_name=$this->get_variable('name');		

$flag=$this->get_variable('flag');
$categ=$this->get_variable('categ');



$validate=array(
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);
$form=$this->create_form();
$form->start("custom_edit",$this->make_url("custom/editgroup/".$id),"post",$validate);
?>

<div class="sub_menu"><?php echo $this->get_label('edit custom field group');?></div>


<table cellpadding="0" cellspacing="0" width="100%" >


<tr><td colspan="2" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>




<tr><td colspan="4" height="10px"></td></tr>
<?php 
if($flag==0)
{
?>
<tr>
<td width="180px"><?php echo $this->get_label("select category");?></td>
<td width="20px">:</td>
<td><select name="catid" id="catid"><?php echo $this->get_variable("categories");?></select></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>

<?php 
}
else
{?>
<tr>
<td width="180px"><?php echo $this->get_label("select category");?></td>
<td width="20px">:</td>
<td>
<input type="hidden" name="catid" id="catid" value="<?php echo $categ;?>"/>
<?php 
 if($categ!=0)
 echo $this->escape($this->get_category_name($categ));
 else
 echo $this->get_label('general'); 
?>

</td>
<td></td>
</tr>
<tr><td colspan="4" height="10px"></td></tr>
<?php 
}
?>
<tr>
<td><?php echo $this->get_label("group name");?></td>
<td>:</td>
<td><input type="text" name="name" value="<?php echo $group_name; ?>"><span class="compulsory">*</span></td>
<td></td>
</tr>

<tr><td colspan="4" height="10px"></td></tr>

<tr>
<td></td>
<td></td>

<td ><input type="hidden" name="id" id="id" value="<?php echo $id;?>">

<input type="submit" name="submit" value="<?php echo $this->get_label("submit");?>"></td>
<td></td>
</tr>
</table>


<?php
$form->end();
$this->dispatch("layout/footer");?>