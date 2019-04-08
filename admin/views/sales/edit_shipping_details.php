<?php
$validate=array(
		
		"ship_id"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"track_id"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"url"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"quantity"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"quantity"=>array(
				"isPositive"=>array($this->get_message("positive integer"))
		),
		"ship_date"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"exp_delivery_date"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"status=>'2' || status=>'3' " => array(
			"recieved_date"=>array(
					"notNull"=>array($this->get_message("mandatory"))
			)
		),
		"status"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)

);


$validate1=array(
				"recieved_date"=>array(
						"notNull"=>array($this->get_message("mandatory"))
				)
);


$shipment_id=$this->get_variable("shipment_id");

$track_id=$this->get_variable("track_id");
$url=$this->get_variable("url");
$ship_id=$this->get_variable("ship_id");
$ship_date=$this->get_variable("ship_date");
$exp_delivery_date=$this->get_variable("exp_delivery_date");
$recieved_date=$this->get_variable("recieved_date");
$quantity=$this->get_variable("quantity");
$status=$this->get_variable("status");
$localpickup=$this->get_variable("localpickup");



?>

<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-ui-1.8.23.custom.min.js' ></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/common.js'></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE.ADMIN_DIR.'/';?>css/jquery.selectBoxIt.css" />
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery.selectBoxIt.min.js'></script> 


<style>
body {background: none;}
.selectboxit-text {max-width: 300px !important;}
</style>



<script type="text/javascript">
$(document).ready(function() {
	$('select').selectBoxIt({
	    showEffect: "fadeIn",
	    showEffectSpeed: 400,
	    hideEffect: "fadeOut",
	    hideEffectSpeed: 400});	


	

	 $("#ship_date").datepicker({dateFormat : 'dd/mm/yy'});

	 $("#exp_delivery_date").datepicker({dateFormat : 'dd/mm/yy'});

	 $("#recieved_date").datepicker({dateFormat : 'dd/mm/yy'});



	 <?php if($localpickup ==1){?>
	 $('#received_date_tr1').show();
	 $('#received_date_tr2').show();
	 <?php }else{?>
	 change_status();
	 <?php }?>
});

function change_status()
{
	if($("#status").val() =="2" || $("#status").val() =="3")
	{
		$('#received_date_tr1').show();
		$('#received_date_tr2').show();
	}
	else
	{
		$('#received_date_tr1').hide();
		$('#received_date_tr2').hide();
	}


	if($("#status").val() =="3")
	{
		$('#del1').hide();
		$('#del2').show();
	}
	else
	{
		$('#del1').show();
		$('#del2').hide();
	}
	
}
</script>

    
    
<div class="sub_menu"><?php echo $this->get_label('manage shipping details');?>

<a class="closeButton" onclick="parent.$('.popup-outer').hide();">X</a>


</div>
<?php 
     $form=$this->create_form();

	 if($localpickup ==0)
     $form->start("ship_edit_".$shipment_id,$this->make_url("sales/edit_shipping_details"),"post",$validate);
	 else 
	 $form->start("ship_edit_".$shipment_id,$this->make_url("sales/edit_shipping_details"),"post",$validate1);
	 	
 ?>
        
        
        
        
        
<table style="width: 100%;padding-left: 20px;">






