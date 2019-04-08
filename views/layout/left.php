<?php 
    $type=$this->get_variable("type");
    $sort_id=$this->get_variable("sort_id");
    $from_price=$this->get_variable("from_price");
    $to_price=$this->get_variable("to_price");
    $outofstock_chkd=$this->get_variable('outofstock_chkd');
    $catid=$this->get_variable('catid');
    $brandid=$this->get_variable('brandid');
    $catname=$this->get_variable('catname');
    $brandname=$this->get_variable('brandname');
    $search=$this->get_variable('search');
?>
    <div class="clear"></div>
    <div class="filterLeft contentLeft">
    
    	<div class="leftFilterOuter">
        	<div class="filterInner">
            <div class="filterTitle"><?php 
			if($catid >0)
			echo $this->escape($this->get_category_name($catid));
			else
			echo $this->get_label('categories');?>
			</div>
            <?php 
			$res=$this->get_result('res');
			foreach($res as $key=>$row)
			{?>
        	<a href="<?php echo $this->make_url("product/list/").$type."/".$row['id']."/".$brandid."/".$sort_id."/".$from_price."/".$to_price."/".$outofstock_chkd."/".$this->seo($row['name'])."/".$brandname."/".$search;?>" <?php if($row['id']==$catid){?>class="cat_selected"<?php }else{?> class="filterContent"<?php } ?> ><?php echo $row['name']; ?></a>
            <?php 
			}
			?>
            </div>
        </div>
             
        <?php 
        if($this->get_variable('brands')==1) 
        {?>
        <div class="leftFilterOuter">
        <div class="filterInner">
            <div class="filterTitle"><?php echo $this->get_label('brands');?></div>
            <?php 
$res=$this->get_result('resbrands');
foreach($res as $key=>$row)
{?>
<a href="<?php echo $this->make_url("product/list/").$type."/".$catid."/".$row['id']."/".$sort_id."/".$from_price."/".$to_price."/".$outofstock_chkd."/".$catname."/".$this->seo($row['name'])."/".$search; ?>" class="filterContent"><?php echo $row['name']; ?></a>
<?php }?>
            </div>
         </div>  
          <?php 
}
?>   
 </div>             