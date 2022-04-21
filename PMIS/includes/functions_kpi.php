<?php
 function getActDataLevel($aid)
{
   $sql="SELECT *  FROM  maindata where itemid=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

 }
 return $data;
	} 
	
		
function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d H:i:s' ) {
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
	
    while( $current <= $last ) {	
        $dates[] = date($format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
}
function GetResourceDates($aid)
{
 $sql="SELECT min(astart) as minStartDate, max(afinish) as maxEndDate FROM cmpresources WHERE aid=".$aid ." order by aid";
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

 }
 return $data;
}

function GetTotalDays($aid)
{
	$totalNumberDays=0;
	$sql="SELECT min(astart) as minStartDate, max(afinish) as maxEndDate FROM cmpresources WHERE aid=".$aid ." order by aid";
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 while($reportdata=mysql_fetch_array($amountresult))
 {
   $endTimeStamp =strtotime($reportdata['maxEndDate']);
  $startTimeStamp=strtotime($reportdata['minStartDate']);
  $currentTimeStamp=strtotime(date('Y-m-d'));
  $timeDiff = abs($endTimeStamp - $startTimeStamp);
  $numberDays = ceil($timeDiff/86400);
  $numberDays = intval($numberDays);
   $totalNumberDays += $numberDays;
 }

 }
 return $totalNumberDays;
}

function GetlastDate($aid,$rid)
{
	$sql="SELECT max(progress_date) as last_date FROM  p0010_vo2_boq_achievedprogress where aid=".$aid ." AND rid=".$rid;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $last_date=$data["last_date"];
 }
 else
 {
	 $last_date=0;
	}

return $last_date;
	} 
	
function GetlastDateA($aid)
{
	$sql="SELECT max(progress_date) as last_date FROM  p0010_vo2_boq_achievedprogress where aid=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $last_date=$data["last_date"];
 }
 else
 {
	 $last_date=0;
	}

return $last_date;
	} 
/*function GetPlannedDates($aid)
{
	$reportquery ="SELECT min(start_date) as min_start_date, max(end_date) as max_end_date , min(pdate) as min_pdate  FROM `dpm_pdata` 
    WHERE aid=".$aid;
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				$reportdata = mysql_fetch_array($reportresult);
				$min_start_date=$reportdata["min_start_date"];
				$max_end_date=$reportdata["max_end_date"];
				$min_pdate=$reportdata["min_pdate"];
				if($min_start_date>=$min_pdate)
					{
					 $avg_prog=TillTodayProgressActivity($aid, $min_start_date);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_start_date);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
  					 $start=$min_start_date;
					
					}
					else
					{
					 $start=$min_pdate;
					 $avg_prog=TillTodayProgressActivity($aid, $min_pdate);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_pdate);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
					 
					}
					if($numberDays<100)
					{
					$numberDays=$numberDays+1;
					}
				 	$remaining=100-$avg_prog;
					
				 	$one_day_avg=$remaining/($numberDays-1);
					 $dates=array();
				
				$dates= dateRange($start, $max_end_date);
				
				  $i=0;
				foreach( $dates as $values )
				{	
				
				//$current = strtotime($values);
					  $pdate=date('Y-m-d',strtotime($values));
					  $m=date('m',strtotime($pdate));
					  $m=intval($m);
					  $m=$m-1;
				
					$code_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
					 ",".date('d',strtotime($pdate)). ") , ".number_format($avg_prog,2)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
					 $avg_prog +=$one_day_avg;
					 $i++;
				  }
					 
				}
				
	return $code_str;
}*/
function GetActualProgress($aid,$pdate)
{
$reportquery =" select aid,rid,sum(ppqty)as total_pqty, sum(ppqty* `iunitpkr`) as pkrProgAmount, sum(ppqty* `iunitfcurrency`) as usdProgAmount, ifcrate FROM `progress` WHERE aid=".$aid." AND progress_date<='".$pdate."' Group by rid  order by rid asc";
$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
while ($Allpamount = mysql_fetch_array($reportresult)) {
	 $total_pamount=($Allpamount["pkrProgAmount"]+($Allpamount["usdProgAmount"]*$Allpamount["ifcrate"]));
	 $pgrand_total +=$total_pamount;
}
	return $pgrand_total;
}
function getComProgress($aid,$start_date,$end_date)
{
 $reportquery ="SELECT sum(ppqty* `iunitpkr`) as pkrProgAmount, sum(ppqty* `iunitfcurrency`) as usdProgAmount, ifcrate FROM `progress` WHERE aid=".$aid." AND `progress_date` BETWEEN '".$start_date."'AND '".$end_date."'";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
$reportdata = mysql_fetch_array($reportresult);
return $reportdata;
}
function GetActualComProgress($componentid,$subcomponentid,$minStar,$pdate)
{
$reportquery ="SELECT aid, l1,l2, l3 , acode, activity, min(astart) as startDate , max(afinish) as endDate ,sum(iquantity) as total_qty, Sum(iquantity*iunitpkr) as pkrAmount, Sum(iquantity*iunitfcurrency) as usdAmount , sum(iamountokr) as totalpkrAmount,  sum(iamountfcurrency) as totalusdAmount, activity_code, subComponentDetail, b.detail,b.code FROM activities a join  p009_vo2_boq_schedule_level_3 b on(a.l3=b.sh_level3_id) where l1=".$componentid." AND l2=".$subcomponentid ."  Group by l3 order by  activity_code ASC";

$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
while ($reportdata = mysql_fetch_array($reportresult)) {
	 $Allpamount=getComProgress($reportdata['aid'],$minStar,$pdate);
	 $total_pamount=($Allpamount["pkrProgAmount"]+($Allpamount["usdProgAmount"]*$Allpamount["ifcrate"]));
	 $pgrand_total +=$total_pamount;
}
	return $pgrand_total;
}	

function GetPlannedComProgress($componentid,$subcomponentid,$minStar,$pdate)
{
 //$reportquery ="SELECT aid ,min(astart) as startDate , max(afinish) as endDate FROM activities  where l1=".$componentid." AND l2=".$subcomponentid ."  Group by l3 order by  activity_code ASC";
 echo $reportquery ="SELECT a.aid,  min(a.astart) as startDate , max(a.afinish) as endDate, (sum(b.pqty * b.iunitpkr) + sum(b.pqty * 
  b.iunitfcurrency * b.ifcrate)) as totalplannedamount, (sum(c.ppqty * c.iunitpkr) + sum(c.ppqty * 
  c.iunitfcurrency * c.ifcrate)) as totalActualamount FROM activities a inner join cmpresources b   
  inner join progress c on (a.aid = b.aid)  AND (a.aid=c.aid) where a.l1=".$componentid." 
  AND a.l2=".$subcomponentid. " AND b.planned_date BETWEEN '".$minStar."'AND '".$pdate."'";
