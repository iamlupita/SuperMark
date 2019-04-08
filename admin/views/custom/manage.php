<?php 
$this->dispatch("layout/header/6/_64");
$group=$this->get_variable("group");
$disp_cat=$this->get_variable("disp_cat");

if($group == -1)
$gst="/1";	
else
$gst="";	
?>
<style type="text/css">

.selectboxit-container .selectboxit{
    width: 160px !important;
}

</style>
<script type="text/javascript">
function loadCheckBox()
{
	if((document.getElementById('cat_id').value =='' && document.getElementById('group').value =='') || (document.getElementById('cat_id').value !='' && document.getElementById('group').value !=''))
	document.getElementById('chdisplay').style.display='';
	else
	document.getElementById('chdisplay').style.display='none';
}
</script>
<div class="sub_menu"><?php echo $this->get_label('manage custom fields');?></div>

<div>
<?php 
$form=$this->create_form();
$form->start("manage",$this->make_url("custom/manage"),"post");
?>
<table style="width: 100%;" cellpadding="0" cellspacing="0">


  	
  <tr>
    <td colspan="5">
    <select id="cat_id" name="cat_id" data-size="12" onchange="loadCheckBox();"><?php echo $this->get_variable('categories');?></select>
    
    <img id="group_img" style="display: none;" title="<?php echo $this->get_label("loading");?>" src="images/load.gif"/>
    <span id="group_span" style="display: none;">
    <?php echo $this->get_label("group");?>&nbsp;&nbsp;<select name="group" id="group" style="width: 130px" onchange="loadCheckBox();"></select>
  	</span>
  	
   <span id="chdisplay" style="display: none;width: 200px;">
   &nbsp;&nbsp;
   <input type="checkbox" name="disp_cat" id="disp_cat" value="1" <?php if($disp_cat==1){?>checked<?php }?>/>&nbsp;<?php echo $this->get_label('display childs');?>
   </span>
  
  &nbsp;&nbsp;
    <input type="submit" name="search" id="search" value="<?php echo $this->get_label('go'); ?>" class="btn btn-default"/>
    </td>
  </tr>
  
  
  
  <tr><td colspan="5" height="20px"></td></tr>
</table>
<?php $form->end(); ?>  
</div>

<table style="width: 100%;" class="data_table" cellpadding="0" cellspacing="0">
  <tr>
    <td class="dt_head_td"></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('category'); ?></td>
    <td class="dt_head_td" width="25%"><?php echo $this->get_label('group'); ?></td>
    
    <td class="dt_head_td" width="20%"><?php echo $this->get_label('field name'); ?></td>
	<td class="dt_head_td" width="10%"><?php echo $this->get_label('type'); ?></td>
    <td class="dt_head_td" width="8%"><?php echo $this->get_label('status'); ?></td>
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('actions'); ?></td>
    <td class="dt_head_td" width="10%"><?php if($group !=-1) {?><?php echo $this->get_label('priority'); ?><?php }else{}?></td>
  </tr>

<?php 
$res=$this->get_result('res');
$rowcount=$this->get_variable("rowcount");

