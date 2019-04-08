<?php
include_once COMMON_DIR_PATH.DS.'helpers'.DS."utility-helper.php";
include_once COMMON_DIR_PATH.DS.'helpers'.DS."login-helper.php";
class CustomController extends AppController
{
	function before_execute()
	{
		if(LoginHelper::validate_admin_login()==0)
			{
				$this->flash($this->get_message('login failed'), $this->make_url('index/index'),0);
			}
	}
	
	function load_groups_action()
	{
		$db=DBLayer::get_instance();
	
		
		$catid=$this->read_page_param(1);
		$selected=$this->read_page_param(2);
		$from=$this->read_page_param(3);
		
		if($catid=="")
		$catid=0;
		$sql=$db->execute_query("select id,name from ".TABLE_PREFIX."customgroups where catid=? and status=? order by priority",array($catid,1));
		$options="";
			
		$options.="<option value=''>".$this->get_label('select')."</option>";
		while($row=$sql->fetch_assoc())
		{
			if($selected ==$row['id'])
			$options.="<option value='".$row['id']."' selected>".$this->escape($row['name'])."</option>";
			else
			$options.="<option value='".$row['id']."'>".$this->escape($row['name'])."</option>";
		}
	
		echo $options;
	    exit;
	}
	
	function add_action()
	{
		$this->set_title($this->get_label('add custom fields'));
		$db= DBLayer::get_instance();
		$categ=0;
		$group=0;
		
 		if($_POST)
		{
			$field_name=$this->read_post_param('name');
			$cat_id=$this->read_post_param('cat_id');
			$type=$this->read_post_param('type');
			$mandatory=$this->read_post_param('mandatory');
			$value=$this->read_post_param('value1');
			$group=$this->read_post_param("group");
			
			
			if($group=="")
			$group=0;
			
			$this->set_variable('name', $field_name);
			$this->set_variable('mandatory', $mandatory);
			$this->set_variable('type', $type);
			$this->set_variable('value', $value);
			$this->set_variable('group', $group);
			$this->set_variable('cat_id', $cat_id);
			
			if($cat_id=="")
			$cat_id=0;
				
			$categ=$cat_id;
			
			$already=$db->read_single_column("select count(id) from ".TABLE_PREFIX."customfields where field_name=? and  groupid=?",array($field_name,$group));
					
			if($type=="dropdown" && $value !="")
			{
				$drp=explode(',',$value);
				$drp_temp=array();
				$drpcount=count($drp);
				
					if(count($drp) >0)
					{
						$j=0;
						for($k=0;$k<$drpcount;$k++)
						{
			   if(trim($drp[$k]) !="")
							 {
								if(!in_array($drp[$k],$drp_temp))
								{
									$drp_temp[$j]=$drp[$k];
									$j=$j+1;
								}
							 }
							 
						}	
					}
				
					
				$drp_temp=implode(',',$drp_temp);
				$value=$drp_temp;
				
			}


			if($type !="dropdown")
			{
				$value="";
			}
			
			
			if($field_name =="")
			{
				$this->set_notice("mandatory");
			}
			else if($type=="dropdown" && $value=="")
			{
				$this->set_notice("mandatory");
			}
			else if($already >0)
			{
				$this->set_notice("custom field already");
			}
			else 
			{
				
				if(isset($_POST['onlynumeric']))
				{
					$columntype='INT(11)';
					$numeric=1;
				}
				else
				{
					$columntype='VARCHAR(256)';
					$numeric=0;
				}
				
				
				$db= DBLayer::get_instance();
				
				$priority=$db->read_single_column("select max(priority) from ".TABLE_PREFIX."customfields where groupid=?",array($group));
				
				if($priority >=1)
					$newpriority=$priority+1;
				else
					$newpriority=1;
				$topcategory= $this->get_last_parent_id($cat_id);
				
				
				$sql="INSERT INTO ".TABLE_PREFIX."customfields (field_name,type,value,status,mandatory,priority,groupid,numeric_only) values (?,?,?,?,?,?,?,?)";
				$res=$db->execute_query($sql,array($field_name,$type,$value,1,$mandatory,$newpriority,$group,$numeric));
				$lastid=$res->get_last_id();
				mysql_query("ALTER TABLE ".TABLE_PREFIX."customfieldvalues_".$topcategory." ADD field_".$lastid." ".$columntype);
				$this->flash($this->get_message('custom field added'), $this->make_url('custom/manage/'.$cat_id.'/'.$group));
				exit;
			}
		}
		
		$categories="<option value='0'>".$this->get_label('select')."</option>".$this->get_category_display(0,0,$categ);
		$this->set_variable("categories",$categories,0);
		
			
	}
	
