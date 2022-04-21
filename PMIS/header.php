<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$sCurPage = substr($_SERVER['PHP_SELF'], (strrpos($_SERVER['PHP_SELF'], "/") + 1));
$pages = array('submit-petrol.php','firminfo.php','mop.php','education.php','language.php','othertrainings.php','cvlist.php','achievements.php','experience.php','dta.php','uploadcv.php', 'statistics.php');
?>
<div id="logo"><a href="maindata.php"  title="PMIS" >
<img src="images/cv-bank.jpg" title="PMIS" alt="PMIS" width="950" height="85"  /></a>
<!-- <img src="images/logo.gif" width="240" height="81" alt="SMEC" title="SMEC" align="left" class="smec" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img src="images/egc.jpg" width="70" height="69" alt="EGC" title="EGC" class="egc" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div style="color:#E9E9E9; font-size:48px; float:right; font-weight:bold; width:300px; margin-top:15px" >CV Bank</div>--> 
</div>

<div id="topmenu">
    <ul id="menu">
		<li><a href="project_calender.php" <? if($sCurPage=='project_calender.php') echo 'class="sel"' ; ?>  class="current">Project</a></li>
	 	<li><a href="maindata.php" <? if($sCurPage=='maindata.php') echo 'class="sel"' ; ?> class="current">Maindata</a></li>
		<li><a href="milestonedata.php" <? if($sCurPage=='milestonedata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">Milestone</a></li>
		<li><a href="addprogress.php" <? if($sCurPage=='addprogress.php') echo 'class="sel"' ; ?>  target="_blank" class="current">Schedule Progress</a></li>
		<li><a href="kpidata.php" <? if($sCurPage=='kpidata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">KPI</a></li>
		<li><a href="camdata.php" <? if($sCurPage=='camdata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">CAM</a></li>
		<li><a href="boqdata.php" <? if($sCurPage=='boqdata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">BOQ</a></li>
		<li><a href="addipc.php" <? if($sCurPage=='addipc.php') echo 'class="sel"' ; ?> class="current" >IPC</a></li>
		<li><a href="evadata.php" <? if($sCurPage=='evadata.php') echo 'class="sel"' ; ?> class="current" >EVA</a></li>
        <li><a href="progress_dashboard.php?obj=1" <? if($sCurPage=='progress_dashboard.php?obj=1') echo 'class="sel"' ; ?>  target="_blank" class="current">ACT-D</a></li>
        <li><a href="KPI_progress_dashboard.php?obj=1" <? if($sCurPage=='KPI_progress_dashboard.php?obj=1') echo 'class="sel"' ; ?>  target="_blank" class="current">KPI-D</a></li>
        <li><a href="KFI_progress_dashboard.php?obj=1" <? if($sCurPage=='KFI_progress_dashboard.php?obj=1') echo 'class="sel"' ; ?>  target="_blank" class="current">KFI-D</a></li>
		
		<li><a href="user_log.php" <? if($sCurPage=='user_log.php') echo 'class="sel"' ; ?>  target="_blank" class="current">User Log</a></li>
		
	   <li><a href="requires/logout.php" class="current" >Logout</a></li>
  				
   		</ul>
  		
    </div>
	