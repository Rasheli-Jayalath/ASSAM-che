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
function mildatamaker($scid,$kpimonth) {
/*$q="insert into main_data_cube (scid, itemid, rid, planned, comm_planned, actual, comm_actual, total_planned, total_actual, planned_perc, actual_perc) 
select g.scid, g.itemid, g.rid, g.planned, g.comm_planned, g.progress, g.comm_progress, h.total_planned, h.total_actual, g.planned/h.total_planned, g.progress/h.total_actual from 
(select ".$scid." as scid, e.itemid, e.rid, e.planned, e.comm_planned, f.progress, f.comm_progress from
(
select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned from (SELECT '$kpimonth' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned FROM planned a WHERE left(a.budgetdate,7) = '$kpimonth' group by a.itemid, a.rid) c
left outer join 
(SELECT '$kpimonth' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned FROM planned b WHERE left(b.budgetdate,7) <= '$kpimonth' group by b.itemid, b.rid) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid)
) e left outer join
(
select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress from (SELECT '$kpimonth' as progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress FROM progress a1 WHERE left(a1.progressdate,7) = '$kpimonth' group by a1.itemid, a1.rid) c1
left outer join 
(SELECT '$kpimonth' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress FROM progress b1 WHERE left(b1.progressdate,7) <= '$kpimonth' group by b1.itemid, b1.rid) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid)
) f
on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid)) g left outer join kpi_total_baseline h on (g.itemid=h.itemid and g.rid = h.rid and left(h.progress_month,7) = '$kpimonth')";

echo $q;*/

 $q="insert into main_data_cube (scid, itemid, rid, planned, comm_planned, actual, comm_actual, total_planned, total_actual, 

planned_perc, actual_perc, temp_id) 
select g.scid, g.itemid, g.rid, g.planned, g.comm_planned, g.progress, g.comm_progress, h.total_planned, h.total_actual, 

g.planned/h.total_planned, g.progress/h.total_actual, g.temp_id from 
(
select ".$scid." as scid, e.itemid, e.rid, e.planned, e.comm_planned, f.progress, f.comm_progress, e.temp_id from
(
select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned, c.temp_id from 
(
SELECT '$kpimonth' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned, a.temp_id FROM planned 
a WHERE left(a.budgetdate,7) = '$kpimonth' group by a.itemid, a.rid
) c
left outer join 
(
SELECT '$kpimonth' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned, b.temp_id FROM planned 

b WHERE left(b.budgetdate,7) <= '$kpimonth' group by b.itemid, b.rid

) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid AND c.temp_id=d.temp_id)
) e left outer join
(

select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress, c1.temp_id from (
select ifnull(a1112.progressdate, a111.budgetdate) as progressdate, ifnull(a1112.itemid, a111.itemid) as itemid, ifnull(a1112.rid, a111.rid) as rid, ifnull(a1112.progress,a111.progress) as progress, ifnull(a1112.comm_progress, a111.comm_progress) as comm_progress, ifnull(a1112.temp_id, a111.temp_id) as temp_id 

from 
 (SELECT '$kpimonth' as budgetdate, a11.itemid, a11.rid, 0 as progress, 0 as comm_progress, a11.temp_id FROM planned a11 WHERE left(a11.budgetdate,7) = '$kpimonth' group by a11.itemid, a11.rid) a111

LEFT OUTER JOIN 

(SELECT '$kpimonth' as 

progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress, a1.temp_id FROM progress a1 WHERE 

left(a1.progressdate,7) = '$kpimonth' group by a1.itemid, a1.rid) A1112 on (a111.itemid = a1112.itemid and a111.rid=a1112.rid and a111.temp_id=a1112.temp_id)

) c1 
left outer join 
(

SELECT '$kpimonth' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress, b1.temp_id  

FROM progress b1 WHERE left(b1.progressdate,7) <= '$kpimonth' group by b1.itemid, b1.rid

) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid AND c1.temp_id=d1.temp_id)


) f
on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid AND e.temp_id = f.temp_id)


) g left outer join kpi_total_baseline h on (g.itemid=h.itemid and g.rid = h.rid and left(h.progress_month,7) = 

'$kpimonth' AND g.temp_id = h.temp_id)";

//echo $q;
//echo "<br/><br/><br/><br/>";
mysql_query($q);


}

///////////////////Step 1 ///////////////////////////////////////////////////////////////

mysql_query("truncate table kpi_total_baseline");
mysql_query("INSERT INTO kpi_total_baseline( itemid, rid, temp_id,progress_month,total_planned, total_actual) select c.itemid, c.rid, c.temp_id, c.budgetdate, sum(budgetqty) as budgetqty, sum(c.pprogressqty) as progressqty from (SELECT a.itemid, a.rid, a.temp_id, a.budgetdate, a.budgetqty, ifnull(b.itemid,a.itemid) as pitemid, ifnull(b.rid, a.rid) as prid, ifnull(b.temp_id, a.temp_id) as ptemp_id, ifnull(b.progressdate, a.budgetdate) as progressdate, ifnull(b.progressqty,0) as pprogressqty FROM planned a left outer join progress b on (a.itemid = b.itemid AND a.rid = b.rid AND a.temp_id = b.temp_id AND a.budgetdate = b.progressdate)) c group by c.itemid, c.rid, c.temp_id, c.budgetdate");

