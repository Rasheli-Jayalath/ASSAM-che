<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module=PROJECT;
if ($uname==null  ) {
header("Location: requires/logout.php");
} 

$edit			= $_GET['edit'];
$objDb  		= new Database( );

if($_SESSION['login_count']==1)
{
$_SESSION['codelength']		=6;
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			{
			 //check for ip from share internet
			 $ip = $_SERVER["HTTP_CLIENT_IP"];
			}
			elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{
			 // Check for the Proxy User
			 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			else
			{
			 $ip = $_SERVER["REMOTE_ADDR"];
			}
			
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
		   $browser ='Internet explorer';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
			$browser = 'Internet explorer';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
		   $browser = 'Mozilla Firefox';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
		   $browser = 'Google Chrome';
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
		   $browser = "Opera Mini";
		 		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
		   $browser = "Opera";
				 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
		   $browser = "Safari";
		 else
		   $browser = 'Something else';
			$request_uri = $_SERVER['REQUEST_URI'];
			$password=$_SESSION['user_pasword'];
			
		
		$uSQL = ("INSERT INTO users_log (user_id,user_name,password,ip_address, req_url, browser) VALUES ('$uid','$uname','$password','$ip', '$request_uri', '$browser')");
			$objDb->execute($uSQL);
			$log_id=mysql_insert_id();
			$_SESSION['log_id']=$log_id;
	}
$_SESSION['login_count']=2;
@require_once("get_url.php");
$msg						= "";
$objDb  		= new Database( );
$eSql = "Select * from project";
$objDb -> query($eSql);
$eCount = $objDb->getCount();
if($eCount == 0)
{
header("location: project_calender.php");
}

	$objDbb  		= new Database( );
	$objVSDb  		= new Database( );
	$objCSDb  		= new Database( );
	$pSql = "Select * from project";
  $objDbb -> query($pSql);
  $pCount = $objDbb->getCount();
	if($pCount > 0){
	  $pid = $objDbb->getField($i,pid);
	  $pcode 					= $objDbb->getField($i,pcode);
	  $pname	 				= $objDbb->getField($i,pname);
	  $pdetail					= $objDbb->getField($i,pdetail);
	  $pstart 					= $objDbb->getField($i,pstart);
	  $pend 					= $objDbb->getField($i,pend);
	  $client					= $objDbb->getField($i,client);
	  $funding_agency			= $objDbb->getField($i,funding_agency);
	  $contractor				= $objDbb->getField($i,contractor);
	  $pcost					= $objDbb->getField($i,pcost);
	  $ssector_id				= $objDbb->getField($i,sector_id);
	  if($ssector_id!=0)
	  {
		  $sssSql = "Select * from rs_tbl_sectors where sector_id='$ssector_id'";
		  $objVSDb -> query($sssSql);
		  $sssCount = $objVSDb->getCount();
			if($sssCount > 0){
			  $sector_name = $objVSDb->getField($i,sector_name);
			}
	  }
	  $scountry_id				= $objDbb->getField($i,country_id);
	  if($scountry_id!=0)
	  {
		  $cccSql = "Select * from rs_tbl_countries where country_id='$scountry_id'";
		  $objCSDb -> query($cccSql);
		  $cccCount = $objCSDb->getCount();
			if($cccCount > 0){
			  $country_name = $objCSDb->getField($i,country_name);
			}
	  }
	  $consultant				= $objDbb->getField($i,consultant);
	  $location				    = $objDbb->getField($i,location);
	  $smec_code				= $objDbb->getField($i,smec_code);
	}
?>
<?php $planned_perc=0;
$actual_perc=0;
$chartSQL="Select a.ppg_id, a.pid, a.planned, a.actual, a.ppg_date From (SELECT ppg_id, pid, planned, actual, ppg_date FROM t023project_progress_graph WHERE pid = ".$pid." ORDER BY ppg_date DESC limit 3) a order by a.ppg_date ASC";
$chartSQLResult = mysql_query($chartSQL);
$chartdatad['max_date']=date('M d Y');
$planned = array();
$actual =  array();
$xaxis =   array();
while ($chartdata = mysql_fetch_array($chartSQLResult)) {
$planned_perc=$chartdata['planned'];
$actual_perc=$chartdata['actual'];
$planned[] = number_format($planned_perc,2);
$actual[] =  number_format($actual_perc,2);
$month = substr($chartdata['ppg_date'],5,2);
if ($month == '01' || $month == 01) {$monthtext='Jan';}
if ($month == '02' || $month == 02) {$monthtext='Feb';}
if ($month == '03' || $month == 03) {$monthtext='Mar';}
if ($month == '04' || $month == 04) {$monthtext='Apr';}
if ($month == '05' || $month == 05) {$monthtext='May';}
if ($month == '06' || $month == 06) {$monthtext='Jun';}
if ($month == '07' || $month == 07) {$monthtext='Jul';}
if ($month == '08' || $month == 08) {$monthtext='Aug';}
if ($month == '09' || $month == 09) {$monthtext='Sep';}
if ($month == '10' || $month == 10) {$monthtext='Oct';}
if ($month == '11' || $month == 11) {$monthtext='Nov';}
if ($month == '12' || $month == 12) {$monthtext='Dec';}
$yeartext = substr($chartdata['ppg_date'],2,2);
$xaxis[] = $monthtext."-".$yeartext;
}
$planneddata = implode(",",$planned);
$actualdata = implode(",",$actual);
$xaxisdata = "'".implode("','",$xaxis)."'";

//$title = "Progress as on ".date('M d, Y',strtotime($chartdatad['max_date']));
//$subtitle = "CURRENT + LAST TWO MONTHS PROGRESS";
$title="Progress Comparison";
$categories =  $xaxisdata;
$xaxistitle = "Months";
$yaxistitle = "Percentage";
$data1name = "Planned";
$data1 = $planneddata;
$data2name = "Actual";
$data2 = $actualdata;

if(isset($pstart) && $pstart!="0000-00-00" && isset($pend)&& $pend!="0000-00-00")
{
	$startTimeStamp = strtotime($pstart);
$endTimeStamp = strtotime($pend);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400;  // 86400 seconds in one day
// and you might want to convert to integer
$total_days = intval($numberDays);
$c_date=date("Y/m/d");
$current_date = strtotime($c_date);
if(isset($pstart))
{
$timeDiff_elap = abs($current_date - $startTimeStamp);
$elapDays = $timeDiff_elap/86400; 
$elapsed_days = intval($elapDays);
}
else
{
$elapsed_days=0;
}
if(isset($pstart) && isset($pend))
{
$per_elapsed=$elapsed_days/$total_days*100;
}
}
else
{
$total_days=0;
$elapsed_days=0;
$per_elapsed=0;
}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<?php /*?><link rel="stylesheet" type="text/css" href="css/CssAdminStyle.css"><?php */?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  <script type="text/javascript" src="scripts/JsCommon.js"></script>
  <script type="text/javascript">
  
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
       
	  title: {
		 text: '<?php echo '<span style="font-size:22px;font-weight:bold; color:#000; font-family:Soleto, sans-serif;width:100%; text-align:left">'.$title.'</span>'; ?>',
        floating: true,
        align: 'left',
        x: -12,
        y: 7
        },
       
        xAxis: {
            categories: [<?php echo $categories; ?>],
			//title: { text: '<?php //echo $xaxistitle; ?>' },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: '<?php echo $yaxistitle; ?>'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}%</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
							
            }
        },
        series: [{
            name: '<?php echo $data1name; ?>',
			data: [<?php echo $data1; ?>],
			color: '<?php echo $color_planned; ?>',
             dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'right',
                    x: 12,
                    y: 25,
					format: '{point.y:.1f}%',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }

        }, {
            name: '<?php echo $data2name; ?>',
			data: [<?php echo $data2; ?>],
			color: '<?php echo $color_actual; ?>',
			 dataLabels: {
                    enabled: true,
                    color: '#FFF',
                    align: 'left',
                    x: 0,
                    y: 25,
					format: '{point.y:.1f}%',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'                        
                    }
					
                }

        }]
    });
});
</script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="highcharts/js/highcharts.js"></script>
  <script src="highcharts/js/modules/exporting.js"></script>
  <script src="highcharts/js/modules/jquery.highchartTable.js"></script>
  <script src="highcharts/js/highcharts-more.js"></script>