$reportresult = mysql_query($reportquery);
	$grand_total=0;	
	$reportdata = mysql_fetch_array($reportresult);		
/*while ($reportdata = mysql_fetch_array($reportresult)) {
	  if($minStar>=$reportdata['startDate']&&$pdate<=$reportdata['endDate'])
	  {
	   $Allamount=getResources($reportdata['aid'],$minStar,$pdate);
	   $total_amount=$reportdata['totalplannedamount'];
	
	  }
	   $grand_total += $total_amount;
}*/
	return $reportdata['totalplannedamount'];
}

function GetProgressDates($aid)
{
	
	 $reportquery =" select aid, min(astart) as startDate , max(afinish) as endDate,rid,sum(pqty)as total_pqty, sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `cmpresources` WHERE aid=".$aid."   order by aid asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				$Allamount = mysql_fetch_array($reportresult);
				     $minStart=$Allamount['endDate'];
  					 $maxEnd=$Allamount['startDate'];
				 	 $endTimeStamp =strtotime($maxEnd);
  					 $startTimeStamp=strtotime($minStart);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
				  $total_amount=($Allamount["pkrAmount"]+($Allamount["usdAmount"]*$Allamount["ifcrate"]));
				 $dates=array();
				$dates= dateRange($maxEnd,$minStart);
				
				  $i=0;
				foreach( $dates as $values )
				{	
				
				//$current = strtotime($values);
					  $pdate=date('Y-m-d',strtotime($values));
					  $m=date('m',strtotime($pdate));
					  $m=intval($m);
					  $m=$m-1;
						  $act_amount=GetActualProgress($aid,$pdate);
						  if($total_amount!=0)
						  {
						$act_prog=($act_amount/$total_amount*100);
						  }
						  else
						  {
							  $act_prog=0;
						  }
					$code_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
					 ",".date('d',strtotime($pdate)). ") , ".number_format($act_prog,2)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
					 //$act_prog +=$act_prog;
					 $i++;
				  }
				
	return $code_str;
}

function GetComProgressDates($componentid,$subcomponentid)
{
	
    $reportquery_d ="SELECT aid, l1,l2, l3 , acode, activity, min(astart) as startDate , max(afinish) as endDate FROM activities where l1=".
	$componentid." AND l2=".$subcomponentid;
	$reportresult_d = mysql_query($reportquery_d);
	$reportdata_d = mysql_fetch_array($reportresult_d);
	 $maxEnd=$reportdata_d['endDate'];
	 $minStart=$reportdata_d['startDate'];
	 $endTimeStamp =strtotime($maxEnd);
	 $startTimeStamp=strtotime($minStart);
	 $timeDiff = abs($endTimeStamp - $startTimeStamp);
	 $numberDays = ceil($timeDiff/86400);
	 $numberDays = intval($numberDays);
	
	 $reportquery ="SELECT aid, l1,l2, l3 , acode, activity, min(astart) as startDate , max(afinish) as endDate FROM activities where l1=".
	$componentid." AND l2=".$subcomponentid ."  Group by l3 order by  activity_code ASC";
	
	// $reportquery =" select aid, min(astart) as startDate , max(afinish) as endDate,rid,sum(pqty)as total_pqty, sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `cmpresources` WHERE aid=".$aid."   order by aid asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				while($reportdata = mysql_fetch_array($reportresult))
				{
					 $Allamount=getResources($reportdata['aid'],$reportdata['startDate'],$reportdata['endDate']);
				     
				  $total_amount=($Allamount["pkrAmount"]+($Allamount["usdAmount"]*$Allamount["ifcrate"]));
				  $grand_total +=$total_amount;
				}
				 $dates=array();
				$dates= dateRange($minStart,$maxEnd);
				
				  $i=0;
				foreach( $dates as $values )
				{	
				
				//$current = strtotime($values);
					  $pdate=date('Y-m-d',strtotime($values));
					  $m=date('m',strtotime($pdate));
					  $m=intval($m);
					  $m=$m-1;
				    $act_amount=GetActualComProgress($componentid,$subcomponentid,$minStart,$pdate);
					$act_prog=($act_amount/$grand_total*100);
					$code_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
					 ",".date('d',strtotime($pdate)). ") , ".number_format($act_prog,2)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
					 //$act_prog +=$act_prog;
					 $i++;
				  }
				
	return $code_str;
}

/*function GetComPlannedDates($componentid,$subcomponentid)
{
  $reportquery_d ="SELECT a.aid,  min(a.astart) as startDate , max(a.afinish) as endDate, (sum(b.pqty * b.iunitpkr) + sum(b.pqty * b.iunitfcurrency * b.ifcrate)) as totalplannedamount FROM activities a inner join cmpresources b on (a.aid = b.aid) where a.l1=".$componentid." AND a.l2=".$subcomponentid;
	 $reportresult_d = mysql_query($reportquery_d);
	 $reportdata_d = mysql_fetch_array($reportresult_d);
	 $maxEnd=$reportdata_d['endDate'];
	 $minStart=$reportdata_d['startDate'];
	 $totalplannedamount=$reportdata_d['totalplannedamount'];
	 $endTimeStamp =strtotime($maxEnd);
	 $startTimeStamp=strtotime($minStart);
	 $timeDiff = abs($endTimeStamp - $startTimeStamp);
	 $numberDays = ceil($timeDiff/86400);
	 $numberDays = intval($numberDays);
// Date found

  $reportquery_d11 ="SELECT a.aid, (sum(b.pqty * b.iunitpkr) + sum(b.pqty * b.iunitfcurrency * b.ifcrate)) as plannedamount, min(a.astart) as minStart, max(a.afinish) as maxfinish FROM activities a inner join cmpresources b on (a.aid = b.aid) where a.l1=".$componentid." AND a.l2=".$subcomponentid." group by a.l3";
	 $reportresult_d11 = mysql_query($reportquery_d11);

	while ($pldata = mysql_fetch_array($reportresult_d11)) {
		 $maxEnd11=$pldata['maxfinish'];
		 $minStart11=$pldata['minStart'];
		 $plannedamount11=$pldata['plannedamount'];
		 $endTimeStamp11 =strtotime($maxEnd11);
		 $startTimeStamp11=strtotime($minStart11);
		 $timeDiff11 = abs($endTimeStamp11 - $startTimeStamp11);
		 $numberDays11 = ceil($timeDiff11/86400);
		 $numberDays11 = intval($numberDays11);
		$totalplannedamount;
		$act_amount=GetPlannedComProgress($componentid,$subcomponentid,$pldata['aid'],$minStart11,$maxEnd11);
					$act_prog=($act_amount/$totalplannedamount*100);
					$code_str .="[Date.UTC(".date('Y',strtotime($maxEnd11)). ",".$m.
					 ",".date('d',strtotime($maxEnd11)). ") , ".number_format($act_prog,2)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
	}

}*/

