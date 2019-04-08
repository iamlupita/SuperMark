<?php 
$this->dispatch("layout/header/6/_64");

$validate=array(
	"field_name"=>array(
			"notNull"=>array($this->get_message("mandatory"))
	),
	"field_type=>'dropdown'" => array(
		"value1"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
	)
);

if($_POST){
	$field_name=$this->get_variable('field_name');
	$value=$this->get_variable('value1');
}
$field_id=$this->get_variable('field_id');

$form=$this->create_form();
$form->start("custom_add",$this->make_url("custom/edit/$field_id"),"post",$validate);

?>


<div class="sub_menu"><?php echo $this->get_label('edit custom fields');?></div>


<?php
$res=$this->get_result('res');
foreach($res as $key=>$row)
{
	if(!$_POST)
	{
		$field_name=$row['field_name'];
		$value=$row['value'];
	}
?>
<table style="width: 100%">




<tr><td colspan="3" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>


<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td width="180px"><?php echo $this->get_label("category");?></td>
<td width="20px">:</td>
<td>
 <?php 
    if($row['catid']!=0)
    { 
    	echo $this->escape($this->get_category_name($row['catid']));
    }
    else
    {
    	echo $this->get_label('general'); 
    } 
    ?>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td></td>
<td width="180px"><?php echo $this->get_label("custom field group");?></td>
<td width="20px">:</td>
<td>
<?php
    if($row['groupid']!=0)
   		echo $this->escape($this->get_group_name($row['groupid']));
    else
   		echo $this->get_label('general'); 
?>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td></td>
<td><?php echo $this->get_label("field name");?></td>
<td>:</td>
<td><input type="text" name="field_name" id="field_name"   value="<?php echo $field_name; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label("field name");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
  <td></td>
  <td><?php echo $this->get_label("type");?></td>
  <td>:</td>
  <td>
  <?php 
  if($row['type']=="text") 
	echo $this->get_label('text'); 
  else if($row['type']=="textarea") 
	echo $this->get_label('textarea'); 
  else if($row['type']=="dropdown") 
	echo $this->get_label('dropdown'); 
  ?>
  </td>
  <td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


 <?php 
  if($row['type']=="dropdown") {?>

<tr>
<td></td>
<td><?php echo $this->get_label("value");?></td>
<td>:</td>
<td><input type="text" name="value1" id="value1" value="<?php echo $value; ?>"class="textStylePadding" placeholder="<?php echo $this->get_label("value");?>" ><span class="compulsory">*</span>
<br><span class="notification">[<?php echo $this->get_label('values seperated using comma');?>]</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<?php } ?>


<tr>
<td></td>
<td><?php echo $this->get_label("make this field mandatory");?></td>
<td>:</td>
<td>
<?php 
if($row['mandatory']==0)
	echo $this->get_label('no');
else if($row['mandatory']==1)
	echo $this->get_label('yes');
?> 
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

 <?php 
  if($row['type']=="text") {?>

<tr>
<td></td>
<td><?php echo $this->get_label("allow numberic values only");?></td>
<td>:</td>
<td>
<?php 
if($row['numeric_only']==0)
	echo $this->get_label('no');
else if($row['numeric_only']==1)
	echo $this->get_label('yes');
?>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>
<?php } ?>


<tr>
<td></td>
<td></td>
<td><input type="hidden" name="field_id" value="<?php echo $field_id;?>" /><input type="hidden" name="field_type" value="<?php echo $row['type'];?>" /></td>
<td ><input type="submit" name="submit" value="<?php echo $this->get_label("submit");?>" class="btn btn-default"></td>
<td></td>
</tr>
</table>

<?php 
} 
$form->end();
$this->dispatch("layout/footer");
?>