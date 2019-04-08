<?php 
$this->dispatch("layout/header/6/_63");
?>


<script type="text/javascript">
window.onload = function ()
{
$('.numbersOnly').keyup(function () { 
	if(isNaN($('#name').val()))
	alert("Numbers only");
    this.value = this.value.replace(/[^0-9\.]/g,'');
});
};

function change()
{
	if($("#type").val() =="dropdown")
	{
		$('#dropdwn').show();
		$('#numeric').hide();
	}
	else if($("#type").val() =="textarea")
	{
		$('#dropdwn').hide();
		$('#numeric').hide();
	}
	else
	{
		$('#dropdwn').hide();
		$('#numeric').show();
	}
}
</script>
<?php
$validate=array(
"group"=>array(
		"notNull"=>array($this->get_message("mandatory"))
),
		"name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		
)
);

if($_POST)
{
$field_name=$this->get_variable('name');
$mandatory=$this->get_variable('mandatory');
$type=$this->get_variable('type');
$value=$this->get_variable('value');
$group=$this->get_variable('group');
}
else
{
	$field_name="";
	$mandatory=0;
	$type="";
	$value="";
	$group=0;
}


$form=$this->create_form();
$form->start("custom_add",$this->make_url("custom/add"),"post",$validate);




?>


<div class="sub_menu"><?php echo $this->get_label('add custom fields');?></div>



<table cellpadding="0" cellspacing="0" style="width: 100%">




<tr><td colspan="3" height="10px"></td><td><?php echo $this->get_label('compulsory message');?></td><td></td></tr>


<tr><td colspan="5" height="10px"></td></tr>


<tr>
<td ></td>
<td width="180px"><?php echo $this->get_label("select category");?></td>
<td width="20px">:</td>
<td>
<select id="cat_id" name="cat_id" data-size="12"><?php echo $this->get_variable('categories');?></select>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>


<tr id="grouptr" style="display: none;">
<td ></td>
<td width="180px"><?php echo $this->get_label("select custom field group");?></td>
<td width="20px">:</td>
<td>
<select name="group" id="group" data-size="12"></select> <span class="compulsory">*</span>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>

<tr>
<td ></td>
<td><?php echo $this->get_label("field name");?></td>
<td>:</td>
<td><input type="text" name="name" id="name"   value="<?php echo $field_name; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label("field name");?>"><span class="compulsory">*</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
  <td></td>
  <td><?php echo $this->get_label("type");?></td>
  <td>:</td>
  <td>
  <select name="type" id="type" onchange="change()" data-size="12">
 <option value="text" <?php if($type=="text") { echo "selected"; }?>><?php echo $this->get_label('text') ?></option>
 <option value="textarea" <?php if($type=="textarea") { echo "selected"; }?>><?php echo $this->get_label('textarea') ?></option>
 <option value="dropdown" <?php if($type=="dropdown") { echo "selected"; }?>><?php echo $this->get_label('dropdown') ?></option>
  </select>
  </td>
  <td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>




<tr id="dropdwn" style="display: none;">
<td ></td>
<td><?php echo $this->get_label("value");?></td>
<td>:</td>
<td><input type="text" name="value1" id="value1" value="<?php echo $value; ?>"class="textStylePadding" placeholder="<?php echo $this->get_label("value");?>" ><span class="compulsory">*</span>
<br><span class="notification">[<?php echo $this->get_label('values seperated using comma');?>]</span></td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr>
<td ></td>
<td><?php echo $this->get_label("make this field mandatory");?></td>
<td>:</td>
<td><input type="radio" name="mandatory" value="0" <?php if($mandatory==0){echo "checked";}?> /> <?php echo $this->get_label('no');?> &nbsp;
<input type="radio" name="mandatory" value="1" <?php if($mandatory==1){echo "checked";}?> /> <?php echo $this->get_label('yes');?>
</td>
<td></td>
</tr>
<tr><td colspan="5" height="10px"></td></tr>



<tr id="numeric" style="display: none;">
<td ></td>
<td><?php echo $this->get_label("allow numberic values only");?></td>
<td>:</td>
<td><input type="checkbox" name="onlynumeric" id="onlynumeric" value="0"  /> <?php echo $this->get_label('yes');?>
</td>
<td></td>
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
<script type="text/javascript">
change();
</script>
<script type="text/javascript">

function loadCustomGroup(selected)
{
	catid=$("#cat_id").val(); 

    if(catid =="")
   	catid=0;


    $("#group").empty().selectBoxIt("refresh");
    $.ajax(
    		{
    		type: "GET",
    		url: "<?php echo $this->make_url("custom/load_groups/");?>"+catid+"/"+selected,
    		success: function(msg)
    			{
    			if(msg=="")
        			alert("No field groups added in this category");
    			$("#group").html(msg);

    			$("#group").selectBoxIt("refresh");
    			}
    		});
}


$("#cat_id").change(function()
{
	$('#grouptr').show();
	loadCustomGroup("<?php echo $group;?>");
})


$(document).ready(function(){

	    catid=$("#cat_id").val(); 
    	$('#grouptr').show();
		loadCustomGroup("<?php echo $group;?>");
	
});
</script>