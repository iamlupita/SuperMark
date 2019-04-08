<?php
$orderid=$this->get_variable('orderid');
$res=$this->get_result('res');
$itarray=$this->get_array('itarray');
$shipping_cost_total=0;
$item_total=0;
$amount_paid=0;
if(count($res)>0)
{
	$i=0;
	foreach($res as $key=>$row)
	{
		$i++;

		if($i==1){

			?>

<table style="width: 100%;">

<tr>
<td colspan="3" style="text-align: center;"><strong style="font-size: 20px;"><?php echo $this->get_label('invoice');?></strong></td>
</tr>

<tr><td colspan="3" style="height: 10px;"></td></tr>

<tr>
<td>

<?php 
echo '<strong style="font-size: 20px;">'.Settings::get_instance()->read('engine_name').'</strong><br />';

if(Settings::get_instance()->read('address1')!="")
echo Settings::get_instance()->read('address1');?><br />
                                    
<?php 
                                    if(Settings::get_instance()->read('city')!="")
                                    echo Settings::get_instance()->read('city');?><br />
									
									<?php 
									if(Settings::get_instance()->read('state')!="")
                                    echo Settings::get_instance()->read('state');?><br />
                                    
                                    <?php 
									if(Settings::get_instance()->read('country')!="")
                                    echo $this->get_country_name(Settings::get_instance()->read('country'));?>
                                    -
                                    <?php 
                                    if(Settings::get_instance()->read('zipcode')!="")
                                    echo Settings::get_instance()->read('zipcode');?><br />
									
									<?php if(Settings::get_instance()->read('phone')!="")
                                    echo $this->get_label('phone no');?> : <?php echo Settings::get_instance()->read('phone');?><br />                                    
                                    
                                    



</td>

<td></td>
<td style="float: right;text-align: right;">
<?php echo $this->get_label('order id');?> : #<?php echo $orderid;?><br/>
<?php echo $this->get_label('order date');?>:<?php echo $this->get_date_format(3,$row['order_date']);?><br/>
<?php echo $this->get_label('payment date');?> : <?php if($row['payment_date'] >0){echo $this->get_date_format(3,$row['payment_date']);}else{echo $this->get_label('na');}?><br/>
<?php echo $this->get_label('payment type');?> : <?php echo $this->get_payment_mode($row['payment_method'],$row['ostatus']);?><br/>
<?php echo $this->get_label('total items');?> : <?php echo $this->get_total_order_quantity($orderid);?><br/>
<?php echo $this->get_label('amount paid');?> : <?php echo $this->get_money_format($row['grand_cost']);?><br/>


</td>


</tr>

<tr>
<td colspan="3">
<hr/>
</td></tr>



<tr>
<td colspan="3">

<div style="float: left;">
<?php echo $this->get_label('shipping details');?><br/>
<?php echo $this->get_address_details($row['shipping_address_id']);?>
</div>

<div style="float: right;">
<?php echo $this->get_label('billing details');?><br/>
<?php echo $this->get_address_details($row['billing_address_id']);?>
</div>
</td>
</tr>




<tr>
<td colspan="3">
<hr/>
</td></tr>

<tr><td colspan="3" style="height: 10px;"></td></tr>

<tr>
<td colspan="3" style="text-align: center;"><strong><?php echo $this->get_label('invoice details');?></strong></td>
</tr>

<tr><td colspan="3" style="height: 10px;"></td></tr>


<tr>
<td colspan="3">
<table style="width: 100%;">
<tr>
<td style="width: 5%;"><?php echo $this->get_label('no');?></td>
<td style="width: 35%;"><?php echo $this->get_label('item');?></td>
<td style="width: 10%;"><?php echo $this->get_label('orderd quantity');?> (A)</td>
<td style="width: 10%;"><?php echo $this->get_label('shipped quantity');?></td>
<td style="width: 10%;"><?php echo $this->get_label('unit price');?> (B)</td>
<td style="width: 10%;"><?php echo $this->get_label('amount');?> (A*B)</td>
<td style="width: 10%;"><?php echo $this->get_label('shipping cost');?> (C)</td>
<td style="width: 10%;"><?php echo $this->get_label('sub total');?> (A*B)+(C)</td>
</tr>

<tr>
<td colspan="8"><hr/></td>
</tr>

<?php }

if($row['shipping_cost'] >0)
{
	$shipping_cost=$this->get_money_format($row['shipping_cost']);
	$shipping_cost_total=$shipping_cost_total+$row['shipping_cost'];
}
else
$shipping_cost=$this->get_label('free');



$item_total=$item_total+($row['unit_price'] * intval($row['quantity']));
$amount_paid=$amount_paid+$row['total_cost'];


?>

<tr>
<td style="height: 30px;"><?php echo $i;?></td>
<td >
<?php 
$productname=$this->escape($this->get_product_name($row['pro_id']));
if($productname !='')
echo $productname;
else
echo $this->get_label('deleted');
?>

</td>
<td ><?php echo intval($row['quantity']);?></td>
<td ><?php echo $itarray[0][$row['pro_id']];?></td>
<td ><?php echo $this->get_money_format($row['unit_price']);?></td>
<td ><?php echo $this->get_money_format($row['unit_price'] * intval($row['quantity']));?></td>
<td ><?php echo $shipping_cost;?></td>
<td ><?php echo $this->get_money_format($row['total_cost']); ?></td>
</tr>


<?php 
}
?>

<tr>
<td colspan="8">
<hr/>
</td></tr>

<tr>
<td colspan="4"></td>
<td colspan="2"><?php echo $this->get_label('item total');?></td>
<td colspan="2"><?php echo $this->get_money_format($item_total); ?></td>
</tr>

<tr>
<td colspan="4"></td>
<td colspan="2"><?php echo $this->get_label('shipping total');?></td>
<td colspan="2">
<?php 
if($shipping_cost_total >0)
echo $shipping_cost_total1=$this->get_money_format($shipping_cost_total);
else
echo $this->get_label('free');
?>
</td>
</tr>

<tr>
<td colspan="4"></td>
<td colspan="4"><hr/></td>
</tr>

<tr>
<td colspan="4"></td>
<td colspan="2"><?php echo $this->get_label('amount paid');?></td>
<td colspan="2"><?php echo $this->get_money_format($amount_paid); ?></td>
</tr>

<tr>
<td colspan="4"></td>
<td colspan="4"><hr/></td>
</tr>

</table>


</td></tr>
</table>
<?php 


}?>