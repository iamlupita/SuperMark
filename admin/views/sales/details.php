<?php $this->dispatch("layout/header/5/_51");?>
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

<div class="sub_menu"><?php echo $this->get_label('order details');?></div>


<?php 
$res=$this->get_result('res');

if(count($res)>0)
{
$i=0;
foreach($res as $key=>$row)
{
$i++;

if($i==1){
	
	$orderid=$row['or_id'];
?>

<div class="order_outer">
<div class="order_inner_one">

<table style="width: 100%;">
<tr>
<td style="width: 120px;" ><?php echo $this->get_label('order id');?></td>
<td style="width: 20px;">:</td>
<td>#<?php echo $row['or_id'];?></td>
</tr>

<tr>
<td><?php echo $this->get_label('user');?></td>
<td>:</td>
<td>



<?php 
$username=$this->get_user_email($row['user_id']);
if($username !=''){?>
<a href="<?php echo $this->make_url('user/profile/').$row['user_id']; ?>"><?php echo $username;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>

</td>
</tr>


<tr>
<td><?php echo $this->get_label('order date');?></td>
<td>:</td>
<td><?php echo $this->get_date_format(3,$row['order_date']);?></td>
</tr>



<tr>
	<td><?php echo $this->get_label('payment date');?></td>
	<td>:</td>
	<td><?php if($row['payment_date'] >0){echo $this->get_date_format(3,$row['payment_date']);}else{echo $this->get_label("na");}?></td>
</tr>

<tr>
	<td><?php echo $this->get_label('payment type');?></td>
	<td>:</td>
	<td><?php echo $this->get_payment_mode($row['payment_method'],$row['or_status']);?>
	
	
	&nbsp;&nbsp;&nbsp;
	<?php if($row['payment_method'] ==1){?><a href="<?php echo $this->make_url('sales/payment_details/'.$this->get_payment_summary_id($row['or_id']));?>" ><?php echo $this->get_label('details');?></a><?php }?>
	
	
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
	<td><?php echo $this->get_money_format($row['grand_cost']);?></td>
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
<td style="width: 155px;"><?php echo $this->get_label('status');?></td>
<td style="width: 110px;"><?php echo $this->get_label('total rate');?></td>
<td style="width: 50px;"><?php echo $this->get_label('local pickup');?></td>
<td style="width: 180px;"><?php echo $this->get_label('action');?></td>
</tr>
</table>


</div>

<?php }?>

<?php 
    list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['pro_id'],1));
	$dimension=$this->get_image_dimension($widthimage,$heightimage,11);
	$dimensionarray=explode('_',$dimension);
 ?>
<div class="orderlist">


<table style="width: 100%;">
<tr style="vertical-align: middle;">
<td style="width: 285px;">

<div class="cartImage" style="float: left; margin-right: 5px; width: 45px;padding-right: 2px;">
<div><img style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>;" src="<?php echo $this->get_product_image($row['pro_id'],1); ?>" /></div>
</div>

<div class="cartProductName">
<?php 
$productname=$this->escape($this->get_product_name($row['pro_id']));
if($productname !=''){?>
<p style="margin-top: 8px;"><a style="color: #000000;text-decoration: none;" href="<?php echo $this->make_url("product/details/".$row['pro_id']);?>"><?php echo $productname;?></a></p>
<?php }else{?>
<p style="margin-top: 8px;"><a style="color: #000000;text-decoration: none;"><?php echo $this->get_label('deleted');?></a></p>
<?php }?>
</div>
</td>
<td style="width: 60px;">
<div class="quantitydiv"><?php echo intval($row['quantity']);?></div>
</td>

<td style="width: 155px;">
<?php 
$shquantity=$this->get_shipping_count($row['or_id'],$row['id'],1);
$dequantity=$this->get_shipping_count($row['or_id'],$row['id'],2);
$noquantity=$this->get_shipping_count($row['or_id'],$row['id'],3);
$retquantity=$this->get_return_count($row['or_id'],$row['id']);

$differance=intval($row['quantity'])-($shquantity+$dequantity+$noquantity);

?>



<?php if($row['or_status'] ==2){?>
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
if($differance >0){?>
<div class="pendingdiv"><?php echo $this->get_label('shipping pending',array('x'=>$differance));?></div>
<?php }?>

</div>
<?php }else if($row['or_status'] ==1){?>
<?php echo $this->get_label('payment pending');?>
<?php }?>

</td>




<td style="width: 110px;"><?php echo $this->get_money_format($row['total_cost']); ?>
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

<td style="width: 50px;">
<?php 
if($row['local_pickup']==1)
echo $this->get_label('yes');
else 
echo $this->get_label('no');
?></td>

<td style="width: 170px;">


<?php 
if(($row['quantity']-$this->get_total_quantity_from_shipmentdetails($row['id'])) >0 && $row['or_status']==2){?>
<div style="width: 44px;height: 18px;" title="<?php echo $this->get_label('add shipping details');?>" onclick="add_shipping_details(0,<?php echo $row['order_id'];?>,<?php echo $row['id'];?>)" class="shipdetailsdiv"><?php echo $this->get_label('add');?><img class="shipimage" src="images/plus.png" /></div>


<div class='popup-outer' id="add-ship-<?php echo $row['id'];?>" style="display:none ;">
<div class="behind_div">
<div class="popup">
<iframe id="iframe-ship-<?php echo $row['id'];?>" src="<?php echo $this->make_url('sales/edit_shipping_details/0/'.$row['order_id'].'/'.$row['id'].'/'.$row['local_pickup']);?>" width="100%" height="100%" frameborder="0"></iframe>
</div>
</div>
</div>


<?php } ?>



<div title="<?php echo $this->get_label('shipping details');?>" class="shipdetailsdiv" onclick="LoadShipDeliveryDetails(<?php echo $row['id'];?>);"><?php echo $this->get_label('details');?><img class="shipimage" id="shipimage<?php echo $row['id'];?>" src="images/down.png" /></div>
<input type="hidden" name="updown<?php echo $row['id'];?>" id="updown<?php echo $row['id'];?>" value="0" />


</td>
</tr>
</table>






</div>

<div class="orderlistdetails" id="orderlistdetails_<?php echo $row['id'];?>" >
<?php $this->dispatch("sales/shipping_details/".$row['id']);?>
</div>






<?php 
} } 
?>