</head>
<body>
<div id="wrap">
  <?php 
		include 'includes/header.php'; 
	?>
<div id="content">
<div style="margin-top:20px; text-align:left">
<table width="100%"  align="center" border="0" >
    <tr><td align="center">
    <table width="100%"  align="center" class="project"  >
	<tr style="border:0; border-color:#FFF">
              <td width="100%" class="detail"  colspan="2" ><strong>Project Information</strong></td>
            </tr><?php
	if((isset($pid)&&$pid!=""&&$pid!=0))
			{
	?>
            <tr>
              <td><strong>Project Detail:</strong></td>
              <td><span title="<?php echo $pdetail; ?>"><?php $str_len=strlen($pdetail);
			  if($str_len>30)
			  {
				 echo substr($pdetail,0,90)."..."; 
			  }
			  else
			  {
				  echo $pdetail;
			  }?></span></td>
            </tr>
            <tr>
              <td  ><strong>Start Date:</strong></td>
              <td ><?php echo date("d-m-Y", strtotime($pstart)); ?></td>
        </tr>
			 <tr>
              <td  ><strong>End Date:</strong></td>
              <td ><?php echo date("d-m-Y", strtotime($pend)); ?></td>
             </tr>
              <tr>
              <td ><strong>Client:</strong></td>
              <td ><?php echo $client; ?></td>
             </tr>
               <tr>
              <td  ><strong>Consultant:</strong></td>
              <td ><?php echo $consultant; ?></td>
             </tr>
             <tr>
              <td  ><strong>Funding Agency:</strong></td>
              <td ><?php echo $funding_agency; ?></td>
             </tr>
             <tr>
              <td  ><strong>Contractor:</strong></td>
              <td ><?php echo $contractor; ?></td>
             </tr>
             <tr>
              <td  ><strong>Contract Value:</strong></td>
              <td ><?php echo number_format($pcost,0); ?></td>
             </tr>
         
             <tr>
              <td  ><strong>Location:</strong></td>
              <td ><?php echo $location; ?></td>
        
      
	<?php }?></table></td><td align="center"><table   align="center" class="project"  height="265px">
	<tr ><td><div id="container" style="min-width: 310px;height:223px;"></div>
								 </td></tr></table> </td></tr>
     <?php /*?>  <tr><td align="center" colspan="2"> <table width="100%"  align="center" class="project"  >
	<tr style="border:0; border-color:#FFF">
              <td width="100%" colspan="2" >
			  <?php // include("includes/functions_progress_dashboard.php");?>
			  <?php //include("includes/outcome_level_progress_dashboard_home.php");?></td></tr></table></tr>    <?php */?>                       
   <tr><td align="center">
	 
