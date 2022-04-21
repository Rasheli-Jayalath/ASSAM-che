<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
if($module=="Progress")
	{
	$id="pmid";
	$tbl_name="progressmonth";
	$tbl_name1="progressmonth_log";
	$file_name="progress.php";
	$valuemonth		= $_REQUEST['month'];
	$valuestatus			= $_REQUEST['status'];
	$valueremarks		= $_REQUEST['remarks'];
	
	
	}

$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';

if($module=="Progress")
{
if($valuemonth!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (pmonth  like '".$valuemonth."%') ";
		}
		else
		{
		$sCondition=" (pmonth  like '".$valuemonth."%') ";
		}
	
}
if($valuestatus!="")
{
	if($valuestatus=="active" || $valuestatus=="Active")
	{
	$valuestatus1=0;
	}
	else if($valuestatus=="inactive" || $valuestatus=="Inactive")
	{
	$valuestatus1=1;
	}
		if($sCondition!="")
		{
		$sCondition.=" AND (status=$valuestatus1) ";
		}
		else
		{
		$sCondition=" (status=$valuestatus1) ";
		}
	
}
if($valueremarks!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (remarks  like '%".$valueremarks."%') ";
		}
		else
		{
		$sCondition=" (remarks  like '%".$valueremarks."%') ";
		}
	
}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $module; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
 <div class="with_search">
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
	
	<?php if($module=="Progress"){?>
	 <th align="center" width="3%"><strong>Sr. No.</strong></th>
      <th align="center" width="2%"><strong>
	  <input  type="checkbox"  name="txtChkAll2" id=
          "txtChkAll2"   form="reports"  onclick="group_checkbox2();"/></strong></th>
      <th align="center" width="25%"><strong>Month</strong></th>	
      <th width="20%"><strong>Status</strong></th>
      <th width="25%"><strong>Remarks</strong></th>
	  
	  <?php
	  }
	  ?>
	 
	  
	<th align="center" width="15%"><strong>Action
    </strong></th>
	<th align="center" width="10%"><strong>Log
    </strong></th>
    </tr>
<strong>
<?php
if($sCondition=="")
{
$sCondition="1=1";
}

if($module=="Progress")
{
			$sSQL = " select * from $tbl_name where ".$sCondition;
			$objDb->query($sSQL);
					$iCount = $objDb->getCount( );
					if($iCount>0)
					{
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$id1 					= $objDb->getField($i, $id);
		$pmonth  				= $objDb->getField($i, pmonth);
		$status3  					= $objDb->getField($i, status);
		 if($status3=="0")
	  {
	  $status="Active";
	  }
	  else if($status3=="1")
	  {
	  $status="Inactive";
	  }
		$remarks  				= $objDb->getField($i, remarks);
		
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
				if($isentry==0)
				{
				$isentry1="No";
				}
				else
				{
				$isentry1="Yes";
				}
$link=$file_name."?edit=".$id1;?>
<tr <?php echo $style; ?> >
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox2" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$id1;?>"  onclick="group_checkbox2();" form="reports">
</td>
<td width="140px"><?=$pmonth;?></td>
<td width="210px"><?=$status;?></td>
<td width="210px"><?=$remarks;?></td>
<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
<a href="<?php echo $link;?>"  ><img src="images/edit.png" width="22" height="22" /></a></td>
<td width="210px" align="right" ><a href="log.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
</tr>

<?php
}
}
}
?>
</table>
</div>
</td> 
</body>
</html>
