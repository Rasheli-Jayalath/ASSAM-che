<?php 
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
$edit			= $_GET['edit'];
$objDb  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($process_flag==0 ) {
header("Location: index.php?init=3");
}
@require_once("get_url.php");
$msg	= "";
?>

<?php 
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
///////////////////////////Making Of Base Table

/* $sql_d="DROP table mildata " ;
$result_d = mysql_query($sql_d); 
$tsql = "CREATE TABLE mildata(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
itemid INT(6) NOT NULL,
rid INT(6) NOT NULL,
";
$ii=0;
$jj=0;
$sql="SELECT *  FROM  project " ;
$result = mysql_query($sql);
$resultdata=mysql_fetch_array($result);
$pstart=$resultdata["pstart"];
$y=date('Y',strtotime($pstart));
$m=date('m',strtotime($pstart));
$start=$y."-".$m."-"."01";
$pend=$resultdata["pend"];
$dates= dateRange($start,$pend);

				$num=sizeof($dates);
				foreach($dates as $values)
				{	
				$ii++;
					  $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scale_date=$vyear.$vmonth.$vmonth_days;
					  $tsql .="`AC$scale_date`  VARCHAR(100) NOT NULL ,";
					  $tsql .="`ACC$scale_date`  VARCHAR(100) NOT NULL ,";
					  $tsql .="`TG$scale_date`  VARCHAR(100) NOT NULL ,";
					  $tsql .="`TGC$scale_date`  VARCHAR(100) NOT NULL ";
					   if($ii<$num)
					 {
					  $tsql .=" , ";
					  
					 }
				}
				
				 $tsql .=" )";
				 
			 $tsql;
				 mysql_query($tsql);*/
				
				 
///////////////////////////END Making Of Base Table
$qtr=0;
$sql_t="TRUNCATE kpiscale " ;
$result_t = mysql_query($sql_t);
$kpisql .="INSERT INTO kpiscale(scmonth,scyear,scquarter) VALUES";

				foreach($dates as $values)
				{	
				$jj++;
				 $vmonth= date('m',strtotime($values));
					  $vyear= date('Y',strtotime($values));
					  $vmonth_days=cal_days_in_month(CAL_GREGORIAN,$vmonth,$vyear);
				      $scmonth=$vyear."-".$vmonth;
					  if($vmonth<=3)
					  $qtr=1;
					  elseif($vmonth>=3&&$vmonth<=6)
					  $qtr=2;
					  elseif($vmonth>=6&&$vmonth<=9)
					  $qtr=3;
					  else
					  $qtr=4;
					  
				$kpisql .=" ( '".$scmonth."' ,". "'".$vyear."', ".$qtr .")";
				
				  if($jj<$num)
					 {
					  $kpisql .=" , ";
					  
					 }
				}
			 mysql_query($kpisql);
				$kpisql;
				
				//echo "Base Data Making Process is complete";
 ?>
 <!--<a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>-->