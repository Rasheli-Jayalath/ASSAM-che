<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$uname = $_SESSION['uname'];
if ($uname==null)
{
	//header("Location: index.php?init=3");
}
$admflag 			= $_SESSION['admflag'];
$superadmflag	 	= $_SESSION['superadmflag'];
$module 			= $_REQUEST['module'];
$boq_id		= $_REQUEST['boq_id'];
$type		= $_REQUEST['type'];
$edit		= $_REQUEST['edit'];
$unit		= $_REQUEST['unit'];
$objDb  = new Database( );
$objDbb  = new Database( );
$objDbe  = new Database( );
@require_once("get_url.php");
/*if($edit!="")
{
 $dSql = "Select * from baseline where rid='$edit'";
  $objDbe -> query($dSql);
  $unit = $objDbe->getField(0,unit);
}*/
if($boq_id!="")
{
 $eSql = "Select * from boq where boqid='$boq_id'";

  $objDbb -> query($eSql);
  $eCount = $objDbb->getCount();
  $boqunit = $objDbb->getField(0,boqunit);
}

?>
<select name="txtboqcodem[]" id="txtboqcodem" onchange="get_sum_unit(this.value)" multiple="multiple">
			  <?php 
			 if($type=="All")
			{
		      $sqlg="Select * from boq where  boqid<>$boq_id";
			}
			elseif($type=="Boq" && isset($edit) && $edit!="" && $unit!="")
			{
				$sqlg="Select * from boq where  boqid<>$boq_id and boqunit='$unit'";
			}
			else
			{
			   $sqlg="Select * from boq where boqunit='$boqunit' and boqid<>$boq_id";
			
			}
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			$boqid=$row3g['boqid'];
			if(isset($edit)&&$edit!="")
			{
			$mbSql = "Select boqid from `baseline_mapping_boqs` where rid=".$edit; 
				$sqlresultbm = mysql_query($mbSql); 
				
				while($boq_rowsbm = mysql_fetch_array($sqlresultbm))
				{
					
				if($boqid==$boq_rowsbm["boqid"])
				{
				 $sel="selected='selected'";
				break;
				}
				else
				{
				$sel="";
				}
				
				}
			}
			?>
			  <option  value="<?php echo $boqid;?>" <?php echo $sel; ?> ><?php echo $row3g['boqid']. ": ".$row3g['boqcode']. " - ". $row3g['boqitem']. " (". $row3g['boqunit']. ")"; ?> </option>
			  <?php
			  }
			  ?>
</select>