function GetComPlannedDates($componentid,$subcomponentid)
{
  				$reportquery_d ="SELECT a.aid,  min(a.astart) as startDate , max(a.afinish) as endDate, (sum(b.pqty * b.iunitpkr) + sum(b.pqty * 
  b.iunitfcurrency * b.ifcrate)) as totalplannedamount FROM activities a inner join cmpresources b on (a.aid = b.aid) where a.l1=".$componentid." 
  AND a.l2=".$subcomponentid;
	 			$reportresult_d = mysql_query($reportquery_d);
	 			$reportdata_d = mysql_fetch_array($reportresult_d);
	 			$maxEnd=$reportdata_d['endDate'];
	 			$minStart=$reportdata_d['startDate'];
	 			$totalplannedamount=$reportdata_d['totalplannedamount'];
	 			$endTimeStamp =strtotime($maxEnd);
	 			$startTimeStamp=strtotime($minStart);
	 			$timeDiff = abs($endTimeStamp - $startTimeStamp);
	 			$numberDays = ceil($timeDiff/86400);
		 		$numberDays = intval($numberDays);
				// Date found
				$dates=array();
				$dates= dateRange($minStart,$maxEnd);
				$j=0;
				foreach( $dates as $values )
				{	
				$j++;
				    $pdate=date('Y-m-d',strtotime($values));
				    $m=date('m',strtotime($pdate));
				    $m=intval($m);
				    $m=$m-1;
			  		$act_amount=GetPlannedComProgress($componentid,$subcomponentid,$minStart,$pdate);
					if($act_amount!=0&&$totalplannedamount!=0)
					{
					$act_prog=($act_amount/$totalplannedamount*100);
					}
					else
					{
						$act_prog=0;
					}
					$code_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
					 ",".date('d',strtotime($pdate)). ") , ".number_format($act_prog,2)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
					 //$act_prog +=$act_prog;
					 $i++;
				  }
				
	return $code_str;
}
function GetPlannedProgress($aid,$pdate)
{
$reportquery ="Select aid,rid,sum(pqty)as total_pqty, sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `cmpresources` WHERE aid=".$aid." AND planned_date<='".$pdate."' Group by rid  order by rid asc";

$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
while ($Allpamount = mysql_fetch_array($reportresult)) {
	 $total_pamount=($Allpamount["pkrAmount"]+($Allpamount["usdAmount"]*$Allpamount["ifcrate"]));
	 $pgrand_total +=$total_pamount;
}
	return $pgrand_total;
}
function GetPlannedDates($aid)
{
	
	$reportquery =" select aid, min(astart) as startDate , max(afinish) as endDate,rid,sum(pqty)as total_pqty, sum(pqty* `iunitpkr`) as pkrAmount, 
	sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `cmpresources` WHERE aid=".$aid."   order by aid asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				$Allamount = mysql_fetch_array($reportresult);
				     $minStart=$Allamount['endDate'];
  					 $maxEnd=$Allamount['startDate'];
				 	 $endTimeStamp =strtotime($maxEnd);
  					 $startTimeStamp=strtotime($minStart);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
				  $total_amount=($Allamount["pkrAmount"]+($Allamount["usdAmount"]*$Allamount["ifcrate"]));
				 $dates=array();
				$dates= dateRange($maxEnd,$minStart);
				
				  $i=0;
				foreach( $dates as $values )
				{	
				
				//$current = strtotime($values);
					  $pdate=date('Y-m-d',strtotime($values));
					  $m=date('m',strtotime($pdate));
					  $m=intval($m);
					  $m=$m-1;
						  $act_amount=GetPlannedProgress($aid,$pdate);
						  if($total_amount!=0)
						  {
						$act_prog=($act_amount/$total_amount*100);
						  }
						  else
						  {
							  $act_prog=0;
						   }
					$code_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
					 ",".date('d',strtotime($pdate)). ") , ".number_format($act_prog,2)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
					 //$act_prog +=$act_prog;
					 $i++;
				  }
				
	return $code_str;
}
function TillTodayProgressActivity($aid, $rid, $current_date)
{
$avg_prog=0;
$count=0;
$reportquery ="SELECT  sum(ppqty) as ppqty , aid FROM `progress` WHERE aid=".$aid." AND progress_date<='".$current_date."' group by aid order by progress_date";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	$count++;
	if($reportdata["ppqty"]!=0)
	{
	$progress= $reportdata["ppqty"]/$reportdata["qty"]*100;
	$total_progress +=$progress;
	}
}
$avg_prog=$total_progress/$count;
}
else
{
	$avg_prog=0;
	}
return $avg_prog;
}	
function GetPlannedProgressP($aid)
{
	$reportquery ="SELECT rid,min(astart) as min_start_date, max(afinish) as max_end_date , min(progress_date) as min_pdate, max(progress_date) as max_pdate
	  FROM `progress` 
    WHERE aid=".$aid. " Group by rid order by rid";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				$reportdata = mysql_fetch_array($reportresult);
				$min_start_date=$reportdata["min_start_date"];
				$max_end_date=$reportdata["max_end_date"];
				$min_pdate=$reportdata["min_pdate"];
				$max_pdate=$reportdata["max_pdate"];
				$rid=$reportdata["rid"];
				if($min_start_date>=$min_pdate)
					{
					 $avg_prog=TillTodayProgressActivity($aid, $rid,$min_start_date);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_start_date);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
  					 $start=$min_start_date;
					
					}
					else
					{
					 $start=$min_pdate;
					 $avg_prog=TillTodayProgressActivity($aid, $min_pdate);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_pdate);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
					 
					}
					/*if($numberDays<100)
					{
					$numberDays=$numberDays+1;
					}*/
					
				 	$remaining=100-$avg_prog;
					
				 $one_day_avg=$remaining/($numberDays-1);
				 $dates=array();
				 $dates= dateRange($min_pdate, $max_pdate);
				$endTimeStamp =strtotime($max_pdate);
  					 $startTimeStamp=strtotime($min_pdate);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDaysP = ceil($timeDiff/86400);
  					 $numberDaysP = intval($numberDaysP);
				    $avg_prog=$avg_prog+($one_day_avg*($numberDaysP));
					 
				}
				
	return $avg_prog;
}
function TodayProgress($aid,$rid, $current_date)
{
 $reportquery ="SELECT sum(ppqty) as total_today_qty FROM p0010_vo2_boq_achievedprogress WHERE aid=".$aid." AND rid=".$rid." AND progress_date='".$current_date."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_today_qty=$reportdata["total_today_qty"];
}
else
{
	$total_today_qty=0;
}
return $total_today_qty;
}

