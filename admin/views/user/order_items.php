<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><link rel="stylesheet" href="css/style.css" type="text/css" /></head>
 <?php 
 $uid=$this->get_variable("uid");
 ?>
<body style="background: none;">
 <div  class="inner_iframe">
 <table class="data_table" cellpadding="0" cellspacing="0">
 <tr>
 <td class="dt_head_td"><?php echo $this->get_label('order id'); ?></td>
 <td class="dt_head_td"><?php echo $this->get_label('amount'); ?></td>
 <td class="dt_head_td"><?php echo $this->get_label('status'); ?></td>
 <td class="dt_head_td"><?php echo $this->get_label('order date'); ?></td>
 </tr>
 
 <?php
 $res2=$this->get_result('res2');
 
 if(count($res2)==0)
 {
 ?>
 <tr><td colspan="5" class="dt_data_td"><?php echo $this->get_label('no records found');?></td></tr>
 <?php
 }
 else
 {
 foreach ($res2 as $key=> $row)
 {
 
 $id=$row['id'];
 ?>
 <tr>
 <td class="dt_data_td"><a target="_parent" href="<?php echo $this->make_url("sales/details/$row[id]");?>">#<?php echo $row['id'];?></a></td>
 <td class="dt_data_td"><?php echo $this->get_money_format($row['grand_cost']);?></td>
 <td class="dt_data_td"><?php echo $this->get_order_status($row['id']);?></td>
 <td class="dt_data_td"><?php echo $this->get_date_format(2,$row['order_date'])?></td>
 </tr>
 
 
 
 <?php
 }
 ?>
 <tr>
 <td class="dt_data_td"  colspan="3"></td>
 <td class="dt_data_td"><?php echo $this->get_variable('pagination1');?></td>
 </tr>
 <?php
 }
 ?>
 
 </table>
 </div>
</body>
</html>