<?php if(count($res)>0){?>
<div class="printhead"><?php echo $this->get_label('print');?></div>

<div class="printlabel" onclick="PrintInvoice();"><img src="images/printer.png" title="<?php echo $this->get_label('print invoice');?>" />&nbsp;&nbsp;<?php echo $this->get_label('print invoice');?>&nbsp;&nbsp;<img class="printdownimage" src="images/down.png" /></div>
<div class="printdetails">
<input type="hidden" name="printupdown" id="printupdown" value="0"/>

<?php 
$allid='';
foreach($res as $key=>$row)
{
    list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['pro_id'],1));
	$dimension=$this->get_image_dimension($widthimage,$heightimage,11);
	$dimensionarray=explode('_',$dimension);
	
	if($allid !='')
	$allid.='-';
	
	$allid.=$row['pro_id'];
	
	

	$shquantity=$this->get_shipping_count($row['or_id'],$row['id'],1);
	$dequantity=$this->get_shipping_count($row['or_id'],$row['id'],2);
	$noquantity=$this->get_shipping_count($row['or_id'],$row['id'],3);
	$retquantity=$this->get_return_count($row['or_id'],$row['id']);
	
	$differance=intval($row['quantity'])-($shquantity+$dequantity+$noquantity);

 ?>
<div class="orderlist" style="margin: 10px;">


<table style="width: 100%;">
<tr style="vertical-align: middle;">
<td style="width: 400px;">

<input onclick="DisplayQuantity(<?php echo $row['pro_id'];?>);" class="printchk" type="checkbox" name="printcheck<?php echo $row['pro_id'];?>" id="printcheck<?php echo $row['pro_id'];?>" value="1" />&nbsp;

<div class="cartImage" style="float: left; margin-right: 5px; width: 45px;padding-right: 2px;">
<div><img style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>;" src="<?php echo $this->get_product_image($row['pro_id'],1); ?>" /></div>
</div>

<div class="cartProductName" style="width: 425px;height: 18px;">
<?php 
$productname=$this->escape($this->get_product_name($row['pro_id']));
if($productname !=''){?>
<p style="margin-top: 4px;float: left;"><a style="color: #000000;text-decoration: none;" href="<?php echo $this->make_url("product/details/".$row['pro_id']);?>"><?php echo $productname;?></a></p>
<?php }else{?>
<p style="margin-top: 4px;float: left;"><a style="color: #000000;text-decoration: none;"><?php echo $this->get_label('deleted');?></a></p>
<?php }?>
</div>