//select g.scid, g.itemid, g.rid, g.planned, g.comm_planned, g.progress, g.comm_progress, h.total_planned, h.total_actual, g.planned/h.total_planned, g.progress/h.total_actual from (select 1 as scid, e.itemid, e.rid, e.planned, e.comm_planned, f.progress, f.comm_progress from ( select c.budgetdate, c.itemid, c.rid, c.planned, d.comm_planned from (SELECT '2018-06' as budgetdate, a.itemid, a.rid, sum(a.budgetqty) as planned, 0 as comm_planned FROM planned a WHERE left(a.budgetdate,7) = '2018-06' group by a.itemid, a.rid) c left outer join (SELECT '2018-06' as budgetdate, b.itemid, b.rid, 0 as planned, sum(b.budgetqty) as comm_planned FROM planned b WHERE left(b.budgetdate,7) <= '2018-06' group by b.itemid, b.rid) d on (c.budgetdate = d.budgetdate AND c.itemid = d.itemid AND c.rid=d.rid) ) e left outer join ( select c1.progressdate, c1.itemid, c1.rid, c1.progress, d1.comm_progress from (SELECT '2018-06' as progressdate, a1.itemid, a1.rid, sum(a1.progressqty) as progress, 0 as comm_progress FROM progress a1 WHERE left(a1.progressdate,7) = '2018-06' group by a1.itemid, a1.rid) c1 left outer join (SELECT '2018-06' as progressdate, b1.itemid, b1.rid, 0 as progress, sum(b1.progressqty) as comm_progress FROM progress b1 WHERE left(b1.progressdate,7) <= '2018-06' group by b1.itemid, b1.rid) d1 on (c1.progressdate = d1.progressdate AND c1.itemid = d1.itemid AND c1.rid=d1.rid) ) f on (e.budgetdate = f.progressdate AND e.itemid = f.itemid AND e.rid=f.rid)) g inner join kpi_total_baseline h on (g.itemid=h.itemid and g.rid = h.rid and left(h.progress_month,7) = "2018-06") where g.itemid = 3 and g.rid = 9

//////////////////// Step 2 ////////////////////////////////////////////////////////////

mysql_query("truncate table main_data_cube");

	$scalesql = "select scid, scmonth from kpiscale";
	$scaleresult = mysql_query($scalesql);
	
	while ($scalerows = mysql_fetch_array($scaleresult)) {
		$kpimonth=$scalerows['scmonth'];
	
	mildatamaker($scalerows['scid'],$scalerows['scmonth']);
	}	
	
//////////////////// Step 3 ////////////////////////////////////////////////////////////

mysql_query("truncate table base_data_cube");
mysql_query("INSERT INTO `base_data_cube`(`parentcd`, `parentgroup`, `activitylevel`, `stage`, `itemcode`, `itemname`, `weight`, `isentry`, `resources`, `aorder`, `kpi_temp_id`, `activityid`, `kaweight`, `kpiid`, `kaid`, `aid`, `startdate`, `enddate`, `baseline`, `temp_id`, `scid`, `rid`, `planned`, `actual`, `comm_planned`, `comm_actual`, `total_planned`, `total_actual`, `planned_perc`, `actual_perc`, `base_desc`, `unit`, `quantity`, `unit_type`, `itemid`) SELECT e.parentcd, e.parentgroup, e.activitylevel, e.stage, e.itemcode, e.itemname, e.weight, e.isentry, e.resources, e.aorder, e.kpi_temp_id, f.activityid, f.kaweight,f.kpiid,f.kaid, f.`aid`, f.startdate, f.enddate, f.baseline, f.temp_id, f.scid, f.rid as rid, f.planned, f.actual, f.comm_planned, f.comm_actual, f.total_planned, f.total_actual, f.planned_perc, f.actual_perc, g.base_desc, g.unit, g.quantity, g.unit_type, f.`itemid` as itemid from kpidata e left outer join (SELECT * FROM kpi_activity c left outer join (SELECT a.aid, a.itemid as itemid1, a.startdate, a.enddate, a.rid, a.baseline, a.temp_id, b.mdcid, b.scid, b.itemid, b.rid as rid2, b.planned, b.actual, b.comm_planned, b.comm_actual, b.total_planned, b.total_actual, b.planned_perc, b.actual_perc FROM activity a inner join `main_data_cube` b on (a.itemid=b.itemid AND a.temp_id=b.temp_id) ) d on (c.activityid=d.aid)) f on (e.kpiid = f.kpiid) left outer join baseline g on (f.rid = g.rid AND f.temp_id=g.temp_id)");


//////////////////// Step 4 ////////////////////////////////////////////////////////////

mysql_query("truncate table kpi_base_level_report");
mysql_query("INSERT INTO `kpi_base_level_report`(temp_id, kpi_temp_id, `kpiid`, `itemcode`, `itemname`, `parentcd`, `parentgroup`, `activitylevel`, `weight`, `startdate`, `enddate`, `baseline`, `rid`, `unit`, `scid`, `kpi_planned`, `kpi_actual`, `kpi_comm_planned`, `kpi_comm_actual`, `kpi_planned_per`, `kpi_actual_per`) SELECT x.kpi_temp_id, x.temp_id, z.kpiid,z.itemcode,z.itemname, z.parentcd, z.parentgroup, z.activitylevel,z.weight, min(b.startdate) as startdate, max(b.enddate) as enddate, b.baseline as baseline, b.rid,x.`unit`, x.scid, x.planned as kpi_planned , x.actual as kpi_actual, x.comm_planned as kpi_comm_planned, x.comm_actual as kpi_comm_actual, x.planned_perc as kpi_planned_per, x.actual_perc as kpi_actual_per FROM kpidata z inner join kpi_activity a on (z.kpiid=a.kpiid) inner join activity b on (a.activityid=b.aid) inner join base_data_cube x on(b.itemid= x.itemid and z.kpiid = x.kpiid) Group by z.kpiid, a.activityid, x.scid, x.temp_id");



echo "Data is Making Process is complete";

?>
<a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>
