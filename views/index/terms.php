<?php 
$from=$this->get_variable("from");
if($from ==1)
{
$this->dispatch("layout/header");
?>
<div class="container" style="margin-top:30px;margin-bottom: 30px;min-height: 200px;">
<h1 class="titleh1"><?php echo $this->get_label('terms conditions');?></h1>
<?php }?>
<div style="text-align: justify;margin-top: 20px;"><?php $terms=$this->get_variable("terms"); echo $terms;?></div>
<?php if($from ==1){?>
</div>
<?php $this->dispatch("layout/footer");?>
<?php }?>