	function edit_action()
	{

		$this->set_title($this->get_label('edit custom fields'));
		$db= DBLayer::get_instance();
		
		if($_POST)
		{
			$field_name=$this->read_post_param('field_name');
			$id=$this->read_post_param('field_id');
			$value=$this->read_post_param('value1');

			$this->set_variable("field_name",$field_name);
			$this->set_variable("value1",$value);
			$this->set_variable("field_id",$id);
			
			$sql="select groupid,type from ".TABLE_PREFIX."customfields where id=?";
			$res=$db->execute_query($sql,array($id));
			$row=$res->fetch_assoc();
			$group=$row['groupid'];
			$type=$row['type'];
			
			$already=$db->read_single_column("select count(id) from ".TABLE_PREFIX."customfields where field_name=? and  groupid=? and id!=?",array($field_name,$group,$id));
		
		
			if($type !="dropdown")
			{
			$value="";
			}
				
				
			if($field_name =="")
			{
				$this->set_notice("mandatory");
			}
			else if($type=="dropdown" && $value=="")
			{
				$this->set_notice("mandatory");
			}
			else if($already >0)
			{
				$this->set_notice("custom field already");
			}
			else
			{	
				if($type=="dropdown" && $value !="")
				{
					$drp=explode(',',$value);
					$drp_temp=array();
					$drpcount=count($drp);
				
					if(count($drp) >0)
					{
							$j=0;
							for($k=0;$k<$drpcount;$k++)
							{
							if(trim($drp[$k]) !="")
							{
								if(!in_array($drp[$k],$drp_temp))
								{
								$drp_temp[$j]=$drp[$k];
								$j=$j+1;
							}
							}
					
							}
						}
				
				
						$drp_temp=implode(',',$drp_temp);
						$value=$drp_temp;
				
				}
				
				$res=$db->execute_query("update ".TABLE_PREFIX."customfields set field_name=?,value=? where id=?",array($field_name,$value,$id));
				$this->flash($this->get_message('custom field edited'), $this->make_url('custom/manage'));
				exit;
			}
			
		}
		
			$id=$this->read_page_param(1);
			
			if(!$this->get_custom_field_exists($id))
			{
				$this->flash($this->get_message('invalid id'), $this->make_url('custom/manage'),0);
				exit;
			}
			
			$sql="select b.name, b.catid, a.*  from ".TABLE_PREFIX."customfields a, ".TABLE_PREFIX."customgroups b where b.id=a.groupid and a.id=?";
			$res=$db->execute_query($sql,array($id));
			$this->set_result("res",$res);
		
			$this->set_variable("field_id",$id);
		
	}
		
	function change_priority_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$operation=$this->read_page_param(2);
		$gst=$this->read_page_param(3);
		
		$res=$db->execute_query("select groupid,priority from ".TABLE_PREFIX."customfields where id=?",array($id));
		$row=$res->fetch_assoc();
		$groupid=$row['groupid'];
		$priority=$row['priority'];
		
		if($operation==1)
			$newpriority=$priority-1;
		else 
			$newpriority=$priority+1;
		
		
		$newpriorityid=$db->read_single_column("select id from ".TABLE_PREFIX."customfields where groupid=? and priority=?",array($groupid,$newpriority));
		if($newpriority>0)
		{
			$db->execute_query("update ".TABLE_PREFIX."customfields set priority=? where id=? and groupid=?",array($priority,$newpriorityid,$groupid));
			$db->execute_query("update ".TABLE_PREFIX."customfields set priority=? where id=? and groupid=?",array($newpriority,$id,$groupid));
		}
		
