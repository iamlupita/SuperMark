<?php 
$res=$this->get_result('res');
$count=count($res);
?>
<div class="behind_div" >
<div class="popup">
<div class="sub_menu"><?php echo $this->get_label('select a product for banner');?><a class="closeButton" style="position: relative;right: -85px;" onclick="ClosePopUp()">X</a></div>
		
<ul style="padding-left: 25px;list-style: square outside none;">
		<?php foreach($res as $key=>$row){?>
		<li id="li_<?php echo $row['id'];?>" style="cursor: pointer;line-height: 30px;" onclick="SelectProduct(<?php echo $row['id'];?>)"><?php echo $row['name'];?></li>
		<?php }	?>
		<?php if($count ==0){?><li id="li_0" style="height: 30px;"><?php echo $this->get_label('no products in category');?></li><?php }?>
</ul>
</div>
</div>