<?php
class LayoutController extends AppController
{
	function header_action()
	{
		$pageid=$this->read_page_param(1);
		$subid=$this->read_page_param(2);
		
		if($pageid=="" || $pageid <=0)
		$pageid=0;
		$this->set_variable("pageid",$pageid);
		$this->set_variable("subid",$subid);
		
	}
	function footer_action()
	{
		
	}
	
};
?>