		$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($groupid));
		

		if($gst==1)
			$this->flash($this->get_message('priority update success'), $this->make_url('custom/manage/'.$catid.'/-1'));
		else
			$this->flash($this->get_message('priority update success'), $this->make_url('custom/manage/'.$catid.'/'.$groupid));
		exit;
	}
	
	function delete_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
		$gst=$this->read_page_param(3);
		
		$res=$db->execute_query("select groupid,priority from ".TABLE_PREFIX."customfields where id=?",array($id));
		$row=$res->fetch_assoc();
		$groupid=$row['groupid'];
		$priority=$row['priority'];
	    $catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($groupid));
	    
	    $catid=$this->get_last_parent_id($catid);
    	$res=$db->execute_query("ALTER TABLE ".TABLE_PREFIX."customfieldvalues_$catid DROP COLUMN field_$id");
		
	
		$res=$db->execute_query("delete from ".TABLE_PREFIX."customfields where id=?",array($id));
		$sqls=$db->execute_query("update ".TABLE_PREFIX."customfields set priority=(priority-1) where priority >? and groupid=?",array($priority,$groupid));
		
		if($gst==1)
		$this->flash($this->get_message('custom field deleted'), $this->make_url('custom/manage/'.$catid.'/-1'));
		else
		$this->flash($this->get_message('custom field deleted'), $this->make_url('custom/manage/'.$catid.'/'.$groupid));
			
		exit;
	}
	
	function activate_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
		$gst=$this->read_page_param(3);
		
		$query="UPDATE ".TABLE_PREFIX."customfields set status=1 where id=?" ;
		$result=$db->execute_query($query,array($id));
		
		
		$groupid=$db->read_single_column("select groupid from ".TABLE_PREFIX."customfields where id=?",array($id));
		$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($groupid));
		
		if($gst==1)
			$this->flash($this->get_message('custom field activated'), $this->make_url('custom/manage/'.$catid.'/-1'));
		else
			$this->flash($this->get_message('custom field activated'), $this->make_url('custom/manage/'.$catid.'/'.$groupid));
		
	}
	
	function block_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
		$gst=$this->read_page_param(3);
		
		$query="UPDATE ".TABLE_PREFIX."customfields set status=0 where id=?" ;
		$result=$db->execute_query($query,array($id));
		
		$groupid=$db->read_single_column("select groupid from ".TABLE_PREFIX."customfields where id=?",array($id));
		$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($groupid));
		
		if($gst==1)
			$this->flash($this->get_message('custom field blocked'), $this->make_url('custom/manage/'.$catid.'/-1'));
		else
			$this->flash($this->get_message('custom field blocked'), $this->make_url('custom/manage/'.$catid.'/'.$groupid));
	}
	
	function add_group_action()
	{
		$this->set_title($this->get_label('add custom field group'));
		$db= DBLayer::get_instance();
		$categ=0;
		
		if($_POST)
		{
			$group_name=$this->read_post_param('name');
			$catid=$this->read_post_param('cat_id');
		
		
			$this->set_variable('name',$group_name);
		
		
			if($catid=="")
			$catid=0;
		
			$categ=$catid;
	
		
			$already=$db->read_single_column("select count(id) from ".TABLE_PREFIX."customgroups where name=? and catid=?",array($group_name,$catid));
		
		
			if($group_name =="")
			{
					$this->set_notice("mandatory");
			}
			else if($already >0)
			{
					$this->set_notice("custom field group already");
			}
			else
			{

				$priority=$db->read_single_column("select max(priority) from ".TABLE_PREFIX."customgroups where catid=?",array($catid));
	
				if($priority >=1)
				$newpriority=$priority+1;
				else
				$newpriority=1;
	
				$sql="INSERT INTO ".TABLE_PREFIX."customgroups (name,catid,status,priority) values (?,?,?,?)";
				$res=$db->execute_query($sql,array($group_name,$catid,1,$newpriority));
				
				$this->flash($this->get_message('custom field group added'), $this->make_url('custom/manage_group/'.$catid));
	            exit;
			}
	}
	
	$categories="<option value='0'>".$this->get_label('select')."</option>".$this->get_category_display(0,0,$categ);
	$this->set_variable("categories",$categories,0);
	
	
}
	

