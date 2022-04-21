
<?php
if ($parentgroup!=0&&$parentgroup!="") {
	$scalesql = "select max(scmonth) as lastMonth from kpiscale";
$scaleresult = mysql_query($scalesql);
$scalerows = mysql_fetch_array($scaleresult);
$lastMonth=$scalerows['lastMonth'];
$lastMonth = str_replace("-","",$lastMonth);

?>
<div id="result1" style="margin-top:10px">
<?php  			 


$i=0;
$progress=0;
	  $cdetail=$gdetailqdata["itemname"];
	  $kpiid=$gdetailqdata["kpiid"];
	  $isentry=$gdetailqdata["isentry"];
	 if($isentry==1)
	 {
		 	$baseline=$reportdata_sub1['baseline'];
			 $mdetail=$reportdata_sub1["itemcode"];
			 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$gend."' order by scid ASC";
									 $scaleresult = mysql_query($scalesql);
									 $total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
										$i++;
									$scmonth=$scalerows['scmonth'];	
									$scid=$scalerows['scid'];	
									 $pdate=date('Y-m-d',strtotime($scmonth));
									 $m=date('m',strtotime($pdate));
									 $y=date('Y',strtotime($pdate));
									 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
									 $pdate=$y."-".$m."-".$days;
									 $scmonth=$pdate;
									$month_mtargets=getMilestoneTargetsCCC($scid,$kpiid);
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }
									$month_machieve=getMilestoneAchieveCCC($scid,$kpiid);
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
																
							
									   $m=$m-1;
									$planned_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
									 ",".date('d',strtotime($pdate)). ") , ".number_format($month_targ,2)." ]";
									 
									 $actual_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
									 ",".date('d',strtotime($pdate)). ") , ".number_format($month_prog,2)." ]";
									 if($i<$total_months)
									 {
									 $planned_str .=" , ";
									 $actual_str .=" , ";
									  
									 }
									 $diff=$month_targ-$month_prog; 
									 } ?>
<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<?php echo  trim($cdetail);?>'
            },
            subtitle: {
                text: '<?php echo "(Progress ".date('Y',strtotime($lastMonth)).")";?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                month: '%m-%Y',
                year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '% Done'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' %';
                }
            },
             legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 30,
            floating: true/*,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
        },
            series: [
			<?php  			
				
			 ?> {
                name: '<?php echo "Actual Progress   :  ".number_format($month_prog,2) ." %";?>
				',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
			
                   <?php echo $actual_str;?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
            },
			{
                 name: '<?php echo "Planned Progress : ".number_format($month_targ,2)." %"; ?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
			
                  <?php echo $planned_str;?>
					
                    
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
			
            }
			,
			{
                name: '    <?php echo "    Gap : ".number_format(($month_targ-$month_prog),2)." %";?>',
				
				color: 'white',
                
				marker: {
               
                 enabled: false,
				 visible: false
            }
			
            }
			
			]
        });
    });
    

		</script>						
	 <?php }
	 else
	 {
	  $pro_prog_till_month=getProjectCommProgC($till_end_scid, $kpiid);
	  $pro_targ_till_month=getProjectCommTargC($till_end_scid, $kpiid);
	  $till_last_month=$till_end;
	  $mm=date('m',strtotime($till_last_month));
	  $yy=date('Y',strtotime($till_last_month));
	  $dayss=cal_days_in_month(CAL_GREGORIAN, $mm, $yy); 
	  $till_last_month=$yy."-".$mm."-".$dayss;
	  $mm=$mm-1;
	 /* $planned_str ="[Date.UTC(".date('Y',strtotime($till_last_month)). ",".$mm.
	  ",".date('d',strtotime($till_last_month)). ") , ".number_format($pro_targ_till_month*100,2)." ]";
	  $planned_str .=" , ";
	  $actual_str .="[Date.UTC(".date('Y',strtotime($till_last_month)). ",".$mm.
	  ",".date('d',strtotime($till_last_month)). ") , ".number_format($pro_prog_till_month*100,2)." ]";
	  $actual_str .=" , ";*/
	   $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$gend."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
									$scid=$scalerows['scid'];
									
										  
										 $pro_prog_month=getProjectCommProgC($scid,$kpiid); 
										 $pro_targ_month=getProjectCommTargC($scid,$kpiid);
										
									
									 $pdate=date('Y-m-d',strtotime($scmonth));
									 $m=date('m',strtotime($pdate));
									 $y=date('Y',strtotime($pdate));
									 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
									 $pdate=$y."-".$m."-".$days;
									 $m=$m-1;
									$planned_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
									 ",".date('d',strtotime($pdate)). ") , ".number_format($pro_targ_month*100,2)." ]";
									 $actual_str .="[Date.UTC(".date('Y',strtotime($pdate)). ",".$m.
									 ",".date('d',strtotime($pdate)). ") , ".number_format( $pro_prog_month*100,2)." ]";
									 if($i<$total_months)
									 {
									 $planned_str .=" , ";
									 $actual_str .=" , ";
									  
									 }
					 				$diff=$pro_targ_month- $pro_prog_month;

									}

	 ?>
        <script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<?php echo  trim($cdetail);?>'
            },
            subtitle: {
                text: '<?php echo "Progress(".date('Y',strtotime($lastMonth)).")";?>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                month: '%m-%Y',
                year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '% Done'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%d-%m-%Y', this.x) +': '+ this.y +' %';
                }
            },
             legend: {
            layout: 'vertical',
            align: 'left',
            x: 90,
            verticalAlign: 'top',
            y: 30,
            floating: true/*,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'*/
        },
            series: [
			<?php  			
				
			 ?> {
                name: '<?php echo "Actual Progress   :  ".number_format($pro_prog_month*100,2) ." %";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				   
                    <?php echo $actual_str;	?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
            },
			{
                name: '<?php echo "Planned Progress : ".number_format($pro_targ_month*100,2)." %";?>',
                // Define the data points. All series have a dummy year
                // of 1970/71 in order to be compared on the same x axis. Note
                // that in JavaScript, months start at 0 for January, 1 for February etc.
                data: [
				
                   <?php echo $planned_str;	?>
                    
                   
                ]
				,
				marker: {
               
                 radius : 1
            }
			
            }
			,
			{
                name: '    <?php echo "    Gap : ".number_format(($diff)*100,2)." %";?>',
				
				color: 'white',
                
				marker: {
               
                 enabled: false,
				 visible: false
            }
			
            }
			
			]
        });
    });
    

		</script>
        <?php }?>
        
