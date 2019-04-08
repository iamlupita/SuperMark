<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";

class ProductController extends AppController
{
	function before_execute()
	{
		if($this->get_action()=="review" || $this->get_action()=="add_wishlist")
		{
			if(LoginHelper::validate_user_login()==0)
			$this->flash($this->get_message('login to continue'), $this->make_url('user/login'),0);
		}
	}
	
	function details_action()
	{
		
		
		
		$login=LoginHelper::validate_user_login();
		$this->set_variable("login",$login);
		
		$db= DBLayer::get_instance();
		$default_ad_image=Settings::get_instance()->read('default_ad_image');
		$this->set_variable("default_ad_image",$default_ad_image);
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("userid",$userid);
		$proid=$this->read_page_param(1);
		
		$prod_block_status=$db->read_single_column("select count(id) from ".TABLE_PREFIX."product where id=$proid and status=1");
		if($prod_block_status==0)
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('index/index'));
			exit;
		}
		
		$prod_stock=$db->read_single_column("select prod_stock from ".TABLE_PREFIX."product where id=$proid");
		$this->set_variable("prod_stock",$prod_stock);
		$proname=$this->read_page_param(2);
		$proname=($proname);
		
		if(Settings::get_instance()->read('engine_name')=='')
		{
			header("location: ".$this->make_base_url("index","installation"));
			die;
		}
		
		$db= DBLayer::get_instance();
		$res=$db->execute_query("select * from ".TABLE_PREFIX."product where id=? and status=1",array($proid));
		$row=$res->fetch_assoc();
		
		$this->set_variable("proid",$row['id']);
		$this->set_variable("proname",$row['name']);
		$this->set_variable("page_title",$row['page_title']);
		$descrip=$row['description']; 
		$this->set_variable("descrip",$descrip,0);
		$warranty_description=$row['warranty_description']; 
		$this->set_variable("warranty_description",$warranty_description);
		$this->set_variable("title",$row['page_title']);
		$this->set_variable("brand_id",$row['brand_id']);
		$this->set_variable("mrp",$row['mrp']);
		$this->set_variable("sale_price",$row['sale_price']);
		$this->set_variable("wrap_status",$row['wrap_status']);
		$shipping_class_id=$row['shipping_class'];
		
		$this->set_variable("cat_id",$row['cat_id']);
		
		$this->set_variable("categ_path",$this->get_category_path1($row['cat_id'],"product/list/category"),0);
		
		if($row['meta_keywords'] !="")
		$this->set_variable("keyword",$row['meta_keywords']);
		
		if($row['meta_description'] !="")
		$this->set_variable("description",$row['meta_description']);
		
		if($row['page_title'] !="")
		$this->set_title($row['page_title']);
		else
		$this->set_title($proname);
	
		
		$pro_image_file=$db->read_single_column("select pro_image_file from ".TABLE_PREFIX."product_images where pro_id=? and preview=1 and status=1 order by id asc",array($proid));
		if($pro_image_file=="")
		{
			$cound=$db->read_single_column("select count(id) from ".TABLE_PREFIX."product_images where pro_id=? and status=?  order by id asc",array($proid,1));
			
			if($cound==0)
			$this->set_variable("pro_image_file",0);	
			else
			{	
				$res=$db->execute_query("select id,pro_image_file from ".TABLE_PREFIX."product_images where pro_id=? and status=1 order by id asc",array($proid));
				$row=$res->fetch_assoc();
				$this->set_variable("pro_image_file",1);
				$this->set_variable("imagename",$row['pro_image_file']);
			}

		}
		else
		{
			$this->set_variable("pro_image_file",1);
			$this->set_variable("imagename",$pro_image_file);
		}
		
		$res4=$db->execute_query("select id,pro_id,pro_image_file from ".TABLE_PREFIX."product_images where pro_id=? and status=1 order by preview DESC",array($proid));
		$this->set_result("productimage",$res4);
		
		
		
		
		$mail=$db->read_single_column("select email from ".TABLE_PREFIX."admin");
		$this->set_variable("mail",$mail);
		
		$rate_cnt=$db->read_single_column("select sum(rate) from ".TABLE_PREFIX."product_rating where prod_id=$proid and status=1");
		$num=$db->read_single_column("select count(id) from ".TABLE_PREFIX."product_rating where prod_id=$proid and status=1");
		
		$user_reviewed=$db->read_single_column("select count(id) from ".TABLE_PREFIX."product_rating where prod_id=? and user_id=?",array($proid,$userid));
		
		$avg=0;
		if($num >0)
        $avg=$rate_cnt/$num;
        
		$this->set_variable("rate",$rate_cnt);
		$this->set_variable("review_cnt",$num);
		$this->set_variable("rating_avg",$avg);
		$this->set_variable("user_reviewed",$user_reviewed);
		
		$res5=$db->execute_query("select * from ".TABLE_PREFIX."shipping_classes where id=?",array($shipping_class_id));
		$this->set_result("shipping_classes",$res5);
  }
	
	
	function add_wishlist_action()
	{
		$db=DBLayer::get_instance();
		$user_id=$this->read_cookie_param(COOKIE_LOGINID);
		$pro_id=$this->read_page_param(1);
		$cound=$db->read_single_column("select count(id) from ".TABLE_PREFIX."wishlist where pro_id=? and user_id=?  order by id desc",array($pro_id,$user_id));
		if($cound !=0)
		{
			 echo 0;
			 exit;		
		}
		else
		{
				$res=$db->execute_query("INSERT INTO ".TABLE_PREFIX."wishlist (`user_id`,`pro_id`) values (?,?)",array($user_id,$pro_id));
				
				echo $watchcount=intval($this->get_wishlist_count());
				exit;
		}
	}
	

	
	
	function compare_action()
	{
		
		if(isset($_COOKIE[COOKIE_COMPARE]))
			$comp_cookie=$_COOKIE[COOKIE_COMPARE];
		
		if($comp_cookie=="")
		{
			header("Location: ".$this->make_url("index/index"));
			die;
		}
		
		$db=DBLayer::get_instance();
		
		$cookie_cat_id="";
		$compare_cookie="";
		
		if(isset($_COOKIE[COOKIE_COMPARE_CATEGORY]))
			$cookie_cat_id=$_COOKIE[COOKIE_COMPARE_CATEGORY];
		
		if(isset($_COOKIE[COOKIE_COMPARE]))
			$compare_cookie=$_COOKIE[COOKIE_COMPARE];
		
		$final_arr=array();
		$list_arr=array();
		
		if($cookie_cat_id!="" && $compare_cookie!="")
		{
			
			$list_arr[0][0]=$this->get_label('title');$final_arr[0][0]=$list_arr[0][0];
			$list_arr[0][1]='';$list_arr[0][2]='';
			
			$list_arr[1][0]=$this->get_label('image');$final_arr[1][0]=$list_arr[1][0];
			$list_arr[1][1]='';$list_arr[0][2]='';
			
			$list_arr[2][0]=$this->get_label('price');$final_arr[2][0]=$list_arr[2][0];
			$list_arr[2][1]='';$list_arr[0][2]='';
			
			$list_arr[3][0]=$this->get_label('availability');$final_arr[3][0]=$list_arr[3][0];
			$list_arr[3][1]='';$list_arr[0][2]='';
			
			$list_arr[4][0]=$this->get_label('warranty description');$final_arr[4][0]=$list_arr[4][0];
			$list_arr[4][1]='';$list_arr[0][2]='';
			
			$list_arr[5][0]=$this->get_label('gift wrapping');$final_arr[5][0]=$list_arr[5][0];
			$list_arr[5][1]='';$list_arr[0][2]='';
			
			$disp_str="title_image_price_availability_warranty_gift";
			$catids=$this->get_parent_category_list($cookie_cat_id,0);
			$topcatid=$this->get_last_parent_id($cookie_cat_id,0);
			
			$sql="SELECT cf.field_name,cf.id as custfield_id,cg.name FROM ".TABLE_PREFIX."customfields cf INNER JOIN ".TABLE_PREFIX."customgroups cg ON cf.groupid=cg.id WHERE catid IN ($catids) AND cf.status=1 AND cg.status=1 ORDER BY cg.priority,cf.priority ASC";
		
		$res1=$db->execute_query($sql);
		$i=6;
			while($row=$res1->fetch_assoc())
			{
				
				$list_arr[$i][0]=$row['field_name'];$final_arr[$i][0]=$list_arr[$i][0];
				
				$list_arr[$i][1]=$row['name'];
				
				$list_arr[$i][2]=$row['custfield_id'];
				$i++;
			}
			
			
			
			$compare_cookie_arr=explode(",", $compare_cookie);
			
			for($k=1;$k<=count($compare_cookie_arr);$k++)
			{
				$prod_id=$compare_cookie_arr[$k-1];
				
				$res=$db->execute_query("select * from ".TABLE_PREFIX."product where id=? and status=?",array($prod_id,1));
				$row=$res->fetch_assoc();
				for($a=0;$a < 6;$a++){
					
					if($a==0)
					$value=$row['name'];
					
					else if($a==1){
						$img_path=$this->get_product_image($row['id']);
						$value=$img_path;
					}
					else if($a==2)
						$value=$this->get_money_format($this->get_product_pricing($row['id']));
					else if($a==3){
						$value=$row['prod_stock'];
					}
					else if($a==4)
						$value=$row['warranty_description'];
					else if($a==5){
						$value=$row['wrap_status'];
					}
				$final_arr[$a][$k]=$value;
				
				}
				
			$res1=$db->execute_query("select * from ".TABLE_PREFIX."customfieldvalues_0 where prodid =".$prod_id);
			$res2=$db->execute_query("select * from ".TABLE_PREFIX."customfieldvalues_".$topcatid." where prodid =".$prod_id);
			
				$row1=$res1->fetch_assoc();
				$row2=$res2->fetch_assoc();
				
				
				
				
					for($b=6;$b<count($list_arr);$b++)
					{
						$val="field_".$list_arr[$b][2];
					   if(isset($row1[$val]))
						{
							if($row1[$val]!="")
								$final_arr[$b][$k]=$row1[$val];
							else
								$final_arr[$b][$k]="--";
						}
						else if(isset($row2[$val]))
						{
							if($row2[$val]!="")
								$final_arr[$b][$k]=$row2[$val];
							else
								$final_arr[$b][$k]="--";
						}
						else 
						{
							$final_arr[$b][$k]="--";
						}
						
						
						
						
					}
					
					$final_arr[$b][0]="";
					
					$final_arr[$b][$k]=$prod_id;
					
					
			}
		
		}
		
		
		
		
		$this->set_array('compare_data',$final_arr);
		$this->set_array('list_arr',$list_arr);
		$this->set_variable('cookie_cat_id',$cookie_cat_id);
		
	}
	
    function review_action()
	{
		
		$db=DBLayer::get_instance();
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		$prod_id=$this->read_page_param(1);
		$res=$db->execute_query("select rate,review from ".TABLE_PREFIX."product_rating where prod_id=? and user_id=?",array($prod_id,$userid));
		$row=$res->fetch_assoc();
		$rate=$row['rate'];
		$review=$row['review'];
		if($_POST)
		{
			
			$prod_id=$_POST['prod_id'];
			$review=$_POST['review'];
			$rate=$_POST['rate'];
			$userid=$this->read_cookie_param(COOKIE_LOGINID);
			
			if($review=="")
				$this->set_notice("mandatory");
			else
			{
				$tot=$db->read_single_column("select count(id) from ".TABLE_PREFIX."product_rating where prod_id=? and user_id=?",array($prod_id,$userid));
				
				if($tot==0)
				{
					$t=time();
					$res=$db->execute_query("INSERT INTO ".TABLE_PREFIX."product_rating (`user_id`,`prod_id`,`rate`,`review`,`time`,`status`) values (?,?,?,?,?,?)",array($userid,$prod_id,$rate,$review,$t,0));
					
					echo "<script>parent.window.location.reload();</script>";die;
						
					$this->flash($this->get_message('review details inserted successfully'), $this->make_url('product/review/'.$prod_id));
					die;
				}
				else
				{
					$res=$db->execute_query("update ".TABLE_PREFIX."product_rating set review=?,rate=?,status=? where prod_id=? and user_id=?",array($review,$rate,0,$prod_id,$userid));
					
					echo "<script>parent.window.location.reload();</script>";die;

					$this->flash($this->get_message('review details updated successfully'), $this->make_url('product/review/'.$prod_id));
					die;
				}
				
			}
		}
		
		$this->set_variable("rate",$rate);
		$this->set_variable("review",$review);
		$this->set_variable("prod_id",$prod_id);
		$this->set_variable("userid",$userid);
	}
	
	function review_details_action()
	{
		$db=DBLayer::get_instance();
		$userid=$this->read_cookie_param(COOKIE_LOGINID);

		$prod_id=$this->read_page_param(1);
		$this->set_variable("prod_id",$prod_id);
		$res=$db->execute_query("select * from ".TABLE_PREFIX."product_rating where prod_id=? and status=?",array($prod_id,1));

		$this->set_result("reviews",$res);
	}
	
	
	function list_action()
	{
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
		
		if($catid >0 && $catname !='')
		$this->set_title($catname);
		
		
		$brandfilter="";
		if($brandid >0)
		$brandfilter=" and brand_id=".$brandid;

		
		$search_str="";
		if($search !=0)
		$search_str="and name like '%".$search."%'";
		
		$categoryname123=0;
		$catstr="";
		
		if($catid >0)
		{
			$categoryname123=$this->get_category_name($catid);
			$childcat=$this->get_child_category_list($catid,0);
			
			if($childcat=="")
			$childcat=$catid;
			
			$catstr=" and cat_id IN (".$childcat.") ".$brandfilter;
		}
		
		$time=time();
		
		$type_str="";
		if($type=="featured")
		$type_str=" status=1 and featured=1 ";
		else if($type=='recent' || $type=="category")
		$type_str=" status=1 ";
		else if($type=='special-offers' || $type=='special offers')
		$type_str=" status=1 and special_offer_from <=".$time." and special_offer_to >= ".$time;
		
	
		$outofstock_str="";
		if($outofstock_chkd==1)
		$outofstock_str=" and prod_stock >0 ";
		
		$min=$db->read_single_column("select min(sale_price) from ".TABLE_PREFIX."product where $type_str $outofstock_str $search_str $catstr");
		$max=$db->read_single_column("select max(sale_price) from ".TABLE_PREFIX."product where $type_str $outofstock_str $search_str $catstr");
		
		if(!isset($from_price) || $from_price=="")
		$from_price=$min;
		
		if(!isset($to_price) || $to_price=="")
		$to_price=$max;
		
		$price_range_str="";
		if($from_price !="" && $to_price !="")
		$price_range_str="and sale_price >= ".$from_price." and sale_price <= ".$to_price;
		
		$sort_str="";
		if($sort_id==1)
		$sort_str=" order by popularity desc,id desc ";
		else if($sort_id==2)
		$sort_str=" order by id desc ";
		else if($sort_id==3)
		$sort_str=" order by id asc ";
		else if($sort_id==4)
		$sort_str=" order by sale_price asc ";
		else if($sort_id==5)
		$sort_str=" order by sale_price desc ";
		
		
		$sql="select id,name,mrp,cat_id,sale_price,prod_stock,page_title from ".TABLE_PREFIX."product where ".$type_str.$price_range_str.$outofstock_str.$search_str.$catstr.$sort_str;
		$pagination = new Pagination($sql);
		$res2=$pagination->get_result();
		$this->set_result("productlist",$res2);
		$this->set_variable("pagination",$pagination->links(),0);
		
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("userid",$userid);
		$this->set_variable("type",$type);
		$this->set_variable("sort_id",$sort_id);
		$this->set_variable("min",$min);
		$this->set_variable("max",$max);
		$this->set_variable("from_price",$from_price);
		$this->set_variable("to_price",$to_price);
		$this->set_variable("outofstock_chkd",$outofstock_chkd);
		$this->set_variable("catid",$catid);
		$this->set_variable("brandid",$brandid);
		$this->set_variable("catnameoriginal",$categoryname123);
		$this->set_variable("catname",$catname);
		$this->set_variable("brandname",$brandname);
		$this->set_variable("search",$search);
	}
	
	function scroll_action()
	{
		$this->disable_notice_area();
		$perpagesize=PAGINATION_SIZE;

		$catid=intval($this->read_post_param('catid'));
		$brandid=intval($this->read_post_param('brandid'));
		$type=trim($this->read_post_param('type'));       //category,featured,recent,special-offers
		$sort_id=intval($this->read_post_param('sort_id'));
		$from_price=$this->read_post_param('from_price');
		$to_price=$this->read_post_param('to_price');
		$outofstock_chkd=intval($this->read_post_param('outofstock_chkd'));
		$catname=trim($this->read_post_param('catname'));
		$brandname=trim($this->read_post_param('brandname'));
		$search=trim($this->read_post_param('search'));
		$currentpage=$this->read_post_param('startpage');
		
		
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
		
		$brandfilter="";
		if($brandid >0)
		$brandfilter=" and brand_id=".$brandid;
		
		$search_str="";
		if($search !=0)
		$search_str=" and name like '%".$search."%' ";
		
		
		
		$categoryname123=0;
		$catstr="";
		
		if($catid >0)
		{
			$categoryname123=$this->get_category_name($catid);
			$childcat=$this->get_child_category_list($catid,0);
			
			if($childcat =="")
			$childcat=$catid;
			
			$catstr=" and cat_id IN (".$childcat.") ".$brandfilter;
		}
		
		$type_str="";
		$time=time();
		
		if($type=='featured')
		$type_str=" status=1 and featured=1 ";
		else if($type=='recent' || $type=="category")
		$type_str=" status=1 ";
		else if($type=='special-offers' || $type=='special offers')
		$type_str=" status=1 and special_offer_from <=".$time." and special_offer_to >=".$time;
		
		$outofstock_str="";
		if($outofstock_chkd==1)
		$outofstock_str=" and prod_stock >0 ";
		
		$price_range_str="";
		if($from_price !="" && $to_price !="")
		$price_range_str=" and sale_price >=".$from_price." and sale_price <=".$to_price;
		
		
		
		$sort_str="";
		if($sort_id==1)
		$sort_str=" order by popularity desc,id desc ";
		else if($sort_id==2)
		$sort_str=" order by id desc ";
		else if($sort_id==3)
		$sort_str=" order by id asc ";
		else if($sort_id==4)
		$sort_str=" order by sale_price asc ";
		else if($sort_id==5)
		$sort_str=" order by sale_price desc ";
	
		$currentpage=1;
		if(isset($_POST['startpage']) && $_POST['startpage'] !="")
		$currentpage=$this->read_post_param('startpage');
		
		$startpages=($currentpage-1)*$perpagesize;
		$db=DBLayer::get_instance();
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable("userid",$userid);
	
		$sql="select id,name,mrp,cat_id,sale_price,prod_stock,page_title from ".TABLE_PREFIX."product where ".$type_str.$price_range_str.$outofstock_str.$search_str.$catstr.$sort_str." LIMIT ".$startpages.",".$perpagesize;
		$res=$db->execute_query($sql);
		$this->set_result("products",$res);
		$this->set_variable("startpages",$startpages);	
	}
};
?>