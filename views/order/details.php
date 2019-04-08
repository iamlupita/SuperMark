<?php 
$this->dispatch("layout/header");
?>
<script type="text/javascript">
function LoadAddress(type)
{
	if(type ==1 && $('#addressdetails1').length >0)
	{
		$('#addressdetails1').show();

		$('#addressdetails2').length >0
		{
			$('#addressdetails2').hide();
			$('#addressdiv2').css('background-color','#ECECEC');
		}

		$('#addressdiv1').css('background-color','#FFFFFF');
		
	}
	else if(type ==2 && $('#addressdetails2').length >0)
	{
		$('#addressdetails2').show();

		if($('#addressdetails1').length >0)
		{
			$('#addressdetails1').hide();
			$('#addressdiv1').css('background-color','#ECECEC');
		}

		$('#addressdiv2').css('background-color','#FFFFFF');
	}
}
</script>
<style type="text/css">
textarea, .textStyle { width: 249px!important;}
</style>


<div class="container mtop-30" style="width:990px;">

            
<?php $this->dispatch("layout/login_left");
$orderitem=$this->get_result('orderitem');
$ord_dtls_cnt=count($orderitem);

?>
<div class="accountData contentLeft">

<?php if($ord_dtls_cnt==0){?>
<h1 class="titleh1" style="text-align:left;font-size:18px;"><?php echo $this->get_label('order details');?></h1>

<?php }?>

<?php 
  $i=0;
    foreach($orderitem as $key=>$row)
    {
    $i++;
    
if($i==1){

$pay_date=$row['payment_date'];
$grand_cost=$row['grand_cost'];
$payment_go=0;
if($pay_date==0 && $grand_cost>0)
	$payment_go=1;
?>


<h1 class="titleh1" style="text-align:left;font-size:18px;"><?php echo $this->get_label('order details');?>



<?php if($payment_go==1){?>

	<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="order_payment" id="order_payment">-->
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="order_payment" id="order_payment">
    <input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="item_name" value="<?php echo Settings::get_instance()->read('engine_name')." - ".$this->get_label('payments');?>">
	<input type="hidden" name="item_number" value="<?php echo $row['or_id'];?>">
	<input type="hidden" name="amount" id="amount" value="<?php echo $grand_cost;?>">
	<input type="hidden" name="currency_code" value="<?php echo Settings::get_instance()->read('paypal_currency');?>">
	<input type="hidden" name="notify_url" value="<?php echo $this->make_url('payment/paypal_ipn')?>">
	<input type="hidden" name="cancel_return" value="<?php echo $this->make_url('payment/cancel')?>">
	<input type="hidden" name="business" value="<?php echo Settings::get_instance()->read('paypal_email');?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="no_note" value="0">
	<input type="hidden" name="custom" value="<?php echo $this->get_variable('userid');?>">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="return" value="<?php echo $this->make_url('payment/paypal_success')?>">
	<input type="submit" class="normalBtn contentRight" style="margin-top:-35px;padding: 5px 15px;" value="<?php echo $this->get_label('proceed to payment');?>" />
	</form>
 
 
 <?php } ?>
								

</h1>





<div class="order_outer">
<div class="order_inner_one">

<table style="width: 100%;">
<tr>
<td style="width: 120px;" ><?php echo $this->get_label('order id');?></td>
<td style="width: 20px;">:</td>
<td>#<?php echo $row['or_id'];?></td>
</tr>

<tr>
<td><?php echo $this->get_label('order date');?></td>
<td>:</td>
<td><?php if($row['order_date']>0)echo $this->get_date_format(3,$row['order_date']);else echo $this->get_label('na');?></td>
</tr>



<tr>
	<td><?php echo $this->get_label('payment date');?></td>
	<td>:</td>
	<td><?php if($row['payment_date']>0)echo $this->get_date_format(3,$row['payment_date']);else echo $this->get_label('na');?></td>
</tr>

<tr>
	<td><?php echo $this->get_label('payment type');?></td>
	<td>:</td>
	<td><?php echo $this->get_payment_mode($row['payment_method'],$row['or_status']);?>
	&nbsp;&nbsp;&nbsp;
	<?php if($row['payment_method'] ==1){?><a href="<?php echo $this->make_url('payment/details/'.$this->get_payment_summary_id($row['or_id'],$this->get_variable('userid')));?>" ><?php echo $this->get_label('details');?></a><?php }?>
	</td>
</tr>

<tr>
	<td><?php echo $this->get_label('total items');?></td>
	<td>:</td>
	<td>
	<?php 
	
// 		$itemcount=$this->get_order_item_count($row['or_id']);
// 		if($itemcount >0)
// 		echo $itemcount;
// 		else 
// 		echo $this->get_label('na');
	?>
	
	<?php 
		$item_qty=$this->get_total_order_quantity($row['or_id']);
		if($item_qty >0)
		echo $item_qty;
		else 
		echo $this->get_label('na');
	?>
	</td>
</tr>


<tr>
	<td><?php echo $this->get_label('amount');?></td>
	<td>:</td>
	<td><?php if($row['grand_cost']>0)echo $this->get_money_format($row['grand_cost']);else echo $this->get_label('na');?></td>
</tr>


</table>


</div>


<div class="order_inner_two">
<?php if($row['shipping_address_id']!=""){?>
<div class="addressdiv" id="addressdiv1" onclick="LoadAddress(1)"><?php echo $this->get_label('shipping details');?></div>
<?php }?>

<?php if($row['billing_address_id']!=""){?>
<div class="addressdiv" id="addressdiv2" onclick="LoadAddress(2)"><?php echo $this->get_label('billing details');?></div>
<?php }?>

<?php if($row['shipping_address_id']!=""){?>
<div class="addressdetails" id="addressdetails1">

<?php echo $this->get_address_details($row['shipping_address_id']);?>

</div>
<?php }?>

<?php if($row['billing_address_id']!=""){?>
<div class="addressdetails" id="addressdetails2" style="display: none;">


<?php echo $this->get_address_details($row['billing_address_id']);?>



</div>

<?php }?>


</div>

</div>




<div class="orderitemdetails"><?php echo $this->get_label('ordered item details');?></div>


<div class="orderitemhead">

<table style="width: 100%;">
<tr>
<td style="width: 300px;"><?php echo $this->get_label('item');?></td>
<td style="width: 80px;"><?php echo $this->get_label('order quantity');?></td>
<td style="width: 140px;"><?php echo $this->get_label('status');?></td>
<td style="width: 120px;"><?php echo $this->get_label('total rate');?></td>
<td style="width: 100px;"><?php echo $this->get_label('local pickup');?></td>
<td style="width: 140px;"><?php echo $this->get_label('action');?></td>
</tr>
</table>


</div>




<?php }?>














<?php 

    list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['pro_id']));
	$dimension=$this->get_image_dimension($widthimage,$heightimage,11);
	$dimensionarray=explode('_',$dimension);
               	
 ?>
 
