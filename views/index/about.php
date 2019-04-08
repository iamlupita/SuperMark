<?php $this->dispatch("layout/header");?>

<div class="container mtop-20 mbot-30" style="min-height: 200px;">

	<h1 class="titleh1"><?php echo $this->get_label('about us');?></h1>
		<div style="text-align: justify;margin-top: 20px;">	
			<?php echo $this->get_variable("description");?>
		</div>
				
</div>

<?php $this->dispatch("layout/footer");?>