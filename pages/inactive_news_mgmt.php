<?php
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

?>


<div id="wrapperPRight">

		<div id="pageContentName"><?php echo "Inactive News/Event";?></div>
		<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=news_mgmt" class="lnkButton"><?php echo "Back";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<div class="clear"></div>
			
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<table  width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
       		
 <?php
 	$objNews->setProperty("status", "N");
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
				<td  valign="top" style="color:black"><a href="?p=detail_news&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none">Read More</a></td>
				<td style="text-align:right">
				<a href="./?p=news_mgmt&mode=active&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none"title="Activate">Activate</a> | <a onClick="return doConfirm('Are you sure to delete this news?');" href="./?p=news_mgmt&mode=delete&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none" title="Delete">Delete</a></td>
                
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
    	<td colspan="6" align="center"><?php echo 'No Inactive news found.';?></td>
    </tr>
    <?php
	}
	?>
	
		 </table>
	  </form>
	</div>

	