<div class="orderlist">


<table style="width: 100%;">
<tr style="vertical-align: middle;">
<td style="width: 290px;">

<div class="cartImage cartImageDetails">
<div><img style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>;" src="<?php echo $this->get_product_image($row['pro_id']); ?>" /></div>
</div>

<div class="cartProductName" style="width: 168px;">
<?php 
$productname=$this->escape($this->get_product_name($row['pro_id']));
if($productname !=''){?>
<p style="margin-top: 12px;"><a style="color: #000000;text-decoration: none;" href="<?php echo $this->make_url("product/details/".$row['pro_id']);?>"><?php echo $productname;?></a></p>
<?php }else{?>
<p style="margin-top: 12px;"><a style="color: #000000;text-decoration: none;"><?php echo $this->get_label('deleted');?></a></p>
<?php }?>
</div>

</td>
<td style="width: 80px;">
<div class="quantitydiv"><?php echo intval($row['quantity']);?></div>
</td>

<td style="width: 150px;">
<?php 
$shquantity=$this->get_shipping_count($row['or_id'],$row['id'],1);
$dequantity=$this->get_shipping_count($row['or_id'],$row['id'],2);
$noquantity=$this->get_shipping_count($row['or_id'],$row['id'],3);
$retquantity=$this->get_return_count($row['or_id'],$row['id']);

$differance=intval($row['quantity'])-($shquantity+$dequantity+$noquantity);

?>




<div class="shipstatusdiv">
<?php 
if($shquantity >0)
{?>
	<div class="shippeddiv"><?php echo $this->get_label('shipped count',array('x'=>$shquantity));?></div>
	<?php 
}

if($dequantity >0){?>
<div class="delivereddiv"><?php echo $this->get_label('delivered count',array('x'=>$dequantity));?></div>
	<?php 
}

if($noquantity >0){?>
<div class="notaccepteddiv"><?php echo $this->get_label('not accepted count',array('x'=>$noquantity));?></div>
<?php }

if($retquantity >0){?>
<div class="retdiv"><?php echo $this->get_label('return count',array('x'=>$retquantity));?></div>
<?php }
?>



