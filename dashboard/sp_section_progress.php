<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include_once("connect.php");
include_once("functions.php");
} else {
	header("Location: index.php?msg=0");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
 
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>
 
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%"><td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Section Wise Progress</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
 
  <tr style="height:80%"><td align="center" valign="top"><?php if($adminflag==1){?>
  <span style="text-align:right; vertical-align:top; margin:0; padding:0">
  <form action="sp_section_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Add New Section" /></form></span>
  <?php
  }
  ?>
 <div style="overflow-y: scroll; height:220px;">
  <table class="table table-bordered">
                              <thead>
                              <tr>
                              <th colspan="50" style="font-size:18px">
                             <strong> Section Wise Progress</strong>
                              </th>
                              </tr>
                                <tr>
                                  <th  rowspan="2" style="text-align:center; vertical-align:middle">Layers</th>
                                  <?php
								  $tototal_uts=0;
								  $j=1;
								  $sections_str="";
						$pdSQLs="SELECT sid, pid, sec_name, sec_no, sec_chainage, sec_length, sec_weight FROM t004sections where pid = ".$pid;
						$pdSQLResults = mysql_query($pdSQLs) or die(mysql_error());
						$tototal_uts= mysql_num_rows($pdSQLResults);
						if($tototal_uts >= 1){
						while($rows_cm = mysql_fetch_array($pdSQLResults))
						{
							$sections_str .= "'".$rows_cm["sec_name"]."'";
							if($j<$tototal_uts)
							{
								$sections_str .= ",";
							}
							$j++;
								 	?>
                        <th colspan="2" style="text-align:center"><?php echo $rows_cm["sec_name"] ;?>  <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; vertical-align:top; margin:0; padding:0 "><form action="sp_section_input.php?sid=<?php echo $rows_cm["sid"] ;?>" method="post"><input type="submit" name="add_new " id="add_new" value="Manage Section" /></form></span>
  <?php
  }
  ?></th>
                                  <?php } 
									}?>
                                </tr>
                                <tr>
                                  <?php for($i=0; $i<$tototal_uts;$i++)
								  {?>
                                  <th  style="text-align:center">Planned</th>
                                  <th  style="text-align:center">Achieved</th>
                                
                                  <?php } ?>
                                </tr>
                              </thead>
                              <tbody><?php  
							  $planneddat="";
			
			$cm=1;
			$pdSQLa="SELECT act_id, act_name, act_weight, act_order FROM t011activities order by act_order  ";
					$pdSQLResulta = mysql_query($pdSQLa) or die(mysql_error());
					while($result=mysql_fetch_array($pdSQLResulta))
					{
				$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
				
				?>
                        <tr>
                          <td ><?php   echo $result['act_name'];?></td>
						  <?php
								 
	 							  $apSQL = "SELECT pspt_id, pid, sid, act_id, pspt_planned, pspt_actual, pspt_date FROM t025project_section_progress_table where pid=".$pid." AND act_id=".$result["act_id"]."  order by sid";

$apSQLResult = mysql_query($apSQL);
$tototal_prog=mysql_num_rows($apSQLResult);
$k=1;
								 	?>
                             <?php
		while ($apdata = mysql_fetch_array($apSQLResult)) {
					
					echo '<td align="right">'.number_format($apdata['pspt_planned'],2). " %".'</td>';
					echo '<td align="right">'.number_format($apdata['pspt_actual'],2). " %". '</td>';
		}
?>
                                        </tr>
                               <?php }
									?>
                              </tbody>
      </table>
						</div>
						</td></tr>
  <tr>
      <td>
	   <div style="overflow-y: scroll; height:220px;">
      <?php if($adminflag==1){?>
  <span style="text-align:right; vertical-align:top; margin:0; padding:0">
  <form action="sp_section_graph_input.php" method="post"><input type="submit" name="add_new_graph" id="add_new_graph" value="Manage Graph" />
  </form></span>
  <?php
  }
  ?>
			  <?php 
			  
		$apSQLS = "SELECT pspg_id, pid, sid, pspg_planned, pspg_actual, pspg_date FROM t028project_section_progress_graph  where pid = ".$pid. " order by sid ASC";

$apSQLResultS = mysql_query($apSQLS);
$tototal_prog=mysql_num_rows($apSQLResultS);
$k=1;
								 	?>
                             <?php
		while ($apdatas = mysql_fetch_array($apSQLResultS)) {
					$planneddata .=number_format($apdatas['pspg_planned'],2);
					$actualdata .=number_format($apdatas['pspg_actual'],2);
					if($k<$tototal_prog)
					{
					$planneddata .=",";
					$actualdata .=",";
					}
					$k++;
		}
			  
			  
        $title = "Progress as on ".date('F d, Y',strtotime($chartdatad['max_date']));
        $subtitle = "CURRENT PROGRESS SECTION WISE";
        $categories =  $sections_str;
        $xaxistitle = "Months";
        $yaxistitle = "Percentage";
        $data1name = "Planned";
        $data1 = $planneddata;
        $data2name = "Actual";
        $data2 = $actualdata;
        ?>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo "SECTION WISE PROGRESS" ?>'
        },
        subtitle: {
            text: '<?php echo $subtitle; ?>'
        },
        xAxis: {
            categories: [<?php echo $categories; ?>],
			title: { text: '<?php echo $xaxistitle; ?>' },
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


    <!--<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'SECTION WISE PROGRESS'
        },
        subtitle: {
            text: 'CURRENT PROGRESS SECTION WISE'
        },
        xAxis: {
            categories: ['Section 1','Section 2','Section 3'],
			title: { text: 'Months' },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Percentage'
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
            name: 'Planned',
			data: [22.00,23.00,24.00],
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
            name: 'Actual',
			data: [22.00,23.00,24.00],
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
</script>-->



<div id="container" style="min-width: 310px; height: 250px; margin: 0 auto"></div>
</div>
      </td>
      </tr>
  </table>
  </figure>
</div>
</body>
</html>
