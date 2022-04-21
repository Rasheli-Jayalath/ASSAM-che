<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$objDb  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($process_flag==0 ) {
header("Location: index.php?init=3");
}
//include("basetable.php");
//function mildatamaker($scid,$kpimonth) {
//
//
////SELECT '$kpimonth' as budgetdate, itemid, rid, sum(budgetqty) as planned, 0 as comm_planned FROM `planned` WHERE left(budgetdate,7) = '$kpimonth' group by itemid, rid
////SELECT '$kpimonth' as budgetdate, itemid, rid, 0 as planned, sum(budgetqty) as comm_planned FROM `planned` WHERE left(budgetdate,7) <= '$kpimonth' group by itemid, rid
//
///*
//select e.budgetdate, e.itemid as p_itemid, e.rid as p_rid, e.planned, e.comm_planned, f.progressdate, f.itemid as pp_itemid, f.rid as pp_rid, f.progress, f.comm_progress from
//(
//
//select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned from (SELECT '$kpimonth' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned FROM planned a WHERE left(a.budgetdate,7) = '$kpimonth' group by a.itemid, a.rid) c
//inner join 
//(SELECT '$kpimonth' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned FROM planned b WHERE left(b.budgetdate,7) <= '$kpimonth' group by b.itemid, b.rid) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid)
//
//) e left outer join
//(
//
//select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress from (SELECT '$kpimonth' as progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress FROM progress a1 WHERE left(a1.progressdate,7) = '$kpimonth' group by a1.itemid, a1.rid) c1
//inner join 
//(SELECT '$kpimonth' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress FROM progress b1 WHERE left(b1.progressdate,7) <= '$kpimonth' group by b1.itemid, b1.rid) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid)
//
//) f
//on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid)
//*/
//
//
///*
//select e.budgetdate, e.itemid, e.rid, e.planned, e.comm_planned, f.progress, f.comm_progress from
//(
//select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned from (SELECT '$kpimonth' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned FROM planned a WHERE left(a.budgetdate,7) = '$kpimonth' group by a.itemid, a.rid) c
//inner join 
//(SELECT '$kpimonth' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned FROM planned b WHERE left(b.budgetdate,7) <= '$kpimonth' group by b.itemid, b.rid) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid)
//) e left outer join
//(
//select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress from (SELECT '$kpimonth' as progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress FROM progress a1 WHERE left(a1.progressdate,7) = '$kpimonth' group by a1.itemid, a1.rid) c1
//inner join 
//(SELECT '$kpimonth' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress FROM progress b1 WHERE left(b1.progressdate,7) <= '$kpimonth' group by b1.itemid, b1.rid) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid)
//) f
//on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid)
//*/
//
//
///* FINAL QUERY */
///*echo $q="insert into main_data_cube (scid, itemid, rid, planned, comm_planned, actual, comm_actual) 
//
//select ".$scid." as scid, e.itemid, e.rid, e.planned, e.comm_planned, f.progress, f.comm_progress from
//(
//select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned from (SELECT '$kpimonth' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned FROM planned a WHERE left(a.budgetdate,7) = '$kpimonth' group by a.itemid, a.rid) c
//inner join 
//(SELECT '$kpimonth' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned FROM planned b WHERE left(b.budgetdate,7) <= '$kpimonth' group by b.itemid, b.rid) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid)
//) e left outer join
//(
//select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress from (SELECT '$kpimonth' as progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress FROM progress a1 WHERE left(a1.progressdate,7) = '$kpimonth' group by a1.itemid, a1.rid) c1
//inner join 
//(SELECT '$kpimonth' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress FROM progress b1 WHERE left(b1.progressdate,7) <= '$kpimonth' group by b1.itemid, b1.rid) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid)
//) f
//on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid)";*/
//
//echo $q="insert into main_data_cube (scid, itemid, rid, planned, comm_planned, actual, comm_actual, total_planned, total_actual, planned_perc, actual_perc) 
//select g.scid, g.itemid, g.rid, g.planned, g.comm_planned, g.progress, g.comm_progress, h.total_planned, h.total_actual, g.planned/h.total_planned, g.progress/h.total_actual from 
//(select ".$scid." as scid, e.itemid, e.rid, e.planned, e.comm_planned, f.progress, f.comm_progress from
//(
//select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned from (SELECT '$kpimonth' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned FROM planned a WHERE left(a.budgetdate,7) = '$kpimonth' group by a.itemid, a.rid) c
//left outer join 
//(SELECT '$kpimonth' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned FROM planned b WHERE left(b.budgetdate,7) <= '$kpimonth' group by b.itemid, b.rid) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid)
//) e left outer join
//(
//select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress from (SELECT '$kpimonth' as progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress FROM progress a1 WHERE left(a1.progressdate,7) = '$kpimonth' group by a1.itemid, a1.rid) c1
//left outer join 
//(SELECT '$kpimonth' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress FROM progress b1 WHERE left(b1.progressdate,7) <= '$kpimonth' group by b1.itemid, b1.rid) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid)
//) f
//on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid)) g left outer join kpi_total_baseline h on (g.itemid=h.itemid)";
//
//echo "<br/>";
//echo "<br/>";
//echo "<br/>";
//mysql_query($q);
//
//
//}

