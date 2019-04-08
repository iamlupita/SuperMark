<?php 
$this->dispatch("layout/header/1/_12");
$invalidmsg=$this->get_message('invalid category name');
$updatemsg=$this->get_message('category name updated succesfully');
$alreadymsg=$this->get_message('category name already exists');
$deletemsg=$this->get_message('do you really want to delete category?');
?>
 <script type="text/javascript">
 var alreadymsg='<?php echo $this->escape($alreadymsg);?>';
 var updatemsg='<?php echo $this->escape($updatemsg);?>';
 var invalidmsg='<?php echo $this->escape($invalidmsg);?>';
 var deletemsg='<?php echo $this->escape($deletemsg);?>';

 function SaveCategory(id)
 {

	
	 var val= $("#submit_"+id).val();
	 if(!isNaN(val) || val=='')
		 set_jnotice(0,invalidmsg);
	 else
	 {
		 	$.ajax({
				type: "POST",
				url: "<?php echo $this->make_url("category/update");?>",
				data:{"id":id,"name":val,"pid":<?php echo $this->get_variable('pid');?>},
				success: function(msg)
					{
						if(msg==1)
							 set_jnotice(0,alreadymsg);
						else	 
						{
							 set_jnotice(1,updatemsg);

								$("#category_span_"+id).hide();
								$("#cnamelabel_"+id).show();
								$("#cnamelabel_"+id).html(val);
						}	 
					}
			});
	 }		
 }

function ShowBrands(id)
{
	$('#brands').show(500);
	$("#branddiv").html("<img src='images/load.gif'>");
	$.ajax({
		  
  type: "GET",cache: false,
  url: "<?php echo $this->make_url("category/brand_list/");?>"+id,
  success: function(data)
   {
	  if(data ==0)
  	  $("#branddiv").html("<?php  echo $this->get_label('no brands found');?>");
	  else
	  $("#branddiv").html(data);
	}
});
}
</script>
<div class="sub_menu"><?php echo $this->get_label('manage categories');?></div>


<div class="sub_menu" style="height: 35px;">
<table style="width: 100%;">

  <tr>
    <td width="1%"></td>
    <td colspan="3"><strong><?php echo $this->get_label('path'); ?> : <a href="<?php echo $this->make_url('category/manage'); ?>"><?php echo $this->get_label('root'); ?></a> &raquo; <?php echo $this->get_variable('cat_path'); ?></strong></td>
    <td ></td>
  </tr>
  <tr><td colspan="5" height="20px"></td></tr>
</table>
</div>

