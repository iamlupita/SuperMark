<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";

class LayoutController extends AppController
{
function header_action()
	{
		$login=LoginHelper::validate_user_login();
		$db=DBLayer::get_instance();
		
		
		$this->set_variable("login",$login);
		
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		

		$headparam=$this->read_page_param(1);
		
		$search='';
		$cartpage=0;
		$detailpage=0;
		$productid=0;
		if($headparam != 'checkout123' && $headparam != 'details')
		$search=$headparam;
		else if($headparam == 'checkout123')
		$cartpage=1;
		else if($headparam == 'details')
		{
			$detailpage=1;
			$productid=intval($this->read_page_param(2));
		}
		
		
		
		
		
		
		
		
		$this->set_variable("cartpage",$cartpage);
		$this->set_variable("search",$search);
		
		
		if($detailpage ==0 || $productid ==0)
		{
			$res2=$db->execute_query("select * from ".TABLE_PREFIX."meta");
			$row2=$res2->fetch_assoc();
			
			
	 		$keyword=str_replace('{ENGINENAME}', Settings::get_instance()->read('engine_name'), $row2['keyword']);
	 		$description=str_replace('{ENGINENAME}', Settings::get_instance()->read('engine_name'), $row2['description']);
		}
		else if($detailpage ==1 && $productid >0)
		{
			$res2=$db->execute_query("select meta_keywords,meta_description from ".TABLE_PREFIX."product WHERE id=?",array($productid));
			$row2=$res2->fetch_assoc();
			
			$keyword=$row2['meta_keywords'];
			$description=$row2['meta_description'];
			
			
			
			$imglist=$db->execute_query("select id,pro_id,pro_image_file from ".TABLE_PREFIX."product_images where pro_id=? and status=1 order by preview DESC",array($productid));
			$this->set_result("productimage",$imglist);
			
			
			
			
		}
 		
		$this->set_variable("productid",$productid);
		$this->set_variable("detailpage",$detailpage);
 		
 		
		$this->set_variable("keyword",$keyword);
		$this->set_variable("description",$description);
		
		
		
		
		
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."users where id=? and status=1",array($userid));
		$row=$res->fetch_assoc();
		
		$this->set_variable("username",$row['name']);
		
 		$public_page_logo=Settings::get_instance()->read('public_page_logo');
		$this->set_variable("public_page_logo",$public_page_logo);
		
		$tabstructure=$this->get_categories_table(0);
		$this->set_variable("tabstructure",$tabstructure,0);
		
		$page_data = explode("/",$this->read_get_param('page'));
		
		$home_tab="";
		$featured_tab="";
		$recent_tab="";
		$special_tab="";
		$about_tab="";
		$contact_tab="";
		
		$wishlist_tab="";
		$myaccount_tab="";
		$reg_tab="";
		$signin_tab="";
		
		if(count($page_data)<2 || ($page_data[0]=="index" && $page_data[1]=="index"))
			$home_tab="current-tab";
		else if($page_data[0]=="product" && $page_data[1]=="list" && $page_data[2]=="featured")
			$featured_tab="current-tab";
		else if($page_data[0]=="product" && $page_data[1]=="list" && $page_data[2]=="recent")
			$recent_tab="current-tab";
		else if($page_data[0]=="product" && $page_data[1]=="list" && $page_data[2]=="special-offers")
			$special_tab="current-tab";
		else if($page_data[0]=="index" && $page_data[1]=="about")
			$about_tab="current-tab";
		else if($page_data[0]=="user" && $page_data[1]=="contact_us")
			$contact_tab="current-tab";
		else if($page_data[0]=="user" && $page_data[1]=="wishlist")
			$wishlist_tab="top_menu_selected";
		else if($page_data[0]=="user" && $page_data[1]=="home")
			$myaccount_tab="top_menu_selected";
		else if($page_data[0]=="user" && $page_data[1]=="register")
			$reg_tab="top_menu_selected";
		else if($page_data[0]=="user" && $page_data[1]=="login")
			$signin_tab="top_menu_selected";
		
		
		
		$this->set_variable("home_tab", $home_tab);
		$this->set_variable("featured_tab", $featured_tab);
		$this->set_variable("recent_tab", $recent_tab);
		$this->set_variable("special_tab", $special_tab);
		$this->set_variable("about_tab", $about_tab);
		$this->set_variable("contact_tab", $contact_tab);
		
