<?php
function checkEntryLevel($aid)
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
		
function GetDates($aid)
{
	 $sql="SELECT min(startdate) as minStartDate, max(enddate) as maxEndDate FROM activity WHERE itemid=".$aid ." order by aid";
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {

 $data=mysql_fetch_array($amountresult);

 }
 return $data;
}	
	
function GetTotalDays($aid)
{
	$totalNumberDays=0;
	 $sql="SELECT * FROM activity WHERE itemid=".$aid ." order by aid";
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
 while($reportdata=mysql_fetch_array($amountresult))
 {
  $endTimeStamp =strtotime($reportdata['enddate']);
  $startTimeStamp=strtotime($reportdata['startdate']);
  $currentTimeStamp=strtotime(date('Y-m-d'));
  $timeDiff = abs($endTimeStamp - $startTimeStamp);
  $numberDays = ceil($timeDiff/86400);
  $numberDays = intval($numberDays);
   $totalNumberDays += $numberDays;
 }

 }
 return $totalNumberDays;
}
function CalculateActualPlannedDays($enddate,$startdate)
{
$reportquery ="SELECT count(pd_date) as total_planned_days FROM project_days WHERE pd_status=1 AND pd_date>='".$startdate."'". " AND pd_date<='".$enddate."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_planned_days=$reportdata["total_planned_days"];
}
else
{
	$total_planned_days=0;
}
return $total_planned_days;
}
function CalculateElapsedDays($enddate,$startdate)
{
$reportquery ="SELECT count(pd_date) as total_planned_days FROM project_days WHERE pd_status=1 AND pd_date>='".$startdate."'". " AND pd_date<='".$enddate."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_planned_days=$reportdata["total_planned_days"];
}
else
{
	$total_planned_days=0;
}
return $total_planned_days;
}

function GetlastDate($aid)
{
	$sql="SELECT max(progressdate) as last_date FROM  progress where itemid=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $actual_finish_date=$data["last_date"];
 $fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
 }
 else
 {
	 $actual_finish_date=0;
	}

return $actual_finish_date;
	} 	
	
function ActualStartDate($aid)
{
$reportquery ="SELECT min(progressdate) as actual_start_date FROM progress WHERE itemid=".$aid;
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$actual_start_date= $reportdata["actual_start_date"];
}
else
{
	$actual_start_date="";
}
return $actual_start_date;
}	
function TodayProgress($aid, $current_date)
{
 $reportquery ="SELECT sum(progressqty) as total_today_qty FROM progress WHERE itemid=".$aid." AND progressdate='".$current_date."'";
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
function ActualProgress($aid)
{
$reportquery ="SELECT sum(progressqty) as total_till_today_qty FROM progress WHERE itemid=".$aid;
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
	
function ActualFinishDate($aid)
{
$reportquery ="SELECT max(progressdate) as actual_finish_date FROM progress WHERE progressqty<>0 AND itemid=".$aid;
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$actual_finish_date= $reportdata["actual_finish_date"];
$fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
}
else
{
	$actual_finish_date="";
}
return $actual_finish_date;
}	
	
function ActualDays($start,$end,$aid)
{
 $reportquery ="SELECT count(progressdate) as actual_days FROM progress WHERE itemid=".$aid. " AND progressdate>='".$start."' AND progressdate<='".$end."' AND progressqty<>0";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$actual_days= $reportdata["actual_days"];
}
else
{
	$actual_days="";
}
return $actual_days;
}
	
function PlannedProgress($aid,$current_date,$planned_start_date)
{
$reportquery ="SELECT sum(budgetqty) as total_planned_qty FROM planned WHERE itemid=".$aid. " AND budgetdate>='".$planned_start_date."' AND budgetdate<='".$current_date."' ";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_planned_qty= $reportdata["total_planned_qty"];
}
else
{
	$total_planned_qty=0;
}
return $total_planned_qty;
}	
function ActualProgressBase($aid,$actual_start_date,$rid)
{
$lastMonth=date('Y-m-d',strtotime($actual_start_date));
	 $m=date('m',strtotime($lastMonth));
	 $y=date('Y',strtotime($lastMonth));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $actual_start_date=$y."-".$m."-".$days;
   $actual_start_date = str_replace("-","",$actual_start_date);	
$reportquery ="SELECT `ACC".$actual_start_date."` as total_till_today_qty FROM mildata WHERE itemid=".$aid. " AND rid=".$rid;


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
function PlannedProgressBase($aid,$planned_date,$rid)
{
	$lastMonth=date('Y-m-d',strtotime($planned_date));
	 $m=date('m',strtotime($lastMonth));
	 $y=date('Y',strtotime($lastMonth));
	 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
	 $planned_date=$y."-".$m."-".$days;
    $planned_date = str_replace("-","",$planned_date);
   $reportquery ="SELECT `TGC".$planned_date."` as total_planned_qty FROM mildata WHERE itemid=".$aid. " AND rid=".$rid;
 
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);

 $total_planned_qty= $reportdata["total_planned_qty"];

}
else
{
	$total_planned_qty=0;
}
return $total_planned_qty;
}
function PlannedProgressG($aid,$planned_start_date)
{
 $reportquery ="SELECT sum(budgetqty) as total_planned_qty FROM planned WHERE itemid=".$aid. " AND budgetdate<='".$planned_start_date."'";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);

 $total_planned_qty= $reportdata["total_planned_qty"];

}
else
{
	$total_planned_qty=0;
}
return $total_planned_qty;
}

