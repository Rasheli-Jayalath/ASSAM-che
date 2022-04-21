<?php
if ($strusername==null  )
	{
		header("Location: ../index.php?init=3");
	}
else if ($news_flag==0)
	{
		header("Location: ../index.php?init=3");
	}

if($_GET['mode'] == 'delete'){
	$objNews->setProperty('news_cd', $_GET['news_cd']);
	 $sql_ii="SELECT * FROM `rs_tbl_news` where news_cd='$_GET[news_cd]'"; 
		$sql_newi=mysql_query($sql_ii);
		$sql_resnew=mysql_fetch_array($sql_newi);
		if($sql_resnew['newsfile']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile']);
		}
		if($sql_resnew['newsfile1']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile1']);
		}
		if($sql_resnew['newsfile2']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile2']);
		}
		if($sql_resnew['newsfile3']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile3']);
		}
		if($sql_resnew['newsfile4']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile4']);
		}
	$objNews->actNews('D');
	
	$objCommon->setMessage('News deleted successfully!', 'Info');
	redirect('./?p=news_mgmt');
}
if($_GET['mode'] == 'active')
{
$n_cd=$_GET['news_cd'];
$sqll="update rs_tbl_news set status='Y' where news_cd='$n_cd'";
mysql_query($sqll);
}
?>

<div id="wrapperPRight">
		<div id="pageContentName"><?php echo NEWS_EVENTS_MGMT;?></div>
		<?php /*if($_SESSION['ne_user_type']==1)
				{*/
				?>
		<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=inactive_news_mgmt" class="lnkButton"><?php echo NEWS_INACTIVE;?>
					</a></li>
				<?php if($newsentry_flag==1 || $newsadm_flag==1)
				{
				?>
				<li><a href="./?p=news_form&amp;mode=add" class="lnkButton"><?php echo NEWS_ADD_NEW;?>
					</a></li>
				<?php
				}
				?>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<?php
		//}
		?>
		<div class="clear"></div>
			
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<table  width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
       		
 <?php
 	$objNews->setProperty("status", "Y");
	$objNews->setProperty("orderby", "newsdate desc");
	$objNews->setProperty("limit", PERPAGE);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<tr>
		<td style="padding-left:20px; padding-right:20px; padding-top:20px;">
    		<div style="width:100%">
			<div style=" background:#FEFEFE; bawidth:15%; min-height:120px; float:left"  > <?php if($rows['newsfile']!="") {?> <a href="<?php echo NEWS_URL.$rows['newsfile'] ;?>" target="_blank"><img src="<?php echo NEWS_URL.$rows['newsfile'] ;?>" border="0" width="80px" height="80px" /></a>
			
           <?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "images/news.jpg" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?></div>
			<div style="width:85%;min-height:120px; float:right" >
			<table width="100%" style=" border-spacing:10px">
			<tr>
               
                <td style=" text-align:left; color:#0033CC; font-size:14px; font-weight:bold"><?php echo $rows['title'];?></td>
				<td style="text-align:right; color:black;"> <?php echo date('d-m-Y', strtotime($rows['newsdate']));?></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" style="color:black"><?php print substr($rows['details'],0,300).'...'?></td>
                
    		</tr>
			<tr>
				<td  valign="top" style="color:black"><a href="?p=detail_news&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none"><?php echo READ_MORE;?></a></td>
				
				<td style="text-align:right">
				<?php if($newsentry_flag==1 || $newsadm_flag==1 )
				{
				?>
				<a href="./?p=news_form&mode=edit&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none"title="Edit"><?php echo EDIT;?></a>
				<?php
				}
				?>
				 <?php if($newsadm_flag==1)
				{
				?>
				 | <a onClick="return doConfirm('<?php echo DEL_MSG?>');" href="./?p=news_mgmt&mode=delete&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none" title="Delete"><?php echo DEL;?></a>
				<?php
				}
				?>
				</td>
				<?php
				/*}
				else
				{
				?>
				<td>&nbsp;</td>
				<?php
				}*/
				?>
                
    		</tr>
			</table>
			</div>
			</div>
			</td>
			</tr>
			<tr>
			<td colspan="4" align="center">---------------------------------------------</td>
			
			</tr>
			
    		<?php
			$sno++;
		}
    }
	else{
	?>
    <tr>
    	<td colspan="6" align="center"><?php echo 'No news found.';?></td>
    </tr>
    <?php
	}
	?>
	
		 </table>
	  </form>
	</div>

	