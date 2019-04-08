<?php 
$this->dispatch("layout/header");
?>
<script>
 function deleteaddress(id)
 {
	
	$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("user/delete_address/");?>"+id,
		success: function(msg)
			{
			
			$("#shipp_"+id).hide();
			if(msg=="1")
			set_jnotice(1,"<?php echo $this->get_message("deleteaddress");?>");
			}
		});			
}
	 </script>       
   	<div class="container mtop-20">
    	

<?php $this->dispatch("layout/login_left");?>

			    <div class="address-box">
			    
				<div class="manage_address_left_div" ><h1><?php echo $this->get_label('manage shipping address');?></h1></div>
                <div class="manage_address_right_div" ><a class="cartAddition" title="<?php echo $this->get_label('add new address');?>" href="<?php echo $this->make_url("user/add_address");?>" ><?php echo $this->get_label('add new address');?></a></div>
				
        <?php if($this->get_variable("tot")>0){ 
		
		$shipaddress=$this->get_result('shipaddress');
		foreach($shipaddress as $key=>$row)
		{
    ?>
                    <div id="shipp_<?php echo $row['id']; ?>" class="address-box-inner-div">
                    
                   
                   <div class="address-box-left-main">
                 
                    	 <div class="address-box-left-div"><?php echo $this->get_label('name');?></div> 
                         <div class="address-box-right-div"><?php echo $row['name']; ?></div>
                       
                        <div class="address-box-left-div"><?php echo $this->get_label('address1');?></div> 
                        <div class="address-box-right-div"><?php echo $row['address1']; ?></div>
                        
                        
                        <div class="address-box-left-div"><?php echo $this->get_label('address2');?></div>
                        <div class="address-box-right-div"><?php echo $row['address2']; ?></div>
                       
                        <div class="address-box-left-div"><?php echo $this->get_label('phone no');?></div>
                        <div class="address-box-right-div"><?php echo $row['phoneno']; ?></div>
                       
                       
                       
                      
                          <div style="width:100%;float:left;height:30px;margin-top:10px;"><a class="cartAddition" href="<?php echo $this->make_url("user/edit_address");?>/<?php echo $row['id']; ?>" > <?php echo $this->get_label('edit');?></a> 
                          <a class="cartAddition" href="javascript:onClick=deleteaddress('<?php echo $row['id']; ?>')" style="margin-left:10px;"><?php echo $this->get_label('delete');?></a>  
                       </div>
						
                        
                        
                       
                       </div>
                       
                         <div class="address-box-right-main">
                  
                   		<div class="address-box-rightdiv"><?php echo $this->get_label('country');?></div>
                       <div class="address-box-rightdiv"><?php echo $this->get_country_name($row['country']); ?></div>
                       
                       
                       
                        <div class="address-box-rightdiv"><?php echo $this->get_label('state');?></div>
                        <div class="address-box-rightdiv"><?php echo $row['state']; ?></div>
                       
                       
                        <div class="address-box-rightdiv"><?php echo $this->get_label('city');?></div>
                        <div class="address-box-rightdiv"><?php echo $row['city']; ?></div>
                       
                       
                        <div class="address-box-rightdiv"><?php echo $this->get_label('zip code');?></div>
                        <div class="address-box-rightdiv"><?php echo $row['zipcode']; ?></div>
                       
                          
                        </div>	
                    
</div>
<?php 
    }
    echo "<div class='public_pagination_div'>".$this->get_variable('pagination')."</div>";
    }
   else{ ?>  
      <div class="width-left"><?php echo $this->get_label('you have no shipping address added');?> </div>
       <?php 
    }
    ?>	
	</div>
				
</div>			
           
<?php $this->dispatch("layout/footer");?>