function ActualProgressG($aid,$actual_start_date)
{
	
$reportquery ="SELECT sum(progressqty) as total_till_today_qty FROM progress WHERE itemid=".$aid. " AND progressdate<='".$actual_start_date."'";

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
function GetlastDateActivity($aid)
{
	$sql="SELECT max(b.progressdate) as last_date from maindata a inner join progress b on(a.itemid=b.itemid) where a.parentcd=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $actual_finish_date=$data["last_date"];
 $fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
 }
 else
 {
	 $actual_finish_date=0;
 }

return $actual_finish_date;
	} 
function GetlastDateOutput($parentgroup)
{
$sql="select max(progressdate) as last_date from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $actual_finish_date=$data["last_date"];
 $fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
 }
 else
 {
	 $actual_finish_date=0;
 }

return $actual_finish_date;
	} 
function ActualStartDateOutput($parentgroup)
{
$sql="select min(progressdate) as actual_start_date from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $actual_start_date=$data["actual_start_date"];
 $fmonth= date('m',strtotime($actual_start_date));
		$fyear= date('Y',strtotime($actual_start_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_start_date=$fyear."-".$fmonth."-".$fmonth_days;
 }
 else
 {
	 $actual_start_date=0;
 }

return $actual_start_date;
	} 

function ActualProgressActivity($aid)
{
	$reportquery="SELECT sum(progressqty) as total_till_today_qty FROM maindata a inner join progress b on(a.itemid=b.itemid) where a.parentcd=".
	$aid ;
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
	
function ActualFinishDateActivity($aid)
{
 $reportquery="SELECT max(b.progressdate) as actual_finish_date from maindata a inner join progress b on(a.itemid=b.itemid) where a.itemid=".$aid ;
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$actual_finish_date= $reportdata["actual_finish_date"];
$fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
}
else
{
	$actual_finish_date="";
}
return $actual_finish_date;
}

function PlannedProgressActivity($aid,$current_date,$planned_start_date)
{
	$reportquery="SELECT sum(b.budgetqty) as total_planned_qty FROM maindata a inner join planned b on(a.itemid=b.itemid) where a.parentcd=".
	$aid.  " AND b.budgetdate>='".$planned_start_date."' AND b.budgetdate<='".$current_date."' "; ;

$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$total_planned_qty= $reportdata["total_planned_qty"];
}
else
{
	$total_planned_qty=0;
}
return $total_planned_qty;
}
function ActualProgressOutput($parentgroup)
{
/*$reportquery="select sum(progressqty) as total_till_today_qty from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;*/
$actual_prog_perc=0;
$actual_prog=0;
$total_actual_prog=0;
$reportquery="select sum(c.progressqty) as total_till_today_qty ,c.itemid,c.progressdate from progress c where  itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b) GROUP BY c.itemid";

$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	$wgt_query="select weight from maindata where itemid=".$reportdata["itemid"];
	$wqtresult = mysql_query($wgt_query);
	$wgtdata= mysql_fetch_array($wqtresult);
	$weight=$wgtdata["weight"];
	$bs_query="select baseline from activity where itemid=".$reportdata["itemid"];
	$bsresult = mysql_query($bs_query);
	$basedata= mysql_fetch_array($bsresult);
	$baseline=$basedata["baseline"];
	$total_till_today_qty= $reportdata["total_till_today_qty"];
	//$planned_prog=($total_planned_qty/$baseline)*$weight;
	$actual_prog=($total_till_today_qty);
	//echo "<br/>";
	$total_actual_prog +=$actual_prog;
}
$actual_prog_perc=$total_actual_prog;
}
else
{
	$actual_prog_perc=0;
}
return $actual_prog_perc;
}
function PlannedProgressOutput($parentgroup,$current_date,$planned_start_date)
{
	
	/*echo $reportquery="select sum(budgetqty) as total_planned_qty from planned where budgetdate>='".$planned_start_date."' AND budgetdate<='".$current_date."' "." AND itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;*/
	$planned_prog=0;
	$total_planned_prog=0;
	$reportquery="select sum(c.budgetqty) as total_planned_qty ,c.itemid,c.budgetdate from planned c where budgetdate>='".$planned_start_date."' AND budgetdate<='".$current_date."' "." AND itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b) GROUP BY c.itemid";
	
	

$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	$wgt_query="select weight from maindata where itemid=".$reportdata["itemid"];
	$wqtresult = mysql_query($wgt_query);
	$wgtdata= mysql_fetch_array($wqtresult);
	$weight=$wgtdata["weight"];
	$bs_query="select baseline from activity where itemid=".$reportdata["itemid"];
	$bsresult = mysql_query($bs_query);
	$basedata= mysql_fetch_array($bsresult);
	$baseline=$basedata["baseline"];
	$total_planned_qty= $reportdata["total_planned_qty"];
	$planned_prog=($total_planned_qty);
	$total_planned_prog +=$planned_prog;
}
 $planned_prog_perc=$total_planned_prog;
}
else
{
	$planned_prog_perc=0;
}
return $planned_prog_perc;
}

function ActualFinishDateOutput($parentgroup)
{
$reportquery="Select max(progressdate) as actual_finish_date  from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$parentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);
$actual_finish_date= $reportdata["actual_finish_date"];
$fmonth= date('m',strtotime($actual_finish_date));
		$fyear= date('Y',strtotime($actual_finish_date));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
}
else
{
	$actual_finish_date="";
}
return $actual_finish_date;
}