function TillTodayProgress($aid,$rid,$current_date)
{
$reportquery ="SELECT sum(ppqty) as total_till_today_qty FROM p0010_vo2_boq_achievedprogress WHERE aid=".$aid." AND rid=".$rid." AND progress_date<='".$current_date."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_till_today_qty= $reportdata["total_till_today_qty"];
}
else
{
	$total_till_today_qty=0;
}
return $total_till_today_qty;
}
function TillTodayPlannedProgress($aid,$rid,$current_date)
{
$reportquery ="SELECT sum(pqty) as total_till_today_plan_qty FROM p005_vo2_boq_plannedbudget WHERE aid=".$aid." AND rid=".$rid." AND planned_date<='".$current_date."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_till_today_qty= $reportdata["total_till_today_plan_qty"];
}
else
{
	$total_till_today_qty=0;
}
return $total_till_today_qty;
}
function TillTodayProgressWithoutP($aid,$rid, $current_date)
{
/* $reportquery ="SELECT sum(pqty) as total_till_today_qty_w FROM `dpm_pdata` 
WHERE sa_id=".$sa_id." AND (pdate<>'2015-04-25' AND pdate<='".$current_date."' )";*/

$reportquery ="SELECT sum(ppqty) as total_till_today_qty_w FROM p0010_vo2_boq_achievedprogress WHERE aid=".$aid." AND rid=".$rid." AND progress_date<='".$current_date."' ";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_till_today_qty_w= $reportdata["total_till_today_qty_w"];
}
else
{
	$total_till_today_qty_w=0;
}
return $total_till_today_qty_w;
}

function GetProgressQtys($aid,$rid)
{
	 $reportquery ="SELECT * FROM `p0010_vo2_boq_achievedprogress` WHERE aid=".$aid." AND rid=".$rid." group by rid, progress_date order by rid, progress_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["ppqty"]!=0)
					{
						
					 $till_today_qty=TillTodayProgress($reportdata['aid'],$reportdata['rid'], $reportdata["progress_date"]);
					 $work_done=$till_today_qty;
					}
					else
					{
						$work_done=0;
					}
					if($work_done!=0)
					{
					//$work_done +=$work_done;
					$month=date("m", strtotime($reportdata["progress_date"]));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["progress_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["progress_date"])). ") , ".round($work_done)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 $work_done=0;
					}
				}
				
	return $code_str;
}
function GetPlannedQtys($aid,$rid)
{
	  $reportquery ="SELECT * FROM `p005_vo2_boq_plannedbudget` WHERE aid=".$aid." AND rid=".$rid." group by rid, planned_date order by rid, planned_date ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["pqty"]!=0)
					{
						
					 $till_today_qty=TillTodayPlannedProgress($reportdata['aid'],$reportdata['rid'], $reportdata["planned_date"]);
					 $work_done=$till_today_qty;
					}
					else
					{
						$work_done=0;
					}
					if($work_done!=0)
					{
					//$work_done +=$work_done;
					$month=date("m", strtotime($reportdata["planned_date"]));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["planned_date"])). ",".$month.
					 ",".date('d',strtotime($reportdata["planned_date"])). ") , ".round($work_done)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 $work_done=0;
					}
				}
				
	return $code_str;
}
/*function GetPlannedQtys($aid,$rid)
{

	
	 $reportquery ="SELECT * FROM cmpresources WHERE aid=".$aid." AND rid=".$rid." group by rid, planned_date order by rid";
	
				$reportresult = mysql_query($reportquery);
				
				$ii=0;
				$work_done=0;
					$reportdata = mysql_fetch_array($reportresult);
					 
					 $till_today_qty=TillTodayPlannedProgress($reportdata['aid'],$reportdata['rid'], $reportdata["planned_date"]);
					
					  $endTimeStamp =strtotime($reportdata['afinish']);
					  if($till_today_qty!=0)
					  {
					  
					  $start=$reportdata['planned_date'];
				      $startTimeStamp=strtotime($reportdata['planned_date']);
					  
					  }
					  else
					  {
						  $start=$reportdata['astart'];
						$startTimeStamp=strtotime($reportdata['astart']);
						}
					  $current_date=date('Y-m-d');
					  $currentTimeStamp=strtotime(date('Y-m-d'));
					  $timeDiff = abs($endTimeStamp - $startTimeStamp);
					  $numberDays =ceil($timeDiff/86400);
					  $numberDays = intval($numberDays);
					if($reportdata["pqty"]!=0&&$numberDays!=0)
					{
					$till_today_qty=TillTodayPlannedProgress($reportdata['aid'],$reportdata['rid'], $reportdata["planned_date"]);
					
					if($till_today_qty!=0)
					{
					
					$work_done=$till_today_qty;
					$remaining=($reportdata["pqty"]-$till_today_qty);
					$one_work_done=($reportdata["pqty"]-$till_today_qty)/($numberDays-1);
					}
					else
					{
						if($numberDays<100)
					{
					$numberDays=$numberDays+1;
					}
					$one_work_done=$reportdata["pqty"]/($numberDays);
					$work_done=$one_work_done;
					
					}
					}
					else
					{
						$one_work_done=0;
						$work_done=0;
					}
				
				 $dates=array();
				$dates= dateRange($start, $reportdata['afinish']);
				//print_r($dates);
				  $i=0;
				foreach( $dates as $values )
				{	
				
				//$current = strtotime($values);
					  $pdate=date('Y-m-d',strtotime($values));
					  $m=date('m',strtotime($pdate));
					  $m=intval($m);
					  $m=$m-1;
					  
					 //echo "<br/>";
					//$code_str .="[Date.UTC(".date('Y,m,d',strtotime($pdate.' -1 month')).") , ".round($work_done)." ]";
					$code_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
					 ",".date('d',strtotime($pdate)). ") , ".round($work_done)." ]";
					 if($i<$numberDays)
					 {
					 $code_str .=" , ";
					  
					 }
					 $work_done +=$one_work_done;
					 $i++;
				  }
				
				
	return $code_str;
}*/
function getComponentDetail($s_id)
{
  $sql="SELECT *  FROM  `mis_tbl_3_subcomponents` where s_id=".$s_id ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $cid=$data["cid"];
 }
 else
 {
	 $cid=0;
	}

