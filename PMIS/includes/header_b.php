<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$sCurPage = substr($_SERVER['PHP_SELF'], (strrpos($_SERVER['PHP_SELF'], "/") + 1));
?>
<div id="logo"><a href="home.php"  title="PMIS" >
<img src="images/cv-bank.jpg" title="PMIS" alt="PMIS" width="950" height="85"  /></a>
</div>
<?php         $_SESSION['log_id']=1;  
                if(isset($_SESSION['log_id'])&&$_SESSION['log_id']!=0)
				{
					
				$kpquery = "select * from kpidata where stage='KPI' and activitylevel=0  order by kpiid ASC";
				$kpresult = mysql_query($kpquery);
				$kpdata = mysql_fetch_array($kpresult);
				
				$kfquery = "select * from baseline ";
				$kfresult = mysql_query($kfquery);
				$kfdata = mysql_fetch_array($kfresult);
				$kfcount = mysql_num_rows($kfresult);
				
				$kpiuery = "select * from maindata ";
				$kpiresult = mysql_query($kpiuery);
				$kpicount = mysql_num_rows($kpiresult);
				
				$camquery = "select * from maindata where stage='CAM' and activitylevel=0  order by itemid ASC";
				$camresult = mysql_query($camquery);
				$camdata = mysql_fetch_array($camresult);
				
				
				$actquery = "select * from maindata where activitylevel=0 order by itemid ASC";
				$actresult = mysql_query($actquery);
				$actdata = mysql_fetch_array($actresult);
				
				$evaquery = "select * from 	`s009-eva-results` ";
				$evaresult = mysql_query($evaquery);
				$evadata = mysql_num_rows($evaresult);
				
				$boqquery = "select * from maindata where stage='BOQ' and activitylevel=0 order by itemid ASC";
				$boqresult = mysql_query($boqquery);
				$boqcount = mysql_num_rows($boqresult);
				
				$resquery = "select * from 	`boqdata` ";
				$resresult = mysql_query($resquery);
				$rescount = mysql_num_rows($resresult);
				
				$actquery = "select * from 	`activity` ";
				$actresult = mysql_query($actquery);
				$actcount = mysql_num_rows($actresult);
				
				$ipcvquery = "select * from `ipcv` ";
				$ipcvresult = mysql_query($ipcvquery);
				$ipcvcount = mysql_num_rows($ipcvresult);
				
				$ipcquery = "select * from `ipc` ";
				$ipcresult = mysql_query($ipcquery);
				$ipccount = mysql_num_rows($ipcresult);
				
				$ppquery = "Select * from baseline ";
				$ppresult = mysql_query($ppquery);
				$ppcount = mysql_num_rows($ppresult);
				
				$pquery = "Select * from project";
				$presult = mysql_query($pquery);
				$presultd = mysql_fetch_array($presult);
				$pdata = mysql_num_rows($presult);
				$project_type=$presultd["ptype"];
				
				$tempquery = "select * from baseline_template where temp_is_default=1 ";
				$tempresult = mysql_query($tempquery);
				$tempcount = mysql_num_rows($presult);
				if($tempcount>0)
				{
				$tempdata = mysql_fetch_array($tempresult);
				}
				}
				$mmquery = "select max(activitylevel) as max_activitylevel from boqdata ";
				$mmresult = mysql_query($mmquery);
				$mmdata = mysql_fetch_array($mmresult); 
				$mmax_activitylevel=$mmdata["max_activitylevel"];
				$m=0;
				$mlevl="";
				$ki_str="";
				while( $m<=$mmax_activitylevel)
				{
					$ddquery = "select min(itemid) as itemid from boqdata where parentcd=0";
				    $ddresult = mysql_query($ddquery);
				    $dddata = mysql_fetch_array($ddresult); 
					
					$ki_str.="itemid_".$m."=";
					if($m==0)
					 {
					  $ki_str.= "00000".$dddata["itemid"];
					  }
					 else
					 {
						 $ki_str.="0";
				     }
					if($m<$mmax_activitylevel)
					{
						$ki_str.='&';
					}
					$m++;
				}
				
               ?>