<table style="width: 100%" class="data_table">

  <tr>
    <td class="dt_head_td" width="1%"></td>
    <td class="dt_head_td" width="60%"><?php echo $this->get_label('cat name'); ?></td>
   <td class="dt_head_td" width="40%"><?php echo $this->get_label('actions'); ?></td>
    <td class="dt_head_td"></td>
  </tr>
    

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{
$ch_cnts=$this->get_child_count($row['id']);
	
	?>
    <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?> >
    <td class="dt_data_td"></td>
    <td class="dt_data_td">
    <?php 
    if($ch_cnts >0)
    {
	?>
  <a href="<?php echo $this->make_url("category/manage/".$row['id']);?>" style="text-decoration: none;">
 <?php 
    }
    ?>
    <label id="cnamelabel_<?php echo $row['id']; ?>" <?php if($ch_cnts >0){?>style="cursor: pointer;text-decoration: none;"<?php }?>><?php echo $row['name']; ?></label><?php 
    if($ch_cnts >0)
    {
	  ?></a>
   <?php 
    } ?>
    
 <span id="category_span_<?php echo $row['id']; ?>" style="display: none;">
<input type="text" id="submit_<?php echo $row['id']; ?>" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->get_label('cat name'); ?>" class="textStylePadding">
<input type="button"  value="<?php echo $this->get_label('go');?>" onclick="SaveCategory(<?php echo $row['id']; ?>)" class="btn btn-default" style="vertical-align: top;" />
<input type="button"  value="x" class="btn btn-default" onclick='$("#category_span_<?php echo $row['id']; ?>").hide();$("#cnamelabel_<?php echo $row['id']; ?>").show();' style="vertical-align: top;" />
 </span>   
   (<?php echo $ch_cnts;?>)
	   
    </td>
    <td class="dt_data_td">
    <a href="javascript:ShowBrands(<?php echo $row['id'] ?>)">
    <img alt="<?php echo $this->get_label('manage brands'); ?>" src="images/brands.png" title="<?php echo $this->get_label('manage brands'); ?>" /></a> 
    
    &nbsp;&nbsp;  <a href="<?php echo $this->make_url("category/add/".$row['id']);?>">
      <img alt="<?php echo $this->get_label('add child'); ?>" src="images/add.png" title="<?php echo $this->get_label('add child'); ?>" /></a> &nbsp;
     
       <a href="javascript:void(0);" onclick='$("#category_span_<?php echo $row['id']; ?>").show();$("#cnamelabel_<?php echo $row['id']; ?>").hide();$("#submit_<?php echo $row['id']; ?>").val($("#cnamelabel_<?php echo $row['id']; ?>").html());'>
   <img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>
  &nbsp;&nbsp;  <a href="<?php echo $this->make_url("category/delete/".$row['id']);?>" onclick="return confirm(deletemsg)"><img  src="images/delete.png" alt="<?php echo $this->get_label('delete'); ?>" title="<?php echo $this->get_label('delete'); ?>"></a>
  &nbsp;
    	<?php
    	if($row['featured']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("category/make_featured/".$row['id']);?>"><img alt="<?php echo $this->get_label('makefeatured'); ?>" src="images/star-white24.png" title="<?php echo $this->get_label('makefeatured'); ?>" /></a>
    	<?php 
    	}
		else
	    {
	    ?><a href="<?php echo $this->make_url("category/remove_featured/".$row['id']);?>"><img alt="<?php echo $this->get_label('removefeatured'); ?>" src="images/star-gold24.png" title="<?php echo $this->get_label('removefeatured'); ?>" /></a>
	    <?php 
	    }
	    ?> 
	&nbsp;
	  <?php 
		if($row['footer_display']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("category/enable_footer_display/".$row['id']);?>"><img alt="<?php echo $this->get_label('enable footer display'); ?>" src="images/disable_footer.png" title="<?php echo $this->get_label('enable footer display'); ?>" /></a>
    	<?php 
    	}
		else
	    {
	    ?><a href="<?php echo $this->make_url("category/disable_footer_display/".$row['id']);?>"><img alt="<?php echo $this->get_label('disable footer display'); ?>" src="images/enable_footer.png" title="<?php echo $this->get_label('disable footer display'); ?>" /></a>
	    <?php 
	    }
	    ?> 
	&nbsp;
	  <?php 
		if($row['status']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("category/activate/".$row['id']);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
		else { ?>
		<a href="<?php echo $this->make_url("category/block/".$row['id']);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
	    <?php } ?> 
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
    <td class="dt_data_td"></td>
    <td class="dt_data_td" colspan="3"><?php echo $this->get_label('no record'); ?></td>
    <td class="dt_data_td"></td>
  </tr>
<?php 
} 
?>
</table>
			
				<div id="brands" style="display: none;">
<div class="behind_div">
				<div class="popup">
<?php 
$form=$this->create_form();
$form->start("brand_add",$this->make_url("category/add_brand"),"post",$validate);

?>
<div class="sub_menu"><?php echo $this->get_label('brand category mapping');?>
<a class="closeButton" style="position: relative;float: right;top: -5px;margin-left: 5px;" onclick="$('#brands').hide(400);">X</a>

<a class="btn btn-default brand-add" href="<?php echo $this->make_url('product/add-brand'); ?>"><?php echo $this->get_label('add new brand');?></a>

</div>
<div id="branddiv" class="brand-div-outer"></div>

<?php $form->end();?>
</div>
</div>
</div>
<?php $this->dispatch("layout/footer");?>