<?php 
$this->dispatch("layout/header/7/_72");
?>
 <script type="text/javascript">
 
 var oldid=0;
 function SaveBrand(id)
 {
	 var val= $("#submit_"+id).val();
	 if(!isNaN(val) || val=='')
	 set_jnotice(0,'<?php echo $this->get_message('invalid brand');?>');
	 else
	 {
		 	$.ajax(
			{
				type: "GET",
				url: "<?php echo $this->make_url("product/save_brand_name/");?>"+id+"/"+val,
				success: function(msg)
					{
						if(msg=='2')
						{
							 set_jnotice(0,'<?php echo $this->get_message('brand already');?>');
						}
						else
						{	
							set_jnotice(1,'<?php echo $this->get_message('brand name updated');?>');
							$("#bnamelabel_"+id).html(val);
							$("#brandspan_"+id).hide();
							$("#bnamelabel_"+id).show();
						}	
					}
			});
	 }		
 }

 
</script>


<div class="sub_menu"><?php echo $this->get_label('manage brands');?></div>




<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
 


  <tr >
    <td class="dt_head_td" width="55%"><?php echo $this->get_label('item name');?></td>
    <td class="dt_head_td" width="25%"><?php echo $this->get_label('status');?></td>
    <td class="dt_head_td" width="20%"><?php echo $this->get_label('actions');?></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td">
    
 <label id="bnamelabel_<?php echo $row['id']; ?>"><?php echo $row['name']; ?></label>
 <span id="brandspan_<?php echo $row['id']; ?>" style="display: none;">
<input type="text" id="submit_<?php echo $row['id']; ?>" value="<?php echo $row['name']; ?>" class="textStylePadding" placeholder="<?php echo $this->get_label("brand name");?>">
<input type="button"  value="<?php echo $this->get_label('go');?>" onclick="SaveBrand(<?php echo $row['id']; ?>)" class="btn btn-default" style="vertical-align: top;" /> 
<input type="button"  value="x" class="btn btn-default" onclick='$("#brandspan_<?php echo $row['id']; ?>").hide();$("#bnamelabel_<?php echo $row['id']; ?>").show();' style="vertical-align: top;" />
 </span>   </td>
    
    <td class="dt_data_td"><?php echo $this->get_item_status($row['status'])?></td>
    
    <td class="dt_data_td">
    <?php 

    	if($row['status']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("product/activate_brand/".$row['id']);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
	
	    if($row['status']!=0) 
	    {
	    ?><a href="<?php echo $this->make_url("product/block_brand/".$row['id']);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
	    <?php 
	    }
	    ?> 
	

  
  <span onclick='$("#brandspan_<?php echo $row['id']; ?>").show();$("#bnamelabel_<?php echo $row['id']; ?>").hide()' style="cursor: pointer;">
  <img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></span>
  
   
  <a href="<?php echo $this->make_url("product/delete_brand/".$row['id']."/0/".$type."/".$status."/".$featured."/".$categ);?>" onclick="return confirm('Do you really want to delete the selected item?')">
  <img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
  
    
  
  
  
  
  
  </td>
</tr>

 
<?php 
} 
?>
<?php 
if(count($res)==0) 
{
?>
  <tr>
    <td class="dt_data_td border-bottom" colspan="3" ><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
   <tr>
    <td class="dt_data_td border-bottom" colspan="3" align="center" ><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php 
}
?>
</table>
<?php $this->dispatch("layout/footer");?>