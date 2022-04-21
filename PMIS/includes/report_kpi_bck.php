<?php

 $sql="SELECT kpi_id, kpi_start, kpi_end, kpi_gend, kpi_till_last FROM kpi_monthly_progress_report ";
 $result = mysql_query($sql);
 if($result!=0)
 {

 $data=mysql_fetch_array($result);
 $kpi_start=$data["kpi_start"];
 $kpi_start_m=date('m',strtotime($kpi_start));
 $kpi_start_y=date('Y',strtotime($kpi_start));
 $start=$kpi_start_y."-".$kpi_start_m;
 $uptolast=
 $kpi_end=$data["kpi_end"];
 $kpi_end_m=date('m',strtotime($kpi_end));
 $kpi_end_y=date('Y',strtotime($kpi_end));
 $end=$kpi_end_y."-".$kpi_end_m;
 $kpi_gend=$data["kpi_gend"];
 $kpi_gend_m=date('m',strtotime($kpi_gend));
 $kpi_gend_y=date('Y',strtotime($kpi_gend));
 $gend=$kpi_gend_y."-".$kpi_gend_m;
 
 $kpi_till_end=$data["kpi_till_last"];
 $kpi_till_end_m=date('m',strtotime($kpi_till_end));
 $kpi_till_end_y=date('Y',strtotime($kpi_till_end));
 $till_end=$kpi_till_end_y."-".$kpi_till_end_m;

 }
 

	

	?>