$i=1;
foreach($res as $key=>$row)
{
?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==-1){?>class="dt_data_tr_pending" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td"></td>
    <td class="dt_data_td">
    <?php
    if($row['catid']!=0)
   	echo $this->escape($this->get_category_name($row['catid']));
    else
   	echo $this->get_label('general'); 
    ?>
    </td>
    
    <td class="dt_data_td" >
    
    <?php
    if($row['groupid']!=0)
   	echo $this->escape($this->get_group_name($row['groupid']));
    else
    echo $this->get_label('general'); 
    ?>
    
    </td>
    
    <td class="dt_data_td">
     <label id="bnamelabel_<?php echo $row['id']; ?>"> <?php echo $row['field_name']; ?></label>
    </td>
    <td class="dt_data_td"><?php 
    
    if($row['type']=="textarea")
    echo $this->get_label('textarea');
    else if($row['type']=="dropdown")
    echo $this->get_label('dropdown');
    else if($row['type']=="text")
    echo $this->get_label('text');
    
 ?></td>
    <td class="dt_data_td"><?php echo $this->get_customfield_status($row['status'])?></td>
    
    <td class="dt_data_td"> 
      <a href="<?php echo $this->make_url("custom/edit/".$row['id']);?>"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>
   
     <?php 
     if($row['status']!=1)
     {
     ?>
    &nbsp;<a href="<?php echo $this->make_url("custom/activate/".$row['id']."/".$disp_cat.$gst);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a> 
      <?php 
     }
     else
     {
     ?>
   	&nbsp;<a href="<?php echo $this->make_url("custom/block/".$row['id']."/".$disp_cat.$gst);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a> 
   	 <?php 
     }
     ?>
	&nbsp;<a href="<?php echo $this->make_url("custom/delete/".$row['id']."/".$disp_cat.$gst);?>" onclick="return confirm('Do you really want to delete custom field?')"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
	</td>
    <td class="dt_data_td">
   &nbsp;
    
    <?php 
    
 if($group !=-1)
 {
   if($rowcount >1) 
   {
    
    if($i==1)
    {?>
    	<a href="<?php echo $this->make_url("custom/change_priority/".$row['id']."/0".$gst);?>"><img alt="<?php echo $this->get_label('down'); ?>" src="images/pdown.png" title="<?php echo $this->get_label('down'); ?>"/></a>
    	
  <?php   }
  else if($i==$rowcount)
  {
  	?>
  	    	<a href="<?php echo $this->make_url("custom/change_priority/".$row['id']."/1".$gst);?>"><img alt="<?php echo $this->get_label('up'); ?>" src="images/pup.png" title="<?php echo $this->get_label('up'); ?>"/></a>
  	
  	<?php 
  }
  else {
  	?>
 	
  	  	    <a href="<?php echo $this->make_url("custom/change_priority/".$row['id']."/1".$gst);?>"><img alt="<?php echo $this->get_label('up'); ?>" src="images/pup.png" title="<?php echo $this->get_label('up'); ?>"/></a>
  	|
  	  	    	<a href="<?php echo $this->make_url("custom/change_priority/".$row['id']."/0".$gst);?>"><img alt="<?php echo $this->get_label('down'); ?>" src="images/pdown.png" title="<?php echo $this->get_label('down'); ?>"/></a>
  	
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
    <td class="dt_data_td border-bottom"></td>
    <td class="dt_data_td border-bottom" colspan="8"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
}
else 
{ 
?>
    <tr>
    <td class="dt_data_td border-bottom" colspan="6"><div style="color: red;">*<?php echo $this->get_label('custom fields displayed in the order of priority');?></div></td>
    <td class="dt_data_td border-bottom" ><?php echo $this->get_variable('pagination');?></td>
    <td class="dt_data_td border-bottom" ></td>
    </tr>
<?php 
}
?>
</table>

<?php $this->dispatch("layout/footer");?>

<script type="text/javascript">

function loadCustomGroup(selected)
{
	catid=$("#cat_id").val(); 

    if(catid =="")
   	catid=0;

    $("#group_img").show();
    $("#group_span").hide();

    $.ajax(
    		{
    		type: "GET",
    		url: "<?php echo $this->make_url("custom/load_groups/");?>"+catid+"/"+selected+"/1",
    		success: function(msg)
    			{
	    			
	    			$("#group_img").hide();
	    			 
	    			$("#group_span").show();
	    			$("#group").html(msg);
	    			$("#group").selectBoxIt("refresh");

	    			loadCheckBox();
    			}
    		});
}


$("#cat_id").change(function()
{
	loadCustomGroup(0);
})

$("#cat_id").ready(function()
{
	loadCustomGroup(<?php echo $group;?>);
})

</script>
<script type="text/javascript">
loadCheckBox();
</script>