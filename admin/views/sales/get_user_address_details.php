<a class="closeButton" onclick="$('#user_address_div').hide();">X</a>
    
<div class="sub_menu"><?php echo $this->get_label('address details');?></div>

<table style="width: 100%;padding-left: 20px;">
 <?php 
    $res=$this->get_result('res');
    if(count($res)==0)
    {?>
    
    <tr><td colspan="2" style="height:25px !important;"></td></tr>
    	
    	
    	<?php echo $this->get_label('no record');
    }
    else{
    foreach($res as $key=>$row)
    {
?>
   <tr>
    <td  width="30%" style="font-weight: bold;"><?php echo $this->get_label('name');?></td>
	<td>
	<?php if($row['name']!=""){echo $row['name'];}?>
	</td>
  </tr>
   
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td  width="30%" style="font-weight: bold;"><?php echo $this->get_label('address1');?></td>
	<td><?php if($row['address1']!=""){echo $row['address1'];}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
  
  <?php if($row['address2']!=""){?>
   <tr>
    <td  width="30%" style="font-weight: bold;"><?php echo $this->get_label('address2');?></td>
	<td><?php echo $row['address2'];?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
  <?php } ?>
  
   <tr>
    <td  width="30%" style="font-weight: bold;"><?php echo $this->get_label('phone no');?></td>
	<td><?php if($row['phoneno']!=""){ echo $row['phoneno'];}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td style="font-weight: bold;"><?php echo $this->get_label('country');?></td>
	<td><?php if($row['country']!=""){echo $this->get_country_name($row['country']);}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td style="font-weight: bold;"><?php echo $this->get_label('state');?></td>
	<td><?php if($row['state']!=""){echo $row['state'];}?></td>
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td style="font-weight: bold;"><?php echo $this->get_label('city');?></td>
	<td><?php if($row['city']!=""){echo $row['city'];}?></td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td style="font-weight: bold;"><?php echo $this->get_label('zipcode');?></td>
	<td><?php echo $row['zipcode'];?>
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:25px !important;"></td></tr>
  
  
  
<?php }}?> 

<tr><td>&nbsp;</td>
  
  <td>
   <input type="button" onclick="$('#user_address_div').hide();" value="<?php echo $this->get_label('close');?>" class="btn btn-default">
  </td>
  
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
     
     
  </table>
 
  