<?php 
if($payment_go==1){?>
<div class="pendingdiv"><?php echo $this->get_label('pending payment');?></div>
<?php }else if($differance >0){?>
<div class="pendingdiv"><?php echo $this->get_label('shipping pending',array('x'=>$differance));?></div>
<?php }?>







</div>

</td>




<td style="width: 120px;"><?php echo $this->get_money_format($row['total_cost']); ?>
<a href="javascript:void(0);" class="subtotal" onmouseover="sub_total_div_mover(<?php echo $row['id'];?>)" onmouseout="sub_total_div_mout(<?php echo $row['id'];?>)">[?]</a>

<div class="sub_total_show_hide_div" id="sub_total_div_<?php echo $row['id'];?>" >
      
      <div class="sub_total_outer" style="text-align: center;"><?php echo $this->get_label('sub total');?></div>
      
       <div class="sub_total_outer">
	      <div class="sub_total_inner1"><?php echo $this->get_label('quantity');?></div>
	      <div class="sub_total_inner2">:</div>
	      <div class="sub_total_inner3"><?php if($row['quantity']>0){echo $row['quantity'];}else{echo $this->get_label('na');} ?></div>
      </div>
      
      <div class="sub_total_outer">
	      <div class="sub_total_inner1"><?php echo $this->get_label('unit price');?></div>
	      <div class="sub_total_inner2">:</div>
	      <div class="sub_total_inner3"><?php if($row['unit_price']>0){echo $this->get_money_format($row['unit_price']);}else{echo $this->get_label('na');} ?></div>
      </div>
      
      <div class="sub_total_outer">
	      <div class="sub_total_inner1"><?php echo $this->get_label('shipping cost');?></div>
	      <div class="sub_total_inner2">:</div>
	      <div class="sub_total_inner3"><?php if($row['shipping_cost']>0){echo $this->get_money_format($row['shipping_cost']);}else{echo $this->get_label('na');} ?></div>
      </div>
            
      <div class="sub_total_outer">
	      <div class="sub_total_inner1"><?php echo $this->get_label('sub total');?></div>
	      <div class="sub_total_inner2">:</div>
	      <div class="sub_total_inner3"><?php if($row['total_cost']>0){echo '<strong style="font-weight:bold;">'.$this->get_money_format($row['total_cost']).'</strong>';}else{echo $this->get_label('na');} ?></div>
      </div>
</div>










</td>

<td style="width: 100px;">
<?php 
if($row['local_pickup']==1)
echo $this->get_label('yes');
else 
echo $this->get_label('no');
?></td>


<td style="width: 140px;">

<div title="<?php echo $this->get_label('shipping details');?>" class="shipdetailsdiv" onclick="LoadShipDeliveryDetails(<?php echo $row['id'];?>);"><?php echo $this->get_label('details');?><img class="shipimage" id="shipimage<?php echo $row['id'];?>" src="images/down.png" /></div>
<input type="hidden" name="updown<?php echo $row['id'];?>" id="updown<?php echo $row['id'];?>" value="0" />


</td>
</tr>
</table>






</div>

<div class="orderlistdetails" id="orderlistdetails_<?php echo $row['id'];?>" >
 
 
<?php 
if($row['shipment_id']!="")
$this->dispatch("order/shipping_details/".$row['id']);
else{?>
<div style="height: 20px;padding-top: 25px;padding-left: 5px;"><?php echo $this->get_label('item not shipped');?></div>
<?php if($row['local_pickup']==1 && $row['or_status']==2){?>


<div style="height: 120px;padding-top: 10px;padding-left: 5px;">
<div style="padding-bottom: 10px;"><?php echo $this->get_label('you may pickup item');?></div>
<div>
 <?php 
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
</div>
</div>
<?php }?>
<?php } ?>


</div>
<?php 
}
?>

</div></div>
				
<script type="text/javascript">
function LoadShipDeliveryDetails(id)
{
	var updown=$('#updown'+id).val();

	if(updown == 0)
	{
		$('#orderlistdetails_'+id).slideDown(200);
		$('#updown'+id).val(1);
		$('#shipimage'+id).attr('src','images/up-arrow.png');
	}
	else if(updown == 1)
	{
		$('#orderlistdetails_'+id).slideUp(200);
		$('#updown'+id).val(0);
		$('#shipimage'+id).attr('src','images/down.png');
	}


}
    
    function sub_total_div_mover(id)
    {
        $("#sub_total_div_"+id).show(300);
    }
    
    function sub_total_div_mout(id)
    {
    	$("#sub_total_div_"+id).hide(200);
    }

</script>
<?php $this->dispatch("layout/footer");?>