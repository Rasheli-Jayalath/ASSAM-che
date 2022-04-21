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
				}
                ?>
<div id="navcontainer" class="menu" >
    <ul>
		<li><a href="home.php" <?php if($sCurPage=='home.php') echo 'class="sel"' ; ?>  class="current">Home</a></li>
		
	 	<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">Activities</a>
		
			<ul>
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
			<li>
			<?php  if($spg_flag==1)
			{
			?>
			<a href="addprogress.php" <?php if($sCurPage=='addprogress.php') echo 'class="sel"' ; ?>  target="_blank" class="current">Schedule Progress</a>
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
			 <?php  if($actd_flag==1)
			{
			?>
			 
			 <a href="progress_dashboard.php?obj=1" <?php if($sCurPage=='progress_dashboard.php?obj=1') echo 'class="sel"' ; ?>  target="_blank" class="current">ACT-D</a>
			 <?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >ACT-D</a>
			<?php
			}
			?>	
			 </li>
			</ul>
		</li>
		<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">Milestone</a>
		
			<ul>
			<li><?php  if($mile_flag==1)
		{
		?>
		<a href="milestonedata.php" <?php if($sCurPage=='milestonedata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">Milestone Data</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Milestone Data</a>
		<?php
		}
		?>	</li>
			
			 <?php if(isset($msdata["itemid"])&&$msdata["itemid"]!=""&&$msdata["itemid"]!=0)
		{?>
        <li>
		<?php  if($miled_flag==1)
			{
			?>
		<a href="Milestone_progress_dashboard.php?obj=<?php echo $msdata["itemid"];?>" <?php if($sCurPage=='Milestone_progress_dashboard.php?obj='.$msdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">Milestone-D</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Milestone-D</a>
		<?php
		}
		?>
		</li>
		 <?php }?></ul>
		</li>
		
		<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">KPI</a>
		
			<ul>
			<li>
			<?php  if($kpi_flag==1)
		{
		?>
		<a href="kpidata.php" <?php if($sCurPage=='kpidata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">KPI Data</a>
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
			 <?php if(isset($kpdata["itemid"])&&$kpdata["itemid"]!=""&&$kpdata["itemid"]!=0)
		{?>
        <li>
		<?php  if($kpid_flag==1)
			{
			?>
		<a href="KPI_progress_dashboard.php?obj=<?php echo $kpdata["itemid"];?>" <?php if($sCurPage=='KPI_progress_dashboard.php?obj='.$kpdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">KPI-D</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >KPI-D</a>
		<?php
		}
		?>
		</li> 
        <?php }?></ul>	
		</li>
		<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">CAM</a>
		
			<ul>
			<li><?php  if($cam_flag==1)
		{
		?>
		<a href="camdata.php" <?php if($sCurPage=='camdata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">CAM Data</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >CAM Data</a>
		<?php
		}
		?></li>
			
			 <?php if(isset($camdata["itemid"])&&$camdata["itemid"]!=""&&$camdata["itemid"]!=0)
		{?><li>
		<?php  if($camd_flag==1)
			{
			?>
        <a href="CAM_progress_dashboard.php?obj=<?php echo $camdata["itemid"];?>" 
		<?php if($sCurPage=='CAM_progress_dashboard.php?obj='.$$camdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">CAM-D
        </a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >CAM-D</a>
		<?php
		}
		?>
		</li>
		 <?php }?></ul>
		</li>
		
		<li>
		<?php  if($boq_flag==1)
		{
		?>
		<a href="boqdata.php" <?php if($sCurPage=='boqdata.php') echo 'class="sel"' ; ?>  target="_blank" class="current">BOQ</a>
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
		<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">IPC</a>
		
			<ul>
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
			 <?php if(isset($kfdata["itemid"])&&$kfdata["itemid"]!=""&&$kfdata["itemid"]!=0)
				{?>
				<li>
				<?php  if($kfid_flag==1)
				{
				?>
				<a href="KFI_progress_dashboard.php?obj=<?php echo $kfdata["itemid"];?>" <?php if($sCurPage=='KFI_progress_dashboard.php?obj='.$kfdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current">KFI-D</a>
				<?php
				}
				else
				{
				?>
				<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >KFI-D</a>
				<?php
				}
				?>
				</li>
				 <?php }?>
         
			</ul>
		</li>
		<li>
		<?php  if($eva_flag==1)
		{
		?><a href="evadata.php" <?php if($sCurPage=='evadata.php') echo 'class="sel"' ; ?> class="current" >EVA</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >EVA</a>
		<?php
		}
		?>
		</li>
        
       
         
               
		
          <?php //if(isset($_SESSION['log_id'])&&$_SESSION['log_id']!=0)
//				{?>
        <li><a href="pictorial_form.php" class="current" >Pictorial Analysis</a></li>
		
		<li><a href="#">Setting</a>
			<ul>
			<li>
			<?php  if($padm_flag==1)
			{
			?>
			<a href="project_calender.php" <?php if($sCurPage=='project_calender.php') echo 'class="sel"' ; ?>  class="current">Add Project</a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" >Add Project</a>
			<?php
			}
			?></li>
			<li><a href="process.php" class="current" >Process</a></li>
			<li><a href="user_log.php" <? if($sCurPage=='user_log.php') echo 'class="sel"' ; ?>  target="_blank" class="current">User Log</a></li>
			</ul>
		</li>
        <?php //}?>
	   <?php /* if(isset($_SESSION['log_id'])&&$_SESSION['log_id']!=0)
				{?>
  		<li><a href="requires/logout.php" >Logout</a></li>	
				<?php }*/ ?>				
   		</ul>
  		
    </div>
	<br />
	