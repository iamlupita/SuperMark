<?php 
if($this->get_variable('payment_go')==0){
	
$this->dispatch("layout/header/checkout123");
$user_address=$this->get_result('user_address');
$user_address_cnt=count($user_address);

$validate=array(
		"billing_name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_phoneno"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_address1"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_country"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_state"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_city"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_zipcode"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"billing_zipcode"=>array(
				"isPositive"=>array($this->get_message("integer"))
		)
);

?>
    
<style>
textarea{height: 61px;margin: 0 0 10px;width: 189px;border: 1px solid #CCCCCC;}
</style>

  
  <script>



 
 function NewAddress()
 {
	 if(!validate_add_billing_address())
	 return false;


		
	  	var billing_name=$('#billing_name').val();
		var billing_address1=$('#billing_address1').val();
		var billing_address2=$('#billing_address2').val();
		var billing_phoneno=$('#billing_phoneno').val();
		var billing_country=$('#billing_country').val();
		var billing_country_name=$('#billing_country option:selected').text();
		var billing_state=$('#billing_state').val();
		var billing_city=$('#billing_city').val();
		var billing_zipcode=$('#billing_zipcode').val();
		var existingid='';
		
	$.ajax({
			type: "POST",
			url: "<?php echo $this->make_url("cart/add_address/");?>",
			data: "name="+billing_name+"&address1="+billing_address1+"&address2="+billing_address2+"&phno="+billing_phoneno+"&country="+billing_country+"&state="+billing_state+"&city="+billing_city+"&zipcode="+billing_zipcode+"&existingid="+existingid,
			success: function(msg)
			{
				if(msg == 'error')
				{
					alert("<?php echo $this->get_message('mandatory');?>");
					return;
				}
				else
				{

				

				if($('#currentdiv').val() ==1)
				$("#billaddressid").val(msg);

				
				if($('#currentdiv').val() ==2 || $('#ship_address_checkbox').prop('checked'))
				$("#shipaddressid").val(msg);

		billstring='';
		shipstring='';



	billstring=billstring+'<div class="checkout_address_inner_bill" id="bill'+msg+'"><div style="height: 145px;">';
	billstring=billstring+'<label class="namelabel">'+billing_name+'</label><br/>';
	billstring=billstring+billing_address1+'<br/>';
	
	if(billing_address2 !="")
	billstring=billstring+billing_address2+'<br/>';
	
	billstring=billstring+billing_city+'<br/>';
	billstring=billstring+billing_state+'<br/>';
	billstring=billstring+billing_country_name+'-'+billing_zipcode+'<br/>';
	
			
	if(billing_phoneno !="" && billing_phoneno !="0")
	billstring=billstring+'<?php echo $this->get_label("phone");?> : '+billing_phoneno+'<br/>';
	
	
	
	billstring=billstring+'<br/></div>';
	billstring=billstring+'<div style="margin: auto;"><a href="javascript:void(0);" class="useThisAddress" onclick="ChangeBillingAddress('+msg+');"><?php echo $this->get_label("use this");?></a></div>';
	
	billstring=billstring+'</div>';	




	shipstring=shipstring+'<div class="checkout_address_inner_ship" id="ship'+msg+'"><div style="height: 145px;">';
	shipstring=shipstring+'<label class="namelabel">'+billing_name+'</label><br/>';
	shipstring=shipstring+billing_address1+'<br/>';
	
	if(billing_address2 !="")
	shipstring=shipstring+billing_address2+'<br/>';
	
	shipstring=shipstring+billing_city+'<br/>';
	shipstring=shipstring+billing_state+'<br/>';
	shipstring=shipstring+billing_country_name+'-'+billing_zipcode+'<br/>';
	
			
	if(billing_phoneno !="" && billing_phoneno !="0")
	shipstring=shipstring+'<?php echo $this->get_label("phone");?> : '+billing_phoneno+'<br/>';
	
	
	
	shipstring=shipstring+'<br/></div>';
	shipstring=shipstring+'<div style="margin: auto;"><a href="javascript:void(0);" class="useThisAddress" onclick="ChangeShippingAddress('+msg+');"><?php echo $this->get_label("use this");?></a></div>';
	
	shipstring=shipstring+'</div>';	





$('.checkout_address_outer_bill').prepend(billstring);
$('.checkout_address_outer_ship').prepend(shipstring);




LoadBillColor();
LoadShipColor();



				AddAddressClose();




				<?php if($user_address_cnt ==0){?>
				window.location.href="<?php echo $this->make_url('cart/checkout/'.$this->get_variable('page_type'));?>"; 
				<?php }?>
				
			}
			}
		});
  
}


 function ManageOrderItems()
 {
	//if($('#manageorderitems').html() =='')
	//{
	
		 $('.order_loading').show();
		 var shipaddressid=$("#shipaddressid").val();
		 if(shipaddressid >0){
		 $.ajax({
				type: "POST",
				url: "<?php echo $this->make_url("cart/order_details");?>",
				data: "id="+shipaddressid+"&page_type=<?php echo $this->get_variable('page_type');?>",
				success: function(response)
					{
						$('.order_loading').hide();
					
					    if(response=="empty")
					    {
						    window.location.href="<?php echo $this->make_url('index/index');?>";
					    }
					    else if(response !="")
						{
			    			$('#manageorderitems').html(response);
				   		}
		 			}
				});
		 }
	//}
 }

 function local_pickup_checkbox_click(id)
 {
	var shipping_cost=parseFloat($("#shipping_cost_"+id).val());
	
	if(shipping_cost==0 || shipping_cost=="")
		return;
	 if($("#local_pickup_checkbox_"+id).prop('checked') == true)
	{
		var grcost=parseFloat($("#grandcost").val())-shipping_cost;
		$("#grandcost").val(grcost);
		$("#grandcost_span").html(money_format(grcost));
		
		var tship_cost=parseFloat($("#total_shipping_cost").val())-shipping_cost;
		$("#total_shipping_cost").val(tship_cost);
		$("#total_shipping_cost_span").html(money_format(tship_cost));

		var item_total=parseFloat($("#item_total_"+id).val())-shipping_cost;
		$("#item_total_"+id).val(item_total);
		$("#item_total_span_"+id).html(money_format(item_total));

		var ship_cost=parseFloat($("#shipping_cost_"+id).val())-shipping_cost;
		$("#shipping_cost_span_"+id).html(money_format(ship_cost));
		
	}
	else
	 {
		 	var grcost=parseFloat($("#grandcost").val())+shipping_cost;
			$("#grandcost").val(grcost);
			$("#grandcost_span").html(money_format(grcost));

			var tship_cost=parseFloat($("#total_shipping_cost").val())+shipping_cost;
			$("#total_shipping_cost").val(tship_cost);
			$("#total_shipping_cost_span").html(money_format(tship_cost));

			var item_total=parseFloat($("#item_total_"+id).val())+shipping_cost;
			$("#item_total_"+id).val(item_total);
			$("#item_total_span_"+id).html(money_format(item_total));

			$("#shipping_cost_span_"+id).html(money_format(shipping_cost));
	 }

 }
 


 
 function js_round(value, precision, mode) {
	  var m, f, isHalf, sgn; // helper variables
	  precision |= 0; // making sure precision is integer
	  m = Math.pow(10, precision);
	  value *= m;
	  sgn = (value > 0) | -(value < 0); // sign of the number
	  isHalf = value % 1 === 0.5 * sgn;
	  f = Math.floor(value);

	  if (isHalf) {
	    switch (mode) {
	      case 'PHP_ROUND_HALF_DOWN':
	        value = f + (sgn < 0); // rounds .5 toward zero
	        break;
	      case 'PHP_ROUND_HALF_EVEN':
	        value = f + (f % 2 * sgn); // rouds .5 towards the next even integer
	        break;
	      case 'PHP_ROUND_HALF_ODD':
	        value = f + !(f % 2); // rounds .5 towards the next odd integer
	        break;
	      default:
	        value = f + (sgn > 0); // rounds .5 away from zero
	    }
	  }

	  return (isHalf ? value : Math.round(value)) / m;
	}

 function js_number_format(number, decimals, dec_point, thousands_sep) {

	  number = (number + '')
	    .replace(/[^0-9+\-Ee.]/g, '');
	  var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function(n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + (Math.round(n * k) / k)
	        .toFixed(prec);
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
	    .split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
	    .length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1)
	      .join('0');
	  }
	  return s.join(dec);
	}
	
	
 function number_format(value)
	{
		var places=2;
		var ts="<?php echo Settings::get_instance()->read('thousand_separator'); ?>";
		var ds="<?php echo Settings::get_instance()->read('decimal_separator'); ?>";
		var ds_places="<?php echo Settings::get_instance()->read('decimal_place'); ?>";

		value=js_round(value,ds_places);
		
		return js_number_format(value,ds_places,ds,ts);
	}
	
	
	function money_format(money)
	{
		var currency_symbol="<?php echo Settings::get_instance()->read('currency_symbol');?>";
		var currency_position="<?php echo Settings::get_instance()->read('currency_position');?>";

		if(money!=0 && money!='')
		money=number_format(money);

		if(currency_position==1)
			money=currency_symbol+" "+money;
		else
			money=money+" "+currency_symbol;
		
		return money;
	}

	

		
		$(document).ready(function(){

	
	$("#continuefirst").click(function(){

	if($('#billaddressid').val() >0)
	{

		if($('#ship_address_checkbox').prop('checked'))
		{

			if($('#shipaddressid').val() >0)
			{
				$('#currentdiv').val(3);
				$('.billingDiv').hide();
				$('.shippingDiv').hide();
				$('.paymentDiv').hide();
				ManageOrderItems();	
				$('.orderDiv').show();

				$('.labelclass').removeClass('selectedCheckOut');
				$('#label3').addClass('selectedCheckOut');
			}
			else
			{
				alert("<?php echo $this->get_message('give me the shipping details');?>");
				$('#currentdiv').val(2);
				$('.billingDiv').hide();		
				$('.paymentDiv').hide();	
				$('.orderDiv').hide();	
				$('.shippingDiv').show();

				$('.labelclass').removeClass('selectedCheckOut');
				$('#label2').addClass('selectedCheckOut');
			}
		}
		else
		{
			$('#currentdiv').val(2);
			$('.billingDiv').hide();
			$('.paymentDiv').hide();	
			$('.orderDiv').hide();	
			$('.shippingDiv').show();

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label2').addClass('selectedCheckOut');
		}
	}
	else
	{
		alert("<?php echo $this->get_message('give me the billing details');?>");
		$('#currentdiv').val(1);
		$('.paymentDiv').hide();	
		$('.orderDiv').hide();	
		$('.shippingDiv').hide();
		$('.billingDiv').show();		

		$('.labelclass').removeClass('selectedCheckOut');
		$('#label1').addClass('selectedCheckOut');
		
	}
		

	});
	


	$("#continuesecond").click(function(){
	
		if($('#shipaddressid').val() >0)
		{
			$('#currentdiv').val(3);
			$('.billingDiv').hide();
			$('.shippingDiv').hide();
			$('.paymentDiv').hide();		
			ManageOrderItems();	
			$('.orderDiv').show();

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label3').addClass('selectedCheckOut');
		}
		else
		{
			alert("<?php echo $this->get_message('give me the shipping details');?>");
			$('#currentdiv').val(2);
			$('.billingDiv').hide();
			$('.orderDiv').hide();
			$('.paymentDiv').hide();
			$('.shippingDiv').show();		

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label2').addClass('selectedCheckOut');	
		}
	

	});


	$(".continuethree").click(function(){
		
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


	$("#continuefour").click(function(){

		if($('#billaddressid').val() >0 && $('#shipaddressid').val() >0 && $("#order-row-success").val() ==1)
		{
			$("#billaddressid1").val($('#billaddressid').val());
			$("#shipaddressid1").val($('#shipaddressid').val());
			
			document.payment_process.submit();
		}
		else if(!($('#billaddressid').val() >0))
		{
			alert("<?php echo $this->get_message('give me the billing details');?>");
			$('#currentdiv').val(1);
			$('.paymentDiv').hide();	
			$('.orderDiv').hide();	
			$('.shippingDiv').hide();
			$('.billingDiv').show();		

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label1').addClass('selectedCheckOut');
			

		}
		else if(!($('#shipaddressid').val() >0))
		{
			alert("<?php echo $this->get_message('give me the shipping details');?>");
			$('#currentdiv').val(2);
			$('.billingDiv').hide();
			$('.orderDiv').hide();
			$('.paymentDiv').hide();
			$('.shippingDiv').show();	

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label2').addClass('selectedCheckOut');

			


		}
		else if($("#order-row-success").val() ==0)
		{
			alert("<?php echo $this->get_message('please confirm the order details');?>");
			$('#currentdiv').val(3);
			$('.billingDiv').hide();
			$('.shippingDiv').hide();
			$('.paymentDiv').hide();
			$('.orderDiv').show();

			ManageOrderItems();

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label3').addClass('selectedCheckOut');

		}

		
	
	});
	
			
		});

function GoBack(type)
{
	if(type ==1)
	{
		$('#currentdiv').val(1);
		$('.shippingDiv').hide();
		$('.orderDiv').hide();
		$('.paymentDiv').hide();
		$('.billingDiv').show();

		$('.labelclass').removeClass('selectedCheckOut');
		$('#label1').addClass('selectedCheckOut');
		
	}
	else if(type ==2)
	{
			$('#currentdiv').val(2);
			$('.orderDiv').hide();
			$('.paymentDiv').hide();
			$('.billingDiv').hide();
			$('.shippingDiv').show();

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label2').addClass('selectedCheckOut');
	}
	else if(type ==3)
	{
		if($('#billaddressid').val() >0 && $('#shipaddressid').val() >0)
		{

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label3').addClass('selectedCheckOut');

			
			$('#currentdiv').val(3);
			$('.shippingDiv').hide();
			$('.paymentDiv').hide();
			$('.billingDiv').hide();
			ManageOrderItems();
			$('.orderDiv').show();
		}
		else if(!($('#billaddressid').val() >0))
		{
			alert("<?php echo $this->get_message('give me the billing details');?>");
			$('#currentdiv').val(1);
			$('.paymentDiv').hide();	
			$('.orderDiv').hide();	
			$('.shippingDiv').hide();
			$('.billingDiv').show();	

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label1').addClass('selectedCheckOut');	
			

		}
		else if(!($('#shipaddressid').val() >0))
		{
			alert("<?php echo $this->get_message('give me the shipping details');?>");
			$('#currentdiv').val(2);
			$('.billingDiv').hide();
			$('.orderDiv').hide();
			$('.paymentDiv').hide();
			$('.shippingDiv').show();	

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label2').addClass('selectedCheckOut');
		}
	}
	else if(type ==4)
	{

		if($("#order-row-success").val() ==1)
		{
			$('#currentdiv').val(4);
			$('.shippingDiv').hide();
			$('.billingDiv').hide();
			$('.orderDiv').hide();
			$('.paymentDiv').show();

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label4').addClass('selectedCheckOut');
		}
		else
		{
			alert("<?php echo $this->get_message('please confirm the order details');?>");
			$('#currentdiv').val(3);
			$('.billingDiv').hide();
			$('.shippingDiv').hide();
			$('.paymentDiv').hide();
			$('.orderDiv').show();

			ManageOrderItems();

			$('.labelclass').removeClass('selectedCheckOut');
			$('#label3').addClass('selectedCheckOut');
		}
		
	}
}

function AddAddressOption(type)
{

	
	document.getElementById("addAddressPopUpId").style.display="";
	document.getElementById("addAddressBehindId").style.display="";



	var ie=document.all && !window.opera;
	var iebody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body ;

	ht=(ie)? iebody.clientHeight: window.innerHeight ;
	wt=(ie)? iebody.clientWidth : window.innerWidth ;

	ofht=document.getElementById("addAddressPopUpId").offsetHeight;
	ofwt=document.getElementById("addAddressPopUpId").offsetWidth;

	ofht=parseFloat(ofht)-76;
		

	document.getElementById("addAddressPopUpId").style.top=(ht/2)-parseFloat(ofht/2) +'px';
	document.getElementById("addAddressPopUpId").style.left=(wt/2)-parseFloat(ofwt/2) +'px';
}

function AddAddressClose()
{
		document.getElementById("addAddressPopUpId").style.display="none";
		document.getElementById("addAddressBehindId").style.display="none";
}


function ChangeBillingAddress(id)
{
	$('#billaddressid').val(id);

	LoadBillColor();
	
	if($('#ship_address_checkbox').prop('checked'))
	{
		$('#shipaddressid').val(id);
		LoadShipColor();
	}



	$("#continuefirst").click();

	
}

function ChangeShippingAddress(id)
{
	$('#shipaddressid').val(id);
	LoadShipColor();


	$("#continuesecond").click();
}

function LoadBillColor()
{
	id=$('#billaddressid').val();
	$('.checkout_address_inner_bill').css('background-color','#FFFFFF');
	$('.checkout_address_inner_bill').removeClass('addressSelected');
	$('#bill'+id).addClass('addressSelected');
}
function LoadShipColor()
{
	id=$('#shipaddressid').val();
	$('.checkout_address_inner_ship').css('background-color','#FFFFFF');
	$('.checkout_address_inner_ship').removeClass('addressSelected');
	$('#ship'+id).addClass('addressSelected');
}




		</script>
		
<style type="text/css">
.selectboxit-option, .selectboxit-optgroup-header{width: 200px !important;}
.selectboxit-container .selectboxit{width: 200px !important;}
</style>

 <div  style="margin: auto;width: 990px;">
        
        
    <h1 style="font-size: 20px;margin-top: 20px;" class="titleh1"><?php echo $this->get_label('checkout process');?></h1>
    <input type="hidden" name="page_type" value="<?php echo $this->get_variable('page_type');?>">
    
    <?php if($user_address_cnt >0){ ?>
    <section class="checkOut">
    <div id="label1" class="labelclass selectedCheckOut" onclick="GoBack(1);"><?php echo $this->get_label('billing address');?></div>
    <div id="label2" class="labelclass"  onclick="GoBack(2);"><?php echo $this->get_label('shipping address');?></div>
    <div id="label3" class="labelclass"  onclick="GoBack(3);"><?php echo $this->get_label('order details');?></div>
    <div id="label4" class="labelclass"  onclick="GoBack(4);"><?php echo $this->get_label('payment');?></div>
    </section>
    <?php }?>
    
    
    <div class="billingDiv">
    
    <input type="hidden" name="currentdiv" id="currentdiv" value="1" />
    
    
    
    
    
    
    <div class="actionsone" <?php if($user_address_cnt ==0){ ?> style="float: left;" <?php }?>>
    
    
    <?php if($user_address_cnt >0){ ?>
    <a href="javascript:void(0);" id="continuefirst" class="normalBtn"  ><?php echo $this->get_label('save and continue');?></a>
    <?php }?>
    
	<a href="javascript:void(0);" class="normalBtn" onclick="AddAddressOption(1);"><?php echo $this->get_label('add new address');?></a>
	</div>
    
    
    
    
    
    <div style="height: 60px;"></div>
    
    <?php if($user_address_cnt >0){ ?>
    <input type="checkbox" name="ship_address_checkbox" id="ship_address_checkbox" value="shipaddress" checked="checked">&nbsp;<?php echo $this->get_label('use billing address');?>
    <?php }?>
    
    
    
    
    
    					<?php
			if($user_address_cnt >0)
			{ 
				$i=1;
			?>
				<div class="checkout_address_outer_bill">
		<?php 
				foreach($user_address as $key=>$row)
				{
				?>
				
				<?php if($i==1){?>
				<input type="hidden" name="billaddressid" id="billaddressid" value="<?php echo $row['id'];?>" />
				<?php }?>
				
				
				<div class="checkout_address_inner_bill" id="bill<?php echo $row['id'];?>">
				
					<div style="height: 145px;">
					<?php 
					$str='';
		$str.='<label class="namelabel">'.$row['name'].'</label><br/>';
		$str.=$row['address1'].'<br/>';
		
		if($row['address2'] !="")
		$str.=$row['address2'].'<br/>';
		
		
		
		$str.=$row['city'].'<br/>';
		$str.=$row['state'].'<br/>';
		$str.=$this->get_country_name($row['country']).'-'.$row['zipcode'].'<br/>';
		
				
		if($row['phoneno'] !="" && $row['phoneno'] !="0")
		$str.=$this->get_label("phone").' : '.$row['phoneno'].'<br/>';
		
		
		echo $str;
		?>
		
		</div>
		<div style="margin: auto;">
		<a href="javascript:void(0);" class="useThisAddress" onclick="ChangeBillingAddress(<?php echo $row['id'];?>);"><?php echo $this->get_label('use this');?></a>
		</div>
				</div>	
			<?php $i++;} ?>
					
				</div>
				<?php } ?>
    
    
    </div>
    
    
     <div class="shippingDiv">
   
    
    
    <div class="actionstwo">
    
    <?php if($user_address_cnt >0){ ?>
    <a href="javascript:void(0);" id="continuesecond" class="normalBtn"  ><?php echo $this->get_label('save and continue');?></a>
    <?php }?>
    
	<a href="javascript:void(0);" class="normalBtn" onclick="AddAddressOption(2);"><?php echo $this->get_label('add new address');?></a>
	</div>
    <div style="height: 77px;"></div>
    
    					<?php
			if($user_address_cnt >0)
			{ 
				$i=1;
			?>
				<div class="checkout_address_outer_ship">
		<?php 
				foreach($user_address as $key=>$row)
				{
				?>
				
				<?php if($i==1){?>
				<input type="hidden" name="shipaddressid" id="shipaddressid" value="<?php echo $row['id'];?>" />
				<?php }?>
				
				<div class="checkout_address_inner_ship" id="ship<?php echo $row['id'];?>">
				
					<div style="height: 145px;">
					<?php 
					$str='';
		$str.='<label class="namelabel">'.$row['name'].'</label><br/>';
		$str.=$row['address1'].'<br/>';
		
		if($row['address2'] !="")
		$str.=$row['address2'].'<br/>';
		
		
		
		$str.=$row['city'].'<br/>';
		$str.=$row['state'].'<br/>';
		$str.=$this->get_country_name($row['country']).'-'.$row['zipcode'].'<br/>';
		
				
		if($row['phoneno'] !="" && $row['phoneno'] !="0")
		$str.=$this->get_label("phone").' : '.$row['phoneno'].'<br/>';
		
		
		echo $str;
		?>
		
		</div>
		<div style="margin: auto;">
		<a href="javascript:void(0);" class="useThisAddress" onclick="ChangeShippingAddress(<?php echo $row['id'];?>);"><?php echo $this->get_label('use this');?></a>
		</div>
		
		
				</div>	
			<?php $i++;} ?>
					
				</div>
				<?php } ?>
    
    
    </div>
    
    
    
    	       <div class="addAddressPopUp" id="addAddressPopUpId" style="display: none;">
                            
                            
            <div style="width: 100%;position: relative;height: 35px;background: #3E454C;padding: 10px 0px;margin-bottom: 20px;">
	      
	       <div class="checkoutAddressHead"><?php echo $this->get_label('add new address');?></div>
	       
	       </div>
	       
	       
                           
						
			<?php 
               $form=$this->create_form();
               $form->start("add_billing_address","","post",$validate);
               
               $countrycode=Settings::get_instance()->read('country');
            ?>
               
			<table style="width:100%; border: 0px solid #ccc;">
			
			
			<tr>
			<td style="width: 2%"></td>
			<td style="width:10%;"> <?php echo $this->get_label('name');?><span class="mandatory">*</span></td>
		  	<td style="width: 20%"><input type="text" class="textStyle textStylePadding" value="" id="billing_name" style="width: 190px;"/></td>
			<td style="width: 2%"></td> 
			<td style="width:10%;"> <?php echo $this->get_label('phone no');?><span class="mandatory">*</span></td>
			<td style="width: 20%"><input type="text" class="textStyle textStylePadding" value="" id="billing_phoneno" style="width: 190px;"/></td>
			<td style="width: 2%"></td> 
			</tr>
			
			<tr><td height="10px" colspan="7"></td></tr>
			
			
			<tr>
			
			<td></td>
			
			<td > <?php echo $this->get_label('address1');?><span class="mandatory">*</span></td>
			
			<td ><input type="text" class="textStyle textStylePadding" id="billing_address1" style="width: 190px;"/></td>
			
			<td ></td>
			
			<td > <?php echo $this->get_label('address2');?></td>
			
			<td ><input type="text" class="textStyle textStylePadding" id="billing_address2" style="width: 190px;"/></td>
			
			<td ></td>
			
			</tr>
			
			
			
			<tr><td height="10px" colspan="7"></td></tr>
			
			
			<tr>
			<td ></td>
			
			<td> <?php echo $this->get_label('country');?><span class="mandatory">*</span></td>
			
			<td>
				<select id="billing_country" style="width: 200px;">
                    <option value="" selected="selected"><?php echo $this->get_label('select');?></option>
                       <?php 
                       $countries=$this->get_result('countries');
   					   foreach($countries as $key=>$row)
    				   {?>
                       <option value="<?php echo $row['ccode']; ?>" <?php if($countrycode==$row['ccode']){?>selected="selected"<?php }?>><?php echo $row['cname']; ?></option>
                       <?php } ?> 
                </select>
            </td>
			
			<td ></td>
			
			<td> <?php echo $this->get_label('state');?><span class="mandatory">*</span></td>
			
			<td ><input type="text" class="textStyle textStylePadding" value="" id="billing_state" style="width: 190px;"/></td>
			
			<td ></td>
			
			
			</tr>
			
			<tr><td height="10px" colspan="7"></td></tr>
			
			
			<tr>
			<td ></td>
			<td><?php echo $this->get_label('city');?><span class="mandatory">*</span></td>
			<td ><input type="text" class="textStyle textStylePadding" value="" id="billing_city" style="width: 190px;"/>
			</td>
			
			<td></td>
			
			<td> <?php echo $this->get_label('zip code');?><span class="mandatory">*</span></td>
			
			<td><input type="text" class="textStyle textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="" id="billing_zipcode" style="width: 190px;"/>
			  
         	<td></td>
            
			
			
			</tr>
			
			<tr><td height="40px" colspan="7"></td></tr>
			
			
			<tr>
			<td colspan="7" style="text-align: center;">
			<a href="javascript:void(0);" class="normalBtn" onclick="NewAddress();"><?php echo $this->get_label('save and continue');?></a>
            <a href="javascript:void(0);" class="normalBtn" style="margin-left: 5px;" onclick="AddAddressClose();" ><?php echo $this->get_label('cancel');?></a>
            </td>
			</tr>
			
			
			<tr><td height="10px" colspan="7"></td></tr>
		
			
			</table>
                                
                               <?php 
                               $form->end();
                               ?>
    </div>
    <div  class="addAddressBehind" id="addAddressBehindId" style="display: none;"></div>
    
    
    
    
      <?php 
                          $form=$this->create_form();
                          $form->start("payment_process",'',"post");
                     ?>
    
    
    
    <div class="orderDiv">
    
    
    <div class="actionsthree">
    
    
    <?php if($user_address_cnt >0){ ?>
    <a href="javascript:void(0);" class="normalBtn continuethree"  ><?php echo $this->get_label('save and continue');?></a>
    <?php }?>
    
	</div>
    <div style="height: 60px;"></div>
    
    <div class="order_loading"><img src="images/loading.gif"/></div>
    
    <div id="manageorderitems"></div>
    
    </div>
    
    
     <div class="paymentDiv">
    
    <div style="height: 60px;"></div>
    

   
						    <div >
                       				 
           					<div class="paymentRadio"><input type="radio" checked="checked" value="paypal" id="payment_type" name="payment_type" /></div>
							<div class="checkOutPayment" ></div>
					        </div>  
                               <div style="margin-top: 35px;margin-bottom: 20px;">
                               
                                <a href="javascript:void(0);" id="continuefour" class="normalBtn right" style="margin-right:10px;"><?php echo $this->get_label('proceed to payment');?></a>
								
                                </div>

				    
				    <input type="hidden" name="page_type" value="<?php echo $this->get_variable('page_type');?>">
					<input type="hidden" name="order-row-success" id="order-row-success"  value="0">
					
					<input type="hidden" name="billaddressid1" id="billaddressid1" value="" />
					<input type="hidden" name="shipaddressid1" id="shipaddressid1" value="" />
					
					
				    
				
    
    
    </div>
    
    
      <?php $form->end(); ?>     
    

</div>
<script type="text/javascript">

$(document).ready(function(){
LoadBillColor();
LoadShipColor();
});
</script>
<?php 
$this->dispatch("layout/footer");

}
else if($this->get_variable('payment_go')==1){
?> 
	
<div style="background-image: url('images/loader.gif');height: 20px;width: 102px;"></div> 
 
  
    <!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="order_payment" id="order_payment">-->
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="order_payment" id="order_payment">
    <input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="item_name" value="<?php echo Settings::get_instance()->read('engine_name')." - ".$this->get_label('payments');?>">
	<input type="hidden" name="item_number" value="<?php echo $this->get_variable('order_id');?>">
	<input type="hidden" name="amount" id="amount" value="<?php echo $this->get_variable('grandcost');?>">
	<input type="hidden" name="currency_code" value="<?php echo Settings::get_instance()->read('paypal_currency');?>">
	<input type="hidden" name="notify_url" value="<?php echo $this->make_url('payment/paypal_ipn')?>">
	<input type="hidden" name="cancel_return" value="<?php echo $this->make_url('payment/cancel')?>">
	<input type="hidden" name="business" value="<?php echo Settings::get_instance()->read('paypal_email');?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="no_note" value="0">
	<input type="hidden" name="custom" value="<?php echo $this->get_variable('user_id');?>">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="return" value="<?php echo $this->make_url('payment/paypal_success')?>">
	</form>
        
    <script type="text/javascript">document.order_payment.submit();</script>
<?php } ?>