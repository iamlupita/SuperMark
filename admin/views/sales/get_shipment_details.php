<div class="sub_menu"><?php echo $this->get_label('shipment details');?>

<a class="closeButton" onclick="$('#editdiv').hide();" style="position: relative;float: right;top: -5px;">X</a>

</div>

 <?php 
    $res=$this->get_result('res');
    if(count($res)==0)
    {
    	echo $this->get_label('no record');
    }
    else{
    foreach($res as $key=>$row)
    {
    	
    	$local=$this->get_shipment_type($row['order_item_id']);
    	
    	
?>
        
<table style="width: 100%;padding-left: 20px;">
 
 
 <?php if($local ==0){?>
   <tr>
    <td style="width: 30%;"><?php echo $this->get_label('shipping company');?></td>
    <td style="width: 10%;">:</td>
	<td><?php echo $this->escape($this->get_shipping_company_name($row['ship_id']));?></td>
  </tr>
   
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('track id');?></td>
    <td>:</td>
	<td><?php echo $row['track_id'];?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('url');?></td>
    <td>:</td>
	<td><?php echo $row['url'];?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('quantity');?></td>
    <td>:</td>
	<td><?php if($row['quantity']!=0){ echo $row['quantity'];}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('ship date');?></td>
    <td>:</td>
	<td><?php echo $this->get_date_format(3,$row['ship_date']);?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('expected delivery date');?></td>
    <td>:</td>
	<td><?php echo $this->get_date_format(3,$row['exp_delivery_date']);?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
  
  <?php }?>
  
  
  
  <?php if($local ==1){?>
  
  <tr>
    <td style="width: 30%;"><?php echo $this->get_label('shippment type'); ?></td>
    <td style="width: 10%;">:</td>
	<td><?php echo $this->get_label('local pickup'); ?></td>
  </tr>
  
   <tr><td colspan="2" style="height:10px !important;"></td></tr>
   
  <?php }?>
   <tr>
    <td><?php 
    if($local ==0)
    echo $this->get_label('received date');
    else  if($local ==1)
    echo $this->get_label('pickup on');
    ?></td>
    <td>:</td>
	<td><?php echo $this->get_date_format(3,$row['recieved_date']);?></td>
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('status');?></td>
    <td>:</td>
	<td><?php echo $this->get_shipping_status($row['status']);?>
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:25px !important;"></td></tr>
   
  </table>
<?php }}?>  