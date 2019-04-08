<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";


class CronjobController extends AppController
{
	function execute_action()
	{
		$db= DBLayer::get_instance();
		
		$error_first="";
		$error_second="";
		$error_third="";
		
		$pending_orders_period=Settings::get_instance()->read('pending_orders_period');
		if($pending_orders_period=="")
			$pending_orders_period=30;
		
		$product_popularity_period=Settings::get_instance()->read('product_popularity_period');
		if($product_popularity_period=="")
			$product_popularity_period=90;
		
		$time1=time()-($pending_orders_period*24*60*60);
		$time2=time()-($product_popularity_period*24*60*60);
		
		$sql="select id from ".TABLE_PREFIX."order where order_date<? and status=?";
		$res=$db->execute_query($sql,array($time1,1));
		while($row=$res->fetch_assoc())
		{
			$result1=$db->execute_query("delete from ".TABLE_PREFIX."order where id=".$row['id']);
			$error_first=$result1->error;
			
			$result2=$db->execute_query("delete from ".TABLE_PREFIX."order_items where order_id=".$row['id']);
			$error_second=$result2->error;
		}
		
		
		$sql="SELECT sum(oi.quantity) as popularity,oi.pro_id FROM ".TABLE_PREFIX."order_items oi INNER JOIN ".TABLE_PREFIX."order o ON oi.order_id=o.id WHERE o.status=? AND o.payment_date>? GROUP BY oi.pro_id";
		$res=$db->execute_query($sql,array(2,$time2));
		while($row=$res->fetch_assoc())
		{
			$prod_id=$row['pro_id'];
			$popularity=$row['popularity'];
			
			$result3=$db->execute_query("UPDATE ".TABLE_PREFIX."product SET popularity=".$popularity." WHERE id=".$prod_id);
			$error_third=$result3->error;
		}
		
		
		if($error_first =="" && $error_second =="" && $error_third =="")
		{
			Settings::get_instance()->update('cron_running_time',time());
			
			echo "<strong>".$this->get_message('cron running successfully')."</strong>";
		}
		else 
		{
			if($error_first !="")
			echo "<strong>".$error_first."</strong>"."<br/>";
			if($error_second !="")
			echo "<strong>".$error_second."</strong>"."<br/>";
			if($error_third !="")
			echo "<strong>".$error_third."</strong>"."<br/>";
			
		}
		exit;
	}	

	function demo_reset_action()
	{
		if(DEMO_MODE==TRUE)
		{
			$db= DBLayer::get_instance();
	
			$product_count=20;
			$user_count=1;
			$cat_count=121;
			$cgroup_count=5;
			$cfield_count=15;
			$banner_count=15;
			$shipping_class_count=4;
			$shipping_company_count=8;
	
			/////////////////////////product delete ////////////////////////////////
			$product_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."product WHERE id>?",array($product_count));
	
			while($product_rowdata=$product_row->fetch_assoc())
			{
				$id=$product_rowdata["id"];
	
				$productcategory=$this->get_product_category($id);
				$lastpid=intval($this->get_last_parent_id($productcategory));
	
				$res1=$db->execute_query("DELETE FROM ".TABLE_PREFIX."customfieldvalues_".$lastpid." WHERE prodid=?",array($id));
				$res2=$db->execute_query("DELETE FROM ".TABLE_PREFIX."customfieldvalues_0 WHERE prodid=?",array($id));
	
				$res3=$db->execute_query("delete from ".TABLE_PREFIX."product where id=?",array($id));
				$res4=$db->execute_query("delete from ".TABLE_PREFIX."product_images where pro_id=?",array($id));
				$res5=$db->execute_query("delete from ".TABLE_PREFIX."product_rating where prod_id=?",array($id));
				$res6=$db->execute_query("delete from ".TABLE_PREFIX."wishlist where pro_id=?",array($id));
	
				$sql123=$db->execute_query("select id,image from ".TABLE_PREFIX."banners where type=1 AND type_id=$id");
				$row123=$sql123->fetch_assoc();
	
				if($row123['id'] >0)
				{
					unlink(DATA_DIR_PATH."banners/".$row123['image']);
					$res7=$db->execute_query("delete from ".TABLE_PREFIX."banners where id=?",array($row123['id']));
				}
	
				$mydir = DATA_DIR_PATH."prodimages/".$id."/";
				$d = dir($mydir);
				if($d)
				{
					while($entry = $d->read())
					{
						if ($entry!= "." && $entry!= "..")
						{
							unlink(DATA_DIR_PATH."prodimages/".$id."/".$entry);
						}
					}
					$d->close();
					rmdir($mydir);
				}
	
			}
	
			//////////////////////////////////users delete ////////////////////////////////
			$user_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."users WHERE id>?",array($user_count));
	
