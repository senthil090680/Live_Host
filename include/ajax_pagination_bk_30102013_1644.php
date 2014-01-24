<?php
//FUNCTION TO CHECK IF THE VALUE OF THE ARRAY IS EMPTY STARTS HERE
function is_array_empty($arr){
  if(is_array($arr)){     
      foreach($arr AS $key => $value) {
          if(!empty($value) || $value != NULL || $value != ""){
              return true;
              break;//stop the process we have seen that at least 1 of the array has value so its not empty
          }
      }
      return false;
  }
}

//FUNCTION TO CHECK IF THE VALUE OF THE ARRAY IS EMPTY ENDS HERE

function debugerr($val) {
	echo "<pre>";
	print_r($val);
	echo "</pre>";
}
function pre($val) {
	echo "<pre>";
	print_r($val);
	echo "</pre>";
}

function get_months($date1, $date2) {
   $time1  = strtotime($date1);
   $time2  = strtotime($date2);
   $my     = date('mY', $time2);

	$monthval		=	ltrim(date('m', $time1),0);
	$months			=	array($monthval);

   while($time1 < $time2) {
      $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
      if(date('mY', $time1) != $my && ($time1 < $time2))
		$monthval		=	ltrim(date('m', $time1),0);
		$months[] = $monthval;
		 
   }

	$monthval		=	ltrim(date('m', $time2),0);
	$months[]		=	$monthval;
	return $months;
}

function get_years($date1, $date2) {
   $time1  = strtotime($date1);
   $time2  = strtotime($date2);
   $my     = date('mY', $time2);

	$yearval		=	date('Y', $time1);
	$years			=	array($yearval);

   while($time1 < $time2) {
      $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
      if(date('mY', $time1) != $my && ($time1 < $time2))
		$yearval		=	date('Y', $time1);
		$years[]		=	$yearval;
		 
   }

	$yearval		=	date('Y', $time2);
	$years[]		=	$yearval;
	return $years;
}

function subval_sort($a,$subkey,$dir) {
    foreach($a as $k=>$v) {
            $b[$k] = strtolower($v[$subkey]);
    }
    $dir($b);
    foreach($b as $key=>$val) {
            $c[] = $a[$key];
    }
    return $c;
}
function array_multi_sort($val, $on1,$on2, $order=SORT_ASC) {
	foreach($val as $key=>$value){
		$one_way_fares[$key] = $value[$on2];
		$return_fares[$key] = $value[$on1];
	}
	array_multisort($return_fares,$order,$one_way_fares,$order,$val);
	return $val;
}

function rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,$js_function_name) { // For Vehicle Stock Ajax pagination 
	if($Num_Pages>=2)
	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:$js_function_name('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:$js_function_name('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:$js_function_name('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:$js_function_name('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:$js_function_name('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}


function rend_cusvisitajaxpagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) { // For Vehicle Stock Ajax pagination 
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_cusvisitajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_cusvisitajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_cusvisitajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_cusvisitajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_cusvisitajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}

function rend_salcolajaxpagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) { // For Vehicle Stock Ajax pagination 
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_salcolajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_salcolajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_salcolajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_salcolajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_salcolajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}
function rend_vehstockajaxpagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) { // For Vehicle Stock Ajax pagination 
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_vehstockajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_vehstockajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_vehstockajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_vehstockajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_vehstockajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}

function rend_devbatchajaxpagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) { // For Device Transactions Ajax pagination Line Items 
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_devbatchajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_devbatchajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_devbatchajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_devbatchajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_devbatchajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}


function rendering_devajaxlineitempagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) { // For Device Transactions Ajax pagination Line Items 
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_devlineitemajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_devlineitemajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_devlineitemajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_devlineitemajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_devlineitemajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}

function rendering_devajaxpagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params)  // For Device Transactions Ajax pagination first display
{
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_devajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_devajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_devajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_devajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_devajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}