return $cid;
	} 
	
	
function getFirst_Level($cid)
{
   $sql="SELECT *  FROM  `p009_vo2_boq_schedule_level_1` where sh_level1_id=".$cid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

 }
 return $data;
	} 
	
function getSec_Level($cid,$subcomponentid)
{
   $sql="SELECT *  FROM  `p009_vo2_boq_schedule_level_2` where sh_level1_id=".$cid." AND sh_level2_id=".$subcomponentid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 //$cid=$data["code"]."-".$data["detail"];
 }
 else
 {
	 $cid="";
	}

return $data;
	} 
	
	
function get3rd_Level($cid,$subcomponentid,$milestone_unit)
{
   $sql="SELECT *  FROM  `p009_vo2_boq_schedule_level_3` where sh_level2_id=".$subcomponentid." AND sh_level3_id=".$milestone_unit ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $cid=$data["code"]."-".$data["detail"];
 }
 else
 {
	 $data="";
	}

return $data;
	} 
	
function getMilestoneUnitDetail($cid,$subcomponentid,$aid,$milestone_items)
{
    $sql="SELECT *  FROM  `activities` where l1=".$cid." AND l2=".$subcomponentid." AND aid=".$aid. " AND rid=".$milestone_items ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

 }
 else
 {
	 $data="";
	}

return $data;
	}
	
function getMilestoneDetail($cid,$subcomponentid,$aid)
{
   $sql="SELECT *  FROM  `p006_vo2_sch_activity` where l1=".$cid." AND l2=".$subcomponentid." AND aid=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);

 }
 else
 {
	 $data="";
	}

return $data;
	}
	
function getProjectCommProg($pid,$latest_month)
{
//$latest_month=0;
$latest_achieved=0;
$reportquery ="SELECT a.aid, a.baseline as milestoneBaseline, a.assig, c.pid  FROM mis_tbl_4_milstones a 
inner join mis_tbl_3_subcomponents b on(a.s_id=b.s_id) inner join mis_tbl_2_components c on (c.cid=b.cid) where c.pid=".$pid." Group by c.pid,b.cid,a.s_id,a.aid Order By c.pid";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 //$latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
  $latest_achieved=getLatestMilestoneProgress($reportdata['aid'],$latest_month);
  }
if($latest_achieved!=0&&$reportdata['milestoneBaseline']!=0)
 {
	 $comm_progress+=($latest_achieved/$reportdata['milestoneBaseline'])*($reportdata['assig']/100);
 $latest_achieved=0;
 }
 
}
if($counter!=0)
{
	if($cid==3||$cid==4)
	{
		$res=$comm_progress;
	}
	else
	{
		$res=$comm_progress/$counter;
	}
}
else
{
	$res=0;}
return $res;
}

function getComponentCommProg($cid,$latest_month)
{
//$latest_month=0;
$latest_achieved=0;
$reportquery ="SELECT a.aid, a.baseline as milestoneBaseline, a.assig, b.s_id, b.Sassig FROM mis_tbl_4_milstones a 
inner join mis_tbl_3_subcomponents b on(a.s_id=b.s_id) where b.cid=".$cid." Group by b.cid,a.s_id order by b.cid";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 //$latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
  $latest_achieved=getSubComponentCommProg($reportdata['s_id'],$latest_month);
  }
if($latest_achieved!=0)
 {
 $comm_progress+=($latest_achieved)*($reportdata['Sassig']/100);
 $latest_achieved=0;
 }
 
}
if($comm_progress!=0)
{
	$res=$comm_progress;
}
else
{
	$res=0;
}
return $res;
}	
	
function getSubComponentCommProg($s_id,$latest_month)
{
//$latest_month=0;
$latest_achieved=0;
 $cid=getComponentDetail($s_id);
$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 //$latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
  $latest_achieved=getMilestoneAchieveCC($latest_month,$reportdata['aid']);
  }
if($latest_achieved!=0&&$reportdata['milestoneBaseline']!=0)
 {
$comm_progress+=($latest_achieved/$reportdata['milestoneBaseline'])*($reportdata['assig']/100);
	 // $comm_progress+=($latest_achieved/$reportdata['milestoneBaseline']);
 $latest_achieved=0;
 }
 
}
if($comm_progress!=0)
{
		$res=$comm_progress;
	
}
else
{
	$res=0;}
return $res;
}
function getProjectCommProgC($scid,$kpiid)
{
 $sql="SELECT  weighted_actual as milestone_actual FROM kpidata_result  where scid=".$scid." AND kpiid=".$kpiid." ";
 
 $amountresult = mysql_query($sql);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_actual"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
}
function getComponentCommProgC($lastMonth,$data_level_id,$latest_month)
{

$latest_achieved=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup,z.activitylevel FROM maindata z left outer join kpi_activity a on (z.itemid=a.kpiid) left outer join activity b on (a.activityid=b.aid) left outer join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentcd=".$data_level_id." Group by z.itemid";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 //$latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
  $latest_achieved=getSubComponentCommProgC($lastMonth,$reportdata['itemid'],$latest_month);
  }
if($latest_achieved!=0)
 {
 $comm_progress+=($latest_achieved)*($reportdata['weight']/100);
 $latest_achieved=0;
 }
 
}
if($comm_progress!=0)
{
	$res=$comm_progress;
}
else
{
	$res=0;
}
return $res;
}
function getSubComponentCommProgC($lastMonth,$data_level_id,$latest_month)
{

$latest_achieved=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup, z.activitylevel FROM maindata z inner join kpi_activity a on (z.itemid=a.kpiid) inner join activity b on (a.activityid=b.aid) inner join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentcd=".$data_level_id."  Group by z.itemid";
//$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	$baseline=$reportdata['baseline'];
  if($latest_month!=0)
  {
  $ptodate=getMilestoneTotalAchieveCLatest($latest_month,$reportdata['itemid']);
  }
if($ptodate!=0&&$baseline!=0)
 {
	 $comm_progress+=($ptodate/$baseline)*($reportdata['weight']/100);
 $ptodate=0;
 }
 
}
if($comm_progress!=0)
{
$res=$comm_progress;	
}
else
{
	$res=0;
}
return $res;
}