<table width="99%"  align="right" border="0" style="margin:5px 5px 5px 7px">
      
      <tr>
        <td height="99"  style="line-height:18px; text-align:justify; vertical-align:top">
          <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
          </td>
        
        </tr>
      
  </table>
<table  cellpadding="0px" cellspacing="0px"   width="100%" align="center"  id="tblList" style="border-left:1px #000000 solid;">

<tr bgcolor="000066" style=" color:#FFF">
<td colspan="30" align="center"><span class="white"><strong><?php echo $pdata["pdetail"];?> (Progress Report)</strong></span></td>
</tr>
<tr>

  <th width="5%" ></th>
  <th width="40%"></th>
  <th  width="4%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
  <th  width="5%">&nbsp;</th>
   <th  width="5%">&nbsp;</th>
    <?php 
	
	 $scalesql = "SELECT DISTINCT(scquarter),scyear FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
     $scaleresult = mysql_query($scalesql);
     $numrows = mysql_num_rows($scaleresult);
while($scalerows = mysql_fetch_array($scaleresult))
{
	$scalesqln = "SELECT count(scmonth) as tmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."'  AND scquarter=".$scalerows["scquarter"]." AND scyear='".$scalerows["scyear"]."'";
  
	$scaleresultn = mysql_query($scalesqln);
	$trowsres = mysql_fetch_array($scaleresultn);
  $scalerows["scquarter"] ."-";
  $total_rows=$trowsres["tmonth"];
    
 ?>
  <th <?php if($total_rows==3)
	{?>colspan="3" <?php } elseif($total_rows==2){?>colspan="2"<?php } else{?> colspan="1"<?php }?> width="9%">Quarter <?php echo $scalerows["scquarter"]." ".$scalerows["scyear"];?> </th>
<?php }?>
<tr >
<th width="5%" height="37">#</th>
<th width="40%"><div align="left">Indicators</div></th>
<th width="4%">UOM</th>
<th width="5%">Baseline</th>
<th width="5%">Total Achieved/Target</th>
<th width="5%">% Weighted</th>
<th width="5%">Achieved/Target</th>
<th>Aggregation</th>

