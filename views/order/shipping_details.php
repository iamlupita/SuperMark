<?php 
$res=$this->get_result('shipping');
foreach($res as $key=>$row)
{
?>


<table class="shipping_table">

<tr>
	<td width="15%" style="font-weight: bold;"><?php echo $this->get_label('status');?></td>
	<td width="5%">:</td>
	<td width="40%" style="font-weight: bold;">
	
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
	<td width="20%"></td>
	<td width="5%"></td>
	
	<td width="20%">
	
	
<?php 
$expired=$this->get_return_expired($row['recieved_date']+(Settings::get_instance()->read('refund_request_period')*24*60*60));
if($expired==0 && ($row['ship_quantity']-$this->get_return_quantity($row['order_item_id'],$row['shipment_id']))>0 && $row['status']==2){
?>
	<div style="width: 65px;margin-top: 10px;background-color:#ECECEC;" title="<?php echo $this->get_label('add return request');?>" class="shipdetailsdiv" onclick="add_return_details('<?php echo $row['shipment_id'];?>');"><?php echo $this->get_label('return');?><img class="shipimage" src="images/plus.png" /></div>
<?php } ?>
	
	
	</td>
</tr>



<?php if($row['local_pickup'] ==0){?>

<tr>
	<td ><?php echo $this->get_label('shipping company');?></td>
	<td >:</td>
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


<div id="iframe_return_details_add_<?php echo $row['shipment_id'];?>" style="display: none;">
<iframe src="<?php echo $this->make_url('order/edit_return_details/0/'.$row['shipment_id'].'/'.$row['id']);?>" width="100%" height="350px" frameborder="0"></iframe>
</div>


<?php $this->dispatch("order/get_return_details/".$row['shipment_id']."/".$expired);?>



<div class="underlinediv"></div>


<?php } ?>

 <script type="text/javascript">
    
    function add_return_details(id)
    {
    		popup(550,350,500,"#return_details_div");
    		$("#return_details_div > #full_content").html($("#iframe_return_details_add_"+id).html());
    }

</script>