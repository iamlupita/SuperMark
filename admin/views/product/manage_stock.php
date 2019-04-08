<?php 
$this->dispatch("layout/header/8/_07");
?>


<div class="sub_menu"><?php echo $this->get_label('manage stock');?></div>




<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
 


  <tr >
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('item name');?></td>
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('category path');?></td>
    
    <td class="dt_head_td" width="30%"><?php echo $this->get_label('stock');?></td>
    
    <td class="dt_head_td" width="5%"><?php echo $this->get_label('action');?></td>
    <td class="dt_head_td" width="0%"></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td">
    <div class="productNameBanner" style="width: 200px;">
    <a href="<?php echo $this->make_url("product/details/".$row['id']);?>"><?php echo $row['name']; ?></a>
</div>
    </td>
    <td class="dt_data_td"><?php echo $this->get_category_path($row['cat_id']); ?></td>
    
    <td class="dt_data_td">
    <input type="text" <?php if($row['prod_stock'] < 1){?>style="width: 40px;border:1px solid red !important;background-color: #ECECEC;vertical-align: middle;"<?php }else{?> style="width: 40px;background-color: #ECECEC;vertical-align: middle;" <?php }?> class="textStylePadding" name="stock_<?php echo $row['id']; ?>" id="stock_<?php echo $row['id']; ?>" disabled value="<?php echo $row['prod_stock']; ?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');">
    <span style="display: none;" id="submit_<?php echo $row['id']; ?>">
    <input type="button" value="<?php echo $this->get_label('go');?>" onclick="savestock(<?php echo $row['id']; ?>)" class="btn btn-default">
    <input type="button"  value="X" class="btn btn-default" onclick='$("#submit_<?php echo $row['id']; ?>").hide();$("#stock_<?php echo $row['id']; ?>").show();$("#stock_<?php echo $row['id']; ?>").attr("disabled", true);$("#stock_<?php echo $row['id']; ?>").val("<?php echo $row['prod_stock']; ?>");$("#editid"+<?php echo $row['id']; ?>).show();'>
    </span>
    </td>
    
    <td class="dt_data_td">
    
    
    
  <span id="editid<?php echo $row['id']; ?>" onclick='edit("<?php echo $row['id']; ?>" )'  style="cursor: pointer;"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></span>
  
  
  
  
  
  
  </td>
<td class="dt_data_td"></td>  
</tr>

 
<?php 
} 
?>
<?php 
if(count($res)==0) 
{
?>
  <tr>
    <td class="dt_data_td border-bottom" colspan="5"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
   <tr>
    <td class="dt_data_td border-bottom" colspan="5" align="center"><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php 
}
?>
</table>

 <script type="text/javascript">
 
 function edit(id)
 {
  $("#stock_"+id).removeAttr("disabled");
  $("#submit_"+id).show();


  $("#editid"+id).hide();

  
  
  }
 
 function savestock(id)
 {
 var val= $("#stock_"+id).val();
 if (val.indexOf('+') != -1 || val.indexOf('-') != -1 ) 
	 set_jnotice(0,'Symbols not allowed.')
 else if(isNaN(val) || val=='')
	 set_jnotice(0,'Invalid stock value')
 else
 {
	 	$.ajax(
		{
			type: "GET",
			url: "<?php echo $this->make_url("product/save_stock/");?>"+id+"/"+val,
			success: function(msg)
				{
					 $("#stock_"+id).attr("disabled",true);
					 $("#submit_"+id).hide();
					  $("#editid"+id).show();
						 
					 set_jnotice(1,"<?php echo $this->get_message('stock value updated succesfully');?>");
				}
		});
 }		
  }

 
</script>
<?php $this->dispatch("layout/footer");?>