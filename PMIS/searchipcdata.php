<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
if($module=="IPC Data")
	{
	$id="ipcid";
	$tbl_name="ipc";
	$tbl_name1="ipc_log";
	$file_name="ipcdata.php";
	
	
$ipcno								= $_REQUEST['ipcno'];
$ipcmonth							= $_REQUEST['ipcmonth'];
$ipcstartdate						= $_REQUEST['ipcstartdate'];
$ipcenddate							= $_REQUEST['ipcenddate'];
$ipcsubmitdate						= $_REQUEST['ipcsubmitdate'];
$ipcreceivedate						= $_REQUEST['ipcreceivedate'];
	
	
	}

$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';

if($module=="IPC Data")
{
if($ipcno!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (ipcno like '%".$ipcno."%') ";
		}
		else
		{
		$sCondition=" (ipcno like '%".$ipcno."%') ";
		}
	
}


if($ipcmonth!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (ipcmonth  like '".$ipcmonth."%') ";
		}
		else
		{
		$sCondition=" (ipcmonth  like '".$ipcmonth."%') ";
		}
	
}

if($ipcstartdate!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (ipcstartdate>='$ipcstartdate') ";
		}
		else
		{
		$sCondition=" (ipcstartdate>='$ipcstartdate') ";
		}
	
}
if($ipcenddate!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (ipcenddate<='$ipcenddate') ";
		}
		else
		{
		$sCondition=" (ipcenddate<='$ipcenddate') ";
		}
	
}
if($ipcsubmitdate!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (ipcsubmitdate='$ipcsubmitdate') ";
		}
		else
		{
		$sCondition=" (ipcsubmitdate='$ipcsubmitdate') ";
		}
	
}
if($ipcreceivedate!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (ipcreceivedate='$ipcreceivedate') ";
		}
		else
		{
		$sCondition=" (ipcreceivedate='$ipcreceivedate') ";
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
      <th align="center" width="3%"><strong>Sr. No.</strong></th>
      <th align="center" width="2%"><strong>
	  <input  type="checkbox"  name="txtChkAll2" id=
          "txtChkAll2"   form="reports"  onclick="group_checkbox2();"/>
		  
		  </strong></th>
      <th align="center" width="10%"><strong>IPC No</strong></th>
      <th width="10%"><strong>IPC Month</strong></th>
      <th width="15%"><strong>IPC Start Date</strong></th>
	  <th width="15%"><strong>IPC End Date</strong></th>
      <th width="15%"><strong>IPC Submit Date</strong></th>
	  <th width="15%"><strong>IPC Receive Date</strong></th>
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

			$sSQL = " select * from $tbl_name where ".$sCondition;
			$objDb->query($sSQL);
					$iCount = $objDb->getCount( );
					if($iCount>0)
					{
	for ($i = 0 ; $i < $iCount; $i ++)
	{
		$id1 								= $objDb->getField($i, $id);
	  $ipcno 								= $objDb->getField($i,ipcno);
	  $ipcmonth	 							= $objDb->getField($i,ipcmonth);
	  $ipcstartdate							= $objDb->getField($i,ipcstartdate);
	  $ipcenddate 							= $objDb->getField($i,ipcenddate);
	  $ipcsubmitdate	 					= $objDb->getField($i,ipcsubmitdate);
	  $ipcreceivedate						= $objDb->getField($i,ipcreceivedate);
		
	
if ($i % 2 == 0) {
	$style = ' style="background:#f1f1f1;"';
} else {
	$style = ' style="background:#ffffff;"';
}
				
$link=$file_name."?edit=".$id1;?>
<tr <?php echo $style; ?> >
<td width="5px"><center> <?=$i+1;?> </center> </td>
<td><input class="checkbox2" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$id1;?>"  onclick="group_checkbox2();" form="reports">
</td>
<td width="210px"><?=$ipcno;?></td>
<td width="100px"><?=$ipcmonth;?></td>
<td width="180px"  ><?=$ipcstartdate;?></td>
<td width="210px"><?=$ipcenddate;?></td>
<td width="100px"><?=$ipcsubmitdate;?></td>
<td width="180px"  ><?=$ipcreceivedate;?></td>

<td style="border-bottom:1px solid #cccccc" width="210px" >&nbsp;
<a href="<?php echo $link;?>"  ><img src="images/edit.png" width="22" height="22" /></a></td>
<td width="210px" align="right" ><a href="log_ipcdata.php?trans_id=<?php echo $id1; ?>&module=<?php echo $module?>" target="_blank">Log</a></td>
</tr>

<?php
}
}

?>
</table>
</div>
</td> 
</body>
</html>