function getProjectCommTargC($scid,$kpiid)
{

 $sql="SELECT  weighted_planned as milestone_targets FROM kpidata_result  where scid=".$scid." AND kpiid=".$kpiid." ";

 $amountresult = mysql_query($sql);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
}
function getComponentCommTargC($lastMonth,$data_level_id,$latest_month)
{

$latest_target=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup,z.activitylevel FROM maindata z left outer join kpi_activity a on (z.itemid=a.kpiid) left outer join activity b on (a.activityid=b.aid) left outer join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentcd=".$data_level_id." Group by z.itemid";

$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	
if($latest_month!=0)
  {
 $latest_target=getSubComponentCommTargC($lastMonth,$reportdata['itemid'],$latest_month);
  }
	
if($latest_target!=0)
 {
	 $comm_progress+=($latest_target)*($reportdata['weight']/100);
 	 $latest_target=0;
 }
 
}
if($comm_progress!=0)
{
$res=$comm_progress;	
}
else
{
	$res=0;
}
return $res;
}
function getSubComponentCommTargC($lastMonth,$data_level_id,$latest_month)
{

$latest_target=0;
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup, z.activitylevel FROM maindata z inner join kpi_activity a on (z.itemid=a.kpiid) inner join activity b on (a.activityid=b.aid) inner join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentcd=".$data_level_id."  Group by z.itemid";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	$baseline=$reportdata['baseline'];
  if($latest_month!=0)
  {
  $ptodate=getMilestoneTotalTargetsCLatest($latest_month,$reportdata['itemid']);
  }
if($ptodate!=0&&$baseline!=0)
 {
	 $comm_progress+=($ptodate/$baseline)*($reportdata['weight']/100);
 $ptodate=0;
 }
 
}
if($comm_progress!=0)
{
$res=$comm_progress;	
}
else
{
	$res=0;}
return $res;
}
function getProjectCommTarg($pid,$latest_month)
{

$latest_target=0;
 $reportquery ="SELECT a.aid, a.baseline as milestoneBaseline, a.assig, c.pid  FROM mis_tbl_4_milstones a 
inner join mis_tbl_3_subcomponents b on(a.s_id=b.s_id) inner join mis_tbl_2_components c on (c.cid=b.cid) where c.pid=".$pid." Group by c.pid,b.cid,a.s_id,a.aid Order By c.pid";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	$baseline=$reportdata['milestoneBaseline'];
  if($latest_month!=0)
  {
  $ptodate=getLatestMilestonePlanned($latest_month,$reportdata['aid']);
  }
if($ptodate!=0&&$baseline!=0)
 {
	 $comm_progress+=($ptodate/$baseline)*($reportdata['assig']/100);
 $ptodate=0;
 }
 
}
if($counter!=0)
{
	if($cid==3||$cid==4)
	{
		$res=$comm_progress;
	}
	else
	{
		$res=$comm_progress/$counter;
	}
}
else
{
	$res=0;}
return $res;
}
function getComponentCommTarg($cid,$latest_month)
{

$latest_target=0;
$reportquery ="SELECT b.Sassig, a.s_id, a.aid, a.baseline as milestoneBaseline, a.assig FROM mis_tbl_4_milstones a 
inner join mis_tbl_3_subcomponents b on(a.s_id=b.s_id) where b.cid=".$cid." Group by b.cid,a.s_id order by b.cid";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
if($latest_month!=0)
  {
 $latest_target=getSubComponentCommTarg($reportdata['s_id'],$latest_month);
  }
	
if($latest_target!=0)
 {
	 $comm_progress+=($latest_target)*($reportdata['Sassig']/100);
 	 $latest_target=0;
 }
 
}
if($comm_progress!=0)
{
$res=$comm_progress;	
}
else
{
	$res=0;
}
return $res;
}
function getSubComponentCommTarg($s_id,$latest_month)
{

$latest_target=0;
 $cid=getComponentDetail($s_id);
$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	$baseline=$reportdata['milestoneBaseline'];
  if($latest_month!=0)
  {
  $ptodate=getMilestoneTargetsCC($latest_month,$reportdata['aid']);
  }
if($ptodate!=0&&$baseline!=0)
 {
	 $comm_progress+=($ptodate/$baseline)*($reportdata['assig']/100);
 $ptodate=0;
 }
 
}
if($comm_progress!=0)
{
	
		$res=$comm_progress;
	
}
else
{
	$res=0;}
return $res;
}
function getSubComponentCommProgCMonth($s_id,$latest_month)
{

$latest_achieved=0;
 $cid=getComponentDetail($s_id);
$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	$baseline=getMilestoneTotalTargetsC($reportdata['aid']);
  if($latest_month!=0)
  {
  $ptodate=getMilestoneAchieveC($latest_month,$reportdata['aid']);
  }
if($ptodate!=0&&$baseline!=0)
 {
	 $comm_progress+=($ptodate/$baseline)*($reportdata['assig']/100);
 $ptodate=0;
 }
 
}
if($counter!=0)
{
	if($cid==3||$cid==4)
	{
		$res=$comm_progress;
	}
	else
	{
		$res=$comm_progress/$counter;
	}
}
else
{
	$res=0;}
return $res;
}
function getSubComponentPlannedProg($s_id)
{
$latest_month=0;
$latest_achieved=0;
 $cid=getComponentDetail($s_id);
$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 $latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
 $latest_planned=getLatestMilestonePlanned($reportdata['aid'],$latest_month);
  }
if($latest_planned!=0&&$reportdata['milestoneBaseline']!=0)
 {
	 $comm_progress+=($latest_planned/$reportdata['milestoneBaseline'])*($reportdata['assig']/100);
 $latest_planned=0;
 }
 
}
if($counter!=0)
{
	if($cid==3||$cid==4)
	{
		$res=$comm_progress;
	}
	else
	{
		$res=$comm_progress/$counter;
	}
}
else
{
	$res=0;}
