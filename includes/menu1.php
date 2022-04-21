<div id="navcontainer" class="menu" >
		<ul>
			
			<li><a href="index.php" <? if($sCurPage=='index.php') echo 'class="sel"' ; ?>  class="current">Home</a></li>
		<li><a href="./?p=news_mgmt" <? if($sCurPage=='./?p=news_mgmt') echo 'class="sel"' ; ?> class="current" target="_blank">News and Events</a></li>
	 	<li><a href="PMIS/index.php" <? if($sCurPage=='PMIS/index.php') echo 'class="sel"' ; ?> class="current" target="_blank">PMIS</a></li>
		<li><a href="DMS/index.php" <? if($sCurPage=='DMS/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current" target="_blank">DMS</a></li>
		<li><a href="Dashboard/index.php" <? if($sCurPage=='Dashboard/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current">Strategic Dashboard</a></li>
	
    <li><a href="./?p=logout" style="color:">Logout</a></li>
 </ul>
</div>

