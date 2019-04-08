<?php 
$this->dispatch("layout/header/8/_02");
?>


 <script type="text/javascript">
 
 function edit(id)
 {
  $("#stock_"+id).removeAttr("disabled");
  $("#submit_"+id).show();
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
					 set_jnotice(1,"<?php echo $this->get_message('stock value updated succesfully');?>");
				}
		});
 }		
  }

 
</script>
 <style type="text/css">
.selectboxit-option, .selectboxit-optgroup-header{width: 140px !important;}
.selectboxit-container .selectboxit{width: 140px !important;}
.selectboxit-list{overflow: auto !important;}
</style>
 
<div class="sub_menu"><?php echo $this->get_label('manage product');?></div>



<table style="width: 100%" cellpadding="0" cellspacing="0">
<tr>
 <td colspan="4" >
<?php 

$status=$this->get_variable("status");
$featured=$this->get_variable("featured");
$catid=$this->get_variable("catid");
$drpstock=$this->get_variable("drpstock");

$form=$this->create_form();
$form->start("manage",$this->make_url("product/manage"),"post");
?> 


<div style="float: left;margin-right: 5px;">
<div><?php echo $this->get_label('category');?></div>
<div><select id="catid" name="catid"  data-size="12"><?php echo $this->get_variable('categories');?></select></div>
</div>
&nbsp;

<div style="float: left;margin-right: 5px;">
<div><?php echo $this->get_label('status'); ?></div>
<div> <select name="status" style="width: 50px !important;">
 <option value="-2" <?php if($status==-2){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
 <option value="1"  <?php if($status==1){ echo "selected";}?>><?php echo $this->get_label('active'); ?></option>
 <option value="0"  <?php if($status==0){ echo "selected";}?>><?php echo $this->get_label('blocked'); ?></option>
 </select>
 </div>
 </div>
 
 
&nbsp;
<div style="float: left;margin-right: 5px;">
<div><?php echo $this->get_label('featured'); ?></div>
<div> <select name="featured" id="featured">
<option value="-2" <?php if($featured ==-2){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
<option value="1"  <?php if($featured ==1){ echo "selected";}?>><?php echo $this->get_label('featured'); ?></option>
<option value="0"  <?php if($featured ==0){ echo "selected";}?>><?php echo $this->get_label('non featured'); ?></option> 
</select>
</div>
 
 </div>
 
<div style="float: left;margin-right: 5px;">
<div><?php echo $this->get_label('stock'); ?></div>
<div> <select name="drpstock" style="width: 50px !important;">
 <option value="0" <?php if($drpstock==0){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
 <option value="1"  <?php if($drpstock==1){ echo "selected";}?>><?php echo $this->get_label('instock'); ?></option>
 <option value="2"  <?php if($drpstock==2){ echo "selected";}?>><?php echo $this->get_label('outstock'); ?></option>
 </select>
 </div>
 </div> 
 
 
 
&nbsp;&nbsp;
<div style="float: left;">
<input type="submit" name="search" id="search" value="<?php echo $this->get_label('go'); ?>" class="btn btn-default" />
</div>
<?php $form->end(); ?>  
 </td>
 </tr>
</table>
 
<br/>	


<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
 


  <tr >
    <td class="dt_head_td" width="35%"><?php echo $this->get_label('item name');?></td>
    <td class="dt_head_td" width="18%"><?php echo $this->get_label('category path');?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('stock');?></td>
    
    <td class="dt_head_td" width="8%"><?php echo $this->get_label('status');?></td>
    
    <td class="dt_head_td" width="28%"><?php echo $this->get_label('actions');?></td>
    <td class="dt_head_td" width="0%"></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>
  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td">
    
    <div class="productNameBanner" style="width: 180px;">
    <a href="<?php echo $this->make_url("product/details/".$row['id']);?>"><?php echo $row['name']; ?></a>
</div>
    </td>
    <td class="dt_data_td"><?php echo $this->escape($this->get_category_name($row['cat_id'])); ?></td>
     <td class="dt_data_td">
    <input type="text" class="textStylePadding" style="width: 40px;  <?php if($row['prod_stock'] < 1){ ?>border:1px solid red !important;<?php }?>background-color: #ECECEC;"  name="stock_<?php echo $row['id']; ?>" id="stock_<?php echo $row['id']; ?>" disabled onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php echo $row['prod_stock']; ?>">
    <span style="display: none;" id="submit_<?php echo $row['id']; ?>">
    <input type="button" value="<?php echo $this->get_label('go');?>" style="padding: 2px;" class="btn btn-default" onclick="savestock(<?php echo $row['id']; ?>)">
    <input type="button"  value="X"  style="padding: 2px;" class="btn btn-default" onclick='$("#submit_<?php echo $row['id']; ?>").hide();$("#stock_<?php echo $row['id']; ?>").show();$("#stock_<?php echo $row['id']; ?>").attr("disabled", true);$("#stock_<?php echo $row['id']; ?>").val("<?php echo $row['prod_stock']; ?>");'>
    
    </span>
    </td>
    
    <td class="dt_data_td">
    <?php echo $this->get_item_status($row['status'])?></td>
    
    

    
    
    <td class="dt_data_td">
    <?php 
 
    	if($row['status']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("product/activate/".$row['id']."/".$status."/".$featured."/".$catid."/".$drpstock);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
	
	    if($row['status']!=0) 
	    {
	    ?><a href="<?php echo $this->make_url("product/block/".$row['id']."/".$status."/".$featured."/".$catid."/".$drpstock);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
	    <?php 
	    }
	 
	    
	    if($row['featured']!=1)
	    {
    	?>
       	<a href="<?php echo $this->make_url("product/make_featured/".$row['id']."/".$status."/".$featured."/".$catid."/".$drpstock);?>"><img alt="<?php echo $this->get_label('makefeatured'); ?>" src="images/star-white24.png" title="<?php echo $this->get_label('makefeatured'); ?>" /></a>
       	<?php 
       	}
   		else
   	    {
   	    ?><a href="<?php echo $this->make_url("product/remove_featured/".$row['id']."/".$status."/".$featured."/".$catid."/".$drpstock);?>"><img alt="<?php echo $this->get_label('removefeatured'); ?>" src="images/star-gold24.png" title="<?php echo $this->get_label('removefeatured'); ?>" /></a>
   	    <?php 
        }
  ?> 
  <a href="<?php echo $this->make_url("product/delete/".$row['id']);?>" onclick="return confirm('Do you really want to delete item?')"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
  
  <a href="<?php echo $this->make_url("product/edit/".$row['id']);?>"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>
  
  <a href="<?php echo $this->make_url("product/add_duplicate/".$row['id']);?>"><img alt="<?php echo $this->get_label('edit'); ?>" src="images/l_to_r.png" title="<?php echo $this->get_label('add duplicate'); ?>" /></a>
  
   <a href="javascript:void(0);"  onclick='edit("<?php echo $row['id']; ?>" )'><img alt="<?php echo $this->get_label('edit stock'); ?>" src="images/stock.png" title="<?php echo $this->get_label('edit stock'); ?>" /></a>
 
   <a href="<?php echo $this->make_url("product/reviews/".$row['id']);?>"><img alt="<?php echo $this->get_label('reviews'); ?>" src="images/review.png" title="<?php echo $this->get_label('reviews'); ?>" /></a>
  
  
  
  
  
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
    <td class="dt_data_td border-bottom" colspan="6"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
   <tr>
    <td class="dt_data_td border-bottom" colspan="6" align="center"><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php 
}
?>
</table>


<?php $this->dispatch("layout/footer");?>