return $res;
}
/*function getSubComponentPlannedProg($s_id)
{
$latest_month=0;
$latest_planned=0;
$reportquery ="SELECT aid, baseline as milestoneBaseline, assig FROM mis_tbl_4_milstones where s_id=".$s_id." Group by s_id,aid order by s_id";

$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$counter=mysql_num_rows($reportresult);
}
while ($reportdata = mysql_fetch_array($reportresult)) {
	 $latest_month=getLatestMonth($reportdata['aid']);
  if($latest_month!=0)
  {
 $latest_planned=getLatestMilestonePlanned($reportdata['aid'],$latest_month);
 //echo "<br/>";
  }
if($latest_planned!=0&&$reportdata['milestoneBaseline']!=0)
 {
	  //$comm_progress+=($latest_achieved/$reportdata['milestoneBaseline'])*($reportdata['assig']/100);
	  $latest_planned."-".$reportdata['milestoneBaseline'];
	  //echo "<br/>";
	  if($reportdata['s_id']='1'||$reportdata['s_id']='2' || $reportdata['s_id']='3' || $reportdata['s_id']='4')
	  {
		$assig=1;
		}
		else
		{
		$assig=$reportdata['assig'];
		}
		
	  
	 $comm_progress+=($latest_planned/$reportdata['milestoneBaseline'])*($assig/100);
	//echo "<br/>";
 
 }
 
}
if($counter!=0)
{
$res=$comm_progress/$counter;
}
else
{
	$res=0;}
return $res;
}*/
function getLatestMonth($aid)
{
	$sql="SELECT max(bid) lastest_month FROM  `mis_tbl_5_milestone_targets` where aid=".$aid . " AND achieved<>0";
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $lastest_month=$data["lastest_month"];
 }
 else
 {
	 $lastest_month=0;
	}

return $lastest_month;
	} 
	
function getLatestMilestoneProgress($aid,$bid)
{
	 $sql="SELECT achieved FROM  `mis_tbl_5_milestone_targets` where aid=".$aid. " AND bid=".$bid;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $achieved=$data["achieved"];
 }
 else
 {
	 $achieved=0;
	}

return $achieved;
	} 
function getLatestMilestonePlanned($aid,$bid)
{
	 $sql="SELECT targets FROM  `mis_tbl_5_milestone_targets` where aid=".$aid. " AND bid=".$bid;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $targets=$data["targets"];
 }
 else
 {
	 $targets=0;
	}

return $targets;
	}
function getItemTargets($bid,$sa_id)
{
	$sql="SELECT targets FROM  `test1` where sa_id=".$sa_id." And bid=".$bid;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $targets=$data["targets"];
 }
 else
 {
	 $targets=0;}

return $targets;
	} 

function getItemAchieve($bid,$sa_id)
{
	$sql="SELECT achieved FROM  `test1` where sa_id=".$sa_id." And bid=".$bid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $achieved=$data["achieved"];
}
else
{
$achieved=0;
}

return $achieved;
	} 
	
function getMilestoneTargets($bid,$aid)
{
	$sql="SELECT sum(targets) as milestone_targets FROM  `test1` where aid=".$aid." And bid=".$bid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	} 
	
	
function getMilestoneTargetsCC($bid,$aid)
{
	$sql="SELECT sum(targets) as milestone_targets FROM  `test1` where aid=".$aid." And bid<='".$bid."'";
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	} 
	
	/*function getMilestoneTargetsC($month,$aid)
{
	$sql="select e.mid, e.month, sum(e.quantity) as milestone_targets from (select d.mid, d.month, sum(d.quantity) as quantity from (select c.mid, c.aid, c.rid, b.month, b.quantity from mis_tbl_4_milestone_act2 c inner join (SELECT a.aid, a.rid, left(a.planned_date,7) as month, sum(a.pqty) as quantity FROM `p005_vo2_boq_plannedbudget` a group by a.aid, a.rid, left(a.planned_date,7)) b on (c.aid = b.aid and c.rid = b.rid)) d group by d.mid, d.month) e where e.mid =".$aid." and e.month<='".$month."' order by e.mid, e.month";
	//$sql="SELECT sum(targets) as milestone_targets FROM  `test1` where aid=".$aid." And bid=".$bid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=$data["milestone_targets"];
}
return $milestone_targets;
	} */
	
function getMilestoneTargetsC($month,$aid)
{
	//$sql="select  sum(prquantity) as milestone_targets from milestone_budget where mid =".$aid." and prmonth<='".$month."' order by mid";
	$sql="select  sum(prquantity) as milestone_targets from milestone_budget where mid =".$aid." AND prmonth='".$month."' order by mid, prmonth";
	//$sql="SELECT sum(targets) as milestone_targets FROM  `test1` where aid=".$aid." And bid=".$bid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	} 
	
	
function getMilestoneTargetsCCC($scid,$kpiid)
{
	
$sql="SELECT  sum(kpi_planned) as milestone_targets FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid<=".$scid;
 $amountresult = mysql_query($sql);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	} 
	
	
function getMilestoneTargetsPC($scid,$kpiid)
{
	 
	 
	 $sql="SELECT  sum(kpi_planned) as milestone_targets FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid=".$scid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $milestone_targets=$data["milestone_targets"];
}
else
{
$milestone_targets=0;
}
return $milestone_targets;
	} 
	
