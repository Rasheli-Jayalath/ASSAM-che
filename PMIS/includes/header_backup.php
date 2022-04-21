<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$sCurPage = substr($_SERVER['PHP_SELF'], (strrpos($_SERVER['PHP_SELF'], "/") + 1));
$pages = array('submit-petrol.php','firminfo.php','mop.php','education.php','language.php','othertrainings.php','cvlist.php','achievements.php','experience.php','dta.php','uploadcv.php', 'statistics.php');
?>
<div id="logo"><a href="maindata.php"  title="PMIS" >
<img src="images/cv-bank.jpg" title="PMIS" alt="PMIS" width="950" height="85"  /></a>
</div>
<?php           
                if(isset($_SESSION['log_id'])&&$_SESSION['log_id']!=0)
				{
				$kpquery = "select * from maindata where stage='KPI' and activitylevel=0  order by itemid ASC";
				$kpresult = mysql_query($kpquery);
				$kpdata = mysql_fetch_array($kpresult);
				
				$kfquery = "select * from maindata where stage='BOQ' and activitylevel=0  order by itemid ASC";
				$kfresult = mysql_query($kfquery);
				$kfdata = mysql_fetch_array($kfresult);
				
				
				$msquery = "select * from maindata where stage='Milestone' and activitylevel=0  order by itemid ASC";
				$msresult = mysql_query($msquery);
				$msdata = mysql_fetch_array($msresult);
				
				$camquery = "select * from maindata where stage='CAM' and activitylevel=0  order by itemid ASC";
				$camresult = mysql_query($camquery);
				$camdata = mysql_fetch_array($camresult);
				
				
				$actquery = "select * from maindata where stage='Strategic Goal' and activitylevel=0 order by itemid ASC";
				$actresult = mysql_query($actquery);
				$actdata = mysql_fetch_array($actresult);
				
				$evaquery = "select * from 	`s009-eva-results` ";
				$evaresult = mysql_query($evaquery);
				$evadata = mysql_num_rows($evaresult);
				
				$boqquery = "select * from maindata where stage='BOQ' and activitylevel=0 order by itemid ASC";
				$boqresult = mysql_query($boqquery);
				$boqcount = mysql_num_rows($boqresult);
				
				$resquery = "select * from 	`resources` ";
				$resresult = mysql_query($resquery);
				$rescount = mysql_num_rows($resresult);
				
				$actquery = "select * from 	`activity` ";
				$actresult = mysql_query($actquery);
				$actcount = mysql_num_rows($actresult);
				
				$ipcvquery = "select * from `ipcv` ";
				$ipcvresult = mysql_query($ipcvquery);
				$ipcvcount = mysql_num_rows($ipcvresult);
				
				$pquery = "Select * from project";
				$presult = mysql_query($pquery);
				$pdata = mysql_num_rows($presult);
				}
				
               ?>
