<?php 
$this->dispatch("layout/header/6/_62");
$disp_cat=$this->get_variable("disp_cat");
?>

 <script type="text/javascript">
 function loadCheckBox()
 {
 	if(document.getElementById('catid').value ==0)
 	document.getElementById('chdisplay').style.display='none';
 	else
 	document.getElementById('chdisplay').style.display='';
 }
 function SaveGroup(id)
 {
	 var val= $("#submit_"+id).val();
	 if(!isNaN(val) || val=='')
		 set_jnotice(0,'<?php echo $this->get_message('invalid group name');?>');
	 else
	 {
			$("#group_name_span_"+id).hide();
			$("#gnamelabel_"+id).show();
		 	$.ajax(
			{
				type: "GET",
				url: "<?php echo $this->make_url("custom/save_group_name/");?>"+id+"/"+val,
				success: function(msg)
					{
						if(msg=='1')
						{
							$("#gnamelabel_"+id).html(val);
						    set_jnotice(1,'<?php echo $this->get_message('group name updated');?>');
						}
						 else
							 set_jnotice(0,'<?php echo $this->get_message('custom field group already');?>');
					}
			});
	 }		
 }


 
</script>
<div class="sub_menu"><?php echo $this->get_label('manage custom field group');?></div>


<div>
<?php 
$form=$this->create_form();
$form->start("manage",$this->make_url("custom/manage_group"),"post");
?>
<table style="width: 100%;" cellpadding="0" cellspacing="0">
  <tr>
    <td  colspan="4">
    <select id="catid" name="catid" data-size="12" onchange="loadCheckBox();"><?php echo $this->get_variable('categories');?></select>
    &nbsp;
    
    <span id="chdisplay" style="display: none;width: 200px;">
    <input type="checkbox" name="disp_cat" id="disp_cat" value="1" class="textStylePadding" <?php if($disp_cat==1){?>checked<?php }?>/>&nbsp;<?php echo $this->get_label('display child category group also');?>
    </span>
    &nbsp;&nbsp;<input type="submit" name="search" id="search" value="<?php echo $this->get_label('go'); ?>" class="btn btn-default" /></td>

  </tr>
  
  <tr><td colspan="4" height="20px"></td></tr>
</table>
<?php $form->end(); ?>  
</div>






<table style="width: 100%;" class="data_table" cellpadding="0" cellspacing="0">



  <tr>
    <td class="dt_head_td" width="33%"><?php echo $this->get_label('cat name'); ?></td>
    <td class="dt_head_td" width="20%"><?php echo $this->get_label('group name'); ?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('status'); ?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('actions'); ?></td>
    
    <td class="dt_head_td" width="10%"><?php if($disp_cat !=1) {?><?php echo $this->get_label('priority'); ?><?php }else{}?></td>
    
  </tr>

<?php 
$res=$this->get_result('res');
$rowcount=$this->get_variable("rowcount");

$i=1;
foreach($res as $key=>$row)
{
?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td">
    <?php
   if($row['catid']!=0)
    echo $this->get_category_path($row['catid']); 
    else
   	echo $this->get_label('general'); 
    ?>
    </td>
    <td class="dt_data_td" >
    <label id="gnamelabel_<?php echo $row['id']; ?>"><?php echo $row['name']; ?></label>
 <span id="group_name_span_<?php echo $row['id']; ?>" style="display: none;">
<input type="text" id="submit_<?php echo $row['id']; ?>" value="<?php echo $row['name']; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label("group name");?>">
<input type="button"  value="<?php echo $this->get_label('go');?>" onclick="SaveGroup(<?php echo $row['id']; ?>)" class="btn btn-default" > 
<input type="button"  value="x" class="btn btn-default" onclick='$("#group_name_span_<?php echo $row['id']; ?>").hide();$("#gnamelabel_<?php echo $row['id']; ?>").show()'>
 </span> 
    
    </td>

    <td class="dt_data_td">
    <?php echo $this->get_customfield_status($row['status']);?></td>
    
    <td class="dt_data_td"> 
 	<span onclick='$("#group_name_span_<?php echo $row['id']; ?>").show();$("#gnamelabel_<?php echo $row['id']; ?>").hide()'  style="cursor: pointer;">
    <img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></span>
  
     
     <?php 
     if($row['status']!=1)
     {
     ?>
   &nbsp;<a href="<?php echo $this->make_url("custom/activate_group/".$row['id']."/".$disp_cat);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a> 
      <?php 
     }
     else
     {
     ?>
   	&nbsp;<a href="<?php echo $this->make_url("custom/block_group/".$row['id']."/".$disp_cat);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a> 
   	 <?php 
     }
     ?>
	&nbsp;<a href="<?php echo $this->make_url("custom/deletegroup/".$row['id']."/".$disp_cat);?>" onclick="return confirm('Do you really want to delete this custom field group?')"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
	</td>
    <td class="dt_data_td">
    
    <?php //echo $row['priority'];?>&nbsp;
    
    
    <?php 
    if($disp_cat !=1)
    {
	   if($rowcount >1) 
	   {
		    if($i==1)
		    {?>
		    <a href="<?php echo $this->make_url("custom/change_group_priority/".$row['id']."/0");?>"><img alt="<?php echo $this->get_label('down'); ?>" src="images/pdown.png" title="<?php echo $this->get_label('down'); ?>"/></a>
		    <?php
		    }
		    else if($i==$rowcount)
		    {
		  	?>
		  	<a href="<?php echo $this->make_url("custom/change_group_priority/".$row['id']."/1");?>"><img alt="<?php echo $this->get_label('up'); ?>" src="images/pup.png" title="<?php echo $this->get_label('up'); ?>"/></a>
		  	<?php 
		  	}
		  	else 
		  	{
		  	?>
		  	<a href="<?php echo $this->make_url("custom/change_group_priority/".$row['id']."/1");?>"><img alt="<?php echo $this->get_label('up'); ?>" src="images/pup.png" title="<?php echo $this->get_label('up'); ?>"/></a>
		  	|
		  	<a href="<?php echo $this->make_url("custom/change_group_priority/".$row['id']."/0");?>"><img alt="<?php echo $this->get_label('down'); ?>" src="images/pdown.png" title="<?php echo $this->get_label('down'); ?>"/></a>
		  	<?php 
		  	}
	   }
	   else
	   {
	   	 echo $this->get_label('na'); 
	   }
    }
    ?>
    
    
    
    </td>
  </tr>
    

  <?php 
  $i=$i+1;

} ?>
<?php 
if(count($res)==0) 
{
?>
  <tr>
    <td class="dt_data_td border-bottom" colspan="6"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
}
else 
{ 
?>
    <tr>
    <td class="dt_data_td border-bottom"  colspan="3"><div style="color: red;">*<?php echo $this->get_label('custom field groups displayed in the order of priority');?></div></td>
    <td class="dt_data_td border-bottom"><?php echo $this->get_variable('pagination');?></td>
    <td class="dt_data_td border-bottom"></td>
    </tr>
    
    
  
    
    
    
<?php 
}
?>
</table>

<?php $this->dispatch("layout/footer");?>
<script type="text/javascript">
loadCheckBox();
</script>