			while($user_rowdata=$user_row->fetch_assoc())
			{
				$id=$user_rowdata["id"];
	
				$res1=$db->execute_query("delete from ".TABLE_PREFIX."users where id=?",array($id));
				$res2=$db->execute_query("delete from ".TABLE_PREFIX."user_address where user_id=?",array($id));
				$res3=$db->execute_query("delete from ".TABLE_PREFIX."product_rating where user_id=?",array($id));
				$res4=$db->execute_query("delete from ".TABLE_PREFIX."wishlist where user_id=?",array($id));
			}
	
			//////////////////////////////////category delete ////////////////////////////////
			$cat_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."categories WHERE id>?",array($cat_count));
	
			while($cat_rowdata=$cat_row->fetch_assoc())
			{
				$id=$cat_rowdata["id"];
	
				$top=$this->get_last_parent_id($id);
	
				if($top==$id)
					$res=$db->execute_query("DROP TABLE ".TABLE_PREFIX."customfieldvalues_$id");
	
				$res1=$db->execute_query("delete from ".TABLE_PREFIX."categories where id=?",array($id));
				$res2=$db->execute_query("delete from ".TABLE_PREFIX."category_brand_mapping where cat_id=?",array($id));
	
				$sql123=$db->execute_query("select id,image from ".TABLE_PREFIX."banners where type=2 AND type_id=$id");
				$row123=$sql123->fetch_assoc();
	
				if($row123['id'] >0)
				{
					unlink(DATA_DIR_PATH."banners/".$row123['image']);
					$res3=$db->execute_query("delete from ".TABLE_PREFIX."banners where id=?",array($row123['id']));
				}
	
			}
	
			//////////////////////////////////custom group delete ////////////////////////////////
			$cgroup_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."customgroups WHERE id>?",array($cgroup_count));
	
			while($cgroup_rowdata=$cgroup_row->fetch_assoc())
			{
				$id=$cgroup_rowdata["id"];
	
				$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($id));
				$priority=$db->read_single_column("select priority from ".TABLE_PREFIX."customgroups where id=?",array($id));
				$res=$db->execute_query("delete from ".TABLE_PREFIX."customgroups where id=?",array($id));
				$sqls=$db->execute_query("update ".TABLE_PREFIX."customgroups set priority=(priority-1) where priority >? and catid=?",array($priority,$catid));
			}
	
			//////////////////////////////////custom field delete ////////////////////////////////
			$cfield_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."customfields WHERE id>?",array($cfield_count));
	
			while($cfield_rowdata=$cfield_row->fetch_assoc())
			{
				$id=$cgroup_rowdata["id"];
	
				$res=$db->execute_query("select groupid,priority from ".TABLE_PREFIX."customfields where id=?",array($id));
				$row=$res->fetch_assoc();
				$groupid=$row['groupid'];
				$priority=$row['priority'];
				$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($groupid));
	
				$catid=$this->get_last_parent_id($catid);
				$res=$db->execute_query("ALTER TABLE ".TABLE_PREFIX."customfieldvalues_$catid DROP COLUMN field_$id");
	
				$res=$db->execute_query("delete from ".TABLE_PREFIX."customfields where id=?",array($id));
				$sqls=$db->execute_query("update ".TABLE_PREFIX."customfields set priority=(priority-1) where priority >? and groupid=?",array($priority,$groupid));
			}
	
			//////////////////////////////////banner delete ////////////////////////////////
			$banner_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."banners WHERE id>?",array($banner_count));
	
			while($banner_rowdata=$banner_row->fetch_assoc())
			{
				$id=$banner_rowdata["id"];
	
				unlink(DATA_DIR_PATH."banners/".$banner_rowdata['image']);
				$res=$db->execute_query("delete from ".TABLE_PREFIX."banners where id=?",array($id));
			}
			
			//////////////////////////////////shipping company delete ////////////////////////////////
			$scomp_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."shippingcompany WHERE id>?",array($shipping_company_count));
			
			while($scomp_rowdata=$scomp_row->fetch_assoc())
			{
				$id=$scomp_rowdata["id"];
			
				$res1=$db->execute_query("delete from ".TABLE_PREFIX."shippingcompany where id=?",array($id));
			}
			
			//////////////////////////////////shipping class delete ////////////////////////////////
			$sclass_row=$db->execute_query("SELECT * FROM ".TABLE_PREFIX."shipping_classes WHERE id>?",array($shipping_class_count));
			
			while($sclass_rowdata=$sclass_row->fetch_assoc())
			{
				$id=$sclass_rowdata["id"];
			
				$res1=$db->execute_query("delete from ".TABLE_PREFIX."shipping_classes where id=?",array($id));
			}
	
		}
		
		echo "<strong>".$this->get_message('demo reset successfully')."</strong>";
		exit;
	}
};