function GetProgressQtysDataLevel($aid)
{
	
	$reportquery ="SELECT * FROM progress WHERE itemid=".$aid." group by itemid, progressdate order by itemid,progressdate ASC";
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
			$actual_finish_date=$reportdata["progressdate"];
 			$fmonth= date('m',strtotime($actual_finish_date));
			$fyear= date('Y',strtotime($actual_finish_date));
			$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
			$actual_finish_date=$fyear."-".$fmonth."-".$fmonth_days;
 
					
					$ii++;
					if($reportdata["progressqty"]!=0)
					{
					$till_today_qty=$reportdata["progressqty"];
					$work_done=$till_today_qty;
					}
					else
					{
						$work_done=0;
					}
					if($work_done!=0)
					{
					//$work_done +=$work_done;
					$month=date("m", strtotime($actual_finish_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($actual_finish_date)). ",".$month.
					 ",".date('d',strtotime($actual_finish_date)). ") , ".round($work_done)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 $work_done=0;
					}
				}
				
	return $code_str;
}
function GetNextLevel($itemid)
{
	 $reportquery ="SELECT * from maindata where parentcd=".$itemid;
	$reportresult = mysql_query($reportquery);
	while ($reportdata = mysql_fetch_array($reportresult)) {
		$i++;
		$parent_group=$reportdata["parentgroup"];
		$act_name=$reportdata["itemname"];
	    $isentry=$reportdata["isentry"];
		if($isentry==1)
		{
			$reportquery_sub ="SELECT * from maindata where parentcd=".$reportdata["itemid"];
			$reportresult_sub = mysql_query($reportquery_sub);
			$reportdata_sub = mysql_fetch_array($reportresult_sub);
			return $itemid;
		}
		else
		{
			GetNextLevel($reportdata["itemid"]);
		}
	}
}
function GetPlannedQtysDataLevel($aid,$current_date,$planned_start_date)
{
	//$reportquery ="SELECT * FROM `dpm_pdata` WHERE aid=".$aid." AND sa_id=".$sa_id." group by sa_id, pdate order by sa_id,pdate ASC";
 $reportquery ="SELECT * FROM planned WHERE itemid=".$aid. "  group by itemid, budgetdate order by itemid,budgetdate ASC";
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["budgetqty"]!=0)
					{
					$till_today_qty=$reportdata["budgetqty"];
					$work_done=$till_today_qty;
					}
					else
					{
						$work_done=0;
					}
					if($work_done!=0)
					{
					//$work_done +=$work_done;
					$month=date("m", strtotime($reportdata["budgetdate"]));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["budgetdate"])). ",".$month.
					 ",".date('d',strtotime($reportdata["budgetdate"])). ") , ".round($work_done)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 $work_done=0;
					}
				}
				
	return $code_str;
}
function GetPlannedQtysSubActLevel($aparentgroup,$aweight,$afactor)
{
	
	
	// Get Plan Scale
/*	$scale_query="SELECT min(startdate) as startdate , max(enddate) as enddate FROM activity a inner join maindata b on(a.itemid=b.itemid) WHERE 
	b.parentcd=".$aid;*/
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $scale_datef=$vyear.$vmonth.$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd 
					  ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $planned_progress=PlannedProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						  
						   $planned_perc=$planned_progress/$reportdata["baseline"]*$afactor*100;
						   $total_planned_perc +=$planned_perc;
						   
					}
					$planned +=$total_planned_perc;
					
					if($planned!=0 && $planned!=""&& $planned!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				 // $planned=0; 
			  }
					
					
	return $code_str;
}
function GetWeight($itemid)
{
	$reportquery_act ="SELECT * from maindata where itemid=".$itemid;
	$reportresult_act = mysql_query($reportquery_act);
	$reportdata_act = mysql_fetch_array($reportresult_act);
	return $reportdata_act["weight"];
}
function GetFactor($itemid)
{
	$reportquery_act ="SELECT * from maindata where itemid=".$itemid;
	$reportresult_act = mysql_query($reportquery_act);
	$reportdata_act = mysql_fetch_array($reportresult_act);
	return $reportdata_act["factor"];
}
function GetParentWeight($itemid)
{
	$reportquery_act ="SELECT weight as pweight from maindata where itemid=(SELECT parentcd from maindata where itemid=".$itemid. " )";
	$reportresult_act = mysql_query($reportquery_act);
	$reportdata_act = mysql_fetch_array($reportresult_act);
	return $reportdata_act["pweight"];
}
function GetParentGroup($itemid)
{
	$reportquery_act ="SELECT parentgroup as parentgroup from maindata where itemid=(SELECT parentcd from maindata where itemid=".$itemid. " )";
	$reportresult_act = mysql_query($reportquery_act);
	$reportdata_act = mysql_fetch_array($reportresult_act);
	return $reportdata_act["parentgroup"];
}
function GetMainParentWeight($parentgroup)
{
	$reportquery_act ="SELECT weight as mweight FROM maindata where parentgroup= '".$parentgroup."' GROUP BY activitylevel, parentcd";
	$reportresult_act = mysql_query($reportquery_act);
	$reportdata_act = mysql_fetch_array($reportresult_act);
	return $reportdata_act["mweight"];
}
function GetActualQtysSubActLevel($aparentgroup,$aweight,$afactor)
{
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);

	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $scale_datef=$vyear.$vmonth.$vmonth_days;
					
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd 
					  ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $actual_progress=ActualProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						  //  $item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress/$reportdata["baseline"]*$afactor*100;
						   $total_actual_perc +=$actual_perc;
						   
					}
					 $actual +=$total_actual_perc;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				 // $actual=0; 
			  }
					
					
	return $code_str;
}