<th>Till  <?php 
echo $till_last_month=date("M Y",strtotime("$start -1 month")); ?></th>
 <?php 
$scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$dprogress_month=date('M',strtotime($scalerows["scmonth"])); ?>
<th><?php echo $dprogress_month;?></th>
<?php }?> 
</tr>
<?php 
$mob_weighted_progress=0;
$current=0;
$prev=0;
$current1=0;
$prev1=0;
$current2=0;
$prev2=0;
//$latest_month=0;
$latest_achieved=0;
$pro_prog=0;
$pro_prog_p=0;
$baseline=0;
$todate=0;
$tolast=0;
$ptodate=0;
$ptolast=0;
$reportquery ="SELECT * FROM kpidata where parentgroup LIKE '".$parentgroup."%'  Order By kpiid,itemcode ";
$i=0;
$progress=0;
$pcurrent=0;
$pprev=0;
$reportresult = mysql_query($reportquery);
while ($reportdata = mysql_fetch_array($reportresult)) {
	 $progress=0;
	 $till_jan_prog=0;
	 $till_jan_targ=0;
	 $latest_achieved=0;
	 $latest_targets=0;

  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
  $pcurrent=$data_level_id;                           
?>
<?php
$pro_prog_till_month=0;
$pro_targ_till_month=0;
$pro_prog_till_month=getProjectCommProgC($till_end_scid, $reportdata['kpiid']);
$pro_targ_till_month=getProjectCommTargC($till_end_scid, $reportdata['kpiid']);
 
if($reportdata['isentry']==1)
  {
	$reportquery_sub ="SELECT sum(baseline) as baseline, unit FROM kpi_base_level_report where kpiid=".$reportdata['kpiid']." Group By kpiid,scid";
	$reportresult_sub = mysql_query($reportquery_sub);
    $reportdata_sub = mysql_fetch_array($reportresult_sub);
 $i=0;
 $progress=0;
 $pcurrent=0;
 $pprev=0;
 $baseline=$reportdata_sub["baseline"];	
	$till_month_targ=0;
	$till_month_prog=0;?>
<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td rowspan="2" style="text-align:right;"><?php echo $reportdata['itemcode']; ?></td>
  <td rowspan="2" style="text-align:left;"><?php echo $reportdata['itemname']; ?></td>
   <td rowspan="2" style="text-align:center;"><?php echo $reportdata_sub["unit"];?></td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($baseline,0); ?></td>
  <td rowspan="2" style="text-align:right;">&nbsp;</td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'],2)."&nbsp;%"; ?></td>
  <td height="20" style="text-align:right;">Achieved:</td>
  <td style="text-align:right;">Accumulative</td>
  <?php 				
									$latest_month=$end;
									$last_month=$till_end;		
								
									
									
									$tolast=getMilestoneTotalTargetsCLast($till_end_scid,$reportdata['kpiid']);
									$ptolast=getMilestoneTotalAchieveCLast($till_end_scid,$reportdata['kpiid']);
									$todate=getMilestoneTotalTargetsCLatest($end_scid,$reportdata['kpiid']);
									$ptodate=getMilestoneTotalAchieveCLatest($end_scid,$reportdata['kpiid']);
									if($baseline!=0&&$tolast!=0)
									 {
										  $till_month_targ=($tolast/$baseline)*100;
									 }
									
									if($baseline!=0&&$ptolast!=0)
									 {
										
										$till_month_prog=($ptolast/$baseline)*100;
									 }
									if($baseline!=0&&$ptodate!=0)
									 {
										 $progress=($ptodate/$baseline)*100;
										
									 } ?>
  <td style="text-align:right;"><?php echo number_format($till_month_prog,2). "%";?></td>
   <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];
$month_prog=0;
?>
     <?php 
									$month_machieve=getMilestoneAchieveCCC($scid,$reportdata['kpiid']);
									
									if($baseline!=0&&$month_machieve!=0)
									 {
										 $month_prog=($month_machieve/$baseline)*100;
									 }
								 ?>
  <td style="text-align:right;"><?php echo number_format($month_prog,2). "%";?></td>
<?php }?>
  </tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
<td style="text-align:right;">Target:</td>
<td style="text-align:right;">Accumulative</td>
<td style="text-align:right;"><?php echo number_format($till_month_targ,2). "%";?></td>
   <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];
