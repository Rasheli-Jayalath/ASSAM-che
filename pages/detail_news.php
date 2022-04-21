<?php
$news_cdd=$_GET['news_cd'];
?>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
<div id="wrapperPRight">

		<div id="pageContentName"><?php echo "News/Events Management";?></div>
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

		<table  width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
       		
 <?php
 	$objNews->setProperty("news_cd", $news_cdd);
	$objNews->setProperty("limit", PERPAGE);
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		$rows = $objNews->dbFetchArray(1);
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<tr>
		<td style="padding-left:20px; padding-right:20px; padding-top:20px;">
    		<div style="width:100%">
			<div style=" background:#FEFEFE; width:15%;  float:left"  > <?php if($rows['newsfile']!="") {?> <a href="<?php echo NEWS_URL.$rows['newsfile'] ;?>" data-lightbox="roadtrip"  data-title="image"><img src="<?php echo NEWS_URL.$rows['newsfile'] ;?>" border="0" width="120px" height="120px" /></a>
			
           <?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "images/news.jpg" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?></div>
			<div style="width:85%; float:right" >
			<table width="100%" style=" border-spacing:10px">
			<tr>
               
                <td style=" text-align:left; color:#0033CC; font-size:14px; font-weight:bold"><?php echo $rows['title'];?></td>
				<td style="text-align:right; color:black;"> <?php echo date('d-m-Y', strtotime($rows['newsdate']));?></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" style="color:black"><?php print $rows['details'];?></td>
                
    		</tr>
			<tr>
			<td colspan="2">
			<?php
			if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="")&& ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			$file3=$rows['newsfile3'];
			$file4=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile2'];
			$file2=$rows['newsfile3'];
			$file3=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile3'];
			$file3=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			$file3=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			$file3=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']!="") )
			{
			$file1=$rows['newsfile3'];
			$file2=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile2'];
			$file2=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile2'];
			$file2=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile4'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			$file2=$rows['newsfile2'];
			}
			else if(($rows['newsfile1']!="") && ($rows['newsfile2']=="") && ($rows['newsfile3']=="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile1'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']!="") && ($rows['newsfile3']=="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile2'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']=="") && ($rows['newsfile3']!="") && ($rows['newsfile4']==""))
			{
			$file1=$rows['newsfile3'];
			}
			else if(($rows['newsfile1']=="") && ($rows['newsfile2']=="") && ($rows['newsfile3']=="") && ($rows['newsfile4']!=""))
			{
			$file1=$rows['newsfile4'];
			}
			else
			{
			$file1="";
			$file2="";
			$file3="";
			$file4="";
			}
			
			
			?>
			<table width="100%"><tr><td><?php if($file1!="")
			{ ?><a href="<?php echo NEWS_URL.$file1 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="<?php echo NEWS_URL.$file1 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			<td><?php if($file2!="")
			{ ?><a href="<?php echo NEWS_URL.$file2 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="<?php echo NEWS_URL.$file2 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			<td><?php if($file3!="")
			{ ?>
			<a href="<?php echo NEWS_URL.$file3 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="<?php echo NEWS_URL.$file3 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			<td><?php if($file4!="")
			{ ?>
			<a href="<?php echo NEWS_URL.$file4 ;?>" data-lightbox="roadtrip"  data-title="image"><img src="<?php echo NEWS_URL.$file4 ;?>" border="0" width="120px" height="120px" /></a><?php }
			?></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</div>
			</div>
			</td>
			</tr>
			
			
    		<?php
			
    }
	
	?>
	
		 </table>

	</div>

	