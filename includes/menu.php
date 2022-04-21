<?php
$superadmin 	= $_SESSION['ne_sadmin'];
$news_flag 		= $_SESSION['ne_news'];
$newsadm_flag 	= $_SESSION['ne_newsadm'];
$newsentry_flag = $_SESSION['ne_newsentry'];
$strusername 	= $_SESSION['ne_username'];

?>
<div id="navcontainer" class="menu" >
		<ul>
			
			<li><a href="index.php" <? if($sCurPage=='index.php') echo 'class="sel"' ; ?>  class="current"><?php echo HOME;?></a></li>
			
		<li> <?php if ($news_flag == 1) { ?> 
		<a href="./?p=news_mgmt" <? if($sCurPage=='./?p=news_mgmt') echo 'class="sel"' ; ?> class="current" target="_blank"><?php echo NEWS_EVENT;?></a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" style="opacity: 0.5;" ><?php echo NEWS_EVENT;?></a>
		<?php
		}
		?>
		
		</li>
	 	<li><a href="PMIS/home.php" <? if($sCurPage=='PMIS/home.php') echo 'class="sel"' ; ?> class="current" target="_blank"><?php echo PMIS;?></a></li>
		
		
		<li><a href="Dashboard/index.php" <? if($sCurPage=='Dashboard/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo SDASHBOARD;?></a></li>
        <li><a href="../IDIP2/index.php" <? if($sCurPage=='./IDIP2/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current"><?php echo GDASHBOARD;?></a></li>
	 <?php if ($superadmin == 1) { ?> 
	 <li><a href="./?p=user_mgmt" style="color:"><?php echo SUPER_ADMIN;?></a></li>
	 <?php
	 }
	 ?>
    <li><a href="./?p=logout" style="color:"><?php echo LOGOUT;?></a></li>
 </ul>
</div>

