<?php 
$this->dispatch("layout/header");

$activeadv=$this->get_variable("activeadv");
$activepub=$this->get_variable("activepub");
$totalads=$this->get_variable("totalads");
$activeads=$this->get_variable("activeads");
$activetextads=$this->get_variable("activetextads");
$activebannerads=$this->get_variable("activebannerads");

$cron_running_time=$this->get_variable("cron_running_time");
$cron_flag=$this->get_variable("cron_flag");

$timeperiod=$this->get_variable("timeperiod");
$orders_processed=$this->get_variable("orders_processed");

$processed_orders_amount=$this->get_variable("processed_orders_amount");
if($processed_orders_amount=="")
	$processed_orders_amount=0;
if($processed_orders_amount>0)
	$processed_orders_amount=$this->get_money_format($processed_orders_amount);

$approved_returns=$this->get_variable("approved_returns");

$returned_orders_amount=$this->get_variable("returned_orders_amount");
if($returned_orders_amount=="")
	$returned_orders_amount=0;
if($returned_orders_amount>0)
	$returned_orders_amount=$this->get_money_format($returned_orders_amount);

?>
<table style="width: 100%; height: 400px;" >

<tr><td colspan="3" class="heading_td"><b><?php echo $this->get_label('admin control panel');?></b></td></tr>
<tr><td colspan="3" height="10px"></td></tr>


<tr><td colspan="3">

<div class="ad_report">
<table  style="line-height: 38px;width:100%;">
<tr ><td colspan="2" class="ad_report_td_head"><?php echo $this->get_label('your system details');?></td></tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('Active Clients');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span"><?php echo $this->get_variable("activeclients");?></span></td>
</tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('Active Products');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span"><?php echo $this->get_variable("activeproducts");?></span></td>
</tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('Active Categories');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span"><?php echo $this->get_variable("activecategories");?></span></td>
</tr>
<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('Active Brands');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span"><?php echo  $this->get_variable("totalbrands");?></span></td>
</tr>
<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;border: none;"><?php echo $this->get_label('Active Banners');?></td>
<td class="ad_report_td_content" width="60%" style="border: none;"><span class="count_span"><?php echo $this->get_variable("activebanners");?></span></td>
</tr>

</table>


</div>


</td>
</tr>

<tr><td colspan="3" style="height: 20px;"></td></tr>




<tr><td colspan="3">

<div class="ad_report">
<table  style="line-height: 38px;width:100%;">
<tr>
<td class="ad_report_td_head" width="40%"><?php echo $this->get_label('order summary');?></td>
<td class="ad_report_td_head" width="60%">

 <select name="timeperiod" id="timeperiod" onchange="timeperiod_change()">
 <option value="0" <?php if($timeperiod==0){ echo "selected";}?>><?php echo $this->get_label('today'); ?></option>
 <option value="1"  <?php if($timeperiod==1){ echo "selected";}?>><?php echo $this->get_label('last 7 days'); ?></option>
 <option value="2"  <?php if($timeperiod==2){ echo "selected";}?>><?php echo $this->get_label('last 14 days'); ?></option>
 <option value="3"  <?php if($timeperiod==3){ echo "selected";}?>><?php echo $this->get_label('last 30 days'); ?></option>
 <option value="4"  <?php if($timeperiod==4){ echo "selected";}?>><?php echo $this->get_label('all'); ?></option>
 </select>
 
</td></tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('no. of orders processed');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span" id="orders_processed"><?php echo $orders_processed;?></span></td>
</tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('payment from processed orders');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span" id="processed_orders_amount"><?php echo $processed_orders_amount;?></span></td>
</tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('no. of approved returns');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span" id="approved_returns"><?php echo $approved_returns;?></span></td>
</tr>
<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;"><?php echo $this->get_label('total amount of approved returns');?></td>
<td class="ad_report_td_content" width="60%"><span class="count_span" id="returned_orders_amount"><?php echo  $returned_orders_amount;?></span></td>
</tr>


</table>


</div>


</td>
</tr>

<tr><td colspan="3" style="height: 20px;"></td></tr>




<tr>
<td colspan="3">

<div class="ad_report" style="height: auto;">
<table  style="line-height: 38px;width:100%;">

<tr><td colspan="2" class="ad_report_td_head"><?php echo $this->get_label('most popular products');?></td></tr>

<?php 
$res=$this->get_result('res');$cnt=count($res);$i=1;$brd="";
if($cnt>0){
?>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;font-weight: bold;"><?php echo $this->get_label('name');?></td>
<td class="ad_report_td_content" width="60%" style="font-weight: bold;"><?php echo $this->get_label('sale price');?></td>
</tr>

<?php 

foreach($res as $key=>$row)
{
	$adid=$row['id'];
	$name=$row['name'];
	
	if($i==$cnt)
		$brd="border:none;";
	?>
<tr>

<td class="ad_report_td_content" width="40%" style="padding-left: 20px;<?php echo $brd;?>"><a href="<?php echo $this->make_url("product/details/".$row['id']);?>" target="_parent"><?php echo $name;?></a></td>
<td class="ad_report_td_content" width="60%" style="<?php echo $brd;?>"><?php echo $this->get_money_format($row['sale_price']);?></td>
</tr>
<?php $i++;}

}?>	

<?php 
if($cnt==0)
{
?>
<tr class="ad_report_td_content"><td colspan="2" style="padding-left: 10px;"><?php echo $this->get_label('no record');?></td></tr>
<?php 
}
?>

</table>

</div>

</td>
</tr>

<tr><td colspan="3" style="height: 30px;"></td></tr>



<tr>
<td colspan="3">

<div class="ad_report" style="height: auto;margin-bottom: 20px;">
<table  style="line-height: 23px;width:100%;">

<tr><td colspan="2" class="ad_report_td_head"><?php echo $this->get_label('cron running details');?></td></tr>

<tr>
<td class="ad_report_td_content" width="40%" style="padding-left: 20px;font-weight: bold;"><?php echo $this->get_label('cron running time');?></td>
<td class="ad_report_td_content" width="60%" style="padding-top: 10px;">
<?php if($cron_running_time!="")echo "<span style='font-weight:bold;'>".$cron_running_time."</span>";?>
<div style="margin: 5px 10px 15px 0px;">
<?php 
if($cron_flag==1)
{
echo $this->get_label('cron not running');
?>
<a target="_blank" href="<?php echo $this->make_url("cronjob/execute");?>" style="text-decoration: none;"><br><strong style="font-size: 12;font-weight: bold;"><?php echo $this->get_label('manual cron running');?></strong></a>
<?php 
}

echo $this->get_label('cron command');
?>

<label style="font-weight: bold;font-style: italic;">
<?php echo "wget ".$this->make_url("cronjob/execute");?>
</label>

</div>

</td>
</tr>

</table>

</div>

</td>

</tr>
</table>

<script type="text/javascript">

function timeperiod_change()
{
	var timeperiod=$("#timeperiod").val();
	$.ajax({
				type: "GET",
				url: "<?php echo $this->make_url("system/order_summary/");?>"+timeperiod,
				success: function(msg)
					{
						if(msg!="")
						{
							var n=msg.split("@#");

							$("#orders_processed").html(n[0]);
							$("#processed_orders_amount").html(n[1]);
							$("#approved_returns").html(n[2]);
							$("#returned_orders_amount").html(n[3]);
						}
					}
			});
}

</script>
<?php $this->dispatch("layout/footer");?>