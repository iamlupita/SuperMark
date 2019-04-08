<?php 
$this->dispatch("layout/header/3/_32");
$validate4=array(
		"thousand_separator"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"decimal_separator"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)
);
$form4=$this->create_form();
$form4->start("settings4",$this->make_url("system/format"),"post",$validate4);
    
 $cday=date("j",time());//9
 $cday1=date("d",time());//09

 $cmonth0=date("n",time());//2
 $cmonth=date("m",time());//02
 $cmonth1=date("M",time());//Feb

 $cyear=date("y",time());//12
 $cyear1=date("Y",time());//2012

 $chour=date("G",time());
 $cminute=date("i",time());
 $csecond=date("s",time());
 $cformat=date("A",time());
 
 if($cminute< 10 && $cminute>0)
 {
 $cminute=	str_replace("0", "", $cminute);
 }
 
 if($csecond< 10 && $csecond>0)
 {
 	$csecond=	str_replace("0", "", $csecond);
 }
 
 
 
 
 
if($_POST)
{
	$decimal_place=$this->get_variable("decimal_place");
	$thousand_separator=$this->get_variable("thousand_separator");
	$decimal_separator=$this->get_variable("decimal_separator");
	
	$day_format=$this->get_variable("day_format");
	$month_format=$this->get_variable("month_format");
	$year_format=$this->get_variable("year_format");
	$hour_format=$this->get_variable("hour_format");
	$minute_format=$this->get_variable("minute_format");
	$second_format=$this->get_variable("second_format");
	$day_separator=$this->get_variable("day_separator");
	$time_separator=$this->get_variable("time_separator");
	$hour_display_format=$this->get_variable("hour_display_format");
	$day_position=$this->get_variable("day_position");

}
else 
{
	$decimal_place=Settings::get_instance()->read('decimal_place');
	$thousand_separator=Settings::get_instance()->read('thousand_separator');
	$decimal_separator=Settings::get_instance()->read('decimal_separator');
	
	$day_format=Settings::get_instance()->read("day_format");
	$month_format=Settings::get_instance()->read("month_format");
	$year_format=Settings::get_instance()->read("year_format");
	$hour_format=Settings::get_instance()->read("hour_format");
	$minute_format=Settings::get_instance()->read("minute_format");
	$second_format=Settings::get_instance()->read("second_format");
	$day_separator=Settings::get_instance()->read("day_separator");
	$time_separator=Settings::get_instance()->read("time_separator");
	$hour_display_format=Settings::get_instance()->read("hour_display_format");
	$day_position=Settings::get_instance()->read("day_position");
	
}

?>   
<div class="sub_menu"><?php echo $this->get_label('format settings');?></div>

     
     
<table  cellpadding="0" cellspacing="0" width="100%" >





<tr><td colspan="2" height="10px">


<div class="sub_menu"><?php echo $this->get_label('date format');?></div>

</td></tr>

<tr>
<td height="30px" style="vertical-align: middle;"><?php echo $this->get_label('demo');?></td>
<td style="vertical-align: middle;" class="notification"><strong><span id="date_demo"></span></strong></td>
</tr>


<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('day');?></td>
<td>
<select id="day" name="day" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="d" <?php if($day_format=="d") echo "selected";?>>D</option>
<option value="D" <?php if($day_format=="D") echo "selected";?>>DD</option>
</select>

<input type="hidden" name="tab" id="tab" value="5"/>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>



<tr>
<td><?php echo $this->get_label('day position');?></td>
<td>
<select id="dayposition" name="dayposition" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="1" <?php if($day_position==1) echo "selected";?>><?php echo $this->get_label('first');?></option>
<option value="2" <?php if($day_position==2) echo "selected";?>><?php echo $this->get_label('second');?></option>
</select>

</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>


<tr>
<td><?php echo $this->get_label('month');?></td>
<td>
<select id="month" name="month" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="m"   <?php if($month_format=="m") echo "selected";?>>M</option>
<option value="M"   <?php if($month_format=="M") echo "selected";?>>MM</option>
<option value="Mon" <?php if($month_format=="Mon") echo "selected";?>>Mon</option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>


<tr>
<td><?php echo $this->get_label('year');?></td>
<td>
<select id="year" name="year" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="y" <?php if($year_format=="y") echo "selected";?>>YY</option>
<option value="Y" <?php if($year_format=="Y") echo "selected";?>>YYYY</option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('hour');?></td>
<td>
<select id="hour" name="hour" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="H" <?php if($hour_format=="H") echo "selected";?>>H</option>
<option value="HH" <?php if($hour_format=="HH") echo "selected";?>>HH</option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('minute');?></td>
<td>
<select id="minute" name="minute" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="M" <?php if($minute_format=="M") echo "selected";?>>M</option>
<option value="MM" <?php if($minute_format=="MM") echo "selected";?>>MM</option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('second');?></td>
<td>
<select id="second" name="second" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="S" <?php if($second_format=="S") echo "selected";?>>S</option>
<option value="SS" <?php if($second_format=="SS") echo "selected";?>>SS</option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('12 or 24');?></td>
<td>
<select id="tformat" name="tformat" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value="12" <?php if($hour_display_format==12) echo "selected";?>><?php echo $this->get_label('12 hour');?></option>
<option value="24" <?php if($hour_display_format==24) echo "selected";?>><?php echo $this->get_label('24 hour');?></option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('date separator');?></td>
<td>
<select id="separator" name="separator" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value=":" <?php if($day_separator==":") echo "selected";?>>:</option>
<option value="/" <?php if($day_separator=="/") echo "selected";?>>/</option>
<option value="-" <?php if($day_separator=="-") echo "selected";?>>-</option>
</select>
</td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('time separator');?></td>
<td>
<select id="tseparator" name="tseparator" style="width: 95px;" onchange="show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>')">
<option value=":" <?php if($time_separator==":") echo "selected";?>>:</option>
<option value="/" <?php if($time_separator=="/") echo "selected";?>>/</option>
<option value="-" <?php if($time_separator=="-") echo "selected";?>>-</option>
</select>
</td>
</tr>

