<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . date("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
 
$JSString=$this->get_variable('JSString');

$order_details=json_decode($JSString);
$page_type=$this->get_variable('page_type');

?>		

<div class="checkout_shipped">
<label class="label_shipped"><?php echo $this->get_label('shipped to');?></label>
<div class="checkout_shipped_inner">
<?php 
$shpaddress=$this->get_variable('shpaddress');

echo $this->get_address_details($shpaddress);
?>
</div>
</div>

	
	<div class="checkout_head">
	<div style="width:47%;"><?php echo $this->get_label('item');?></div>
	<div style="width:10%;"><?php echo $this->get_label('quantity');?></div>
	<div  style="width:10%;"><?php echo $this->get_label('price');?></div>
	<div style="width:10%;"><?php echo $this->get_label('local pickup');?></div>
	<div  style="width:10%;"><?php echo $this->get_label('shipping cost');?></div>
	<div style="width:10%;"><?php echo $this->get_label('subtotal');?></div>
	</div>
	
	<div style="height: 25px;"></div>
	<?php 	   
		    for($i=0;$i< $order_details->total_items;$i++)
		    {?>
		    
		    <div class="checkout_list" <?php if($i == ($order_details->total_items-1)){?>style="border-bottom: 1px solid #000000;"<?php }?>>

		    <div class="checkout_list_div" style="width:47%;float: left;" >
		    
		    
		    <div class="checkoutImage" style="padding-right: 4px;">
		    <div>
		    	
		    <?php 	 
		    if($order_details->shopping[$i]->image !=""){?>
		    <img src="<?php echo $order_details->shopping[$i]->image;?>" style="width:<?php echo $order_details->shopping[$i]->width;?>px;height:<?php echo $order_details->shopping[$i]->height;?>px;" />
		   <?php }?>
		   
		    </div>
		    </div>
		    
		
		    <div class="checkout_title"><?php echo $order_details->shopping[$i]->name;?></div>
		    </div>
		    
		    <div class="checkout_list_div checkout_content" style="width:10%;margin-top: 27px;" >
		    
		    
		    <?php $pstock=$this->get_stock($order_details->shopping[$i]->id);?>
		    
		    <input type="text" class="order_quantity" id="order_qty<?php echo $order_details->shopping[$i]->id;?>" value="<?php echo $order_details->shopping[$i]->quantity;?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');if(this.value ><?php echo $pstock; ?>){$('#order_save_<?php echo $order_details->shopping[$i]->id;?>').hide();alert('<?php echo $this->get_message('quantity exceeded stock');?>');}else{$('#order_save_<?php echo $order_details->shopping[$i]->id;?>').show();}"/>
	        <input class="order_save" id="order_save_<?php echo $order_details->shopping[$i]->id;?>" type="button"  value="<?php echo $this->get_label('save');?>" onclick="ChangeOrderQuantity(<?php echo $order_details->shopping[$i]->id;?>);"/>
		    
		    
		    
		    
		    
		    
		    </div>
		    
		    <div class="checkout_list_div checkout_content" style="width:10%;font-weight: bold;"><?php echo $this->get_money_format($order_details->shopping[$i]->price);?></div>
		  
		  
		  
		  <div class="checkout_list_div checkout_content" style="width:10%;">
		   
		   <?php 	
		    if($order_details->shopping[$i]->localpickup ==1){?>
		    <input type="checkbox" id="local_pickup_checkbox_<?php echo $order_details->shopping[$i]->id;?>" name="local_pickup_checkbox_<?php echo $order_details->shopping[$i]->id;?>" value="" onclick="local_pickup_checkbox_click(<?php echo $order_details->shopping[$i]->id;?>);" />
		   <?php } else{echo $this->get_label('na');}?>
		    </div>
		  
		  
		  
		  
		  
		  
		  
		    <div class="checkout_list_div checkout_content" style="width:10%;font-weight: bold;">

		    <input type="hidden" name="shipping_cost_<?php echo $order_details->shopping[$i]->id;?>" id="shipping_cost_<?php echo $order_details->shopping[$i]->id;?>" value="<?php echo $order_details->shopping[$i]->shipping_cost;?>">
		    
		    <?php 
		    if($order_details->shopping[$i]->shipping_cost ==0)
		   	echo $this->get_label('free');
		    else
		    {?>
			    <span id="shipping_cost_span_<?php echo $order_details->shopping[$i]->id;?>"><?php echo $this->get_money_format($order_details->shopping[$i]->shipping_cost);?></span>
			<?php }?>   
		    </div>
		    
		    <div class="checkout_list_div checkout_content" style="width:10%">
		    
		    <input type="hidden" name="item_total_<?php echo $order_details->shopping[$i]->id;?>" id="item_total_<?php echo $order_details->shopping[$i]->id;?>" value="<?php echo $order_details->shopping[$i]->sub_total_cost;?>" />
		    <span id="item_total_span_<?php echo $order_details->shopping[$i]->id;?>" style="font-weight: bold;"><?php echo $this->get_money_format($order_details->shopping[$i]->sub_total_cost);?></span>
		    
		    
		    
		   
		    
		    </div>
		    <div class="checkout_list_div checkout_content" style=""><a onclick="RemoveOrderItem(<?php echo $order_details->shopping[$i]->id;?>);" class="closeButton1" title="<?php echo $this->get_label('remove item');?>">x</a></div>
		    
		    </div>
		    
			<?php 	
		    }
		    
?>
<div class="checkout_total">

<div class="checkout_total_div" style="width: 12%;"><a href="javascript:void(0);" id="order-row-continue" class="normalBtn continuethree"><?php echo $this->get_label('save and continue');?></a></div>

<div class="checkout_total_div checkout_total_font" style="width:20%;"><?php echo $this->get_label('grand total');?> : <span id="grandcost_span"><?php echo $this->get_money_format($order_details->grand_total_cost);?></span></div>

<div class="checkout_total_div checkout_total_font" ><?php echo $this->get_label('total shipping cost');?> : <?php 
		    if($order_details->total_shipping_cost ==0){?>				
		    <span style="font-weight: bold;"><?php echo $this->get_label('free');?></span>
		    <?php }else {?>
			<span id="total_shipping_cost_span"><?php echo $this->get_money_format($order_details->total_shipping_cost);?></span>
			<?php }?>
			</div>

<div class="checkout_total_div checkout_total_font" ><?php echo $this->get_label('total item cost');?> : <span id="total_item_cost_span"><?php echo $this->get_money_format($order_details->total_item_cost);?></span></div>



			




		 <input type="hidden" id="grandcost" name="grandcost" value="<?php echo $order_details->grand_total_cost;?>" /> 
		 <input type="hidden" id="total_shipping_cost" name="total_shipping_cost" value="<?php echo $order_details->total_shipping_cost;?>" />
			
			
</div>
<script type="text/javascript">
function RemoveOrderItem(pid)
{
	var pagetype=<?php echo $page_type;?>;

	if(pagetype ==0)
	var name="<?php echo COOKIE_CART_ITEMS;?>";
	else if(pagetype ==1)
	var name="<?php echo COOKIE_REORDER_ITEMS;?>";

	
	var cnt=0;
	var newvalue='';
    var oldvalue=Get_Cookie(name);
    if(oldvalue!=null && oldvalue!="")
    { 
    	oldvalue_data=oldvalue.split(',');
    	cookielength=oldvalue_data.length;
    	
    	for(i=0;i < cookielength;i++)
   		{
    		olditems=oldvalue_data[i].split('-');

    		if(pid !=olditems[0] && olditems[1] >0)
    		{
        		if(newvalue !='')
        		newvalue=newvalue+',';

       			newvalue=newvalue+olditems[0]+'-'+olditems[1];
       			cnt=parseInt(cnt)+parseInt(olditems[1]);
    		}
   	    }
    }

    Set_Cookie(name,newvalue,1000,"<?php echo $this->get_base_path();?>","<?php echo $this->get_base_domain();?>");

    
    if(pagetype ==0)
    {
		$('#setcartitem').html(cnt);	
		if(cnt >0)
		$('#setcartitem').show();
		else
		$('#setcartitem').hide();
    }

	ManageOrderItems();
}

function ChangeOrderQuantity(pro_id)
{
var quantity=$("#order_qty"+pro_id).val();

if(quantity !="" && quantity >0)
{
	$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("cart/change_checkout_quantity/");?>"+pro_id+"/"+quantity+"/"+<?php echo $page_type;?>,
		success: function(msg)
			{
				if(msg=="stock")
				alert("<?php echo $this->get_message('quantity exceeded stock');?>");
				else if(msg=='quantity')
				alert("<?php echo $this->get_message('invalid quantity');?>");
				else
				{
					if(msg >0)
					$('#setcartitem').html(msg);
					
					ManageOrderItems();
				}
			}
		});	
}
else
	alert("<?php echo $this->get_message('invalid quantity');?>");
}


		    
$("#order-row-continue").click(function(){
	
	if($('#billaddressid').val() >0 && $('#shipaddressid').val() >0)
	{
		$('#currentdiv').val(4);
		$("#order-row-success").val(1);
		
		$('.billingDiv').hide();
		$('.shippingDiv').hide();
		$('.orderDiv').hide();
		$('.paymentDiv').show();

		$('.labelclass').removeClass('selectedCheckOut');
		$('#label4').addClass('selectedCheckOut');
	}
	else
	{
		alert("<?php echo $this->get_message('give me the billing details');?>");
		$('#currentdiv').val(1);
		$('.shippingDiv').hide();
		$('.orderDiv').hide();
		$('.paymentDiv').hide();
		$('.billingDiv').show();	

		$('.labelclass').removeClass('selectedCheckOut');
		$('#label1').addClass('selectedCheckOut');	
	}


});
</script>