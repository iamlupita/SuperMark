<?php $this->dispatch("layout/header/6/_61");?>
<?php
$validate=array(
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);

if($_POST)
$group_name=$this->get_variable('name');
else
$group_name="";



$form=$this->create_form();
$form->start("custom_add",$this->make_url("custom/add_group"),"post",$validate);




?>


<div class="sub_menu"><?php echo $this->get_label('add custom field group');?></div>



<table cellpadding="0" cellspacing="0" style="width: 100%">

<tr><td colspan="3" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>


<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td width="133px"><?php echo $this->get_label("select category");?></td>
<td width="20px">:</td>
<td>
<select id="cat_id" name="cat_id" data-size="12"><?php echo $this->get_variable('categories');?></select>

</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
<td ></td>
<td><?php echo $this->get_label("group name");?></td>
<td>:</td>
<td><input type="text" name="name" id="name" value="<?php echo $group_name; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label("group name");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
<td></td>
<td></td>
<td></td>
<td ><input type="submit" name="submit" value="<?php echo $this->get_label("submit");?>" class="btn btn-default" ></td>
<td></td>
</tr>
</table>


<?php
$form->end();
$this->dispatch("layout/footer");?>