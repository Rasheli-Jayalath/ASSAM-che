
<?php
if ($adata["isentry"]==0&&$adata["activitylevel"]==0) {


$scalesql = "select max(scmonth) as lastMonth from kpiscale";
$scaleresult = mysql_query($scalesql);
$scalerows = mysql_fetch_array($scaleresult);
$lastMonth=$scalerows['lastMonth'];
$lastMonth = str_replace("-","",$lastMonth);
?>
<div id="result1" style="margin-top:10px">
<table  cellpadding="0px" cellspacing="0px"   width="100%" align="center"  id="tblList" style="border-left:1px #000000 solid;">

<tr bgcolor="000066" style=" color:#FFF">
<td colspan="31" align="center"><span class="white"><strong><?php echo $pdata["pdetail"];?> (Project Level)</strong></span></td>
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
    <?php $scalesql = "SELECT DISTINCT(scquarter),scyear FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
 ?>
  <th colspan="3" width="9%">Quarter <?php echo $scalerows["scquarter"]." ".$scalerows["scyear"];?> </th>
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
//$lastMonth=$scalerows['lastMonth'];
//$lastMonth = str_replace("-","",$lastMonth);
$dprogress_month=date('M',strtotime($scalerows["scmonth"])); ?>
<th><?php echo $dprogress_month;?></th>
<?php }?>
<!--  <th width="110">Contract Amount</th> -->  
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
$reportquery ="SELECT z.itemid,z.itemname, z.itemcode, z.parentcd,z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, sum(b.baseline) as baseline,z.parentgroup,z.activitylevel, b.rid FROM maindata z left outer join kpi_activity a on (z.itemid=a.kpiid) left outer join activity b on (a.activityid=b.aid) left outer join mildata c on (b.itemid=c.itemid AND b.rid=c.rid) where z.parentgroup LIKE '".$aparentgroup."%' Group by z.itemid order by z.aorder ";
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
	 if($reportdata["rid"]!=""&&$reportdata["rid"]!=0)
	{
	 $res_query="SELECT * from resources where rid=".$reportdata["rid"];
	$ress = mysql_query($res_query);
	$res_data=mysql_fetch_array($ress);
	}
  $bgcolor = ($bgcolor == "#FFFFFF") ? "#EAF4FF" : "#FFFFFF";
  $pcurrent=$data_level_id;
  if($reportdata['activitylevel']==1)
  {
  $current=$reportdata["itemid"];
  }
  if($reportdata['activitylevel']==2)
  {
  $current1=$reportdata["itemid"];
  }
  $current2=$reportdata["itemid"];
                            
?>
<?php
 $pro_prog_till_month=0;
 $pro_targ_till_month=0;
 $pro_prog_till_month=getProjectCommProgC($lastMonth,$data_level_id,$till_end);
 $pro_targ_till_month=getProjectCommTargC($lastMonth,$data_level_id,$till_end);
  if($reportdata['activitylevel']==0)
  {
if($pprev!=$pcurrent)
{
?>
<tr bgcolor="#00CC66">
  <td width="5%" rowspan="2" style="text-align:right;"><strong><?php echo $reportdata['itemcode']; ?></strong></td>
  <td width="40%" rowspan="2" style="text-align:left;"><div align="left"><strong><?php echo $reportdata['itemname']; ?></strong></div></td>
  <td width="4%" rowspan="2" style="text-align:center;"><?php echo "%";?></td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td height="20" align="right" bgcolor="#00CC66"><span style="text-align:right;">Achieved:</span></td>
  <td style="text-align:right;">Accumulative</td>
  <td style="text-align:right;"><?php echo number_format($pro_prog_till_month*100,2). "%";?></td>
  <?php	$scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
									$pro_prog_month=0;
	 								$pro_prog_month=getProjectCommProgC($lastMonth,$data_level_id,$scmonth); 
	 ?>
  <td style="text-align:right;"><?php echo number_format($pro_prog_month*100,2). "%";?></td>
<?php }?>
</tr>
<tr bgcolor="#00CC66">
<td width="5%" height="20" align="right" ><span style="text-align:right;">Target:</span></td>
<td style="text-align:right;" width="5%">Accumulative</td>
<td style="text-align:right;" width="5%"><?php echo number_format($pro_targ_till_month*100,2). "%";?></td>
<?php	$scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
									 $pro_targ_month=0;
	 								 $pro_targ_month=getProjectCommTargC($lastMonth,$data_level_id,$scmonth);
	 ?>
<td style="text-align:right;" width="9%"><?php echo number_format($pro_targ_month*100,2). "%";?></td>
<?php } ?>
<!--<td style="text-align:left;"></td>-->
</tr>
<?php
}
  }
