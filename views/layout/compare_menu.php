<div class="clear"></div>
<?php 
  $codatacount=$this->get_variable("codatacount");
  $comparemenu=$this->get_variable("comparemenu");
 ?>
<div style="width: 100%;position:relative ;z-index:2102;" id="cmpdiv_main">
<div class="compareOtr container" style="<?php if($codatacount < 1){?>display: none; <?php }else{?> margin:auto !important;top:0 !important;<?php } ?>" >

<div class="compairData" id="cmpDta">
<div id="comparelist"><?php echo $comparemenu;?></div>
</div>

</div>

</div>

 <script type="text/javascript">
function compareClose(){
	$(".compareOtr").hide(300);
}
</script>