<div id="navcontainer" class="menu">
    <ul>
    <span <?php if($pdata == 0){?>style="pointer-events: none;" <?php }?>>
	<li><a href="home.php" <?php if($sCurPage=='home.php') echo 'class="sel"' ; ?>  
     class="current">Home</a></li>
  
	<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">
    Data Model</a>
			<ul>
            <li>
		<?php  if($boq_flag==1)
		{
		?>
		<a href="boqdata.php" <?php if($sCurPage=='boqdata.php') echo 'class="sel"' ; ?>  target="_self" class="current">BOQ</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >BOQ</a>
		<?php
		}
		?>
		</li>
        	<?php if($boqcount!=0)
			{?>
            
			<li><?php  if($res_flag==1)
			{
			?>
			<a href="resources.php" <?php if($sCurPage=='resources.php') echo 'class="sel"' ; ?> class="current">Resources</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Resources</a>
			<?php
			}
			?>	</li>
            <li>
			<?php  if($ipc_flag==1)
			{
			?>
			<a href="addipc.php" <?php if($sCurPage=='addipc.php') echo 'class="sel"' ; ?> class="current" >IPC Data</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >IPC Data</a>
			<?php
			}
			?>
			</li>
            <?php if($boqcount!=0&&$rescount!=0)
			{?>
			<li><?php  if($mdata_flag==1)
			{
			?>
			<a href="maindata.php" <?php if($sCurPage=='maindata.php') echo 'class="sel"' ; ?> class="current">Maindata</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Maindata</a>
			<?php
			}
			?>	</li>
            
             <?php if($boqcount!=0&&$rescount!=0&&$actcount!=0)
			{?>
			<li>
			<?php  if($splnentry_flag==1 || $splnadm_flag==1)
			{
			?>
			<a href="planned.php" <?php if($sCurPage=='planned.php') echo 'class="sel"' ; ?>  target="_self" class="current">Schedule Planned</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Schedule Planned</a>
			<?php
			}
			?>
			
				
			</li>
			<li>
			<?php  if($spg_flag==1)
			{
			?>
			<a href="addprogress.php" <?php if($sCurPage=='addprogress.php') echo 'class="sel"' ; ?>  target="_self" class="current">Schedule Progress</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Schedule Progress</a>
			<?php
			}
			?>	
			</li>
            <li>
			<?php  if($kpi_flag==1)
		{
		?>
		<a href="kpidata.php" <?php if($sCurPage=='kpidata.php') echo 'class="sel"' ; ?>  target="_self" class="current">KPI Data</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >KPI Data</a>
		<?php
		}
		?>
		</li>
            <li><?php  if($mile_flag==1)
		{
		?>
		<a href="milestonedata.php" <?php if($sCurPage=='milestonedata.php') echo 'class="sel"' ; ?>  target="_self" class="current">Milestone Data</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Milestone Data</a>
		<?php
		}
		?>	</li>
          	<li><?php  if($cam_flag==1)
		{
		?>
		<a href="camdata.php" <?php if($sCurPage=='camdata.php') echo 'class="sel"' ; ?>  target="_self" class="current">CAM Data</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >CAM Data</a>
		<?php
		}
		?></li>
        <?php }?>
        	<?php }?>
           <?php }?>
			</ul>
		</li>
		<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">
        Dashboards</a>
		
			<ul>
           <?php if(isset($kpdata["itemid"])&&$kpdata["itemid"]!=""&&$kpdata["itemid"]!=0)
		{?>
        <li>
		<?php  if($kpid_flag==1)
			{
			?>
		<a href="KPI_progress_dashboard.php?obj=<?php echo $kpdata["itemid"];?>" <?php if($sCurPage=='KPI_progress_dashboard.php?obj='.$kpdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">KPIs Dashboard</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >KPIs Dashboard</a>
		<?php
		}
		?>
		</li> 
        <?php }?> <!--// KPI Dashboard-->
        <?php if(isset($ipcvcount)&&$ipcvcount!=""&&$ipcvcount!=0)
				{?>
				<li>
				<?php  if($kfid_flag==1)
				{
				?>
				<a href="KFI_progress_dashboard.php?obj=<?php echo $kfdata["itemid"];?>" <?php if($sCurPage=='KFI_progress_dashboard.php?obj='.$kfdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">KFIs Dashboard</a>
				<?php
				}
				else
				{
				?>
				<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >KFIs Dashboard</a>
				<?php
				}
				?>
				</li>
				 <?php }?> <!--// KFI Dashboard-->
         <?php if($evadata>0)
		{?>
        <li>
		<?php  if($evad_flag==1)
		{
		?><a href="eva_dashboard.php" target="_blank">EVA Dashboard</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >EVA Dashboard</a>
		<?php
		}
		?>
		</li>
        <?php }?>
			  <?php if(isset($actdata["itemid"])&&$actdata["itemid"]!=""&&$actdata["itemid"]!=0)
		{?>
			 <li>
			 <?php  if($actd_flag==1)
			{
			?>
			 
			 <a href="progress_dashboard.php?obj=<?php echo $actdata["itemid"]; ?>" <?php if($sCurPage=='progress_dashboard.php?obj='.$actdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">Activity Dashboard</a>
			 <?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Activity Dashboard</a>
			<?php
			}
			?>	
			 </li>
             <?php }?> <!--// Activity Dashboard-->
			
			 <?php if(isset($msdata["itemid"])&&$msdata["itemid"]!=""&&$msdata["itemid"]!=0)
		{?>
        <li>
		<?php  if($miled_flag==1)
			{
			?>
		<a href="Milestone_progress_dashboard.php?obj=<?php echo $msdata["itemid"];?>" <?php if($sCurPage=='Milestone_progress_dashboard.php?obj='.$msdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">Milestones Dashboard</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Milestones Dashboard</a>
		<?php
		}
		?>
		</li>
		 <?php }?> <!--// Milestone Dashboard-->
         
          <?php if(isset($camdata["itemid"])&&$camdata["itemid"]!=""&&$camdata["itemid"]!=0)
		{?><li>
		<?php  if($camd_flag==1)
			{
			?>
        <a href="CAM_progress_dashboard.php?obj=<?php echo $camdata["itemid"];?>" 
		<?php if($sCurPage=='CAM_progress_dashboard.php?obj='.$$camdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">Critical Act Dashboard
        </a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Critical Act Dashboard</a>
		<?php
		}
		?>
		</li>
		 <?php }?> <!--// CAM Dashboard-->
         </ul>
		</li>
	        <li>
		<?php  if($pic_flag==1)
		{
		?>
		<a href="analysis.php" <?php if($sCurPage=='analysis.php') echo 'class="sel"' ; ?> class="current" >Pictorial Analysis</a>
		<?php
		}
		else
		{
		?>
	<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Pictorial Analysis</a>
		<?php
		}
		?>
		</li>
		
		<li><a href="#">Setting</a>
			<ul>
			<li>
			<?php  if($padm_flag==1)
			{
			?>
			<a href="project_calender.php" <?php if($sCurPage=='project_calender.php') echo 'class="sel"' ; ?>  class="current">View Project</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Add Project</a>
			<?php
			}
			?></li>
           <li>
			<?php  if($issueAdm_flag==1)
			{
			?>
			<a href="project_issues_info.php" <?php if($sCurPage=='project_issues_info.php') echo 'class="sel"' ; ?>  class="current">Manage Issues</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Manage Issues</a>
			<?php
			}
			?>
			
			</li>
             <li>
			<?php  if($padm_flag==1)
			{
			?>
			<a href="refreshcache.php" <?php if($sCurPage=='refreshcache.php') echo 'class="sel"' ; ?>  class="current">Refresh Cache</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Refresh Cache</a>
			<?php
			}
			?>
			</li>
			<li>
			<?php  if($process_flag==1)
			{
			?>
			<a href="process.php" <?php if($sCurPage=='process.php') echo 'class="sel"' ; ?> class="current" >Process</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Process</a>
			<?php
			}
			?>
			</li>
			<li><a href="user_log.php" <? if($sCurPage=='user_log.php') echo 'class="sel"' ; ?>  target="_blank" class="current">User Log</a></li>
			</ul>
		</li>
        </span>
        <?php //}?>
	   <?php  if(isset($_SESSION['log_id'])&&$_SESSION['log_id']!=0)
				{?>
  		<li><a href="requires/logout.php" >Logout</a></li>	
           <li><a href="about.php" <?php if($sCurPage=='about.php') echo 'class="sel"' ; ?>  
     class="current">About PMIS</a></li>
				<?php } ?>				
   		</ul>
  		
    </div>
	<br />
	