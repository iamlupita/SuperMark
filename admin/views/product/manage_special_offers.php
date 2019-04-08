<?php 
$this->dispatch("layout/header/8/_06");
?>
<script type="text/javascript">
 function edit(id)
 { 
	$("#editdiv").show();
	$("#editname").html($("#name_"+id).html());
	$("#editprice").val($("#price_"+id).html());
	$("#editprodid").val(id);

	
	if($("#fromdate_"+id).html() != '-')
	$("#editfromdate").val($("#fromdate_"+id).html());
	else
	$("#editfromdate").val('');
	

	if($("#todate_"+id).html() != '-')
	$("#edittodate").val($("#todate_"+id).html());
	else
	$("#edittodate").val('');


	$("#editfromdate").datepicker({dateFormat : 'dd/mm/yy'});
	$("#edittodate").datepicker({dateFormat : 'dd/mm/yy'});
 }
 
 function SaveSpecialOffer()
 {
	 var id=$("#editprodid").val();
	 var price=$("#editprice").val();
	 var fromdate=$("#editfromdate").val();
	 var todate=$("#edittodate").val();
	 
	 if(price=='' || fromdate=='' || todate=='' || isNaN(price))
		 set_jnotice(0,'Please check all mandatory fields.');
	 else
	 {
			
		 	$.ajax(
			{
				type: "POST",
				url: "<?php echo $this->make_url("product/save_offer_price/");?>",
                async: false,
                data: "prodid="+id+"&price="+price+"&fromdate="+fromdate+"&todate="+todate,
				success: function(msg)
					{

					if(msg==""){
						
						$("#editdiv").hide();
						 set_jnotice(1,'Offer details updated succesfully');
					$("#price_"+id).html($("#editprice").val());
					$("#fromdate_"+id).html($("#editfromdate").val());
					$("#todate_"+id).html($("#edittodate").val());
					}
					else
						 set_jnotice(0,'to date must be greater');
					}
			});
	 }		
  }

 function removeoffer(id)
 {
	 var price=0;
	 var fromdate="";
	 var todate="";
	 
			$("#editdiv").hide();
			 set_jnotice(1,'Offer removed succesfully');
		 	$.ajax(
			{
				type: "POST",
				url: "<?php echo $this->make_url("product/remove_offer/");?>",
                async: false,
                data: "prodid="+id+"&price="+price+"&fromdate="+fromdate+"&todate="+todate,
				success: function(msg)
					{
						$("#spl_offer_tr_"+id).remove();
					}
			});
		
  }
</script>

<div class="sub_menu"><?php echo $this->get_label('manage special offers');?></div>


<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
 


  <tr >
    <td class="dt_head_td" width="28%"><?php echo $this->get_label('item name');?></td>

    <td class="dt_head_td" width="15%"><?php echo $this->get_label('actual price');?></td>
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('sale price');?></td>
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('offer price');?></td>
    
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('from');?></td>
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('to');?></td>
    
    <td class="dt_head_td" width="6%"><?php echo $this->get_label('actions');?></td>
    <td class="dt_head_td" width="0%"></td>
  </tr>  