?>
<?php
if($reportdata['activitylevel']==1)
  {
if($prev!=$current)
{
	 $com_prog_till_month=0;
	 $com_targ_till_month=0;
  $com_prog_till_month=getComponentCommProgC($lastMonth,$reportdata["itemid"],$till_end);
  $com_targ_till_month=getComponentCommTargC($lastMonth,$reportdata["itemid"],$till_end);
?>
<tr bgcolor="#0099CC">
  <td width="5%" rowspan="2" style="text-align:right;"><strong><?php echo $reportdata['itemcode']; ?></strong></td>
  <td width="40%" rowspan="2" style="text-align:left;"><div align="left"><strong><?php echo $reportdata['itemname']; ?></strong></div></td>
  <td width="4%" rowspan="2" style="text-align:center;"><?php echo "%";?></td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:left;">&nbsp;</td>
  <td width="5%" rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'],2). " %"; ?></td>
  <td height="20" align="right"><span style="text-align:right;">Achieved:</span></td>
  <td style="text-align:right;">Accumulative</td>
  <td style="text-align:right;"><?php echo number_format($com_prog_till_month*100,2). "%";?></td>
    <?php $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									 $com_prog_month=0;
									$scmonth=$scalerows['scmonth'];
									 $com_prog_month=getComponentCommProgC($lastMonth,$reportdata["itemid"],$scmonth);
									 ?>
  <td style="text-align:right;"><?php echo number_format($com_prog_month*100,2). "%";?></td>
 <?php }?>
</tr>
<tr bgcolor="#0099CC">
<td width="5%" height="20" align="right" ><span style="text-align:right;">Target:</span></td>
<td style="text-align:right;">Accumulative</td>
<td style="text-align:right;" width="5%"><?php echo number_format($com_targ_till_month*100,2). "%";?></td>
 <?php $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$i++;
									$scmonth=$scalerows['scmonth'];
										$com_targ_month=0;
										 $com_targ_month=getComponentCommTargC($lastMonth,$reportdata["itemid"],$scmonth);
										
									 ?>
<td style="text-align:right;" width="9%"><?php echo number_format($com_targ_month*100,2). "%";?></td>
<?php }?>


<!--<td style="text-align:left;"></td>-->
</tr>
<?php
} 
 }
?>

<?php 
if($reportdata['activitylevel']==2)
  {
if($prev1!=$current1)
{?>
<tr style="background-color:#9CC;">
  <td rowspan="2" style="text-align:right;"><strong><?php echo $reportdata['itemcode']; ?></strong></td>
  <td rowspan="2" style="text-align:left;"><strong><?php  echo $reportdata['itemname']; ?></strong></td>
  <td rowspan="2" style="text-align:left;">&nbsp;</td>
  <td rowspan="2" style="text-align:left;"></td>
  <td rowspan="2" style="text-align:left;">&nbsp;</td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'],2)."&nbsp;%"; ?></td>
  <td height="20" style="text-align:right;"><?php 
?>
    Achieved:</td>
  <td style="text-align:right;">Accumulative</td>
  <?php
   $sub_com_prog_till_month=0;
   $sub_com_targ_till_month=0;
    $sub_com_prog_till_month=getSubComponentCommProgC($lastMonth,$reportdata["itemid"], $till_end);
	$sub_com_targ_till_month=getSubComponentCommTargC($lastMonth,$reportdata["itemid"],$till_end);
	  	$till_last_month=date("Y-m-d",strtotime("$start -1 month"));?>
        <td style="text-align:right;"><?php  echo number_format($sub_com_prog_till_month*100,2). "%";?></td>
        <?php
    $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
									$scmonth=$scalerows['scmonth'];
									$sub_com_prog_month=0;
							 		$sub_com_prog_month=getSubComponentCommProgC($lastMonth,$reportdata["itemid"],$scmonth);
									 ?>
    <td style="text-align:right;"><?php  echo number_format($sub_com_prog_month*100,2). "%";?></td>
								<?php }?>
  </tr>
<tr style="background-color:#9CC;">
  <td height="20" style="text-align:right;">Target:</td>
  <td style="text-align:right;">Accumulative</td>
  <td style="text-align:right;"><?php  echo number_format($sub_com_targ_till_month*100,2). "%";?></td>
       <?php
    $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid 
									  ASC";
									$scaleresult = mysql_query($scalesql);
									$total_months = mysql_num_rows($scaleresult);
									while($scalerows = mysql_fetch_array($scaleresult))
									{
										$sub_com_targ_month=0;
									$scmonth=$scalerows['scmonth'];
	 								$sub_com_targ_month=getSubComponentCommTargC($lastMonth,$reportdata["itemid"],$scmonth);
									 ?>
  <td style="text-align:right;"><?php  echo number_format($sub_com_targ_month*100,2). "%";?></td>
 <?php }?>
</tr>
<?php
}
  }