function manage_action()
{

	$this->set_variable("allowpriority",0);
	$categ="";
	if($_POST)
	{
		$categ=$this->read_post_param("cat_id");
		$group=$this->read_post_param("group");
		$disp_cat=$this->read_post_param("disp_cat");
		if($group!='')
			$this->set_variable("allowpriority",1);
	}
	else
	{
		$categ=$this->read_page_param(1);
		$group=$this->read_page_param(2);
		$disp_cat=$this->read_page_param(3);
	}

	if($group=="")
	$group=-1;

	if($disp_cat =="")
	$disp_cat=0;
	
	$this->set_variable("disp_cat",$disp_cat);

	$groupstr="";$astr="";
	if($group == "")
	$groupstr="";
	else if($group > 0)
	$groupstr="	and groupid=".$group." ";
	
	if($disp_cat ==1)
	{
		if($categ >0)
		{
			$cudata="";
			$cudata=$this->get_child_ids($categ);
			$cudata=$cudata.$categ;
	
			$astr=str_replace("_", ",", $cudata);
		}
		else
		{
			$astr=$categ;
		} 
	}
	else
	{
		$astr=$categ;
	}

	$this->set_title($this->get_label('manage custom fields'));
	$db= DBLayer::get_instance();
	if($categ=="")
		$sql="select b.name, b.catid, a.*  from ".TABLE_PREFIX."customfields a, ".TABLE_PREFIX."customgroups b where b.id= a.groupid order by groupid desc,priority asc";
	else 
		$sql="select b.name, b.catid, a.* from ".TABLE_PREFIX."customfields a, ".TABLE_PREFIX."customgroups b where catid IN (".$astr.") ".$groupstr." and b.id= a.groupid order by groupid desc,priority asc";
	
	$res=$db->execute_query($sql);
	$this->set_result("res",$res);
	
	$rowcount=$res->get_num_records();
	$this->set_variable("rowcount",$rowcount);

	$this->set_variable("group",$group);

	$categories="<option value=''>".$this->get_label('select category')."</option>".$this->get_category_display(0,0,$categ);
	$this->set_variable("categories",$categories,0);
		
}

	function manage_group_action()
	{
		
		$categ="";
		if($_POST)
		{
		$categ=$this->read_post_param("catid");
		$disp_cat=$this->read_post_param("disp_cat");
		}
		else
		{
		$categ=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
		}
		
		if($categ =="")
		$categ=0;
		
		if($disp_cat =="")
		$disp_cat=0;
		
		$this->set_variable("disp_cat",$disp_cat);
		
		
		if($disp_cat ==1)
		{
			if($categ >0)
			{
				$cudata="";
				$cudata=$this->get_child_ids($categ);
				$cudata=$cudata.$categ;
				$astr=str_replace("_", ",", $cudata);
			}
			else 
			{
				$astr=$categ;
			}
		}
		else
		{
			$astr=$categ;
		}
		
		$condition="where catid IN (".$astr.")";
		if($categ==0)
		$condition="";
		
		$this->set_title($this->get_label('manage custom field group'));
		$db= DBLayer::get_instance();
		$res=$db->execute_query("select * from ".TABLE_PREFIX."customgroups $condition order by catid,priority asc");
		$this->set_result("res",$res);
		
		$rowcount=$res->get_num_records();
		$this->set_variable("rowcount",$rowcount);
		
		
		$categories="<option value='0'>".$this->get_label('select category')."</option>".$this->get_category_display(0,0,$categ);
		$this->set_variable("categories",$categories,0);
		
		
	}
	
	function activate_group_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
	
		if(!$this->get_custom_group_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('custom/manage_group'),0);
			exit;
		}
	
	    $catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($id));
	
		$query="UPDATE ".TABLE_PREFIX."customgroups set status=1 where id=?" ;
		$result=$db->execute_query($query,array($id));
		$this->flash($this->get_message('custom field group activated'), $this->make_url('custom/manage_group/'.$catid.'/'.$disp_cat));
	}
	
	function block_group_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
	
		if(!$this->get_custom_group_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('custom/manage_group'),0);
			exit;
		}
	
		$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($id));
		
		
		$query="UPDATE ".TABLE_PREFIX."customgroups set status=0 where id=?" ;
		$result=$db->execute_query($query,array($id));
		$this->flash($this->get_message('custom field group blocked'), $this->make_url('custom/manage_group/'.$catid.'/'.$disp_cat));
	}
	
	
	function change_group_priority_action()
	{
	
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$operation=$this->read_page_param(2);
	
		
		if(!$this->get_custom_group_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('custom/manage_group'),0);
			exit;
		}
		
		$res=$db->execute_query("select catid,priority from ".TABLE_PREFIX."customgroups where id=?",array($id));
		$row=$res->fetch_assoc();
		$catid=$row['catid'];
		$priority=$row['priority'];
		
	
		if($operation==1)
		{
			$newpriority=$priority-1;
		}
		else
		{
			$newpriority=$priority+1;
		}
	
		$newpriorityid=$db->read_single_column("select id from ".TABLE_PREFIX."customgroups where catid=? and priority=?",array($catid,$newpriority));
		if($newpriority>0)
		{
		$db->execute_query("update ".TABLE_PREFIX."customgroups set priority=? where id=? and catid=?",array($priority,$newpriorityid,$catid));
		$db->execute_query("update ".TABLE_PREFIX."customgroups set priority=? where id=? and catid=?",array($newpriority,$id,$catid));
		}
	
		$this->flash($this->get_message('priority update success'), $this->make_url('custom/manage_group/'.$catid));
		exit;
	
	}
	
	function deletegroup_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$disp_cat=$this->read_page_param(2);
		$flag=$this->read_page_param(3);
	
		$this->set_variable('id', $id);
		$this->set_variable('disp_cat', $disp_cat);
	
		if(!$this->get_custom_group_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('custom/manage_group'),0);
			exit;
		}
	
		$fcount=$db->read_single_column("select id from ".TABLE_PREFIX."customfields where groupid=?",array($id));
		if($fcount=='')
		{
			$catid=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($id));
			
			$priority=$db->read_single_column("select priority from ".TABLE_PREFIX."customgroups where id=?",array($id));
			
			
			$res=$db->execute_query("delete from ".TABLE_PREFIX."customgroups where id=?",array($id));
			
			$sqls=$db->execute_query("update ".TABLE_PREFIX."customgroups set priority=(priority-1) where priority >? and catid=?",array($priority,$catid));
			
			$this->flash($this->get_message('custom field group deleted'), $this->make_url('custom/manage_group/'.$catid.'/'.$disp_cat));
			exit;
		}
		else 
		{
			$this->flash($this->get_message('custom fields exists'), $this->make_url('custom/manage_group/'.$catid.'/'.$disp_cat),0);
			die;
		}
	}

	function save_group_name_action()
	{
		$pid=$this->read_page_param(1);
		$val=$this->read_page_param(2);
		$db=DBLayer::get_instance();
	
		$cat=$db->read_single_column("select catid from ".TABLE_PREFIX."customgroups where id=?",array($pid));
	
		$already=$db->read_single_column("select count(id) from ".TABLE_PREFIX."customgroups where name=? and catid=? and id!=?",array($val,$cat,$pid));
		if($already!=0)
		{
			echo "2";exit;
		}
		$res=$db->execute_query("update ".TABLE_PREFIX."customgroups set name=? where id=?",array($val,$pid));
	
		echo "1";exit;
	}
	
};