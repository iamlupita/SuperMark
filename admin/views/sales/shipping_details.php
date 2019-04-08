<?php 
$res=$this->get_result('shipping');

$cnt=count($res);
//$allid='';
if($cnt >0){
foreach($res as $key=>$row)
{
	
	
?>

<?php if($row['shipment_id']!=""){

	//if($allid !='')
	//$allid.='-';
	
	//$allid.=$row['shipment_id'];
	
	
	?>
<table class="shipping_table">

<tr>
	<td width="18%" style="font-weight: bold;">
	
	
	
	<?php echo $this->get_label('status');?></td>
	<td width="5%">:</td>
	<td width="30%" style="font-weight: bold;">
	
<div class="shipstatusdiv">
<?php 
if($row['status']==1)
{?>
	<div class="shippeddiv"><?php echo $this->get_label('shipped count',array('x'=>$this->get_label('qty').' '.$row['ship_quantity']));?></div>
	<?php 
}

if($row['status']==2){?>
<div class="delivereddiv"><?php echo $this->get_label('delivered count',array('x'=>$this->get_label('qty').' '.$row['ship_quantity']));?></div>
	<?php 
}

if($row['status']==3){?>
<div class="notaccepteddiv"><?php echo $this->get_label('not accepted count',array('x'=>$this->get_label('qty').' '.$row['ship_quantity']));?></div>
<?php }?>
</div>	
	
	</td>
	<td width="25%">
	
	
	
	</td>
	<td width="5%"></td>
	<td width="15%">
	
	
	<?php if($row['status']==3){?>
	<div style="width: 70px;margin-top: 10px;background-color:#ECECEC;" title="<?php echo $this->get_label('reship');?>" class="shipdetailsdiv" onclick="edit_shipping_details(<?php echo $row['shipment_id'];?>,<?php echo $row['order_id'];?>,<?php echo $row['id'];?>);"><?php echo $this->get_label('reship');?><img class="shipimage" src="images/edit.png" /></div>
	<?php }else{?>
	<div style="width: 65px;margin-top: 10px;background-color:#ECECEC;" title="<?php echo $this->get_label('update shipping details');?>" class="shipdetailsdiv" onclick="edit_shipping_details(<?php echo $row['shipment_id'];?>,<?php echo $row['order_id'];?>,<?php echo $row['id'];?>);"><?php echo $this->get_label('update');?><img class="shipimage" src="images/edit.png" /></div>
	<?php }?>
	
	

	
	
	
	
	
	
	
	<!--&nbsp;<input class="printchk" type="checkbox" name="printcheck<?php echo $row['shipment_id'];?>" id="printcheck<?php echo $row['shipment_id'];?>" value="1" />-->
	
	
	</td>
</tr>



<?php if($row['local_pickup'] ==0){?>

<tr>
	<td ><?php echo $this->get_label('shipping company');?></td>
	<td>:</td>
	<td ><?php echo $this->escape($this->get_shipping_company_name($row['ship_id']));?></td>
	<td ><?php echo $this->get_label('shipped on');?></td>
	<td >:</td>
	<td ><?php echo $this->get_date_format(3,$row['ship_date']);?>
	</td>
</tr>

<tr>
	<td ><?php echo $this->get_label('tracking id');?></td>
	<td >:</td>
	<td ><?php echo $row['track_id'];?></td>
	<td ><?php echo $this->get_label('expected delivery date');?></td>
	<td >:</td>
	<td ><?php if($row['exp_delivery_date'] >0){echo $this->get_date_format(3,$row['exp_delivery_date']);}else{echo $this->get_label('na');}?></td>
</tr>

<tr>
	<td ><?php echo $this->get_label('tracking url');?></td>
	<td >:</td>
	<td ><a href="<?php echo $row['url'];?>" target="_blank" style="outline: none;"><?php echo $row['url'];?></a></td>
	<td >
	<?php 
	if($row['status']==3)
	echo $this->get_label('attempted date');
	else
	echo $this->get_label('delivered on');
	?>
	</td>
	<td >:</td>
	<td ><?php if($row['recieved_date'] >0){echo $this->get_date_format(3,$row['recieved_date']);}else{echo $this->get_label('na');}?></td>
</tr>


<?php }else if($row['local_pickup'] ==1){?>

<tr>
	<td ><?php echo $this->get_label('pickup on');?></td>
	<td >:</td>
	<td ><?php if($row['recieved_date'] >0){echo $this->get_date_format(3,$row['recieved_date']);}else{echo $this->get_label('na');}?></td>
	<td ></td>
	<td ></td>
	<td ></td>
</tr>

<?php }?>










</table>



<div class='popup-outer' id="edit-ship-<?php echo $row['shipment_id'];?>" style="display:none ;">
<div class="behind_div">
<div class="popup">
<iframe src="<?php echo $this->make_url('sales/edit_shipping_details/'.$row['shipment_id'].'/'.$row['order_id'].'/'.$row['id'].'/'.$row['local_pickup']);?>" width="100%" height="100%" frameborder="0"></iframe>
</div>
</div>
</div>

<?php } else{?>

<div style="height: 50px;padding-top: 25px;padding-left: 5px;"><?php echo $this->get_label('no record');?></div>

<?php } 

 $this->dispatch("sales/get_return_details/".$row['shipment_id']);?>

<?php }
?>

	<input type="hidden" name="allid<?php echo $row['id'];?>" id="allid<?php echo $row['id'];?>" value="<?php echo $allid;?>" />
<?php 

}
else {?>
<div style="height: 50px;padding-top: 25px;padding-left: 5px;"><?php echo $this->get_label('no record');?></div>
<?php } ?>



<script type="text/javascript">
    function edit_shipping_details(id,order_id,order_item_id)
    {
    	$(".popup-outer").hide();
    	$("#edit-ship-"+id).show();
    }
    
</script>