function GetPlannedQtysMainActLevel($aparentgroup,$aweight,$afactor)
{
	
	
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date,$reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					   $scale_datef=$vyear.$vmonth.$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd 
					  ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						 $planned_progress=PlannedProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						  $item_factor=GetFactor($reportdata['itemid']);
						  $planned_perc=$planned_progress/$reportdata["baseline"]*$afactor;
						  $total_planned_perc +=$planned_perc;
						   
					}
					 $planned +=$total_planned_perc;
				// echo "<br/>";
					if($planned!=0 && $planned!=""&& $planned!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				  //$planned=0; 
			  }
		 $code_str;		
					
	return $code_str;
}


function GetActualQtysMainActLevel($aparentgroup,$aweight,$afactor)
{
	// Get Plan Scale
$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)" ;
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $scale_datef=$vyear.$vmonth.$vmonth_days;
				      
					
					   $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid ,a.rid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $actual_progress=ActualProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						    //$item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress/$reportdata["baseline"]*$afactor;
						 
						   $total_actual_perc +=$actual_perc;
						   
					}
					 $actual +=$total_actual_perc;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				  //$actual=0; 
			  }
					
					
	return $code_str;
}

function GetPlannedQtysOutputLevel($aparentgroup,$aweight)
{
	
	
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
			    $num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $scale_datef=$vyear.$vmonth.$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd 
					  ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						  $planned_progress=PlannedProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						  
						  //$item_factor=GetFactor($reportdata['itemid']);
						  $planned_perc=$planned_progress;
						  $total_planned_perc +=$planned_perc;
						   
					}
					 $planned +=$total_planned_perc;
				    // echo "<br/>";
					if($planned!=0 && $planned!=""&& $planned!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				 // $planned=0; 
			  }
		 $code_str;		
					
	return $code_str;
}
function GetActualQtysOutputLevelG($aparentgroup,$aweight)
{

	// Get Plan Scale
/*$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)";*/
$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	 $till_today_qty=ActualProgressOutput($aparentgroup);
					
					
	return $till_today_qty;
}
function  GetPlannedQtysOutputLevelG($aparentgroup)
{

$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline, itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
	 $last_date=GetlastDate($reportdata_scale['itemid']);
  	$start_date=$syear."-".$smonth."-01";
	$planned_progress=PlannedProgressOutput($reportdata_act["parentgroup"],$last_date,$reportdata_scale['startdate']);
					
					
	return $planned_progress;
}
function GetActualQtysOutputLevel($aparentgroup,$aweight)
{

	// Get Plan Scale
$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
				      $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
					  $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
				      $scale_datef=$vyear.$vmonth.$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $actual_progress=ActualProgressBase($reportdata['itemid'],$scale_datef,$reportdata['rid']);
						   //$item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress;
						   $total_actual_perc +=$actual_perc;
						   
					}
					
					$actual +=$total_actual_perc;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				 // $actual=0; 
			  }
					
					
	return $code_str;
}
function GetPlannedQtysOutcomeLevel($aparentgroup,$aweight)
{
	
	
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '000010_000011%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
			    $num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					$reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN(SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					 
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						  $planned_progress=PlannedProgressBase($reportdata['itemid'],$scale_date,$reportdata['rid']);
						  
						 // $item_factor=GetFactor($reportdata['itemid']);
						  if($reportdata["baseline"]!=0&&$reportdata["baseline"]!="")
						  {
						  $planned_perc=$planned_progress;
						  }
						  else
						  {
							   $planned_perc=0;
						  }
						  $total_planned_perc +=$planned_perc;
						   
					}
					 $planned +=$total_planned_perc;
				    // echo "<br/>";
					if($planned!=0 && $planned!=""&& $planned!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				 // $planned=0; 
			  }
		 $code_str;		
					
	return $code_str;
}
function GetPlannedQtysOutcomeLevelH($aparentgroup,$aweight)
{
	
	
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
			    $num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					$reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN(SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					 
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						  $planned_progress=PlannedProgressBase($reportdata['itemid'],$scale_date,$reportdata['rid']);
						  
						  $item_factor=GetFactor($reportdata['itemid']);
						  if($reportdata["baseline"]!=0&&$reportdata["baseline"]!="")
						  {
						  $planned_perc=$planned_progress/$reportdata["baseline"]*$item_factor;
						  }
						  else
						  {
							   $planned_perc=0;
						  }
						  $total_planned_perc +=$planned_perc;
						   
					}
					 $planned +=$total_planned_perc*100;
				    // echo "<br/>";
					if($planned!=0 && $planned!=""&& $planned!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				 // $planned=0; 
			  }
		 $code_str;		
					
	return $code_str;
}