<?php 
$res=$this->get_result('res');
$time=$this->get_variable('ttime');
foreach($res as $key=>$row)
{

	if($row['special_offer_from'] < $time && $row['special_offer_to'] > $time)
	$class_tr="dt_data_tr_active";
    else
   	$class_tr="dt_data_tr_inactive";
	
?>
  <tr class="<?php echo $class_tr;?>" id="spl_offer_tr_<?php echo $row['id'];?>">
    <td class="dt_data_td">
    <div class="productNameBanner" style="width: 200px;">
    <a href="<?php echo $this->make_url("product/details/".$row['id']);?>" id="name_<?php echo $row['id'];?>"><?php echo $row['name']; ?></a>
	</div>
    </td>
    
    <td class="dt_data_td">  <?php echo $row['mrp']; ?>  </td>
   
    <td class="dt_data_td">  <?php echo $row['sale_price']; ?>  </td>
   
   
    <td class="dt_data_td" id="price_<?php echo $row['id'];?>"><?php if($row['special_offer_from']=='') {echo "-";}else{echo $row['special_offer_price']; }?></td>
  
   
   <?php 
   $td='';
   $tm='';
   $ty='';
   
   
   if($row['special_offer_from'] >0)
  {
	  $td=date('d',$row['special_offer_from']);
	  $tm=date('m',$row['special_offer_from']);
	  $ty=date('Y',$row['special_offer_from']);
  } ?>
   
   
    <td class="dt_data_td" id="fromdate_<?php echo $row['id']; ?>"><?php if($row['special_offer_from'] ==0) {echo "-";}else{ echo $td.'/'.$tm.'/'.$ty;} ?></td>
    
    
     <?php if($row['special_offer_to'] >0)
  {
	  $td=date('d',$row['special_offer_to']);
	  $tm=date('m',$row['special_offer_to']);
	  $ty=date('Y',$row['special_offer_to']);
  } ?> 
    
    <td class="dt_data_td" id="todate_<?php echo $row['id']; ?>"><?php if($row['special_offer_to'] ==0) {echo "-";}else{ echo $td.'/'.$tm.'/'.$ty;} ?></td>  
    
   
   
    
    

    
    
    <td class="dt_data_td">
   <a href='javascript:edit("<?php echo $row['id']; ?>")' >
    <img alt="<?php echo $this->get_label('edit'); ?>" src="images/edit.png" title="<?php echo $this->get_label('edit'); ?>" /></a>
  
   <a href='javascript:removeoffer(<?php echo $row['id']; ?>)' >
    <img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('cancel'); ?>" /></a>
  
  
 
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
    <td class="dt_data_td border-bottom" colspan="7"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
   <tr>
    <td class="dt_data_td border-bottom" colspan="7" align="center"><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php 
}
?>
</table>


<div id="editdiv" style="display: none;">
<div class="behind_div">
<div class="popup" style="height: 275px;width: 350px;">

<div class="sub_menu"><?php echo $this->get_label('edit special offer');?>
<a class="closeButton" onclick="$('#editdiv').hide();" style="position: relative;float: right;top: -5px;">X</a>
</div>

<table style="width: 95%;padding-left: 12px;" cellpadding="0" cellspacing="0">

  <tr >
  <td style="width: 100px;" ><?php echo $this->get_label('item name');?></td>
  <td style="width: 200px;" id="editname"></td>
  </tr>  
  
  <tr><td colspan="2" height="10px"></td></tr>
  
   <tr >
    <td><?php echo $this->get_label('offer price');?></td>
	<td><input id="editprice" name="editprice" value="" class="textStylePadding" placeholder="<?php echo $this->get_label('offer price');?>" size="5"><?php echo Settings::get_instance()->read('currency_symbol');?><span class="compulsory">*</span></td>
   </tr>
     
      <tr><td colspan="2" height="10px"></td></tr>
  
  <tr >
    <td><?php echo $this->get_label('from');?></td>
	<td><input  id="editfromdate" name="editfromdate" value="" class="textStylePadding" placeholder="<?php echo $this->get_label('from');?>" size="8"><span class="compulsory">*</span></td>
  </tr>
  
   <tr><td colspan="2" height="10px"></td></tr>
  
   <tr >
    
    <td><?php echo $this->get_label('to');?></td>
	<td><input  id="edittodate" name="edittodate" value="" class="textStylePadding" placeholder="<?php echo $this->get_label('to');?>" size="8"><span class="compulsory">*</span></td>
   </tr>
   
    <tr><td colspan="2" height="10px"></td></tr>
  
    <tr >
      <td></td>
	  <td>
	  <input type="hidden" id="editprodid" value="" />
	  <input type="button" onclick="SaveSpecialOffer()" value="<?php echo $this->get_label('save');?>" class="btn btn-default ">
	  </td>
   </tr>
 
  </table>
 
</div></div></div>
<?php $this->dispatch("layout/footer");?>