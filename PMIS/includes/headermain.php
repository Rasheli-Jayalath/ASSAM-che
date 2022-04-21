<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$sCurPage = substr($_SERVER['PHP_SELF'], (strrpos($_SERVER['PHP_SELF'], "/") + 1));
?>
<div id="logo"><a href="maindata.php"  title="PMIS" >
<img src="images/cv-bank.jpg" title="PMIS" alt="PMIS" width="950" height="85"  /></a>
</div>

<div id="topmenu">
    <ul id="menu">
		<li><a href="main.php" <? if($sCurPage=='main.php') echo 'class="sel"' ; ?>  class="current">Home</a></li>
		<li><a href="PMIS/index.php" <? if($sCurPage=='PMIS/index.php') echo 'class="sel"' ; ?> class="current">News and Events</a></li>
	 	<li><a href="PMIS/index.php" <? if($sCurPage=='PMIS/index.php') echo 'class="sel"' ; ?> class="current">PMIS</a></li>
		<li><a href="DMS/index.php" <? if($sCurPage=='DMS/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current">DMS</a></li>
		<li><a href="Dashboard/index.php" <? if($sCurPage=='Dashboard/index.php') echo 'class="sel"' ; ?>  target="_blank" class="current">Strategic Dashboard</a></li>
		</ul>
  		
    </div>
	