function GetActualQtysOutcomeLevel($aparentgroup,$aweight)
{

	// Get Plan Scale
$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
				      $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					 
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $actual_progress=ActualProgressBase($reportdata['itemid'],$scale_date,$reportdata['rid']);
						  // $item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress;
						   $total_actual_perc +=$actual_perc;
						   
					}
					
					$actual +=$total_actual_perc;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				 // $actual=0; 
			  }
					
					
	return $code_str;
}
function GetActualQtysOutcomeLevelH($aparentgroup,$aweight)
{

	// Get Plan Scale
 $scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '000010_000011%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
				      $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
					 
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $actual_progress=ActualProgressBase($reportdata['itemid'],$scale_date,$reportdata['rid']);
						   $item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress/$reportdata["baseline"]*$item_factor;
						   $total_actual_perc +=$actual_perc;
						   
					}
					
					$actual +=$total_actual_perc*100;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				 // $actual=0; 
			  }
					
					
	return $code_str;
}
function GetPlannedQtysPDOLevel($aparentgroup,$aweight)
{
	
	
	// Get Plan Scale
	$scale_query ="Select min(b.startdate) as startdate , max(b.enddate) as enddate, sum(b.baseline) as baseline from (select a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
			    $num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				  $total_planned_perc=0;
				  $planned_perc=0;
				  $planned=0;
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd 
					  ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						  $planned_progress=PlannedProgressBase($reportdata['itemid'],$scale_date,$reportdata['rid']);
						  
						  $item_factor=GetFactor($reportdata['itemid']);
						  if($reportdata["baseline"]!=0&&$reportdata["baseline"]!="")
						  {
						  $planned_perc=$planned_progress/$reportdata["baseline"]*$item_factor;
						  }
						  else
						  {
							   $planned_perc=0;
						  }
						  $total_planned_perc +=$planned_perc;
						   
					}
					 $planned +=$total_planned_perc*100;
				    // echo "<br/>";
					if($planned!=0 && $planned!=""&& $planned!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($planned)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_planned_perc=0;
				  $planned_perc=0;
				 // $planned=0; 
			  }
		 $code_str;		
					
	return $code_str;
}
function GetActualQtysPDOLevel($aparentgroup,$aweight)
{

	// Get Plan Scale
$scale_query="Select max(progressdate) as enddate , min(progressdate) as startdate from progress where itemid IN (select b.itemid from (select 
a.startdate, a.enddate, a.baseline ,a.itemid From activity a where itemid IN (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup.
"%' AND isentry=1 GROUP BY activitylevel, parentcd ORDER BY maindata.activitylevel)) b)";
	$reportresult_scale = mysql_query($scale_query);
	$reportdata_scale=mysql_fetch_array($reportresult_scale);
	$smonth= date('m',strtotime($reportdata_scale['startdate']));
  	$syear= date('Y',strtotime($reportdata_scale['startdate']));
  	$start_date=$syear."-".$smonth."-01";
	// END Plan Scale
	 $dates=array();
				$dates= dateRange($start_date, $reportdata_scale['enddate']);
				$num=sizeof($dates);
				//print_r($dates);
				  $ii=0;
				 $total_actual_perc=0;
				  $actual_perc=0;
				  $actual=0; 
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
				      $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear."-".$vmonth."-".$vmonth_days;
					  $reportquery ="Select * from (select a.startdate, a.enddate, a.baseline ,a.itemid, a.rid From activity a where itemid IN 
					  (SELECT itemid FROM maindata WHERE parentgroup LIKE '".$aparentgroup."%' AND isentry=1 GROUP BY activitylevel, parentcd 
					  ORDER BY maindata.activitylevel)) b";
					  $reportresult = mysql_query($reportquery);			
					  while ($reportdata = mysql_fetch_array($reportresult)) {
						
						   $actual_progress=ActualProgressBase($reportdata['itemid'],$scale_date,$reportdata['rid']);
						   $item_factor=GetFactor($reportdata['itemid']);
						   $actual_perc=$actual_progress/$reportdata["baseline"]*$item_factor;
						   $total_actual_perc +=$actual_perc;
						   
					}
					
					$actual +=$total_actual_perc*100;
				
					if($actual!=0 && $actual!=""&& $actual!=NULL)
					{
					
					$month=date("m", strtotime($scale_date));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($scale_date)). ",".$month.
					 ",".date('d',strtotime($scale_date)). ") , ".round($actual)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					
					
					}
					
				   $total_actual_perc=0;
				  $actual_perc=0;
				 // $actual=0; 
			  }
					
					
	return $code_str;
}
	//////////////////////////////END FUNCTIONS/////////////////

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
$milestone_targets=$data["milestone_targets"];
}
return $milestone_targets;
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
	
