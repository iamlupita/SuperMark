<?php 
$this->dispatch("layout/header");
$cookie_cat_id=$this->get_variable('cookie_cat_id');
?>

<script type="text/javascript">
function remove_compare_cmplist(pid)
{
	remove_compare(pid,'co');
	window.location.reload();
}
</script>

<div class="container mtop-20 mbot-30">

	<h1><?php echo $this->get_label('compare products');?></h1>
	

            <div class="max-width">
            	
			   
				<div class="clear"></div>
				
		<br>
		
		<?php 
		
			$compare_data=$this->get_array('compare_data');
			$list_arr=$this->get_array('list_arr');
			if(count($compare_data)=="0"){
        ?>
		<?php 
			echo $this->get_label('no record');
			}
			else{
		?>
		
		<table class="max-width-with-border">
		<tr><td colspan="10">&nbsp;</td></tr>
		<?php 
		$i=0;
		foreach($compare_data as $key=>$row)
		{
			if($i==0)
			{
				echo '<tr><td></td><td colspan="9" class="compare-items-head">'.$this->get_label('basic').'</td></tr><tr><td colspan="10" style="height:10px"></td></tr>';
				
				$newvalue=$list_arr[$i][1];
				
			}
			else
			{
				$oldvalue=$newvalue;$newvalue=$this->get_label('action');
				if(isset($list_arr[$i][1]))
				$newvalue=$list_arr[$i][1];
				if($oldvalue!=$newvalue)
					echo '<tr><td colspan="10" style="height:10px"></td></tr><tr><td></td><td colspan="9" class="compare-items-head">'.$newvalue.'</td></tr><tr><td colspan="10" style="height:10px"></td></tr>';
			}
			$i++;
			
			
		?>
		<tr>
		<td style="width: 1%;">&nbsp;</td>
			
		<?php for($k=0;$k<count($row);$k++){
			
			?>
			
		<td class="compare-col-items <?php if($i==count($compare_data)){ ?>bg-br-none <?php } ?>">
		<?php if(isset($row[$k])) {
			
			if($i==1 && $k >0){
				$specialcmpcount=count($compare_data)-1;
				
				echo '<div class="compare_head_title"><a href="'.$this->make_url('product/details/'.$compare_data[$specialcmpcount][$k].'/'.$this->escape($this->get_seo_title($compare_data[$specialcmpcount][$k]))).'" class="compare-std-link">'.$row[$k].'</a></div>';
			}
			else if($i==2 && $k >0){
				
				list($widthimage,$heightimage) = @getimagesize($row[$k]);
				$dimension=$this->get_image_dimension($widthimage,$heightimage,6);
				$dimensionarray=explode('_',$dimension);
				
				echo '<div class="compare-image-div"><div><img src="'.$row[$k].'" border="0" width="'.$dimensionarray[0].'px" height="'.$dimensionarray[1].'px" /></div><div>';
				}
			else if($i==6 && $k >0){
				if($row[$k]==1)
					echo '<img src="images/available.png" border="0" width="20px" height="20px">';
				else
					echo '<img src="images/notavailable.png" border="0" width="20px" height="20px">';
				}
				else if($i==4 && $k >0){
					if($row[$k] >0)
						echo '<span class="available">'.$this->get_label('in stock').'</span>';
					else
						echo '<span class="unavailable">'.$this->get_label('out of stock').'</span>';
					}
					else if($i==count($compare_data) && $k >0 )
					{

						
						if($this->get_stock($row[$k]) >0)
						echo '<a class="cartButtonCmp" href="javascript:cartAddition('.$row[$k].')">'.$this->get_label("add to cart").'</a>';
						
						
						echo '<a class="cartButtonCmp" href="javascript:remove_compare_cmplist('.$row[$k].');">'.$this->get_label("remove").'</a>';
					}
			else
			echo $row[$k];
		}else {echo "-";}?></td>
		
		<td style="width: 1%;">&nbsp;</td>
		
		<?php } ?>
		
		</tr>
		<?php }
		?>
		
		<tr><td colspan="10">&nbsp;</td></tr>
		
		</table>
		
		<?php } ?>
          
            
        </div>
        
        
    </div>

	
<?php $this->dispatch("layout/footer");?>