/*$actquery="SELECT * FROM `main_data_cube` ";
$actresult = mysql_query($actquery);
	
	while ($actrows = mysql_fetch_array($actresult)) {
		
		 $qdata="Select * FROM `kpi_total_baseline` where itemid='".$actrows["itemid"]."'";
		$qresult = mysql_query($qdata);
		$qrows = mysql_fetch_array($qresult);
		$perc_planned=$actrows["planned"]/$qrows["total_planned"];
		if($qrows["total_actual"]!=0)
		$perc_actual=$actrows["actual"]/$qrows["total_actual"];
		else
		$perc_actual=0;

		
    echo $progquey="UPDATE `main_data_cube` SET wgt_planned_perc='$perc_planned', wgt_actual_perc='$perc_actual' where mdcid=".$actrows["mdcid"];
	     mysql_query($progquey) or die("error");
		echo "<br/>";
//	UPDATE `main_data_cube` SET wgt_planned_perc='0.47692307695385', wgt_actual_perc='0.4820298446682' where itemid=252

	}*/
	
	/*select c.itemid, c.budgetqty, d.progressqty from (select itemid, sum(budgetqty) as budgetqty, 0 as progressqty from planned group by itemid) c 
left outer join (select itemid, 0 as budgetqty, sum(progressqty) as progressqty from progress group by itemid) d on (c.itemid = d.itemid) order by c.itemid

select c.itemid, c.rid, c.budgetqty, d.progressqty, c.budgetdate, d.progressdate from (select itemid, rid, sum(budgetqty) as budgetqty, 0 as progressqty, max(budgetdate) as budgetdate from planned group by itemid) c left outer join (select itemid, rid, 0 as budgetqty, sum(progressqty) as progressqty, max(progressdate) as progressdate from progress group by itemid) d on (c.itemid = d.itemid) order by c.itemid*/
///////////////////////////////////////////////////////////////////////

	/*$lsql = "Select max(activitylevel) as maxlevel from kpidata";
	$lresult = mysql_query($lsql);
	$lrows = mysql_fetch_array($lresult);
	 $maxlevel=$lrows['maxlevel'];
	$csql = "Select * from kpidata where activitylevel=$maxlevel";
	$cresult = mysql_query($csql);
	while($crows = mysql_fetch_array($cresult))
	{
		$par_groups=$crows['parentgroup'];
	  	$par_arr=explode("_",$par_groups);
	   	$lenns=count($par_arr);
		for($i=0;$i<$lenns;$i++)
		{  
		    $parent=($lenns-2);
			if($parent==$i)
			{
			echo $par_arr[$i]."-";
			}
		}
		echo "<br/>";
	}*/
//echo "Data is Making Process is complete";

	$planned_perc=0;
	$actual_perc=0;
	$prev=0;
    $bsql = "SELECT * FROM `kpidata` ";
	$bresult = mysql_query($bsql);
	while($lrows = mysql_fetch_array($bresult))
	{
	    
		$par_arr=explode("_",$lrows["parentgroup"]);
	    $kpi_levels=count($par_arr);
		$kpi_levels=$kpi_levels-4;
		$subsrt=substr($lrows["parentgroup"],0,4);
		$current=$par_arr[$kpi_levels];
		if($current!=$prev)
		{
		echo $llsql= "INSERT INTO kpi_top_level_report( `kpiid`, `scid`, `kpi_plan_per`, `kpi_act_per`) (SELECT ".$current.", scid, sum(kpi_comm_planned/baseline*weight/100) as kpi_plan_per , sum(kpi_comm_actual/baseline*weight/100) as kpi_act_per FROM `kpi_base_level_report` where parentgroup LIKE '".$subsrt."%' group by  scid ORDER BY `kpiid`,scid ASC)";
		 $lresult = mysql_query($llsql);
		echo "<br/>";
		}
		$prev=$current;
		//for($i=$kpi_levels;$i>=2;$i--)
//	    { 
//			
			
	/*	 if($i==$kpi_levels)
	  {
			  
			   if($lrows["baseline"]!=0)
			   {
				$planned_perc=$lrows["kpi_comm_planned"]/$lrows["baseline"]*100 ;
				 $actual_perc=$lrows["kpi_comm_actual"]/$lrows["baseline"]*100 ;
			   }
				else
				{
				$planned_perc=0;
				$actual_perc=0;
				}
		      
		
		echo $llsql = "INSERT INTO kpi_top_level_report( `kpiid`, `scid`, `kpi_plan_per`, `kpi_act_per`) VALUES 
		(".$lrows["kpiid"].",".$lrows["scid"].",".$planned_perc.",".$actual_perc.")";
	$lresult = mysql_query($llsql);
		$planned_perc=0;
		$actual_perc=0;
		  }*/

    //    }
		 
		 
			echo "11------------------------------------------------<br/>";
	
	}

?>
<a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>