function getResources($aid,$start_date,$end_date)
{
$reportquery ="SELECT sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `resources` WHERE aid=".$aid." AND `planned_date` BETWEEN '".$start_date."'AND '".$end_date."'";
$reportresult = mysql_query($reportquery);
$counter=mysql_num_rows($reportresult);
$reportdata = mysql_fetch_array($reportresult);
return $reportdata;
}
function getResourceDetail($aid,$rid,$start_date,$end_date)
{
$reportquery ="SELECT rid,sum(pqty)as total_pqty, sum(pqty* `iunitpkr`) as pkrAmount, sum(pqty* `iunitfcurrency`) as usdAmount, ifcrate FROM `resources` WHERE aid=".$aid." AND rid=".$rid." AND `planned_date` BETWEEN '".$start_date."'AND '".$end_date."'";
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
$reportquery ="SELECT rid,sum(ppqty* `iunitpkr`) as pkrProgAmount, sum(ppqty* `iunitfcurrency`) as usdProgAmount, ifcrate 
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



function TillTodayProgress($sa_id, $current_date)
{
$reportquery ="SELECT sum(pqty) as total_till_today_qty FROM `dpm_pdata` WHERE sa_id=".$sa_id." AND pdate<='".$current_date."'";
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
function TillTodayProgressActivity($aid, $current_date,$countsub)
{
$avg_prog=0;
 $count=$countsub;
$reportquery ="SELECT  sum(pqty) as pqty , qty, sa_id FROM `dpm_pdata` WHERE aid=".$aid." AND pdate<='".$current_date."' group by sa_id order by pdate";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	//$count++;
	if($reportdata["qty"]!=0)
	{
	$progress= $reportdata["pqty"]/$reportdata["qty"]*100;
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
function TillTodayPlannedActivity($aid, $current_date,$countsub)
{
$avg_prog=0;
/* $reportqueryc ="SELECT count(sa_id) as scount FROM dpm_data where aid=".$aid." order by  act_id ASC";
				$reportresultc = mysql_query($reportqueryc);
				$reportdatac = mysql_fetch_array($reportresultc);*/
				
 //$count=$reportdatac["scount"];
 $count=$countsub;
$reportquery ="SELECT  sum(bqty) as bqty , qty, sa_id FROM `dpm_bdata` WHERE aid=".$aid." AND bdate<='".$current_date."' group by sa_id order by bdate";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	//$count++;
	if($reportdata["qty"]!=0)
	{
	$progress= $reportdata["bqty"]/$reportdata["qty"]*100;
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
function TillTodayPlannedSubActivity($sa_id,$current_date)
{
$avg_prog=0;
$count=$countsub;
$reportquery ="SELECT  sum(bqty) as bqty , qty, sa_id FROM `dpm_bdata` WHERE sa_id=".$sa_id." AND bdate<='".$current_date."' group by sa_id order by bdate";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
$reportdata = mysql_fetch_array($reportresult);

	$progress=$reportdata["bqty"];

}
else
{
	$progress=0;
	}
return $progress;
}
function TillTodayProgressActivityRate($aid, $current_date)
{
$avg_prog=0;
$count=0;
$reportquery ="SELECT  sum(pqty) as pqty , qty, sa_id FROM `dpm_pdata` WHERE aid=".$aid." AND pdate<='".$current_date."' AND pdate<>'".'2015-04-25'."'  group by sa_id order by pdate";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	$count++;
	if($reportdata["qty"]!=0)
	{
	$progress= $reportdata["pqty"]/$reportdata["qty"]*100;
	$total_progress +=$progress;
	}
}
if($count!=0&&$count!="")
{
$avg_prog=$total_progress/$count;
}
else
{
	$avg_prog=0;
}
}
else
{
	$avg_prog=0;
	}
return $avg_prog;
}
function TillTodayProgressActivityMain($current_date)
{
$avg_prog=0;
$count=0;
$reportquery ="SELECT  sum(pqty) as pqty , qty, sa_id FROM `dpm_pdata` WHERE  pdate<='".$current_date."' group by sa_id order by pdate";
$reportresult = mysql_query($reportquery);
if($reportresult!=0)
{
while($reportdata = mysql_fetch_array($reportresult))
{
	$count++;
	if($reportdata["qty"]!=0)
	{
	$progress= $reportdata["pqty"]/$reportdata["qty"]*100;
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

function GetProgressQtys($aid,$sa_id)
{
	$reportquery ="SELECT * FROM `dpm_pdata` WHERE aid=".$aid." AND sa_id=".$sa_id." group by sa_id, pdate order by sa_id,pdate ASC";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["qty"]!=0)
					{
					$till_today_qty=TillTodayProgress($reportdata['sa_id'], $reportdata["pdate"]);
					$work_done=$till_today_qty;
					}
					else
					{
						$work_done=0;
					}
					if($work_done!=0)
					{
					//$work_done +=$work_done;
					$month=date("m", strtotime($reportdata["pdate"]));
					
					$month=$month-1;
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["pdate"])). ",".$month.
					 ",".date('d',strtotime($reportdata["pdate"])). ") , ".round($work_done)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 $work_done=0;
					}
				}
				
	return $code_str;
}
 function dateRange($first, $last, $step = '+1 month', $format = 'Y-m-d H:i:s' ) {
    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);
	
    while( $current <= $last ) {	
        $dates[] = date($format, $current);
        $current = strtotime($step, $current);
    }
    return $dates;
}
function GetPlannedQtys($aid,$sa_id)
{
//	echo $reportquery ="SELECT `pid`, `aid` , `acode`, `adetail`, `sa_id`,`code`,`detail`,`start_date`,`end_date`, `qty`,`rate`,`sdetail`,`pqty`, `pdate` , max(pdate) as maxPdate FROM `dpm_pdata` WHERE aid=".$aid." AND sa_id=".$sa_id." group by sa_id, pdate order by sa_id";
	
	 $reportquery ="SELECT * FROM `dpm_pdata` WHERE aid=".$aid." AND sa_id=".$sa_id." group by sa_id, pdate order by sa_id";
	
				$reportresult = mysql_query($reportquery);
				
				$ii=0;
				$work_done=0;
					$reportdata = mysql_fetch_array($reportresult);
					 
					 $till_today_qty=TillTodayProgress($reportdata['sa_id'], $reportdata["pdate"]);
					
					  $endTimeStamp =strtotime($reportdata['end_date']);
					  if($till_today_qty!=0)
					  {
					  
					  $start=$reportdata['pdate'];
				      $startTimeStamp=strtotime($reportdata['pdate']);
					  
					  }
					  else
					  {
						  $start=$reportdata['start_date'];
						$startTimeStamp=strtotime($reportdata['start_date']);
						}
					  $current_date=date('Y-m-d');
					  $currentTimeStamp=strtotime(date('Y-m-d'));
					  $timeDiff = abs($endTimeStamp - $startTimeStamp);
					  $numberDays =ceil($timeDiff/86400);
					  $numberDays = intval($numberDays);
					if($reportdata["qty"]!=0&&$numberDays!=0)
					{
					//$till_today_qty=TillTodayProgress($reportdata['sa_id'], $reportdata["pdate"]);
					
					if($till_today_qty!=0)
					{
					
					$work_done=$till_today_qty;
					$remaining=($reportdata["qty"]-$till_today_qty);
					$one_work_done=($reportdata["qty"]-$till_today_qty)/($numberDays-1);
					}
					else
					{
						if($numberDays<100)
					{
					$numberDays=$numberDays+1;
					}
					$one_work_done=$reportdata["qty"]/($numberDays);
					$work_done=$one_work_done;
					
					}
					}
					else
					{
						$one_work_done=0;
						$work_done=0;
					}
				
				 $dates=array();
				$dates= dateRange($start, $reportdata['end_date']);
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
}
function GetPlannedQtysNew($aid,$sa_id)
{
	$reportquery ="SELECT sum(bqty) as bqty, bdate FROM `dpm_bdata` WHERE aid=".$aid." AND sa_id=".$sa_id." group by sa_id, bdate order by bdate asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
				
					 $avg_prog +=$reportdata["bqty"];
					
					$month=date("m", strtotime($reportdata["bdate"]));
					
					$month=$month-1;
					
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["bdate"])). ",".$month.
					 ",".date('d',strtotime($reportdata["bdate"])). ") , ".$avg_prog." ]";
					
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 
				}
				
				//echo $list;
	return $code_str;
}
function GetPlannedDatesNew($aid,$countsub)
{
	$reportquery ="SELECT * FROM `dpm_bdata` WHERE aid=".$aid."  group by sa_id,  MONTH(bdate) order by bdate asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["qty"]!=0)
					{
					 $avg_prog=TillTodayPlannedActivity($aid, $reportdata["bdate"],$countsub);
				     //$avg_prog +=$avg_prog;
					//echo "<br/>";
					
					}
					else
					{
						$avg_prog=0;
					}
					$month=date("m", strtotime($reportdata["bdate"]));
					
					$month=$month-1;
					
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["bdate"])). ",".$month.
					 ",".date('d',strtotime($reportdata["bdate"])). ") , ".number_format($avg_prog,2)." ]";
					/* if($reportdata["pdate"]=='2015-05-31')
					 {
					 echo $code_str;
					 echo "</br></br>";
					
					 }*/
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 
				}
				
				//echo $list;
	return $code_str;
}
function GetProgressDates($aid,$countsub)
{
	$reportquery ="SELECT * FROM `dpm_pdata` WHERE aid=".$aid."  group by sa_id, MONTH(pdate) order by pdate asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["qty"]!=0)
					{
					 $avg_prog=TillTodayProgressActivity($aid, $reportdata["pdate"],$countsub);
				     //$avg_prog +=$avg_prog;
					//echo "<br/>";
					
					}
					else
					{
						$avg_prog=0;
					}
					$month=date("m", strtotime($reportdata["pdate"]));
					
					$month=$month-1;
					
					 $code_str .="[Date.UTC(".date('Y',strtotime($reportdata["pdate"])). ",".$month.
					 ",".date('d',strtotime($reportdata["pdate"])). ") , ".number_format($avg_prog,2)." ]";
					/* if($reportdata["pdate"]=='2015-05-31')
					 {
					 echo $code_str;
					 echo "</br></br>";
					
					 }*/
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 
				}
				
				//echo $list;
	return $code_str;
}
function GetProgressRate($aid)
{
	$reportquery ="SELECT * FROM `dpm_pdata` WHERE aid=".$aid."  group by 
	pdate order by pdate asc";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					if($reportdata["qty"]!=0)
					{
						
							
					 $avg_prog=TillTodayProgressActivityRate($aid, $reportdata["pdate"]);
				
						
					//echo $avg_prog +=$avg_prog;
					//echo "<br/>";
					
					}
					else
					{
						$avg_prog=0;
					}
					
					 $avg_prog_rate=$avg_prog/$num;
				}
				
	return $avg_prog_rate;
}
function GetMainProgressDates($max_date)
{
	$reportquery ="SELECT aid , min(start_date) as min_start, max(end_date) as max_end , max(pdate) as max_pdate 
	FROM `dpm_pdata` where pdate<='".$max_date."' group by pdate";
	
				$reportresult = mysql_query($reportquery);
				if($reportresult!=0)
				{
				$num=mysql_num_rows($reportresult);
				}
				$ii=0;
				$work_done=0;
				$avg_prog=0;
				while ($reportdata = mysql_fetch_array($reportresult)) {
					
					$ii++;
					
					 $avg_prog=TillTodayProgressActivityMain($reportdata["max_pdate"]);
					
					$code_str .="[Date.UTC(".date('Y',strtotime($reportdata["max_pdate"])). ",".date('m',strtotime($reportdata["max_pdate"].' -1 months')).
					 ",".date('d',strtotime($reportdata["max_pdate"])). ") , ".number_format($avg_prog,2)." ]";
					 if($ii<$num)
					 {
					 $code_str .=" , ";
					  
					 }
					 
				}
				
	return $code_str;
}
function GetPlannedDates($aid,$countsub)
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
					 $avg_prog=TillTodayProgressActivity($aid, $min_start_date,$countsub);
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
					 $avg_prog=TillTodayProgressActivity($aid, $min_pdate,$countsub);
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
}
function GetPlannedProgressP($aid,$countsub)
{
	$reportquery ="SELECT min(start_date) as min_start_date, max(end_date) as max_end_date , min(bdate) as min_bdate, max(bdate) as max_bdate
	  FROM `dpm_bdata` 
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
				$min_bdate=$reportdata["min_bdate"];
				$max_bdate=$reportdata["max_bdate"];
				if($min_start_date>=$min_bdate)
					{
					 $avg_prog=TillTodayPlannedActivity($aid, $min_start_date,$countsub);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_start_date);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
  					 $start=$min_start_date;
					
					}
					else
					{
					 $start=$min_bdate;
					 $avg_prog=TillTodayProgressActivity($aid, $min_bdate,$countsub);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_bdate);
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
				 $dates= dateRange($min_bdate, $max_bdate);
				$endTimeStamp =strtotime($max_pdate);
  					 $startTimeStamp=strtotime($min_pdate);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDaysP = ceil($timeDiff/86400);
  					 $numberDaysP = intval($numberDaysP);
				    $avg_prog=$avg_prog+($one_day_avg*($numberDaysP));
					 
				}
				
	return $avg_prog;
}
function GetPlannedProgressRate($aid,$countsub)
{
	$reportquery ="SELECT min(start_date) as min_start_date, max(end_date) as max_end_date , min(pdate) as min_pdate, max(pdate) as max_pdate
	  FROM `dpm_pdata` 
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
				$max_pdate=$reportdata["max_pdate"];
				if($min_start_date>=$min_pdate)
					{
					 $avg_prog=TillTodayProgressActivity($aid, $min_start_date,$countsub);
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
					 $avg_prog=TillTodayProgressActivity($aid, $min_pdate,$countsub);
					 $endTimeStamp =strtotime($max_end_date);
  					 $startTimeStamp=strtotime($min_pdate);
 					 $timeDiff = abs($endTimeStamp - $startTimeStamp);
  					 $numberDays = ceil($timeDiff/86400);
  					 $numberDays = intval($numberDays);
					 
					}
					$current_date=$min_pdate;
					$currentTimeStamp=strtotime($current_date);
					$startTimeStamp=strtotime($max_pdate);
					if($current_date>=$min_start_date)
					 {
						 if($current_date>=$max_pdate)
						 {
							 $numberDaysElapsed=$numberDays;
						 }
						 else
						 {
						  $timeElapsedDiff= abs($currentTimeStamp - $startTimeStamp);
						  $numberDaysElapsed = ceil($timeElapsedDiff/86400);
						  $numberDaysElapsed = intval($numberDaysElapsed);
						 }
					  
					 }
					 else
					 {
						 $time_elapsed_percent=0;
						 $numberDaysElapsed=0;
					}
					/*if($numberDays<100)
					{
					$numberDays=$numberDays+1;
					}*/
					
				 	$remaining=100-$avg_prog;
					 $numberDaysElapsed;
					$remaining_days=$numberDays-$numberDaysElapsed;
				 $one_day_avg=$remaining/($remaining_days);
				 
					 
				}
				
	return $one_day_avg;
}
function GetMainPlannedDates()
{
	$reportquery ="SELECT min(start_date) as min_start_date, max(end_date) as max_end_date , min(pdate) as min_pdate  FROM `dpm_pdata` 
    group by pdate";
	//"SELECT aid , min(start_date) as min_start, max(end_date) as max_end , max(pdate) as max_pdate FROM `dpm_pdata` group by pdate";
	
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
					 $avg_prog=TillTodayProgressActivityMain($min_start_date);
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
					 $avg_prog=$avg_prog=TillTodayProgressActivityMain($min_pdate);
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
}
	