		$this->set_variable("wishlist_tab", $wishlist_tab);
		$this->set_variable("myaccount_tab", $myaccount_tab);
		$this->set_variable("reg_tab", $reg_tab);
		$this->set_variable("signin_tab", $signin_tab);
		
		
	}
	
	function left_action()
	{
		$login=LoginHelper::validate_user_login();
		$db=DBLayer::get_instance();
		
		$type=trim($this->read_page_param(1));//category,featured,recent,special-offers
		$catid=intval($this->read_page_param(2));
		$brandid=intval($this->read_page_param(3));
		$sort_id=intval($this->read_page_param(4));
		$from_price=$this->read_page_param(5);
		$to_price=$this->read_page_param(6);
		$outofstock_chkd=intval($this->read_page_param(7));
		$catname=trim($this->read_page_param(8));
		$brandname=trim($this->read_page_param(9));
		$search=trim($this->read_page_param(10));
		
		
		if($type =="")
		$type='category';
		
		if($sort_id ==0)
		$sort_id=1;
		
		if($catname =="")
		$catname=0;
		
		if($brandname =="")
		$brandname=0;
		
		if($search =="")
		$search=0;
		
		$brands=$this->get_brand_ids($catid);
		$this->set_variable("brands",0);
		
		if($catid >=0 && $brands !="")
		{	
			$res3=$db->execute_query("select id,name from ".TABLE_PREFIX."brands where status=1 and id IN (".$brands.")");
			$this->set_result("resbrands",$res3,array('name'));
			$this->set_variable("brands",1);
		}
		
		if($catid >0)
		{
			$childcat=$this->get_first_category_list($catid);
			
			if($childcat !='')
			$cat_str=" and id IN(".$childcat.") ";
			else 
			$cat_str=" and id IN(".$catid.") ";
				
		}
		else
		$cat_str=" and pid=0 ";
		
		
		$res=$db->execute_query("select id,name from ".TABLE_PREFIX."categories where status=1 ".$cat_str." order by name asc");
		$this->set_result("res",$res,array('name'));
		
		$this->set_variable("type",$type);
		$this->set_variable("sort_id",$sort_id);
		$this->set_variable("from_price",$from_price);
		$this->set_variable("to_price",$to_price);
		$this->set_variable("outofstock_chkd",$outofstock_chkd);
		$this->set_variable("catid",$catid);
		$this->set_variable("brandid",$brandid);
		$this->set_variable("catname",$catname);
		$this->set_variable("brandname",$brandname);
		$this->set_variable("search",$search);
		
	}
	
	function login_left_action()
	{
		$page_data = explode("/",$this->read_get_param('page'));
		
		$order_tab="";
		$wishlist_tab="";
		$payments_tab="";
		$profile_tab="";
		$chpassword_tab="";
		$mnaddress_tab="";
		
		if(($page_data[0]=="order" && ($page_data[1]=="details" || $page_data[1]=="reorder")) || ($page_data[0]=="user" && $page_data[1]=="home"))
			$order_tab="cat_selected";
		else if($page_data[0]=="user" && $page_data[1]=="wishlist")
			$wishlist_tab="cat_selected";
		else if(($page_data[0]=="user" && $page_data[1]=="payments") || ($page_data[0]=="payment" && $page_data[1]=="details"))
			$payments_tab="cat_selected";
		else if($page_data[0]=="user" && $page_data[1]=="edit_profile")
			$profile_tab="cat_selected";
		else if($page_data[0]=="user" && $page_data[1]=="change_password")
			$chpassword_tab="cat_selected";
		else if($page_data[0]=="user" && ($page_data[1]=="manage_address" || $page_data[1]=="manage-address"))
			$mnaddress_tab="cat_selected";
		
		

		$this->set_variable("order_tab", $order_tab);
		$this->set_variable("wishlist_tab", $wishlist_tab);
		$this->set_variable("payments_tab", $payments_tab);
		$this->set_variable("profile_tab", $profile_tab);
		$this->set_variable("chpassword_tab", $chpassword_tab);
		$this->set_variable("mnaddress_tab", $mnaddress_tab);
		
	}
	
	function footer_action()
	{

		$login=LoginHelper::validate_user_login();
		$this->set_variable("login",$login);
		
		$db=DBLayer::get_instance();
		$sql="select id,name from ".TABLE_PREFIX."categories where status=? and footer_display=? order by name asc";
		$res=$db->execute_query($sql,array(1,1));
		$this->set_result("res",$res);
		
	}
	
	
	function compare_menu_action()
	{
		$cmppage=$this->read_page_param(1);
		$codatacount=0;
		if(isset($_COOKIE[COOKIE_COMPARE]))
		{
			$codata=$_COOKIE[COOKIE_COMPARE];
			$codata_array=explode('_',$codata);
			$codatacount=count($codata_array);
		}
		
		
		$comparemenu="";
		if($codatacount=="")
			$codatacount=0;
		
			$comparemenu=$this->get_compare_menu($cmppage);
			
		
		$this->set_variable("comparemenu",$comparemenu,0);
		
		$this->set_variable("codatacount",$codatacount);
		
	}
	
	function get_compare_menu($cmppage)
	{
		$db= DBLayer::get_instance();
		$string="";
		$string0="";
		if(isset($_COOKIE[COOKIE_COMPARE]))
			$codata=$_COOKIE[COOKIE_COMPARE];
		else
			$codata="";
	
		$cn=0;$codata_array=array();
		
		if($codata=="")
			$cn=0;
		else {
			$codata_array=explode(',',$codata);
			
			foreach($codata_array as $ke=>$va)
			{
					$cn=$cn+1;
			}
		}
		$codatacount=$cn;
	
		$cwt=$codatacount*255;
	
		$string0='<div class="compareOuterMain">';
	
	
		foreach($codata_array as $key=>$value)
		{
				if($value >0)
				{
					$row=$db->execute_query("SELECT id,cat_id,name,description,page_title FROM ".TABLE_PREFIX."product WHERE id=?",array($value));
					$row_data=$row->fetch_assoc();
	
					$title=$row_data['name'];
					$summary=$row_data['description'];
					$path=$this->get_product_image($row_data['id']);
					$idico=$row_data['id'];
					$cat_id=$row_data['cat_id'];
					
					$mrp=$this->get_money_format($this->get_product_pricing($idico));
					
					
					list($widthimage,$heightimage) = @getimagesize($path);
					$dimension=$this->get_image_dimension($widthimage,$heightimage,10);
					$dimensionarray=explode('_',$dimension);
					
					
	
					$string.='<div class="compareOuter compareOriginal" id="dv_'.$value.'">';
					$string.='<div class="compareImage" onclick="location.href=\''.$this->make_url("product/details/".$idico."/".$row_data['page_title']).'\';"><div><img src="'.$path.'" style="width: '.$dimensionarray[0].'px;height: '.$dimensionarray[1].'px;" /></div></div>';
					$string.='<div class="compareTitle" onclick="location.href=\''.$this->make_url("product/details/".$idico."/".$row_data['page_title']).'\';">'.$title.'</div>';
					$string.='<div class="compareMrp" onclick="location.href=\''.$this->make_url("product/details/".$idico."/".$row_data['page_title']).'\';">'.$mrp.'</div>';
	
					$string.='<div class="compareOptions">';
					
					$string.='<div class="compareRemove"><a href="javascript:void(0)" onclick="remove_compare('.$idico.',\''.$cmppage.'\');"><img alt="'.$this->get_label('remove').'"  src="images/delete.png" title="'.$this->get_label('remove').'"/></a></div>';
					
					$string.='</div>';
					$string.='</div>';
				}
		}
	
		
		for($k=0;$k<(4-$codatacount) && $codatacount<=4;$k++)
		{
			$string.='<div class="compareOuter compareDummy">';
			$string.='<div class="compareImage"><img src="images/compare.png" style="width: 60px;height: 60px;"/></div>';
			$string.='<div class="compareTitle" style="color:#808080;">'.$this->get_label('add another').'</div>';
			$string.='<div ></div>';
			
			$string.='<div class="compareOptions">';
				
			$string.='</div>';
			$string.='</div>';
		}
	
		
			$string.='<input type="hidden" id="watchids" name="watchids" value="'.$codata.'"/>';
			$string.='<div class="cmpbut" style="float:right;padding-top:35px;" >';
				
			if($cn >1)
			$string.='<input type="submit"  value="'.$this->get_label('compare').'" id="compareButtons" onclick="getCompareOperation()" class="compare_btn" />';
			else
			$string.='<input style="display:none;" type="submit"  value="'.$this->get_label('compare').'" id="compareButtons" onclick="getCompareOperation()" class="compare_btn" />';
		
			$string.='</div>';
		
		
		if($string !="")
		$string='<div id="cpdv123">'.$string.'</div>';
	
		$string.='<div class="compareclose_btn" id="compareclose" onclick="compareClose();"><img title="Close" src="images/delete.png" alt="Close"></div></div>';
	
		return $string0.$string;
	}
	
	
	
	function search_action()
	{
	
	$str="";
	$db=DBLayer::get_instance();
	
	
	$type=$this->read_page_param(1);//category,featured,recent,special-offers
	$catid=$this->read_page_param(2);
	$brandid=$this->read_page_param(3);
	$sort_id=$this->read_page_param(4);
	$from_price=$this->read_page_param(5);
	$to_price=$this->read_page_param(6);
	$outofstock_chkd=$this->read_page_param(7);
	$catname=$this->read_page_param(8);
	$brandname=$this->read_page_param(9);
	$search=$this->read_page_param(10);
	
	if($type=="") $type='category';
	
	if($catid=="") $catid=0;
	
	if($brandid=="") $brandid=0;
	
	if($sort_id=="") $sort_id=1;
	
	if($outofstock_chkd=="") $outofstock_chkd=0;
	
	if($catname=="") $catname=0;
	
	if($brandname=="") $brandname=0;
	
	if($search=="")	$search=0;
	
	$brandfilter="";
	if($brandid>0)
	{
		$brandfilter="and brand_id=$brandid";
	}
	
	$search_str="";
	if(isset($search) && $search!="" && $search!="0")
		$search_str="and name like '%".$search."%'";
	
	$type_str="";
	
	$time=time();
	
	
	$categoryname123="0";
	$catstr="";
	
	if($catid!="" && $catid>0){
		$categoryname123=$this->get_category_name($catid);
		$childcat=$this->get_child_category_list($catid,0);
		if($childcat=="")
		{
			$childcat=$catid;
		}
		$catstr="and cat_id IN ($childcat) $brandfilter";
	}
	
	
	if($type=="featured")
		$type_str="status=1 and featured=1";
	else if($type=='recent' || $type=="" || $type=="category")
		$type_str="status=1";
	else if($type=='special-offers' || $type=='special offers')
		$type_str="status=1 and special_offer_from<=$time and special_offer_to>=$time";
	
	
	$outofstock_str="";
	if(isset($outofstock_chkd) && $outofstock_chkd==1)
		$outofstock_str="and prod_stock>0";
	
	$min=$db->read_single_column("select min(mrp) from ".TABLE_PREFIX."product where $type_str $outofstock_str $search_str $catstr");
	$max=$db->read_single_column("select max(mrp) from ".TABLE_PREFIX."product where $type_str $outofstock_str $search_str $catstr");
	
	if(!isset($from_price) || $from_price=="")
		$from_price=$min;
	
	if(!isset($to_price) || $to_price=="")
		$to_price=$max;
	
	$price_range_str="";
	if($from_price!="" && $to_price!="")
		$price_range_str="and mrp>=$from_price and mrp<=$to_price";
	
	$sort_str="";
	if($sort_id==1)
		$sort_str="order by popularity desc,id desc";
	else if($sort_id==2)
		$sort_str="order by id desc";
	else if($sort_id==3)
		$sort_str="order by id asc";
	else if($sort_id==4)
		$sort_str="order by sale_price asc";
	else if($sort_id==5)
		$sort_str="order by sale_price desc";
	
	
	
	
	$sql="select * from ".TABLE_PREFIX."product where $type_str $price_range_str $outofstock_str $search_str $catstr $sort_str";
	$res2=$db->execute_query($sql);
	$num=$db->read_single_column("select count(id) from ".TABLE_PREFIX."product where $type_str $price_range_str $outofstock_str $search_str $catstr $sort_str");   
      if($num!="0")
        {
                    
	    while($row=$res2->fetch_assoc())
		{
		$name=$row['name'];
		
		
		
		list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['id']));
		$dimension=$this->get_image_dimension($widthimage,$heightimage,11);
		$dimensionarray=explode('_',$dimension);
		
		
		
	             	        	
		$str.='<a href="'. $this->make_url("product/details/".$row['id']."/".$row['page_title']).'" class="searchSuggResultTag"><div class="searchSuggResultImagediv">';
		
		$str.='<div><img style="height: '.$dimensionarray[1].'px;width: '.$dimensionarray[0].'px;" src="'.$this->get_product_image($row['id']).'" /></div></div><div class="searchSuggResultProduct"> '.$name.' </div></a>';  
		
		
	 }
	 }
	 else
		 {
			$str.='<div  class="seacrhNoResult">'.$this->get_label('no match found').'</div>';
		 }
	
         echo $str;
         exit;
    
	}
	
	function socialmedia_action()
	{
		$this->disable_notice_area();
	}
	
	function facebooklogin_action()
	{
		$this->disable_notice_area();
	}
	
	function googlelogin_action()
	{
		$this->disable_notice_area();
	}
	
	
	function get_categories_table($id)
	{
		$db= DBLayer::get_instance();
	
		$res=$db->execute_query("select id,name from ".TABLE_PREFIX."categories where pid=? order by name",array($id));
	
		$table_string="";
	
		$mpid='';
		$divcnt=0;
		$rowindex=0;
		$additionalrow=0;
		$remindercnt=0;
	
		$dcnt=0;
		while($row_new=$res->fetch_assoc())
		{
			$res1_new=$db->execute_query("select id,name from ".TABLE_PREFIX."categories where pid=? order by name",array($row_new['id']));
			$dcnt=$dcnt+1;
		}
	
		$res->set_result_index();
	
		$catcount=$dcnt;
	
		$rownumber=intval($catcount / 4);
		$reminder=$catcount % 4;
		$reminder_temp=$reminder;
	
		if($reminder==0)
			$rowno=$rownumber-1;
		else
			$rowno=$rownumber;
	
		$cols=1;
		while($row=$res->fetch_assoc())
		{
			$name=$row['name'];
			$name=str_replace(" ", "-", $name);
			$name=urlencode($name);
	
			$res1=$db->execute_query("select id,name from ".TABLE_PREFIX."categories where pid=? order by name",array($row['id']));
	
			$subcatcount=$res1->get_num_records();
	
	
			if($divcnt ==0)
			{
				$table_string.='<div class="category_item_col" id="col'.$cols.'">';
				$cols=$cols+1;
			}
	
	
			$table_string.='<div class="category_items">';
	
	
			$table_string.='<div class="item_head">';
	
	
			$table_string.='<p><a href="'.$this->make_url("product/list/category/".$row['id']).'">'.$row['name'].'</a></p></div>';
			
			$ci=0;
			//$displimit=Settings::get_instance()->read('display_child_category_limit');
			$displimit=5;
			$disptype=1;
			$dispheight=($displimit*30).'px';
	
	
			$childcount=$res1->get_num_records();
			while($row1=$res1->fetch_assoc())
			{
				$nam=$row1['name'];
				$nam=str_replace(" ", "-", $nam);
				$nam=urlencode($nam);
	
				if($ci ==0 && $childcount >$displimit && $displimit >0 && $disptype ==1)
				{
					if($mpid =='')
						$mpid.=$row['id'];
					else
						$mpid.='_'.$row['id'];
				}
	
				if($ci ==0)
				{
					$table_string.='<div class="item_list" ';
	
					if($childcount >$displimit && $displimit >0 && $disptype ==2)
						$table_string.=' style="overflow-y:auto;max-height: '.$dispheight.'; " ';
	
					$table_string.='>';	
						
				}
				else if($ci ==$displimit && $disptype ==1 && $displimit >0)
					$table_string.='<span id="morespan_'.$row['id'].'" style="" onclick="LoadMore('.$row['id'].');">'.$this->get_label('more').'</span></div><div id="morediv_'.$row['id'].'" style="display: none;" class="item_list">';
	
				$table_string.='<p><span class="itemlist_square_span"></span><a href="'.$this->make_url("product/list/category/".$row1['id']).'">'.$row1['name'].'</a></p>';
				
				$ci=$ci+1;
				if($childcount >$displimit && $childcount ==$ci && $disptype ==1 && $displimit >0)
					$table_string.='<span id="hidespan_'.$row['id'].'" style="" onclick="HideMore('.$row['id'].');">'.$this->get_label('hide').'</span>';
	
			}
	
			if($childcount >0)
				$table_string.='</div>';
	
			$table_string.='</div>';
	
			if($rowindex ==$rowno && $additionalrow==0)
			{
				$rowindex=0;
				$table_string.='</div><!--<span class="rightline_span">&nbsp;</span>-->';
				$divcnt=0;
	
				$remindercnt=$remindercnt+1;
	
				if($reminder_temp ==$remindercnt)
					$additionalrow=1;
	
			}
			else if($additionalrow ==1 && $rowindex ==$rowno-1)
			{
				$rowindex=0;
				if($cols<5)
				$table_string.='</div><!--<span class="rightline_span">&nbsp;</span>-->';
				else
				$table_string.='</div>';
				$divcnt=0;
			}
			else
			{
				$rowindex=$rowindex+1;
				$divcnt=$divcnt+1;
			}
	
		}
	
		$table_string.='<input type="hidden" name="mpid" id="mpid" value="'.$mpid.'" />';
	
		return $table_string;
	}
};
?>