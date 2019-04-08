<?php 
$this->dispatch("layout/header");


$pendingship=intval($this->get_variable("pendingship"));
$pendingcomplete=intval($this->get_variable("pendingcomplete"));
$returns=intval($this->get_variable("returns"));
$outofstock=intval($this->get_variable("outofstock"));
$pendingreview=intval($this->get_variable("pendingreview"));
?>


<table style="width: 100%;" cellpadding="0" cellspacing="0" >


<tr ><td colspan="3" class="heading_td"><strong><?php echo $this->get_label('todo');?></strong></td></tr>


<tr ><td colspan="3" height="10px"></td></tr>







<tr><td colspan="3" height="5px;"></td></tr>

<tr><td colspan="3"  height="30px"><img class="header_img" src="images/point-right.png" /><a href="<?php echo $this->make_url("sales/items_to_ship")?>"><?php echo $this->get_label('pending products to ship');?></a> (<?php echo $pendingship;?>)</td></tr>
<tr><td colspan="3"  height="30px"><img class="header_img" src="images/point-right.png" /><a href="<?php echo $this->make_url("sales/items_to_deliver")?>"><?php echo $this->get_label('pending products to deliver');?></a> (<?php echo $pendingcomplete;?>)</td></tr>
<tr><td colspan="3"  height="30px"><img class="header_img" src="images/point-right.png" /><a href="<?php echo $this->make_url("sales/returns/1")?>"><?php echo $this->get_label('pending refund verification');?></a> (<?php echo $returns;?>)</td></tr>
<tr><td colspan="3"  height="30px"><img class="header_img" src="images/point-right.png" /><a href="<?php echo $this->make_url("product/manage/-2/-2/0/2")?>"><?php echo $this->get_label('out of stock');?></a> (<?php echo $outofstock;?>)</td></tr>
<tr><td colspan="3"  height="30px"><img class="header_img" src="images/point-right.png" /><a href="<?php echo $this->make_url("product/pending_review")?>"><?php echo $this->get_label('pending reviews');?></a> (<?php echo $pendingreview;?>)</td></tr>


</table>





<?php $this->dispatch("layout/footer");?>