function getMilestoneTotalTargetsCLatest($end,$kpiid)
{


 $sql="SELECT  kpi_comm_planned as milestone_targets FROM kpidata_result  where scid<=".$end." AND kpiid=".$kpiid." ";
 $amountresult = mysql_query($sql);

if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $total_milestone_targets=$data["milestone_targets"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
	
function getMilestoneTotalAchieveCLatest($end,$kpiid)
{

	 $sql="SELECT  sum(kpi_actual) as milestone_achieved FROM kpi_base_level_report  where scid<=".$end." AND kpiid=".$kpiid." ";

 $amountresult = mysql_query($sql);

if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $total_milestone_targets=$data["milestone_achieved"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
	
function getMilestoneTotalAchieveCLast($till_end,$kpiid)
{

	 $sql="SELECT  kpi_comm_actual as milestone_achieved FROM kpidata_result  where scid=".$till_end." AND kpiid=".$kpiid." ";
 $amountresult = mysql_query($sql);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $total_milestone_targets=$data["milestone_achieved"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
	
function getMilestoneTotalTargetsCLast($till_end,$kpiid)
{
	

	$sql="SELECT  kpi_comm_planned as milestone_targets FROM kpidata_result  where scid=".$till_end." AND kpiid=".$kpiid." ";
 $amountresult = mysql_query($sql);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $total_milestone_targets=$data["milestone_targets"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 	
function getMilestoneTotalTargetsC($itemid,$lastMonth)
{
$baseline="TGC".$lastMonth;
 $sql="select ".$baseline." as baseline from activity where itemid =".$itemid." order by itemid";
//echo "<br/>";
	//$sql="SELECT sum(targets) as milestone_targets FROM  `test1` where aid=".$aid." And bid=".$bid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
 $total_milestone_targets=$data["baseline"];
}
else
{
$total_milestone_targets=0;
}
return $total_milestone_targets;
	} 
function getMilestoneAchieve($bid,$aid)
{
	$sql="SELECT sum(achieved) as milestone_achieved FROM  `test1` where aid=".$aid." And bid=".$bid;
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
$milestone_achieved=$data["milestone_achieved"];
}
else
{
	$milestone_achieved=0;
}
return $milestone_achieved;
	} 
function getMilestoneAchieveCC($bid,$aid)
{
	$sql="SELECT sum(achieved) as milestone_achieved FROM  `test1` where aid=".$aid." And bid<='".$bid."'";
	 $amountresult = mysql_query($sql);
	//echo $amountsize= mysql_num_rows($amountresult);
	if($amountresult!=0)
	{
	 $data=mysql_fetch_array($amountresult);
	$milestone_achieved=$data["milestone_achieved"];
	}
	else
	{
		$milestone_achieved=0;
	}
return $milestone_achieved;
	} 	
	
/*function getMilestoneAchieveC($month,$aid)
{
	$sql="select e.mid, e.month, sum(e.quantity) as milestone_achieved from (select d.mid, d.month, sum(d.quantity) as quantity from (select c.mid, c.aid, c.rid, b.month, b.quantity from mis_tbl_4_milestone_act2 c inner join (SELECT a.aid, a.rid, left(a.progress_date,7) as month, sum(a.ppqty) as quantity FROM `p0010_vo2_boq_achievedprogress` a group by a.aid, a.rid, left(a.progress_date,7)) b on (c.aid = b.aid and c.rid = b.rid)) d group by d.mid, d.month) e where e.mid =".$aid." and e.month<='".$month."' order by e.mid, e.month";
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
$milestone_achieved=$data["milestone_achieved"];
}
else
{
	$milestone_achieved=0;
}
return $milestone_achieved;
	} */
	
	
function getMilestoneAchieveC($month,$aid)
{

 $sql="select  sum(prquantity) as milestone_achieved from milestone_progress where mid =".$aid." and prmonth='".$month."' order by mid";
 $amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
$milestone_achieved=$data["milestone_achieved"];
}
else
{
	$milestone_achieved=0;
}
return $milestone_achieved;
	} 
	
	
function getMilestoneAchieveCCC($scid,$kpiid)
{

	
	 $sql="SELECT  sum(kpi_actual) as milestone_achieved FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid<=".$scid;
	
 	$amountresult = mysql_query($sql);
	if($amountresult!=0)
	{
	 $data=mysql_fetch_array($amountresult);
	$milestone_achieved=$data["milestone_achieved"];
	}
	else
	{
		$milestone_achieved=0;
	}
return $milestone_achieved;
	} 
	
	
function getMilestoneAchievePC($scid,$kpiid)
{

	$sql="SELECT  sum(kpi_actual) as milestone_achieved FROM kpi_base_level_report  where kpiid=".$kpiid." AND scid=".$scid;
 	$amountresult = mysql_query($sql);
//echo $amountsize= mysql_num_rows($amountresult);
if($amountresult!=0)
{
 $data=mysql_fetch_array($amountresult);
$milestone_achieved=$data["milestone_achieved"];
}
else
{
	$milestone_achieved=0;
}
return $milestone_achieved;
	} 
	
function getResources($aid,$start_date,$end_date)
{
 $reportquery ="SELECT sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `cmpresources` WHERE aid=".$aid." AND `planned_date` BETWEEN '".$start_date."'AND '".$end_date."'";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
$reportdata = mysql_fetch_array($reportresult);
//echo "heloo"."<br/>";
return $reportdata;
}
function getResourceDetail($aid,$rid,$start_date,$end_date)
{
 $reportquery ="SELECT rid,sum(pqty)as total_pqty, sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `cmpresources` WHERE aid=".$aid." AND rid=".$rid." AND `planned_date` BETWEEN '".$start_date."'AND '".$end_date."'";
//echo $reportquery ="SELECT `p005_vo2_boq_plannedbudget`.`aid` , `p005_vo2_boq_plannedbudget`.`rid` , `p006_vo2_sch_activity`.`acode` , `p006_vo2_sch_activity`.`activity` , SUM(`p005_vo2_boq_plannedbudget`.`pqty`) as total_pqty ,p005_vo2_boq_plannedbudget.`planned_date` FROM `mis_t4hp`.`p005_vo2_boq_plannedbudget` JOIN `mis_t4hp`.`p006_vo2_sch_activity` ON (`p005_vo2_boq_plannedbudget`.`aid` = `p006_vo2_sch_activity`.`aid`) where rid=".$rid." AND p006_vo2_sch_activity.aid=".$aid." AND p005_vo2_boq_plannedbudget.`planned_date` BETWEEN '".$start_date."'AND '".$end_date."'";
//echo "<br/>";
$reportresult = mysql_query($reportquery);
if($reportresult!=""&&$reportresult!=0)
{
$counter=mysql_num_rows($reportresult);
}
else
{
	$counter=0;
}
if($reportresult!=""&&$reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
}
return $reportdata;
}
function getProgress($aid,$start_date,$end_date)
{
$reportquery ="SELECT sum(ppqty* `iunitpkr`) as pkrProgAmount, sum(ppqty* `iunitfcurrency`) as usdProgAmount, ifcrate FROM `progress` WHERE aid=".$aid." AND `progress_date` BETWEEN '".$start_date."'AND '".$end_date."'";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
$reportdata = mysql_fetch_array($reportresult);
return $reportdata;
}

function getProgressDetail($aid,$rid,$start_date,$end_date)
{
 $reportquery ="SELECT rid,sum(ppqty)as total_ppqty, sum(ppqty* `iunitpkr`) as pkrProgAmount, sum(ppqty* `iunitfcurrency`) as usdProgAmount, ifcrate
FROM `progress` WHERE aid=".$aid." AND rid=".$rid." AND `progress_date` BETWEEN '".$start_date."'AND '".$end_date."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=""&&$reportresult!=0)
{
$counter=mysql_num_rows($reportresult);
}
else
{
	$counter=0;}
if($reportresult!=""&&$reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
}
return $reportdata;
}

function CheckResources($aid)
{
$reportquery ="SELECT * from `p007_vo2_sch_res_assign` WHERE aid=".$aid;
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$counter=mysql_num_rows($reportresult);
}
else
{
	$counter=0;
}
//$reportdata = mysql_fetch_array($reportresult);
return $counter;
}

function GetMonthID($scmonth)
{
	$reportquery ="SELECT bid from mis_tbl_6_progressmonth WHERE bdate LIKE '%".$scmonth."%'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$bid=$reportdata["bid"];
}
else
{
	$bid=0;
}
return $bid;
}
	?>