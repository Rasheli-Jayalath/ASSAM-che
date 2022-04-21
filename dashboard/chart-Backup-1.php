<?php
session_start();

if (isset($_REQUEST['pwpin'])) {
	if ($_REQUEST['pwpin'] == '1234') {
		$_SESSION['adminflag']=1;
		$adminflag = $_SESSION['adminflag'];
		} elseif ($_REQUEST['pwpin'] == '5678' || 'Vonly_8159') {
			$_SESSION['adminflag']=2;
			$adminflag = $_SESSION['adminflag'];
			} else {
				header("Location: index.php?msg=0");
				}
	}
$adminflag = $_SESSION['adminflag'];

//$adminflag = 2;
if ($adminflag == 1 || $adminflag == 2) {
include_once("connect.php");
//==========================================================

if (!isset($_REQUEST['back'])) {
	if (isset($_SESSION['srid'])) {
		if (!isset($_REQUEST['stop']) && !isset($_REQUEST['resume'])) { 
			$sridlist = $_SESSION['sridlist'];
			$srid = $_SESSION['srid'];
			$sr_max = $_SESSION['sr_max'];
			if ($srid >= $sr_max-1) {
					$srid = 0;
					$_SESSION['srid'] = $srid;	
					$pidsql = "select pid from nha_pmis.t002project where srid = ".$sridlist[$srid];
					$pidresult = mysql_query($pidsql);
					$piddata = mysql_fetch_array($pidresult);
					$pid = $piddata['pid'];
					$_SESSION['pid'] = $pid;
					$maxpid=$_SESSION['max_pid'];
					$mode= $_SESSION['mode'];
				} else {
					$_SESSION['srid'] = $srid + 1;
					$srid = $_SESSION['srid'];
					$pidsql = "select pid from nha_pmis.t002project where srid = ".$sridlist[$srid];
					$pidresult = mysql_query($pidsql);
					$piddata = mysql_fetch_array($pidresult);
					$pid = $piddata['pid'];
					$_SESSION['pid'] = $pid;
					$maxpid=$_SESSION['max_pid'];
					$mode= $_SESSION['mode'];
				}
		} else {
			 if (isset($_REQUEST['stop'])) {
				 $_SESSION['mode'] = 0;
				 $srid = $_SESSION['srid'];
				 $sridlist = $_SESSION['sridlist'];
				 $sr_max = $_SESSION['sr_max'];
				 $pid= $_SESSION['pid'];
				 $maxpid=$_SESSION['max_pid'];
				 $mode= $_SESSION['mode'];
			 }
			 if (isset($_REQUEST['resume'])) {
				 $_SESSION['mode'] = 1;
				 $srid = $_SESSION['srid'];
				 $sridlist = $_SESSION['sridlist'];
				 $sr_max = $_SESSION['sr_max'];
				 $pid= $_SESSION['pid'];
				 $maxpid=$_SESSION['max_pid'];
				 $mode= $_SESSION['mode'];
			 }
	   }
	} else {
	
		$plistsql = "select srid from nha_pmis.t002project where srid IS NOT NULL and srid <> '' and srid <> 0 order by srid";
		$plistresult = mysql_query($plistsql);
		
		while ($plistdata = mysql_fetch_array($plistresult)) {
			$sridlist[] = $plistdata['srid'];
		}
		$srid = 0;
		$sr_max = count($sridlist);
		$_SESSION['sridlist'] = $sridlist;
		$_SESSION['srid'] = $srid;
		$_SESSION['sr_max'] = $sr_max;
		$pidsql = "select pid from nha_pmis.t002project where srid = ".$sridlist[$srid];
		$pidresult = mysql_query($pidsql);
		$piddata = mysql_fetch_array($pidresult);
		$pid = $piddata['pid'];
		$_SESSION['pid'] = $pid;
		$projSQL = "select max(pid) as pid from t002project";
	  	$projSQLResult = mysql_query($projSQL);
	  	$projdata = mysql_fetch_array($projSQLResult);
	  	$maxpid = 	$projdata['pid'];
	  	$_SESSION['mode'] = 1;
	  	$mode= $_SESSION['mode'];
	  	$_SESSION['max_pid']= $maxpid;
	}
} else {
		 $srid= $_SESSION['srid'];
 		 $sridlist = $_SESSION['sridlist'];
	     $maxpid=$_SESSION['sr_max'];
		 $mode= $_SESSION['mode'];
		 $pid = $_SESSION['pid'];
		 $maxpid=$_SESSION['max_pid'];
}

//==========================================================

/*if (!isset($_REQUEST['back'])) {
 if(isset($_SESSION['pid'])) {
   if (!isset($_REQUEST['stop']) && !isset($_REQUEST['resume'])) { 
	 if($_SESSION['pid']>=$_SESSION['max_pid'])
	 {
	   $_SESSION['pid'] = 1;
	  $pid= $_SESSION['pid'];
	  $maxpid=$_SESSION['max_pid'];
	  $mode= $_SESSION['mode'];
	 }
	 else
	 {
	 $pid = $_SESSION['pid']+1;
	 $_SESSION['pid']=$pid;
	 $maxpid=$_SESSION['max_pid'];
	 $mode= $_SESSION['mode'];
	 }
   } else {
	 if (isset($_REQUEST['stop'])) {
		 $_SESSION['mode'] = 0;
	  	 $pid= $_SESSION['pid'];
	     $maxpid=$_SESSION['max_pid'];
		 $mode= $_SESSION['mode'];
	 }
	 if (isset($_REQUEST['resume'])) {
		 $_SESSION['mode'] = 1;
		 $pid= $_SESSION['pid'];
	     $maxpid=$_SESSION['max_pid'];
		 $mode= $_SESSION['mode'];
	 }
   }
 } else {
	  $_SESSION['pid'] = 1;
	  $pid= $_SESSION['pid'];
	  
	  $projSQL = "select max(pid) as pid from t002project";
	  $projSQLResult = mysql_query($projSQL);
	  $projdata = mysql_fetch_array($projSQLResult);
	  $maxpid = 	$projdata['pid'];
	  $_SESSION['mode'] = 1;
	  $mode= $_SESSION['mode'];
	  $_SESSION['max_pid']= $maxpid;	  
 }
} else {
		 $pid= $_SESSION['pid'];
	     $maxpid=$_SESSION['max_pid'];
		 $mode= $_SESSION['mode'];
}
*///	  $_SESSION['pid'] = 1;
//	  $pid= $_SESSION['pid'];


$chartSQLD = "SELECT max(sp_date) as max_date FROM overall_project_progress where pid = ".$pid." ";
$chartSQLResultd = mysql_query($chartSQLD);
$chartdatad = mysql_fetch_array($chartSQLResultd);
$planned_perc=0;
$actual_perc=0;

$chartSQL="Select a.ppg_id, a.pid, a.planned, a.actual, a.ppg_date From (SELECT ppg_id, pid, planned, actual, ppg_date FROM t023project_progress_graph WHERE pid = ".$pid."  ORDER BY ppg_date DESC limit 3) a order by a.ppg_date ASC";
$chartSQLResult = mysql_query($chartSQL);
$chartdatad['max_date']=date('M d Y');
$planned = array();
$actual = array();
$xaxis = array();
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

$title = "Progress as on ".date('F d, Y',strtotime($chartdatad['max_date']));
$subtitle = "CURRENT + LAST TWO MONTHS PROGRESS";
$categories =  $xaxisdata;
$xaxistitle = "Months";
$yaxistitle = "Percentage";
$data1name = "Planned";
$data1 = $planneddata;
$data2name = "Actual";
$data2 = $actualdata;

$pdSQL = "SELECT pid, pgid,proj_name, proj_length, con_id, cons_id, proj_cont_price, proj_start_date, proj_end_date, proj_src_fund, proj_pc1_amount, proj_main , pcolor , proj_cur FROM t002project where pid = ".$pid;
$pdSQLResult = mysql_query($pdSQL);
$pdData = mysql_fetch_array($pdSQLResult);
$pname = $pdData['proj_name'];
$plength = $pdData['proj_length'];
$pcon = $pdData['con_id'];
$pcons = $pdData['cons_id'];
$pprice = $pdData['proj_cont_price'];
$pstart = $pdData['proj_start_date'];
$pend = $pdData['proj_end_date'];
$psrc = $pdData['proj_src_fund'];
$ppc1 = $pdData['proj_pc1_amount'];
$pcolor = $pdData['pcolor'];
$proj_cur = $pdData['proj_cur'];
} else {
	header("Location: index.php?msg=0");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php /*?><?php if ($mode == 1) {?>
<META HTTP-EQUIV="refresh" CONTENT="15">
<?php } ?><?php */?>
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<style type="text/css">
${demo.css}
</style>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $title; ?>'
        },
        subtitle: {
            text: '<?php echo $subtitle; ?>'
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
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '<?php echo $data1name; ?>',
			data: [<?php echo $data1; ?>],
			 dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'center',
                    x: 0,
                    y: 2,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }

        }, {
            name: '<?php echo $data2name; ?>',
			data: [<?php echo $data2; ?>],
			 dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'center',
                    x: 0,
                    y: 2,
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
<script>
window.onload = function() {
    var countdownElement = document.getElementById('countdown'),
        downloadButton = document.getElementById('download'),
        seconds = 14,
        second = 0,
        interval;

    downloadButton.style.display = 'none';

    interval = setInterval(function() {
        countdownElement.firstChild.data = '' + (seconds - second) + ' seconds';
        if (second >= seconds) {
            downloadButton.style.display = 'block';
            clearInterval(interval);
        }

        second++;
    }, 1000);
}


</script>

</head>
<body>
<div class="top-box-set" >

<h1 align="center" style="background-color:<?php echo $pcolor; ?>; color:#FFF"><?php echo $pname; ?></h1>
 

<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 100px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
<span style="position:absolute; top: 21px; right: 20px;font-family:Verdana, Geneva, sans-serif; font-size: 1.9em;font-weight:bold; color:#4CAF50; background-color:#FFF">PMU</span>
<!-- -->
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="box">

  <table  style="border:1px; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="2"><h3>Project Information 
					  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_project_info_update.php" target="_self" method="post"><input type="submit" name="p_update" id="p_update" value="update"  /></form></span><?php }?></h3> </th></thead>
                      <tbody>
                        <tr>
                          <td width="155"><strong>Civilworks Contractor:</strong></td>
                          <td width="112" align="right"><?php 
						  if($plength!=""&&$plength!=NULL)
						  echo $plength ?></td>
                        </tr>
                        <tr>
                          <td><strong>E &amp; M Contractor:</strong></td>
                          <td align="right"><?php echo $pcon; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Consultant (M&amp;E):</strong></td>
                          <td align="right"><?php echo $pcons; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Contract Price: ( <?php echo $proj_cur;?> )</strong></td>
                          <td align="right"><?php if($pprice!=""&&$pprice!=NULL&&$pprice!=0)
						  echo number_format($pprice,0); ?></td>
                        </tr>
                        <tr>
                          <td><strong>Start Date:</strong></td>
                          <td align="right">
						  <?php if(isset($pstart)&&$pstart!=""&&$pstart!=NULL&&$pstart!="1970-01-01"){echo date("d/m/Y", strtotime($pstart)); }?></td>
                        </tr>
                        <tr>
                          <td><strong>VO2 Completition Date:</strong></td>
                          <td align="right"> <?php if(isset($pend)&&$pend!=""&&$pend!=NULL&&$pend!="1970-01-01"){echo date("d/m/Y", strtotime($pend));} ?></td>
                        </tr>
                        <tr>
                          <td><strong>Source of Funds:</strong></td>
                          <td align="right"><?php echo $psrc; ?></td>
                        </tr>
                        <tr>
                          <td><strong>Appro. PC-1 Amount:  ( <?php echo $proj_cur;?> )</strong></td>
                          <td align="right"><?php if($ppc1!=""&&$ppc1!=NULL&&$ppc1!=0)
						  echo number_format($ppc1,0); ?></td>
                        </tr>
                      </tbody>
    </table>
  </figure>
  <figure class="box1"> <?php if($adminflag==1)
								  {
								  
							
								   ?><span style="float:right"><form action="sp_progress_graph.php" target="_self" method="post"><input type="submit" name="g_update" id="g_update" value="Manage"  /></form></span><?php } ?>
								   <div id="container" style="min-width: 310px; height: 272px; margin: 0 auto"></div></figure>
  <figure class="box2">
<?php  
/*$apSQL = "SELECT b.act_name, a.ppt_id, a.pid, a.act_id, a.ppt_planned as planned_percent, a.ppt_actual as actual_percent, a.ppt_date FROM t024project_progress_table a left outer join t011activities b on a.act_id = b.act_id where a.ppt_date = (select max(t.ppg_date) from t023project_progress_graph t where t.pid=".$pid.") AND a.pid=".$pid." and a.act_id<>7 order by b.act_order";*/
$others="others";
$apSQL = "SELECT ppt_id,pid, act_id,ppt_planned as planned_percent,ppt_actual as actual_percent FROM t024project_progress_table where  pid=$pid and act_id!='$others' order by ppt_id";
 
$apSQLResult = mysql_query($apSQL);
?>  
  
  <table  style="border:thick #000; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="3"><h3>Major Items Progress as on 
					  <?php echo date('F d, Y',strtotime($chartdatad['max_date']));?><?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_major_items.php" target="_self" method="post"><input type="submit" name="i_update" id="i_update" value="Update"  /></form></span><?php }?></h3></th></thead>
                        <tr>
                          <th rowspan="2"  style="text-align:center; vertical-align:middle">Description</th>
                          <th colspan="2" style="text-align:center; vertical-align:middle">Progress</th>
                        </tr>
                        <tr>
                          <th>Planned</th>
                          <th>Achieved</th>
                        </tr>
                      <tbody>
<?php
		while ($apdata = mysql_fetch_array($apSQLResult)) {
					echo '<tr><td>'.$apdata['act_id'].'</td><td align="right">'.number_format($apdata['planned_percent'],2). " %".'</td><td align="right">'.number_format($apdata['actual_percent'],2). " %". '</td></tr>';
		}
?> 
      </tbody>
    </table>

  </figure>
  
  <figure class="box3">
  <?php  
  
$funSQL1 = "SELECT fid,fund_year1,fund_year2 ,fund_year3,fund_year4,fund_psdp_alloc_y1,fund_psdp_alloc_y2,fund_psdp_alloc_y3,fund_psdp_alloc_y4, fund_released, fund_expense, fund_paid FROM t003funds WHERE pid = ".$pid;
$funSQLResult1 = mysql_query($funSQL1);
$fundata1 = mysql_fetch_array($funSQLResult1);
$fid = $fundata1['fid']; 
$year1 = $fundata1['fund_year1']; 
$year2 = $fundata1['fund_year2'];
$year3 = $fundata1['fund_year3'];
$year4 = $fundata1['fund_year4'];
$alloc1 = $fundata1['fund_psdp_alloc_y1']; 
$alloc2 = $fundata1['fund_psdp_alloc_y2']; 
$alloc3 = $fundata1['fund_psdp_alloc_y3']; 
$alloc4 = $fundata1['fund_psdp_alloc_y4']; 
$release = $fundata1['fund_released'];
$expense = $fundata1['fund_expense'];
$paid = $fundata1['fund_paid'];
 
?>  
 




  <table  style="border:thick #000; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="4"><h3>Financial Status till Date in <?php echo $proj_cur;?> 
					  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_financial_info_input.php?fid=<?php echo $fid; ?>" target="_self" method="post"><input type="submit" name="f_update" id="f_update" value="Update"  /></form></span><?php } ?></h3></th>
                     </thead>
                      <tbody>
                        <tr>
                          <td width="56" rowspan="4"><strong>PSDP Allocation</strong></td>
                          <td width="56"><?php echo $year1; ?></td>
                          <td width="84" align="right"><?php if($alloc1!=""&&$alloc1!=NULL&&$alloc1!=0)
						  echo number_format($alloc1,3); ?></td>
                        </tr>
                        <tr>
                          <td><?php echo $year2; ?></td>
                          <td width="84" align="right"><?php if($alloc2!=""&&$alloc2!=NULL&&$alloc2!=0)
						  echo number_format($alloc2,3); ?></td>
                        </tr>
						<tr>
                          <td><?php echo $year3; ?></td>
                          <td width="84" align="right"><?php if($alloc3!=""&&$alloc3!=NULL&&$alloc3!=0)
						  echo number_format($alloc3,3); ?></td>
                        </tr>
						<tr>
                          <td><?php echo $year4; ?></td>
                          <td width="84" align="right"><?php if($alloc4!=""&&$alloc4!=NULL&&$alloc4!=0)
						  echo number_format($alloc4,3); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Funds Released</strong></td>
                          <td align="right"><?php if($release!=""&&$release!=NULL&&$release!=0)
						  echo number_format($release,3); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Expenditure</strong></td>
                          <td align="right"><?php if($expense!=""&&$expense!=NULL&&$expense!=0)
						  echo number_format($expense,3); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Payment to Contractor</strong></td>
                          <td align="right"><?php if($paid!=""&&$paid!=NULL&&$paid!=0)
						  echo number_format($paid,3); ?></td>
                        </tr>
                      </tbody>
                    </table> 
  </figure>
  <figure class="box4">
<?php  
$issueSQL = "SELECT iss_id, iss_title, iss_detail FROM t012issues where pid = ".$pid. " order by iss_id asc limit 100";
$issueSQLResult = mysql_query($issueSQL);
?>  
                      
<table  style="border:thick #000; width:100%; height:100%; padding:10px;">
                      <thead><th colspan="2"><h3>Major/Current Issues  <?php if($adminflag==1)
								  {
								   ?><span style="float:right"><form action="sp_issues_info.php" target="_self" method="post"><input type="submit" name="i_update" id="i_update" value="Manage"  /></form></span><?php } ?></h3> </th></thead></table>

<marquee id="MARQUEE1" style="text-align: left; float: left; height: 210px;" scrollamount="3" onmouseout="this.start();" onmouseover="this.stop();" direction="up" behavior="scroll">







                      <ul class="list-unstyled timeline widget">
<?php
                while ($issuedata = mysql_fetch_array($issueSQLResult)) {
				$iss_id=$issuedata['iss_id'];
					   echo '<li>';
                        echo '<div class="block">';
                          echo '<div class="block_content">';
                            echo '<h2 class="title">';
                               echo "<a href='sp_issue.php?iss_id=$iss_id' target='_self'>".$issuedata['iss_title'].'</a>';
                            echo '</h2>';
                           
                          echo '</div>';
                        echo '</div>';
                      echo '</li>';
				}
?>
                     </ul>
		

 </marquee>
  
  </figure>
<figure class="box5">

<table  style="border:thick #000; width:100%; height:100%; padding:0px;">
                      <thead><th colspan="2"><h3>More...</h3></th></thead>
                      <tbody>
                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_pc1.php"><input type="submit" value="PC-1 Summary" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_align.php"><input type="submit" value="Project Layout Plan" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td style="width:50%;padding:0px; margin:0px;"><span style="width:50%; height:100%; padding:0px; margin:0px;"><form action="sp_finstatus.php"><input type="submit" value="Financial Status" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></span></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_typx.php"><input type="submit" value="Line Balance Diagram" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_contmob.php"><input type="submit" value="Contractor's Mobilization" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_gphoto.php"><input type="submit" value="Graphical Progress" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_cashflow.php"><input type="submit" value="Cash Flow Requirement" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_photo.php"><input type="submit" value="Progress Photographs" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_security_info.php"><input type="submit" value="Security" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_dphoto.php"><input type="submit" value="Drawings" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td  style="width:50%;padding:0px; margin:0px;"><span style="width:50%; height:100%; padding:0px; margin:0px;"><form action="sp_component_wise.php"><input type="submit" value="Component Wise KPIs" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></span></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_video.php"><input type="submit" value="Videos" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>

                        <tr style="padding:0px; margin:0px;"><td width="50%" style="padding:0px; margin:0px;"><form action="sp_deva.php"><input type="submit" value="Earned Value Analysis" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td><td width="50%" style="padding:0px; margin:0px;"><form action="sp_qaqc.php"><input type="submit" value="QA/QC Tests" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td></tr>
                        
                        <tr><td width="50%" style="padding:0px; margin:0px;"><form action="sp_financial_disbur.php"><input type="submit" value="Financial Disbursments" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td>
                    <td width="50%" style="padding:0px; margin:0px;"><form action="sp_dpm_vo2.php"><input type="submit" value="VO2 Critical Analysis" style="width:100%; height:20px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></td>    </tr>
                        <tr><td  style="width:50%;"><span style="width:50%; height:100%; padding:0px; margin:0px;"><form action="sp_maindashboard.php"><input type="submit" value="Projects List" style="width:100%; height:40px; margin:0px; padding:0px; font-family:Verdana, Geneva, sans-serif; font-size:10px;font-weight:bold;"></form></span></td>
                          <td style="width:50%"> <span style="width:50%; height:100%; padding:0px; margin:0px;"><a href="http://www.egcpakistan.com/index.php?id=it" target="_blank"><img src="egc.jpg" width="40px" style="padding:0px;" align="right" /><img src="smec.jpg" width="100px" style="padding:0px;" align="right" /></a></span> </td>
                        </tr>
                      </tbody>
    </table> 
  </figure>
</div>
</body>
</html>
