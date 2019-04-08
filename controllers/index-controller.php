<?php
include_once COMMON_DIR_PATH.DS.'helpers'.DS."utility-helper.php";

class IndexController extends AppController
{

	function index_action()
	{
		$this->set_title($this->get_label('home'));
		if(Settings::get_instance()->read('engine_name')=='')
		{
			header("location: ".$this->make_base_url("index","installation"));
			die;
		}
		

		
		$db=DBLayer::get_instance();
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("userid",$userid);
		
		$res=$db->execute_query("select id,image,type,type_id,banner_type  from ".TABLE_PREFIX."banners where status=1 AND banner_type=1 order by id desc");
		$this->set_result("banners",$res);
		
		
		$res4=$db->execute_query("select id,image,type,type_id,banner_type  from ".TABLE_PREFIX."banners where status=1 AND banner_type=2 order by id desc");
		$this->set_result("smallbanners",$res4);
		
		
		
		
		
		$res2=$db->execute_query("select id,name,mrp,cat_id,prod_stock,sale_price,page_title from ".TABLE_PREFIX."product where status=1 and featured=1 order by popularity desc,id desc");
		$this->set_result("feproduct",$res2);
		
		$res3=$db->execute_query("select id,name,mrp,prod_stock,cat_id,sale_price,page_title from ".TABLE_PREFIX."product where status=1 order by popularity desc,id desc limit 0,20");
		$this->set_result("recentproduct",$res3);
		
		
		$count=$db->read_single_column("select count(id) from ".TABLE_PREFIX."categories where status=1 and featured=1");
		$this->set_variable("categories",$count);
		
		$res1=$db->execute_query("select id,name from ".TABLE_PREFIX."categories where featured=1 and status=1 order by id desc");
		$this->set_result("categ",$res1);
		
		
		$feat_category=array();
		
		$res1=$db->execute_query("select id,name from ".TABLE_PREFIX."categories where featured=1 and status=1 order by id desc");
		$i=0;
		while($row1=$res1->fetch_assoc())
		{
			$res2=$db->execute_query("select id,name,mrp,cat_id,prod_stock,sale_price,page_title from ".TABLE_PREFIX."product where status=1 and cat_id=? order by popularity desc,id desc",array($row1['id']));
			while($row2=$res2->fetch_assoc())
			{
				$feat_category[$i]['cat_id']=$row2['cat_id'];
				$feat_category[$i]['cat_name']=$row1['name'];
				$feat_category[$i]['id']=$row2['id'];
				$feat_category[$i]['name']=$row2['name'];
				$feat_category[$i]['mrp']=$row2['mrp'];
				$feat_category[$i]['prod_stock']=$row2['prod_stock'];
				$feat_category[$i]['sale_price']=$row2['sale_price'];
				$feat_category[$i]['page_title']=$row2['page_title'];
				
				
				
				$i++;
			}
				
		}
		
		$this->set_array("feat_categ",$feat_category);
		
	} 
	
	
	function get_horizontal_banner($type)
	{
		$db= DBLayer::get_instance();
		
		$string='';
		$res=$db->execute_query("select id,image,type,type_id,banner_type  from ".TABLE_PREFIX."banners where status=1 AND banner_type=3 AND banner_position=? order by id desc",array($type));
		
		if($res->get_num_records() >0)
		{
			$string.='<div class="container">';
			$string.='<div class="horizontal-banner-outer">';
			
			$ii=1;
			
			if($type ==-1)
			{
				$typevariable='-featured'.$type;
				$typevariable1='featured-active'.$type;
			}
			else if($type ==-2)
			{
				$typevariable='-recent'.$type;
				$typevariable1='recent-active'.$type;
			}
			else 
			{
				$typevariable='-category'.$type;
				$typevariable1='category-active'.$type;
			}
			
			
			while($row=$res->fetch_assoc())
			{
				if($row['type'] ==1)
				$click_url=$this->make_url("product/details/".$row['type_id'].'/'.$this->get_seo_title($row['type_id']));
				else
				$click_url=$this->make_url("product/list/category/".$row['type_id']);
				
				
				$string.='<div class="horizontal-inner horizontal'.$typevariable.' ';
				if($ii ==1)
				$string.=$typevariable1.' "';
				else
				$string.='" style="display:none" ';
				
				$string.=' ><a href="'.$click_url.'"><img src="'.DATA_DIR.'/banners/'.$row['image'].'" /></a>';
				
				
				$string.='</div>';
				
				$ii=$ii+1;
			}
			
			
			
			
			$string.='</div>';
			
			
			
					$string.='<script type="text/javascript">';
					if($type ==-1)
					{
					  		$string.='$(document).ready(function(){setInterval("ShowFeaturedBanner()", 5000);});';
							$string.='function ShowFeaturedBanner()	{';
					}
					else if($type ==-2)
					{
					  		$string.='$(document).ready(function(){setInterval("ShowRecentBanner()", 5000);});';
							$string.='function ShowRecentBanner()	{';
					}
					else 
					{
						$string.='$(document).ready(function(){setInterval("ShowCategoryBanner'.$type.'()", 5000);});';
						$string.='function ShowCategoryBanner'.$type.'()	{';
					}
			
			
				    $string.="if($('.horizontal".$typevariable."').length ==1){";
					$string.='$(".'.$typevariable1.'").fadeOut(2000);$(".'.$typevariable1.'").fadeIn(2000);';
				    $string.='}	else {';
					$string.="var length=$('.horizontal".$typevariable."').length;";
					$string.="var currentindex=$('.".$typevariable1."').index();";
					$string.="var newindex=parseInt(currentindex)+1;";
					$string.="if(newindex ==length)";
					$string.="newindex=0;";
			
					$string.="$('.horizontal".$typevariable."').removeClass('".$typevariable1."');";
					$string.="$('.horizontal".$typevariable.":eq('+newindex+')').addClass('".$typevariable1."');";
			
					$string.="$('.horizontal".$typevariable."').fadeOut(4000);";
					$string.="$('.".$typevariable1."').fadeIn(4000);";
					$string.="}";
					$string.="}";
			
					$string.='</script>';
			
			
			
			$string.='</div>';
		}
		return $string;
		
		
		
		
	}

	function about_action()
 	{
 		$this->set_title($this->get_label('about us'));
 		$db= DBLayer::get_instance();
 		$description=$db->read_single_column("select description from ".TABLE_PREFIX."aboutus where id=1");
 		$description=str_replace('{ENGINENAME}', Settings::get_instance()->read('engine_name'), $description);
 		$this->set_variable("description",nl2br($description),0);
 	}
 	
 	function privacy_action()
 	{
 		$this->set_title($this->get_label('privacy policy'));
 		$db= DBLayer::get_instance();
 		$description=$db->read_single_column("select description from ".TABLE_PREFIX."privacy where id=1");
 		$description=str_replace('{ENGINENAME}', Settings::get_instance()->read('engine_name'), $description);
 		$this->set_variable("description",nl2br($description),0);
 	}

	function terms_action()
 	{
 		$this->set_title($this->get_label('terms conditions'));
 		$db= DBLayer::get_instance();
 		$from=$this->read_page_param(1);
 		if($from=="")
 		$from=0;
 		$terms=$db->read_single_column("select description from ".TABLE_PREFIX."terms");
 		$terms=str_replace('{ENGINENAME}', Settings::get_instance()->read('engine_name'), $terms);
 		$this->set_variable("terms",nl2br($terms),0);
 		$this->set_variable("from",$from);
 		
 	
 	}
 	
};
?>