<div id="navcontainer" class="menu">
    <ul>
    <span <?php if($pdata == 0){?>style="pointer-events: none;" <?php }?>>
	<li><a href="home.php" <?php if($sCurPage=='home.php') echo 'class="sel"' ; ?>  
     class="current"><?php echo HOME;?></a></li>
  </span>
	
		<li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">
        <?php echo DASHBOARDS;?></a>
		
			<ul>
           <?php if(isset($kpdata["kpiid"])&&$kpdata["kpiid"]!=""&&$kpdata["kpiid"]!=0)
		{?>
        <li>  <a href="#" style="background:#e36c00; text-align:center"><?php echo KPI_DASHBOARDS;?></a></li>
      
		<?php 
		if($kpid_flag==1)
			{ ?>
            <?php
		$sqlg="Select * from kpi_templates ";
			$resg=mysql_query($sqlg);
			while($kpi_temp=mysql_fetch_array($resg))
			{
			$kpquery = "select max(activitylevel) as max_activitylevel from kpidata  where kpi_temp_id=".$kpi_temp["kpi_temp_id"];
				$kpresult = mysql_query($kpquery);
				$kpdata = mysql_fetch_array($kpresult); 
				$kpmax_activitylevel=$kpdata["max_activitylevel"];
				$kp=0;
				$mlevl="";
				$kpi_str="";
				while( $kp<=$kpmax_activitylevel)
				{
					$kpiquery = "select min(kpiid) as kpiid, parentgroup from kpidata where parentcd=0 AND kpi_temp_id=".$kpi_temp["kpi_temp_id"];
				    $kpiresult = mysql_query($kpiquery);
				    $kpidata = mysql_fetch_array($kpiresult); 
					
					$kpi_str.="kpiid_".$kp."=";
					if($kp==0)
					 {
					  $kpi_str.= "0";
					  }
					 else
					 {
						 $kpi_str.="0";
				     }
					if($kp<$kpmax_activitylevel)
					{
						$kpi_str.='&';
					}
					$kp++;
				}
			?>
		  <?php /*?><li><a href="KPI_progress_dashboard.php?kpi_temp_id=<?php echo $kpi_temp["kpi_temp_id"];?>&<?php echo $kpi_str;?>" <?php if($sCurPage=='KPI_progress_dashboard.php?kpi_temp_id='.$kpi_temp["kpi_temp_id"].'&'.$kpi_str) echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo $kpi_temp["kpi_temp_title"]; ?></a></li><?php */?>
          <li><a href="KPI_progress_dashboard.php?kpi_temp_id=<?php echo $kpi_temp["kpi_temp_id"];?>&level_count=5&start_date=2018-12-10&end_date=2019-12-31&kpiid_0=000001&kpiid_1=0&kpiid_2=0&kpiid_3=0" <?php if($sCurPage=='KPI_progress_dashboard.php?kpi_temp_id='.$kpi_temp["kpi_temp_id"]) echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo $kpi_temp["kpi_temp_title"]; ?></a></li>
		<?php
		} }
		else
		{
		?>
	<li><a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo KPI_DASHBOARDS;?></a></li> 
		<?php
		}
		?>
		
        <?php }?> <!--// KPI Dashboard-->
        <?php if($rescount!=0)
				{?>
                 <li>  <a href="#" style="background:#e36c00; text-align:center"><?php echo KFI_DASHBOARDS;?></a></li>
				<li>
				<?php  if($rescount!=0)
				{
				?>
				<a href="KFI_progress_dashboard.php?itemid_0=1&itemid_1=2&itemid_2=0" <?php if($sCurPage=='KFI_progress_dashboard.php?$ki_str') echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo KFI_DASHBOARDS;?></a>
				<?php
				}
				else
				{
				?>
				<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo KFI_DASHBOARDS;?></a>
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
		?><a href="eva_dashboard.php" target="_blank"><?php echo EVA_DASHBOARDS;?></a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo EVA_DASHBOARDS;?></a>
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
			 
			 <a href="progress_dashboard.php?temp_id=<?php echo $tempdata["temp_id"]; ?>" <?php if($sCurPage=='progress_dashboard.php?temp_id='.$tempdata["temp_id"]) echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo ACT_DASHBOARDS;?></a>
			 <?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo ACT_DASHBOARDS;?></a>
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
		<a href="Milestone_progress_dashboard.php?obj=<?php echo $msdata["itemid"];?>" <?php if($sCurPage=='Milestone_progress_dashboard.php?obj='.$msdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo MIL_DASHBOARDS;?></a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo MIL_DASHBOARDS;?></a>
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
		<?php if($sCurPage=='CAM_progress_dashboard.php?obj='.$$camdata["itemid"]) echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo CAM_DASHBOARDS;?>
        </a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo CAM_DASHBOARDS;?></a>
		<?php
		}
		?>
		</li>
		 <?php }?> <!--// CAM Dashboard-->
         </ul>
		</li>
	    <li>
           <a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current">
       <?php echo PTOOLS;?></a> 
        <ul>
		
        <li>
		<?php  if($pic_flag==1)
		{
		?>
		<a href="analysis.php" <?php if($sCurPage=='analysis.php') echo 'class="sel"' ; ?> class="current" ><?php echo PIC_ANALYSIS;?></a>
		<?php
		}
		else
		{
		?>
	<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo PIC_ANALYSIS;?></a>
		<?php
		}
		?>
		</li>
		<li>
			<?php  if($draw_flag==1)
			{
			?>
			<a href="dm_drawingmap.php" <?php if($sCurPage=='dm_drawingmap.php') echo 'class="sel"' ; ?>  class="current"><?php echo MAPS_DRAWINGS;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo MAPS_DRAWINGS;?></a>
			<?php
			}
			?>
			</li>
        <li>
			<?php  if($issueAdm_flag==1)
			{
			?>
			<a href="project_issues_info.php" <?php if($sCurPage=='project_issues_info.php') echo 'class="sel"' ; ?>  class="current"><?php echo PROJECT_ISS;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo PROJECT_ISS;?></a>
			<?php
			}
			?>
			
			</li>
        <li>
			<?php  if($ncf_flag==1)
			{
			?>
			<a href="project_nonconfirmity_info.php" <?php if($sCurPage=='project_nonconfirmity_info.php') echo 'class="sel"' ; ?>  class="current"><?php echo NON_CONFON;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo NON_CONFON;?></a>
			<?php
			}
			?>
			
			</li>
        <li>
			<?php  if($dp_flag==1)
			{
			?>
			<a href="sp_design.php" <?php if($sCurPage=='sp_design.php') echo 'class="sel"' ; ?>  class="current"><?php echo DESIGN_PROG;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo DESIGN_PROG;?></a>
			<?php
			}
			?>
			
			</li>
		</ul>
        </li>
		<li >
      <a href="#"><?php echo ADMINI;?></a>
      
			<ul>
            <li>  <a href="#" style="background:#e36c00; text-align:center"><?php echo PROJ_SETUP;?></a></li>
			<li>
			<?php  if($padm_flag==1)
			{
			?>
			<a href="project_calender.php" <?php if($sCurPage=='project_calender.php') echo 'class="sel"' ; ?>  class="current"><?php echo PDETAILS;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo ADD_PROJ;?></a>
			<?php
			}
			?></li>
         <?php /*?>   <li>
            <a href="project_currency.php" <?php if($sCurPage=='project_currency.php') echo 'class="sel"' ; ?>  class="current">Project Currencies</a>
            </li><?php */?>
           
             <?php /*?><li>
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
			</li><?php */?>
			

			 <span <?php if($pdata == 0){?>style="pointer-events: none;" <?php }?>>
             
             	
         <li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current" style="background:#e36c00;text-align:center">
    <?php if($project_type==1)
		{
			echo BOQ;
		}
		else
		{
		 echo MIL;
		 }echo " ".BASE_DATA_SETUP;?></a></li>
    
         <li>
		<?php 
			if($project_type==1)
		{?>
		<a href="boqdata.php" <?php if($sCurPage=='boqdata.php') echo 'class="sel"' ; ?>  target="_self" class="current"><?php echo STEP1." - ".BOQ_ENTRY;?> </a>
		<?php
		}
		elseif($project_type==2)
		{?>
        <a href="mildata.php" <?php if($sCurPage=='mildata.php') echo 'class="sel"' ; ?>  target="_self" class="current"><?php echo STEP1." - ".MIL_ENTRY;?></a>
		<?php }
		
		else
		{
		?>
       
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo STEP1." - ".BOQ_MIL_ENTRY;?></a>
       
       
		<?php
		}
		?>
		</li>
        	<li>
			<?php  if($rescount!=0)
			{
			?>
			<a href="addipc.php" <?php if($sCurPage=='addipc.php') echo 'class="sel"' ; ?> class="current" ><?php echo STEP2." - ".IPC_ENTRY;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo STEP2." - ".IPC_ENTRY;?></a>
			<?php
			}
			?>
			</li>
			
            <li><a href="#" <?php if($sCurPage=='#') echo 'class="sel"' ; ?>  class="current" style="background:#e36c00;text-align:center">
     <?php echo KPI_DATA_SETUP;?></a></li>
     
     	<li><?php  if($rescount!=0)
			{
			?>
			<a href="baseline.php" <?php if($sCurPage=='baseline.php') echo 'class="sel"' ; ?> class="current"><?php echo STEP1." - ".BASELINE_ENTRY;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo STEP1." - ".BASELINE_ENTRY;?></a>
			<?php
			}
			?>	</li>
          
			<li><?php  if($kfcount!=0)
			{
			?>
			<a href="maindata.php" <?php if($sCurPage=='maindata.php') echo 'class="sel"' ; ?> class="current"><?php echo STEP2." - ".ACT_ENTRY;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo STEP2." - ".ACT_ENTRY;?></a>
			<?php
			}
			?>	</li>
            
             <?php //if($boqcount!=0&&$rescount!=0&&$actcount!=0)
//			{?>
			
			<?php /*?><li>
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
			</li><?php */?>
            <li>
			<?php  
		if($kpicount!=0)
		{
		?>
		<a href="kpidata.php" <?php if($sCurPage=='kpidata.php') echo 'class="sel"' ; ?>  target="_self" class="current"><?php echo STEP3." - ".KPI_ENTRY;?></a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo STEP3." - ".KPI_ENTRY;?></a>
		<?php
		}
		?>
		</li>
        <li>
			<?php  if($ppcount!=0)
			{
			?>
			<a href="addprogress.php" <?php if($sCurPage=='addprogress.php') echo 'class="sel"' ; ?>  target="_self" class="current"><?php echo STEP2." - ".PROG_ENTRY;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo STEP2." - ".PROG_ENTRY;?></a>
			<?php
			}
			?>	
			</li>
            <li>
			<?php  if($ppcount!=0)
			{
			?>
			<a href="process.php" <?php if($sCurPage=='process.php') echo 'class="sel"' ; ?> class="current" ><?php echo PROCESS;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo PROCESS;?></a>
			<?php
			}
			?>
			</li>
        
        <li><a href="#" style="background:#e36c00; text-align:center"><?php echo MICH;?></a></li>
        <li><?php  if($kfcount!=0)
			{
			?>
			<a href="planned.php" <?php if($sCurPage=='planned.php') echo 'class="sel"' ; ?>  target="_self" class="current"><?php echo MODIFY_PLAN;?></a>
			<?php
			}
			else
			{
			?>
			<a href="javascript:void(0);" style="opacity: 0.5;" class="current" ><?php echo MODIFY_PLAN;?></a>
			<?php
			}
			?>
			</li>
        <li><a href="user_log.php" <? if($sCurPage=='user_log.php') echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo USR_LOG;?></a></li> 
            <?php /*?><li><?php  if($mile_flag==1)
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
		?>	</li><?php */?>
          	<?php /*?><li><?php  if($cam_flag==1)
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
		?></li><?php */?>
        <?php //}?>
          </span>
           </ul>
		</li>
       
     
        <?php //}?>
	   <?php  if(isset($_SESSION['log_id'])&&$_SESSION['log_id']!=0)
				{?>
  		<li><a href="requires/logout.php" ><?php echo LOGOUT;?></a></li>	
           <li><a href="about.php" <?php if($sCurPage=='about.php') echo 'class="sel"' ; ?>  
     class="current"><?php echo APMIS;?></a></li>
				<?php } ?>	
               <li> <a href="home.php?language=en">English</a> </li><li> <a href="home.php?language=rus">Russian</a> </li>		
   		</ul>
  		
    </div>
	<br />
	