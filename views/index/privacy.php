<?php $this->dispatch("layout/header");?>

<div class="container" style="margin-top:30px;margin-bottom: 30px;min-height: 200px;">

	<h1><?php echo $this->get_label('privacy policy');?></h1>
		<div style="text-align: justify;margin-top: 20px;">	
			<?php echo $this->get_variable("description");?>
		</div>
				
</div>

<?php $this->dispatch("layout/footer");?>