function rendering_pagination($Num_Pages,$Page,$Prev_Page,$Next_Page,$params)  // for stock status first display
{
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pagination_ajax('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pagination_ajax('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pagination_ajax('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pagination_ajax('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pagination_ajax('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}


function rend_pag_stock($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) // for stock status second popup
{
	if($Num_Pages>=2)

	{

		if($Page==1)

		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";

		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_ajax_stosta('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_ajax_stosta('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_ajax_stosta('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_ajax_stosta('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_ajax_stosta('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}

function rend_cust_confirm($Num_Pages,$Page,$Prev_Page,$Next_Page,$params) // for stock status second popup
{
	if($Num_Pages>=2)
	{
		if($Page==1)
		{
			echo "<span class='blink' >First</span>&nbsp;&nbsp;";

			echo "<span class='blink' >&lt;&lt;</span>&nbsp;&nbsp;";
		} 

		if($Page!=1)

		{
			echo "<a href=\"JavaScript:pag_ajax_cuscon('1','$params')\" class='blink'>First</a>&nbsp;&nbsp;";

			echo "<a href=\"JavaScript:pag_ajax_cuscon('$Prev_Page','$params')\" class='blink'>&lt;&lt;</a>&nbsp;&nbsp;";

		}

		$min_links=$Page;
		
		if($Num_Pages<10) 
		{
			$num_link_per=$Num_Pages;
		}
		else
		{
			$num_link_per=10;
		}
		
		if($Page>=10)
		{
				$min_links=round($Page-($num_link_per/2));
				$max_links=$Page+($num_link_per/2);	
		}
		else
		{
			$min_links=1;
			$max_links=10;
		}
		
		if($max_links>$Num_Pages)
		{
			$min_links=round($Num_Pages-$num_link_per);
			$max_links=$Num_Pages;
		}
		if($min_links<=0)
		{
			$min_links=1;
		}
		
		for($i=$min_links; $i<=$max_links; $i++)
		{

			if($i != $Page)

			{

				echo "<a href=\"JavaScript:pag_ajax_cuscon('$i','$params')\" class='blink'>$i</a>&nbsp;&nbsp;";

			}

			else

			{

				echo "<span class='blink'>$i</span>&nbsp;&nbsp;";

			}

		}

		if($Page!=$Num_Pages)

		{

			echo "<a href=\"JavaScript:pag_ajax_cuscon('$Next_Page','$params')\" class='blink'>&gt;&gt;</a>&nbsp;&nbsp";

			echo "<a href=\"JavaScript:pag_ajax_cuscon('$Num_Pages','$params')\" class='blink'>Last</a>";

		}

		if($Page==$Num_Pages)

		{
			echo "<span class='blink' >&gt;&gt;</span>&nbsp;&nbsp;";

			echo "<span class='blink' >Last</span>";

		}

	}
}
function getdsrval($DSR_Code,$resfieldname,$qrycolname){ // TO GET DSR ID, DESCRIPTION & CODE
	$sel_dsrid			=	"SELECT $resfieldname from dsr WHERE $qrycolname = '$DSR_Code'";
	$res_dsrid			=	mysql_query($sel_dsrid) or die(mysql_error());
	$rowcnt_dsrid	=	mysql_num_rows($res_dsrid);		
	if($rowcnt_dsrid > 0){
		$row_dsrid	=	mysql_fetch_array($res_dsrid);
		return $dsrid		=	$row_dsrid[$resfieldname];
	}
}
function getdeviceval($device_code,$resfieldname,$qrycolname) { //TO GET DEVICE ID, DESCRIPTION & CODE
	$query_devid				=	"SELECT $resfieldname FROM device_master WHERE $qrycolname = '$device_code'";			
	$res_devid					=	mysql_query($query_devid) or die(mysql_error());
	$row_devid					=	mysql_fetch_array($res_devid);
	return $row_devid[$resfieldname];
}

function getrouteval($route_code,$resfieldname,$qrycolname) { //TO GET ROUTE ID, DESCRIPTION & CODE
	$query_routeid				=	"SELECT $resfieldname FROM route_master WHERE $qrycolname = '$route_code'";			
	$res_routeid				=	mysql_query($query_routeid) or die(mysql_error());
	$row_routeid				=	mysql_fetch_array($res_routeid);
	$route_desc					=	$row_routeid['route_desc'];
	return $route_id			=	$row_routeid[$resfieldname];
}
function getlocationval($location,$resfieldname,$qrycolname) {  //TO GET LOCATION & ID
	$query_locid				=	"SELECT $resfieldname FROM location WHERE $qrycolname = '$location'";			
	$res_locid					=	mysql_query($query_locid) or die(mysql_error());
	$row_locid					=	mysql_fetch_array($res_locid);
	return $location			=	$row_locid[$resfieldname];
}
function getvehicleval($vehicle_code,$resfieldname,$qrycolname) { //TO GET VEHICLE ID, DESCRIPTION & CODE
	$query_vehid				=	"SELECT $resfieldname FROM vehicle_master WHERE $qrycolname = '$vehicle_code'";			
	$res_vehid					=	mysql_query($query_vehid) or die(mysql_error());
	$row_vehid					=	mysql_fetch_array($res_vehid);
	return $vehicle				=	$row_vehid[$resfieldname];
}
function getproductval($productval,$resfieldname,$qrycolname) { //TO GET VEHICLE ID, DESCRIPTION & CODE
	$query_vehid				=	"SELECT $resfieldname FROM product WHERE $qrycolname = '$productval'";			
	$res_vehid					=	mysql_query($query_vehid) or die(mysql_error());
	$row_vehid					=	mysql_fetch_array($res_vehid);
	return $vehicle				=	$row_vehid[$resfieldname];
}
function getKDval($qryval,$resfieldname,$qrycolname) { //TO GET VEHICLE ID, DESCRIPTION & CODE
	$query_KD				=	"SELECT $resfieldname FROM kd WHERE $qrycolname = '$qryval'";			
	$res_KD					=	mysql_query($query_KD) or die(mysql_error());
	$row_KD					=	mysql_fetch_array($res_KD);
	return $KD				=	$row_KD[$resfieldname];
}
function getdbval($qryval,$resfieldname,$qrycolname,$tablename) { //PARAMETERS ARE TABLE QUERY COLUMN VALUE, TABLE RESULT COLUMN, TABLE QUERY COLUMN NAME, TABLE NAME
	$query_KD				=	"SELECT $resfieldname FROM $tablename WHERE $qrycolname = '$qryval'";			
	$res_KD					=	mysql_query($query_KD) or die(mysql_error());
	$row_KD					=	mysql_fetch_array($res_KD);
	return $KD				=	$row_KD[$resfieldname];
}
function upperstate($caseval) {
	return ucwords(strtolower($caseval));
}

function findSR($wherefordsr,$asmcodecol) {

	$query_dsr							=   "SELECT id FROM asm_sp $wherefordsr $asmcodecol";

	$res_dsr							=   mysql_query($query_dsr);

	while($row_dsr						=   mysql_fetch_assoc($res_dsr)) {
		$dsrid_dsr[]					=	$row_dsr["id"];
	}
	 
	$dsrid_dsr							=	array_unique($dsrid_dsr);
	$dsrid_Total						=	implode("','",$dsrid_dsr);

	$asmcodeid							=	"WHERE ASM IN ('".$dsrid_Total."')";

	$query_SR							=	"select id,DSRName,DSR_Code FROM dsr $asmcodeid";
	$res_SR 							=	mysql_query($query_SR) or die(mysql_error());
	$rowcnt_SR 							=	mysql_num_rows($res_SR);
	if($rowcnt_SR	> 0) {
		while($row_SR					=	mysql_fetch_array($res_SR)) {
			$Complete_DSR_Code[] 		=	$row_SR[DSR_Code];
		}
		//debugerr($Complete_DSR_Code);
		$DSR_Codeuni					=	array_unique($Complete_DSR_Code);
		//debugerr($DSR_Codeuni);
		$DSR_Codestr					=	implode("','",$DSR_Codeuni);
	}
	return $DSR_Codestr;
}

function finddbval($qryval,$resval,$qrycol,$tblname) {  // searching with multiple values for single column and getting result in multiple values for single column
	$query_find						=   "SELECT $resval FROM $tblname WHERE $qrycol IN  $qryval";
	$res_find						=   mysql_query($query_find);
	while($row_find					=   mysql_fetch_assoc($res_find)) {
		$find_res[]					=	$row_find[$resval];
	}
	$find_res						=	array_unique($find_res);
	$find_res_Total					=	implode("','",$find_res);

	return $find_res_Total;
}

function getdbstr($resval,$tblname) {  // searching with multiple values for single column and getting result in multiple values for single column
	$query_find						=   "SELECT $resval FROM $tblname";
	$res_find						=   mysql_query($query_find);
	while($row_find					=   mysql_fetch_assoc($res_find)) {
		$find_res[]					=	$row_find[$resval];
	}
	$find_res						=	array_unique($find_res);
	$find_res_Total					=	implode("','",$find_res);

	return $find_res_Total;
}

function findCustomerCount($routestr,$DSR_Code) {
	$query_dsr							=   "SELECT id FROM customer WHERE route IN ('".$routestr."') AND DSR_Code = '$DSR_Code'";
	$res_dsr							=   mysql_query($query_dsr);
	return $rowcnt_dsr					=   mysql_num_rows($res_dsr);
}
function multi_array_sum($next,$elementname) {  //FIRST PARAMETER IS ARRAY, SECOND PARAMETER IS ELEMENT THAT VALUE NEEDS TO BE SUMMED UP
   $total		=	'';
   foreach($next AS $nextVal) {
	   $total += $nextVal[$elementname];	   
   }
   return $total;
}
function compareDeepValue($val1, $val2)
{
   return strcmp($val1['value'], $val2['value']);
}
function myfunction_tosearch_arrayvalue($arraytosearch, $search_value,$search_key,$return_val) {  // THIS FUNCTION SEARCHES A VALUE IN A MULTIDIMENSIONAL ARRAY, FIRST PARAMETER IS SEARCHING ARRAY, SECOND PARAMETER IS SEARCHING VALUE, THIRD PARAMETER IS SEARCHING KEY, FOURTH PARAMETER IS RETURNING KEY
   foreach($arraytosearch as $key => $arraytosearch_val) {
      if ($arraytosearch_val[$search_key] === $search_value)
         return $arraytosearch_val[$return_val];
   }
   return false;
}
?>