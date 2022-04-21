<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  		= new Database( );
$objDb1  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($process_flag==0 ) {
header("Location: index.php?init=3");
}
@require_once("get_url.php");
$tSQL="TRUNCATE planned";
$objDb1->execute($tSQL);
$eSqls = "Select aid from activity ";
  $objDb -> query($eSqls);
  
	$iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		//cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear)
		$aid 	= $objDb->getField($i,aid);

//echo $sSQL='SELECT CONCAT(YEAR(pd_date),"-",if(length(MONTH (pd_date))=1,concat("0",MONTH(pd_date)),MONTH(pd_date)),"-01") as pl_date FROM activity';
// echo "<br/><br/><br/>";


 $sSQL = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty) select d.itemid, d.rid, d.pl_date,d.planned_qty from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as pl_date, count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) a ,(select count(LAST_DAY(CONCAT(YEAR(pd_date),"-",IF(LENGTH(MONTH(pd_date))=1,CONCAT("0",MONTH(pd_date)),MONTH(pd_date)),"-01"))) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01")) as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by LAST_DAY(CONCAT(YEAR(aa.pd_date),"-",IF(LENGTH(MONTH(aa.pd_date))=1,CONCAT("0",MONTH(aa.pd_date)),MONTH(aa.pd_date)),"-01"))) e on (f.pl_date=e.pl_date) ) d');


 
 //$sSQL = ('INSERT INTO planned (itemid,rid,budgetdate,budgetqty) select d.itemid, d.rid, d.pl_date,d.planned_qty from (select e.itemid as itemid , e.rid as rid , f.itemid as itemid1, f.rid as rid1, f.baseline, f.pl_date as pl_date1, f.days, f.total_days ,(f.planned_qty+e.budgetqty) as planned_qty, e.pl_date as pl_date from (select b.itemid, b.rid, b.baseline,a.pl_date, a.days, c.total_days,((a.days/c.total_days)*b.baseline) as planned_qty from activity b , (select CONCAT(YEAR(pd_date),"-",if(length(MONTH (pd_date))=1,concat("0",MONTH(pd_date)),MONTH(pd_date)),"-01") as pl_date, count(CONCAT(YEAR(pd_date),"-",if(length(MONTH(pd_date))=1,concat("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1 group by CONCAT (YEAR(pd_date),"-",if(length(MONTH(pd_date))=1,concat("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) a ,(select count(CONCAT(YEAR(pd_date),"-",if(length(MONTH (pd_date))=1,concat("0",MONTH(pd_date)),MONTH(pd_date)),"-01")) as total_days from project_days where pd_date BETWEEN (select startdate from activity where aid='.$aid.') AND (select enddate from activity where aid='.$aid.') AND pd_status=1) c where b.aid='.$aid.') f right outer join (select bb.itemid, bb.rid, concat(year(aa.pd_date),"-",if(length(Month(aa.pd_date))=1,CONCAT("0",Month(aa.pd_date)),Month(aa.pd_date)),"-01") as pl_date , 0 as budgetqty from project_days aa, activity bb where bb.aid = '.$aid.' group by concat(year(aa.pd_date),"-",if(length(Month(aa.pd_date))=1,CONCAT("0",Month(aa.pd_date)),Month(aa.pd_date)),"-01")) e on (f.pl_date=e.pl_date) ) d');
	$objDb1->execute($sSQL);
	}
 }
 
 
 
/* 
 $bSqls = "Select * from planned ";
  $objDb -> query($bSqls);
  
	$iCount = $objDb->getCount( );
 if($iCount>0)
 {
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		
		$plid 	= $objDb->getField($i,plid);
		$budgetdate 	= $objDb->getField($i,budgetdate);
		$fmonth= date('m',strtotime($budgetdate));
		$fyear= date('Y',strtotime($budgetdate));
		$fmonth_days=cal_days_in_month(CAL_GREGORIAN,$fmonth,$fyear);
		$budgetdate =$fyear."-".$fmonth."-".$fmonth_days;


 
echo  $bSQL = ("UPDATE planned SET budgetdate='".$budgetdate."' WHERE plid=".$plid);
	$objDb1->execute($bSQL);
	}
 }*/
  $bSQL = ("UPDATE planned SET temp_id=1");
	$objDb->execute($bSQL);
	$objDb  -> close( );
	$objDb1  -> close( );
echo "Planned Data Making Process is complete";
 ?>
 <a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>