function GetMinDate($aid)
{
	$sql="SELECT min(start_date) as min_date FROM  `dpm_data` where aid=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $min_date=$data["min_date"];
 }
 else
 {
	 $min_date=0;
	}

return $min_date;
	}
	
function GetMaxDateP($aid)
{
	$sql="SELECT max(end_date) as maxx_date FROM  `dpm_data` where aid=".$aid ;
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $max_date=$data["maxx_date"];
 }
 else
 {
	 $max_date=0;
 }

return $max_date;
	}
function getSubActCount($aid)
{
	 $reportqueryc ="SELECT count(sa_id) as scount FROM dpm_data where aid=".$aid." order by  act_id ASC";
				$reportresultc = mysql_query($reportqueryc);
				$reportdatac = mysql_fetch_array($reportresultc);
				
 //$count=$reportdatac["scount"];
 $count=$reportdatac["scount"];
 return $count;
}	 
function GetMaxDate()
{
	$sql="SELECT max(pdate) as max_date FROM  `dpm_progress` ";
 $amountresult = mysql_query($sql);
 if($amountresult!=0)
 {
//echo $amountsize= mysql_num_rows($amountresult);
 $data=mysql_fetch_array($amountresult);
 $last_date=$data["max_date"];
 }
 else
 {
	 $last_date=0;
	}

return $last_date;
	} 
	?>