<?php if($localpickup ==0){?>



 <tr>
    <td><?php echo $this->get_label('shipping status');?><span class="mandatory">*</span></td>
	<td>
	<select name="status" id="status" onchange="change_status()">
	<option value="" selected="selected"><?php echo $this->get_label('select');?></option>
	<option value="1" selected="selected" ><?php echo $this->get_label('shipped');?></option>
	<option value="2" <?php if($status==2){ echo "selected";}?>><?php echo $this->get_label('delivered');?></option>
	<option value="3" ><?php echo $this->get_label('not accepted by user');?></option>
	
	</select>
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>



 
   <tr>
    <td  width="35%;"><?php echo $this->get_label('shipping company');?><span class="mandatory">*</span></td>
	<td>
	<select name="ship_id" id="ship_id" onchange="LoadTrackingUrl();" style="width: 177px;">
	<option value="" ><?php echo $this->get_label('select'); ?></option>
<?php 
$res=$this->get_result('comp');
foreach($res as $key=>$row1)
{?>
<option value="<?php echo $row1['id'];?>" <?php if($row1['id']==$ship_id){ echo "selected";}?> ><?php echo $row1['name'] ?></option>
<?php }?>			
</select>
	
<?php foreach($res as $key1=>$row11){?>
<input type="hidden" name="trk<?php echo $row11['id'];?>" id="trk<?php echo $row11['id'];?>" value="<?php echo $row11['url'];?>" />	 
<?php }?>
	
	</td>
  </tr>
  
    <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td  width="35%;"><?php echo $this->get_label('tracking url');?><span class="mandatory">*</span></td>
	<td><input type="text" id="url" name="url" value="<?php echo $url;?>" class="textStylePadding">
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td  width="35%;"><?php echo $this->get_label('tracking id');?><span class="mandatory">*</span></td>
	<td><input type="text" id="track_id" name="track_id" value="<?php echo $track_id;?>" class="textStylePadding">
	</td>
  </tr>
  

  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td  width="35%;"><?php echo $this->get_label('quantity');?><span class="mandatory">*</span></td>
	<td><input type="text" id="quantity" name="quantity" onkeyup="this.value = this.value.replace(/[^0-9]/g,'');" value="<?php if($quantity!=0){ echo $quantity;}?>" class="textStylePadding">
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
  
  <?php 
  if($ship_date >0)
  {
	  $td=date('d',$ship_date);
	  $tm=date('m',$ship_date);
	  $ty=date('Y',$ship_date);
  } 
  
  if($status ==3)
  $ship_date=0;
  ?>
  
   <tr>
    <td><?php echo $this->get_label('shipped on');?><span class="mandatory">*</span></td>
	<td><input  id="ship_date" name="ship_date" value="<?php if($ship_date >0){echo $td.'/'.$tm.'/'.$ty;}?>" class="textStylePadding"> </td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
  
   <?php if($exp_delivery_date >0)
  {
	  $td=date('d',$exp_delivery_date);
	  $tm=date('m',$exp_delivery_date);
	  $ty=date('Y',$exp_delivery_date);
  } 
  
  if($status ==3)
  $exp_delivery_date=0;
  
  
  ?>
   <tr>
    <td><?php echo $this->get_label('expected delivery date');?><span class="mandatory">*</span></td>
	<td><input  id="exp_delivery_date" name="exp_delivery_date" value="<?php if($exp_delivery_date >0){echo $td.'/'.$tm.'/'.$ty;}?>" class="textStylePadding" > </td>
  </tr>
  
  
  
  
  <?php }?>
  
  
  
  <?php 
  if($recieved_date >0)
  {
	  $td=date('d',$recieved_date);
	  $tm=date('m',$recieved_date);
	  $ty=date('Y',$recieved_date);
  } 
  
  if($status ==3)
  $recieved_date=0;
  
  
  ?>
  
  <tr id="received_date_tr1" ><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr id="received_date_tr2">
    <td>
    
    <label id="del1"><?php 
    if($localpickup ==0)
    echo $this->get_label('delivered on');
    else 
    echo $this->get_label('pickup on');
    ?></label>
    <label id="del2" style="display: none;"><?php echo $this->get_label('attempted date');?></label>
    
    <span class="mandatory">*</span></td>
	<td><input  id="recieved_date" name="recieved_date" value="<?php if($recieved_date >0){echo $td.'/'.$tm.'/'.$ty;}?>" class="textStylePadding" > </td>
  </tr>
  

  
  <tr><td colspan="2" style="height:5px !important;"></td></tr>
  
  
  
  
  <tr><td>&nbsp;</td>
  
  <td>
   <input type="hidden" name="shipment_id" value="<?php echo $shipment_id;?>"> 
   <input type="hidden" name="order_id" value="<?php echo $this->get_variable('order_id');?>">
   <input type="hidden" name="order_item_id" value="<?php echo $this->get_variable('order_item_id');?>">
   <input type="hidden" name="localpickup" id="localpickup" value="<?php echo $localpickup;?>" />
   
   
   
  <input type="submit" name="sub" value="<?php echo $this->get_label('submit');?>" class="btn btn-default">
  </td>
  
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
     
     
  </table>

  
<?php $form->end(); ?> 
<script type="text/javascript">
function LoadTrackingUrl()
{
	iddata=$('#ship_id').val();
	trackurl=$('#url').val();
	if(iddata !='')
	{
		$('#url').val($('#trk'+iddata).val());
	}
	else if(iddata =='')
	{
		$('#url').val('');
	}
}
</script>