<tr><td height="20px" colspan="2"></td></tr>


<tr><td colspan="2" >

<div class="sub_menu"><?php echo $this->get_label('number format');?></div>

</td></tr>


<tr><td></td><td height="10px"><?php echo $this->get_label('compulsory message');?></td></tr>

<tr>
<td height="30px" style="vertical-align: middle;"><?php echo $this->get_label('demo');?></td>
<td style="vertical-align: middle;" class="notification"><strong><span id="number_demo"></span></strong></td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('decimal place');?></td>
<td><input type="text" name="decimal_place" id="decimal_place" value="<?php echo $decimal_place;?>" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('decimal place');?>" onkeyup="show_number_format()" maxlength="1" /><span class="compulsory">*</span></td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>
 
<tr>
<td><?php echo $this->get_label('thousand separator');?></td>
<td><input type="text" name="thousand_separator" id="thousand_separator" value="<?php echo $thousand_separator;?>" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('thousand separator');?>" onkeyup="show_number_format()" maxlength="1" /><span class="compulsory">*</span></td>
</tr>

<tr><td height="10px" colspan="2"></td></tr>

<tr>
<td><?php echo $this->get_label('decimal separator');?></td>
<td><input type="text" name="decimal_separator" id="decimal_separator" value="<?php echo $decimal_separator;?>" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('decimal separator');?>" onkeyup="show_number_format()" maxlength="1" /><span class="compulsory">*</span></td>
</tr>

<tr><td height="20px" colspan="2"></td></tr>
 
<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="<?php echo $this->get_label('update');?>" class="btn btn-default"></td></tr>
<tr><td colspan="2" height="10px"></td></tr>    
      
      </table>
     
     
  <?php $form4->end(); $this->dispatch("layout/footer");?>  
  <script type="text/javascript">


show_date_demo('<?php echo $cday;?>','<?php echo $cday1;?>','<?php echo $cmonth0;?>','<?php echo $cmonth;?>','<?php echo $cmonth1;?>','<?php echo $cyear;?>','<?php echo $cyear1;?>','<?php echo $chour; ?>','<?php echo $cminute; ?>','<?php echo $csecond; ?>','<?php echo $cformat; ?>');
show_number_format();




function show_number_format()
{

  
    decimal_string="";
	
	decimal_place=$("#decimal_place").val();
	thousand_separator=$("#thousand_separator").val();
	decimal_separator=$("#decimal_separator").val();


   
      
	


    for(i=0;i<decimal_place;i++)
    {
      decimal_string=decimal_string+(i+1);
    }    


    if(decimal_place=="" || decimal_place==0 || decimal_separator=="")
    {
    numberstring=1+thousand_separator+234+thousand_separator+567+thousand_separator+890;
    }
    else
    {        
    numberstring=1+thousand_separator+234+thousand_separator+567+thousand_separator+890+decimal_separator+decimal_string;
    }
	
	$("#number_demo").html(numberstring);


	
}



function show_date_demo(current_day,current_day1,current_month0,current_month,current_month1,current_year,current_year1,chour,cminute,csecond,cformat)
{
separator=$("#separator").val();
tseparator=$("#tseparator").val();
position=$("#dayposition").val();
day=$("#day").val();
month=$("#month").val();
year=$("#year").val();
tformat=$("#tformat").val();

hour1=$("#hour").val();
min1=$("#minute").val();
second1=$("#second").val();


datestring="";


if(day=='d')
datestring_day=current_day;
else if(day=='D')
datestring_day=current_day1;


if(month=='m')
daystring_month=current_month0;
else if(month=='M')
daystring_month=current_month;
else if(month=='Mon')
daystring_month=current_month1;



if(year=='y')
daystring_year=current_year;
else if(year=='Y')
daystring_year=current_year1;


	if(tformat==12)
	{
		if(chour>=12)
		{
			chour=(chour-12);
				if(chour==0)
				{
				chour="00";
				}
			cformat="PM";
		}
	}

        if(chour<10 && chour>0)
	{
	        if(hour1=='HH')
		{
		chour="0"+(chour);
		}
		
	}
        if(hour1=='H' && chour=="00")
        {
        chour="0";
        }



        if(cminute<10 && cminute>0)
	{
	        if(min1=='MM')
		{
		cminute="0"+(cminute);
		}
		
	}
        if(min1=='M' && cminute=="00")
        {
        cminute="0";
        }

	if(csecond<10 && csecond>0)
	{
	         if(second1=='SS')
		 {
		 csecond="0"+(csecond);
		 }
		
	}

        if(second1=='S' && csecond=="00")
	{
	csecond="0";
	}




if(tformat==12)
{
	
daystring_time=" "+chour+tseparator+cminute+tseparator+csecond+" "+cformat;
}
else if(tformat==24)
{
daystring_time=" "+chour+tseparator+cminute+tseparator+csecond;
}


if(position==1)
{
	datestring=datestring_day+separator+daystring_month+separator+daystring_year+daystring_time;
}
else if(position==2)
{
	datestring=daystring_month+separator+datestring_day+separator+daystring_year+daystring_time;
}

$("#date_demo").html(datestring);
	
}






</script>