$month_targ=0;
?>
     <?php 
									
									$month_mtargets=getMilestoneTargetsCCC($scid,$reportdata['kpiid']);
									
									if($baseline!=0&&$month_mtargets!=0)
									 {
										 $month_targ=($month_mtargets/$baseline)*100;
									 }				
																
									
									?>
<td style="text-align:right;"><?php echo number_format($month_targ,2). "%";?></td>
<?php }?>
</tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
<td rowspan="2" style="text-align:right;">&nbsp;</td>
<td rowspan="2" style="text-align:right;">&nbsp;</td>
<td rowspan="2" style="text-align:left;">&nbsp;</td>
<td rowspan="2" style="text-align:left;">&nbsp;</td>
<td height="20" style="text-align:right;"><?php echo number_format($ptodate,2);?></td>
<td style="text-align:left;">&nbsp;</td>
<td style="text-align:right;"><strong>Achieved</strong>:</td>
<td style="text-align:right;"><strong>Monthly</strong></td>
<td style="text-align:right;"><?php echo number_format($ptolast,2);?></td>
 <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];
?>
 <?php 
									$pmonth_machieve=getMilestoneAchievePC($scid,$reportdata['kpiid']);
									
									?>
<td style="text-align:right;"><?php 
									echo number_format($pmonth_machieve,2);?></td>
<?php }?>

</tr>
<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td height="20" style="text-align:right;"><?php echo number_format($todate,2);?></td>
  <td style="text-align:left;">&nbsp;</td>
  <td style="text-align:right;"><strong>Target</strong>:</td>
  <td style="text-align:right;"><strong>Monthly</strong></td>
  <td style="text-align:right;"><?php echo number_format($tolast,2);?></td>
   <?php 
 
 $scalesql = "SELECT scid,scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
$scid=$scalerows['scid'];

?>
  <?php 	
									$pmonth_mtargets=getMilestoneTargetsPC($scid,$reportdata['kpiid']);
									 ?>
  <td style="text-align:right;"><?php 
									echo number_format($pmonth_mtargets,2);?></td>
<?php }?>
</tr>
<?php

  }
  
  else
  {
?>

<?php  $colorq="SELECT 	kpi_color from 	kpi_colors where kpi_actlevel=".$reportdata['activitylevel'];
 $colorresult = mysql_query($colorq);
 $colordata=mysql_fetch_array($colorresult);?>
<tr bgcolor="<?php echo $colordata["kpi_color"];?>">
  <td width="5%" rowspan="2" style="text-align:right;"><strong><?php echo $reportdata['itemcode']; ?></strong></td>
  <td width="40%" rowspan="2" style="text-align:left;"><div align="left"><strong><?php echo $reportdata['itemname']; ?></strong></div></td>
  <td width="4%" rowspan="2" style="text-align:center;"><?php echo "%";?></td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'],2)."&nbsp;%"; ?></td>
  <td height="20" align="right" bgcolor="<?php echo $colordata["kpi_color"];?>"><span style="text-align:right;">Achieved:</span></td>
  <td style="text-align:right;">Accumulative</td>
  <td style="text-align:right;"><?php echo number_format($pro_prog_till_month*100,2). "%";?></td>
  <?php	$scalesql = "SELECT scid, scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
									$scid=$scalerows['scid'];
									$pro_prog_month=0;
	 								$pro_prog_month=getProjectCommProgC($scid,$reportdata['kpiid']); 
	 ?>
  <td style="text-align:right;"><?php echo number_format($pro_prog_month*100,2). "%";?></td>
<?php }?>
</tr>
<tr bgcolor="<?php echo $colordata["kpi_color"];?>">
<td width="5%" height="20" align="right" ><span style="text-align:right;">Target:</span></td>
<td style="text-align:right;" width="5%">Accumulative</td>
<td style="text-align:right;" width="5%"><?php echo number_format($pro_targ_till_month*100,2). "%";?></td>
<?php	$scalesql = "SELECT scid, scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
									$scid=$scalerows['scid'];
									 $pro_targ_month=0;
	 								$pro_targ_month=getProjectCommTargC($scid,$reportdata['kpiid']);
	 ?>
<td style="text-align:right;" width="9%"><?php echo number_format($pro_targ_month*100,2). "%";?></td>
<?php } ?>
<!--<td style="text-align:left;"></td>-->
</tr>


<?php
  }

}
?>
</table>
</div>
<?php
}
?>