?>
<?php 
if($reportdata['activitylevel']==3)
  {
	  if($prev2!=$current2)
{ $baseline=$reportdata["baseline"];	
	$till_month_targ=0;
	$till_month_prog=0;?>
<tr   style="background-color:<?php echo $bgcolor;?>;">
  <td rowspan="2" style="text-align:right;"><?php echo $reportdata['itemcode']; ?></td>
  <td rowspan="2" style="text-align:left;"><?php echo $reportdata['itemname']; ?></td>
   <td rowspan="2" style="text-align:center;"><?php echo $res_data["unit"];?></td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($baseline,0); ?></td>
  <td rowspan="2" style="text-align:right;">&nbsp;</td>
  <td rowspan="2" style="text-align:right;"><?php echo number_format($reportdata['weight'])."&nbsp;%"; ?></td>
  <td height="20" style="text-align:right;">Achieved:</td>
  <td style="text-align:right;">Accumulative</td>
  <?php 				
									$latest_month=$end;
									$last_month=$till_end;		
								
									$ptodate=getMilestoneTotalAchieveCLatest($latest_month,$reportdata['itemid']);
									$ptolast=getMilestoneTotalAchieveCLast($last_month,$reportdata['itemid']);
									$todate=getMilestoneTotalTargetsCLatest($latest_month,$reportdata['itemid']);
									$tolast=getMilestoneTotalTargetsCLast($last_month,$reportdata['itemid']);
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
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
$month_prog=0;
?>
     <?php 
									$month_machieve=getMilestoneAchieveCCC($scmonth,$reportdata['itemid']);
									
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
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];
$month_targ=0;
?>
     <?php 
									
									$month_mtargets=getMilestoneTargetsCCC($scmonth,$reportdata['itemid']);
									
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
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];

?>
 <?php 
									$pmonth_machieve=getMilestoneAchievePC($scmonth,$reportdata['itemid']);
									
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
 
 $scalesql = "SELECT scmonth FROM kpiscale WHERE  scmonth>='".$start."' AND scmonth<='".$end."' order by scid ASC";
$scaleresult = mysql_query($scalesql);
while($scalerows = mysql_fetch_array($scaleresult))
{
$scmonth=$scalerows['scmonth'];

?>
  <?php 	
									$pmonth_mtargets=getMilestoneTargetsPC($scmonth,$reportdata['itemid']);
									 ?>
  <td style="text-align:right;"><?php 
									echo number_format($pmonth_mtargets,2);?></td>
<?php }?>
</tr>
<?php
}
  }
?>




<?php
$pprev=$reportdata['pid'];
if($reportdata['activitylevel']==1)
{
$prev=$reportdata['cid'];
}
if($reportdata['activitylevel']==2)
{
$prev1=$reportdata['s_id'];
}
$prev2=$reportdata['aid'];
}
?>
</table>
</div>
<?php
}
?>