<?php  
$issueSQL = "SELECT iss_id, iss_title, iss_detail FROM t012issues where pid=$pid and iss_status=1 order by iss_no asc limit 100";
$issueSQLResult = mysql_query($issueSQL);
?>  
                      
<table width="78%"  align="center" border="1" class="project">
	<tr>
              <td width="100%"  class="detail"><strong>Project Issues</strong></td>
            </tr>
            <tr><td>

<marquee id="MARQUEE1" style="text-align: left; float: left; height: 210px;" scrollamount="3" onmouseout="this.start();" onmouseover="this.stop();" direction="up" behavior="scroll">







                      <ul class="list-unstyled timeline widget">
<?php
                while ($issuedata = mysql_fetch_array($issueSQLResult)) {
				$iss_id=$issuedata['iss_id'];
					   echo '<li>';
                        echo '<div class="block">';
                          echo '<div class="block_content">';
                            echo '<h2 class="title">';
                               echo "<a href='project_issues.php?iss_id=$iss_id' target='_self'>".$issuedata['iss_title'].'</a>';
                            echo '</h2>';
                           
                          echo '</div>';
                        echo '</div>';
                      echo '</li>';
				}
?>
                     </ul>
		

 </marquee>
 </td>
 </tr>
 </table>
  </td><td align="center"><table width="45%"  align="center" class="project" height="275px">
	<tr ><td><?php /*?><table border="0" align="left" width="50%"   > 
<tr> 
<td align="left" valign="top" width="50%" >
<?php include("includes/functions_eva.php");?>
<?php $psql = "select max(emonth) as lastProgressMonth, min(emonth) as firstProgressMonth from `s007-eva-earned`";
$presult = mysql_query($psql);
$prows = mysql_fetch_array($presult);
$lastProgressMonth=$prows['lastProgressMonth'];
$firstProgressMonth=$prows['firstProgressMonth'];
$start=$firstProgressMonth;
$end=$lastProgressMonth;
$last=$lastProgressMonth;
?>
       <?php  $CPI=GetCPIValue($last);
	   $CPI=number_format($CPI,2);
	   $mi=date('m',strtotime($last));
	$yi=date('Y',strtotime($last));
	$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
	
	$last_date=$last;
		?>
        <script type="text/javascript">
$(function () {
	
    $('#container_cpi').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: ''
	    },
	    subtitle: {
                text: ''
            },
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 2,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'CPI'
	        },
	        plotBands: [{
	            from: 0,
	            to: 0.8,
	            color: '#DF5353' // red
	        }, {
	            from: 0.8,
	            to: 2,
	            color: '#55BF3B' // yellow
	        }]        
	    },
	
	    series: [{
	        name: 'CPI',
	        data: [<?php echo $CPI;?>],
	        tooltip: {
	            valueSuffix: ' '
	        }
	    }]
	
	}
	);
});
		</script>
        <table width="40%"  align="right" border="0" cellpadding="0" cellspacing="0">
   
   <tr>
     <td   style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container_cpi" style="min-width: 210px; max-width:300px; height: 200px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table><?php */?></td><td><?php /*?><table border="0" cellpadding="0px" cellspacing="0px" align="left" width="50%"  style="padding:0; margin:0;" > 
<tr> 
<td align="left" valign="top" width="50%" >

       <?php  $SPI=GetSPIValue($last);
	   $SPI=number_format($SPI,2);
	    $mi=date('m',strtotime($last));
		$yi=date('Y',strtotime($last));
		$days=cal_days_in_month(CAL_GREGORIAN,$mi,$yi);
		
		$last_date=$yi."-".$mi."-".$days;
	?>
        <script type="text/javascript">
$(function () {
	
    $('#container_spi').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: ''
	    },
	    
		subtitle: {
                text: ''
            },
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 2,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'SPI'
	        },
	        plotBands: [{
	            from: 0,
	            to: 0.8,
	            color: '#DF5353' // red
	        }, {
	            from: 0.8,
	            to: 2,
	            color: '#55BF3B' // yellow
	        }]        
	    },
	
	    series: [{
	        name: 'SPI',
	        data: [<?php echo $SPI;?>],
	        tooltip: {
	            valueSuffix: ' '
	        }
	    }]
	
	}
	);
});
		</script>
        <table width="45%"  align="right" border="0" cellpadding="0" cellspacing="0">
   
   <tr>
     <td  style="line-height:18px; text-align:justify; vertical-align:top">
     <div id="container_spi" style="min-width: 210px; max-width: 300px; height: 200px; margin: 0 auto"></div>
     </td>
     
   </tr>
   
</table></td>
</tr>
</table><?php */?></td></tr></table></td></tr>
     
</table>
</div>
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb-> close( );
?>