</td>

<td style="width: 75px;display: none;" id="qtytd<?php echo $row['pro_id'];?>">
<?php echo $this->get_label('quantity');?>
<input style="border: 1px solid #CCCCCC;border-radius: 0 0 0 0 !important;width: 55px;margin-top: 4px;" type="text" name="printquantity<?php echo $row['pro_id'];?>" id="printquantity<?php echo $row['pro_id'];?>" onkeyup="this.value = this.value.replace(/[^0-9]/g,'');" onblur="CheckQuantity(<?php echo $row['pro_id'];?>);"  value="<?php echo $differance;?>" size="3" />

&nbsp;&nbsp;
<input type="hidden" name="orderquantity<?php echo $row['pro_id'];?>" id="orderquantity<?php echo $row['pro_id'];?>" value="<?php echo intval($row['quantity']);?>" />

</td>
</tr>
</table>
</div>




<?php }?>
<input type="hidden" name="orderid" id="orderid" value="<?php echo $orderid;?>" />
<input type="hidden" name="allid" id="allid" value="<?php echo $allid;?>" />
<div class="printbutton"><input type="button" name="print" id="print" onclick="LoadPrintContent();" value="<?php echo $this->get_label('print');?>" /></div>
</div>


<div class="printcontent" style="display:none;"></div>




<?php }?>
 
 
 
 
<script type="text/javascript">
 function CheckQuantity(id)
 {
	qty=$('#printquantity'+id).val();
	orderquantity=$('#orderquantity'+id).val();

	if(qty > orderquantity)
	{
 		alert('<?php echo $this->get_message('shipping quantity is greater');?>');
	}

 }
function LoadPrintContent()
{
	allid=$('#allid').val();
	allidarray=allid.split('-');
	var specialdata='';
	for(i=0;i < allidarray.length; i++)
	{
		if($('#printcheck'+allidarray[i]).prop('checked') && ($('#printquantity'+allidarray[i]).val() =='' || $('#printquantity'+allidarray[i]).val() ==0))
		{
			alert('<?php echo $this->get_message('please fill quantity');?>');
			$('#printquantity'+allidarray[i]).focus();
			return false;
		}

		if($('#printcheck'+allidarray[i]).prop('checked') && $('#printquantity'+allidarray[i]).val() >0)
		{
			if(specialdata !='')
			specialdata=specialdata+'-';

			specialdata=specialdata+allidarray[i]+'_'+$('#printquantity'+allidarray[i]).val();
		}
	}

	orderid=$('#orderid').val();
	if(specialdata !='')
	{
		dataparam="orderid="+orderid+"&list="+specialdata;
		
		$.ajax(
		{
			type: "POST",
			data: dataparam,
			url: "<?php echo $this->make_url('sales/print_invoice');?>",
			success: function(resp)
			{
				if(resp !='')
				{
					$(".printcontent").html(resp);


					PrintSlip();
					
				}
			} 
		});

	}

	
}
function DisplayQuantity(id)
{
	if($('#printcheck'+id).prop('checked'))
	$('#qtytd'+id).show();
	else
	$('#qtytd'+id).hide();

	flag=0;
	allid=$('#allid').val();
	allidarray=allid.split('-');

	for(i=0;i < allidarray.length; i++)
	{
		if($('#printcheck'+allidarray[i]).prop('checked'))
		{
			flag=1;
			break;
		}
	}

	if(flag ==1)
	$('.printbutton').show();
	else
	$('.printbutton').hide();
	
}
function PrintInvoice()
{
	var printupdown=$('#printupdown').val();

	if(printupdown == 0)
	{
		$('.printdetails').slideDown(200);
		$('#printupdown').val(1);
		$('.printdownimage').attr('src','images/up-arrow.png');
	}
	else if(printupdown == 1)
	{
		$('.printdetails').slideUp(200);
		$('#printupdown').val(0);
		$('.printdownimage').attr('src','images/down.png');
	}
}
 
function PrintSlip()
{
	 var printWindow = window.open("","printdata");
	 printWindow.document.open();
	 printWindow.document.write($('.printcontent').html());
	 printWindow.document.close();
	 printWindow.print();
}

 

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


    function add_shipping_details(id,order_id,order_item_id)
    {
    	$(".popup-outer").hide();
    	$("#add-ship-"+order_item_id).show();
    }


    
</script>
<?php $this->dispatch("layout/footer");?>