<?php
if(isset($_REQUEST["start_date"]))
 {
 $kpi_start=date('Y-m',strtotime($_REQUEST["start_date"]));
 $start=$kpi_start;
 $qs="SELECT scid from kpiscale where scmonth='$kpi_start'";
 $qsresult = mysql_query($qs);
 $qsdata=mysql_fetch_array($qsresult);
 $start_scid=$qsdata["scid"];

  // Up to last start//////
  $upsql="SELECT min(scmonth) as min_scmonth, max(scmonth) as max_scmonth FROM `kpiscale`";
 $upresult = mysql_query($upsql);
 if($result!=0)
 {
 $updata=mysql_fetch_array($upresult);
 }
 if(isset($updata["min_scmonth"])&&$updata["min_scmonth"]==$kpi_start)
 {
  $kpi_till_end=$kpi_start;
 }
 else
 {
	 $kpi_till_end=date("Y-m",strtotime("$kpi_start -1 month"));
 }

 $qt="SELECT scid from kpiscale where scmonth='$kpi_till_end'";
 $qtresult = mysql_query($qt);
 $qtdata=mysql_fetch_array($qtresult);
  $till_end_scid=$qtdata["scid"];
  
    // Up to last End//////
  
 }
 
 else
 {
 $sql="SELECT min(scmonth) as min_scmonth, max(scmonth) as max_scmonth FROM `kpiscale`";
 $result = mysql_query($sql);
 if($result!=0)
 {
 $data=mysql_fetch_array($result);
 $kpi_start=$data["min_scmonth"];
  $start=$kpi_start;
 $qs="SELECT scid from kpiscale where scmonth='$kpi_start'";
 $qsresult = mysql_query($qs);
 $qsdata=mysql_fetch_array($qsresult);
 $start_scid=$qsdata["scid"];
 $kpi_end=$data["max_scmonth"];
 $end=$kpi_end;
  $qe="SELECT scid from kpiscale where scmonth='$kpi_end'";
 $qeresult = mysql_query($qe);
 $qedata=mysql_fetch_array($qeresult);
 $end_scid=$qedata["scid"];
 $gend=$kpi_end;
 $till_end=$kpi_start;

 /*$kpi_gend=$data["kpi_gend"];
 $kpi_gend_m=date('m',strtotime($kpi_gend));
 $kpi_gend_y=date('Y',strtotime($kpi_gend));
 $gend=$kpi_gend_y."-".$kpi_gend_m;*/
 }

 }
 
 if(isset($_REQUEST["end_date"]))
 {
  $kpi_end=date('Y-m',strtotime($_REQUEST["end_date"]));
 $end=$kpi_end;
 $qe="SELECT scid from kpiscale where scmonth='$kpi_end'";
 $qeresult = mysql_query($qe);
 $qedata=mysql_fetch_array($qeresult);
 $end_scid=$qedata["scid"];
 $gend=$kpi_end;

 }
 else
 {
 $sqlt="SELECT progress_type FROM `template_progress` where temp_id=".$temp_id ;
 $result_type = mysql_query($sqlt);
 if($result_type!=0)
 {
	$tempdata=mysql_fetch_array($result_type);
 }
 if(isset($tempdata["progress_type"])&&$tempdata["progress_type"]!=""&&$tempdata["progress_type"]==1)
 {
	$sqlp="SELECT max(ipcmonth) as max_pmonth FROM `ipc` ";
 $resultp = mysql_query($sqlp);
 if($resultp!=0)
 {
	$qsdatap=mysql_fetch_array($resultp);
 }	
 }
 else
 {
 $sqlp="SELECT max(pmonth) as max_pmonth FROM `progressmonth` where temp_id=".$temp_id ;
 $resultp = mysql_query($sqlp);
 if($resultp!=0)
 {
	$qsdatap=mysql_fetch_array($resultp);
 }	
 }
 $kpi_till_end=$qsdatap["max_pmonth"];
 
 $till_end=$$kpi_till_end; // KPI UP Till END
 $qt="SELECT scid from kpiscale where scmonth='$till_end'";
 $qtresult = mysql_query($qt);
 $qtdata=mysql_fetch_array($qtresult);
   $till_end_scid=$qtdata["scid"];
$gend=$till_end;
 }
	?>