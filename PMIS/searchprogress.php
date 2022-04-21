<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
if ($uname==null)
{
	header("Location: index.php?init=3");
}
$module 			= $_REQUEST['module'];

if($module=="Add Progress")
{
$id="itemid";
$tbl_name="maindata";
$tbl_name1="maindata_log";
$file_name="maindata.php";
$valuestage			= $_REQUEST['stage'];
$valueitemcode		= $_REQUEST['itemcode'];
$valueitemname 		= $_REQUEST['itemname'];
$valueweight 		= $_REQUEST['weight'];
$valueisentry		= $_REQUEST['isentry'];
}
$objDb  = new Database( );
@require_once("get_url.php");
$sCondition = '';


if($module=="Add Progress")
{

if($valuestage!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (stage  like '%".$valuestage."%' and (stage='Output' or stage='Activity') and isentry=0) ";
		}
		else
		{
		$sCondition=" (stage  like '%".$valuestage."%' and (stage='Output' or stage='Activity') and isentry=0) ";
		}
	
}

if($valueitemcode!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemcode  like '%".$valueitemcode."%' and (stage='Output' or stage='Activity') and isentry=0) ";
		}
		else
		{
		$sCondition=" (itemcode  like '%".$valueitemcode."%' and (stage='Output' or stage='Activity') and isentry=0) ";
		}
	
}
if($valueitemname!="")
{
	
		if($sCondition!="")
		{
		$sCondition.=" AND (itemname  like '%".$valueitemname."%' and (stage='Output' or stage='Activity') and isentry=0) ";
		}
		else
		{
		$sCondition=" (itemname  like '%".$valueitemname."%' and (stage='Output' or stage='Activity') and isentry=0) ";
		}
	
}
if($valueisentry !="")
{
if($valueisentry=='y' || $valueisentry=='ye' || $valueisentry=='yes' || $valueisentry=='e' || $valueisentry=='s' || $valueisentry=='es')
{
$valueisentry=1;
}
else if($valueisentry=='n' || $valueisentry=='no' || $valueisentry=='o')
{
$valueisentry=0;
}	
		if($sCondition!="")
		{
		$sCondition.=" AND (isentry=$valueisentry and (stage='Output' or stage='Activity') and isentry=0) ";
		}
		else
		{
		$sCondition=" (isentry=$valueisentry and (stage='Output' or stage='Activity') and isentry=0) ";
		}
	
}

if($valueweight!="")
{
 $len = strlen($valueweight);
 $pos = strpos($valueweight,'-');
 $last = substr($valueweight,-1);

if (strpos($valueweight,'-') === 0) {
	$expstart = substr($valueweight, 1, $len - $pos);
	//$sSQL1 = "SELECT * FROM tblcvmain WHERE totalExp <= ".$expstart;
	if($sCondition!="")
	{
		
	$sCondition.=" AND (weight <= '$expstart' and (stage='Output' or stage='Activity') and isentry=0) ";
	}
	else
	{
	$sCondition= " (weight  <= '$expstart' and (stage='Output' or stage='Activity') and isentry=0) ";
	}
} 
else if (strpos($valueweight,'-') === false) {
	$expstart = substr($valueweight, 0, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight  = ".$expstart." and (stage='Output' or stage='Activity') and isentry=0) ";
	}
	else
	{
	$sCondition= " (weight  = ".$expstart." and (stage='Output' or stage='Activity') and isentry=0) ";
	}
}
else if (strpos($valueweight,'-') > 0 && $last =='-') {
	$expstart = substr($valueweight, 0, $len - 1);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight >= ".$expstart." and (stage='Output' or stage='Activity') and isentry=0) ";
	}
	else
	{
	$sCondition= " (weight >= ".$expstart." and (stage='Output' or stage='Activity') and isentry=0) ";
	}
} 
else if (strpos($valueweight,'-') > 0) {
	$expstart = substr($valueweight, 0, $pos);
	$expend = substr($valueweight, $pos+1, $len - $pos);
	if($sCondition!="")
	{
	$sCondition.=" AND (weight between ".$expstart." and ".$expend." and (stage='Output' or stage='Activity') and isentry=0) ";
	}
	else
	{
	$sCondition= " (weight between ".$expstart." and ".$expend." and (stage='Output' or stage='Activity') and isentry=0) ";
	}
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
	
	
	  <?php if($module=="Add Progress"){?>
    <th></th>
	 <th align="center" width="50%"><strong>Item Name</strong></th>
	  <th align="center" width="15%"><span class="label">Stage</span></th>
	  <th align="center" width="10%"><span class="label">Item Code</span></th>
	  <th width="10%"><strong>Weight</strong></th>
	   <th align="center" width="10%"><span class="label">Isentry</span></th>
      <th align="center" width="5%"><strong><input  type="checkbox"  name="txtChkAll2" id=
          "txtChkAll2"   form="reportsp"  onclick="group_checkbox2();"/></strong></th>
      
	 	 	 
	  <?php
	  }
	  ?>
	
    </tr>
<strong>
<?php
if($sCondition=="")
{
$sCondition="1=1 and (stage='Output' or stage='Activity') and isentry=0";
}
if($module=="Add Progress")
{
$sSQL = " select * from $tbl_name where ".$sCondition." order by parentgroup, parentcd";
$sqlresult = mysql_query($sSQL);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parentgroup'];
	$parentcd = $data['parentcd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql2 = "select * from maindata where itemid = ".$cdlist[0];
	$cdsqlresult12 = mysql_query($cdsql2);
	$cddata1 = mysql_fetch_array($cdsqlresult12);
	$itemname = $cddata1['itemname'];
	?>

</strong>
<tr id="abcd<?php echo $cdlist[$items-1];?>">
		<?php
		$cdsql = "select * from maindata where itemid = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$itemid = $cddata['itemid'];
		$parentcd = $cddata['parentcd'];
		$stage=$cddata['stage'];
		$activitylevel=$cddata['activitylevel'];
		if($cddata['isentry']==0)
				{
				$isentry1="No";
				}
				else
				{
				$isentry1="Yes";
				}

			?>
<script>


function AddNewSizeProject<?php echo $itemid; ?>(){
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this,<?php echo $itemid; ?>);" title="Remove size">[X]</a>';
	var td2 = '<input type="hidden" name="txtitemid" id="txtitemid" value="<?php echo $itemid; ?>" size="25" style="text-align:right; width:100px"/><input type="text" name="txtcode" id="txtcode"  size="25" style="text-align:right; width:100px"/>';
	var td4 = '<input type="text" name="txtstartdate" id="txtstartdate" onClick=add_sd("txtstartdate");  size="25" style="text-align:right; width:100px" />';
                                   
	var td5 = '<input type="text" name="txtenddate" id="txtenddate" onClick=add_ed("txtenddate"); size="25" style="text-align:right; width:100px"/>';
	var td6 = '<input type="text" name="txtastartdate" id="txtastartdate" onClick=add_asd("txtastartdate"); size="25" style="text-align:right; width:100px"/>';
	var td7 = '<input type="text" name="txtaenddate"  id="txtaenddate"  onClick=add_aed("txtaenddate"); size="25" style="text-align:right; width:100px"/>';
	var td8 = '<input type="text" name="txtorder"  id="txtorder"  size="25" style="text-align:right; width:100px"/>';
	var td9 = '<input type="text" name="txtbaseline" id="txtbaseline"  size="25" style="text-align:right; width:100px"/>';
	var td10 = '<input type="text" name="txtweight" id="txtweight"  size="25" style="text-align:right; width:100px"/>';
	var td11 = '<input type="text" name="txtremarks" id="txtremarks"  size="25" style="text-align:right; width:100px"/>';
	var td12 = '<input type="button" id="save" name="save" value="Save" size="25" onClick=add_data(txtitemid.value); style="text-align:right; width:100px"/>';
	var td3 = '<select name="txtscheduleid" id="txtscheduleid" style="width:70px">' + "\n";

	
	<?php 
	$sqlg="Select * from resources";
			$resg=mysql_query($sqlg);
			while($row3g=mysql_fetch_array($resg))
			{
			?>
	td3 	+= "\t" + '<option value="<?php echo $row3g['schedulecode'];?>"><?php echo $row3g['schedulecode'].": ".$row3g['resource'];?></option>' + "\n";
	<?php }?>
	
	td3 	+= '</select>' + "\n";
	
	document.getElementById("addnew<?php echo $itemid; ?>").style.display="none";
	
	var arrTds = new Array(td1, td2, td3,td4, td5, td6,td7, td8, td9,td10,td11,td12);
	doAddTr(arrTds, 'tblPrdSizesProject<?php echo $itemid; ?>');
}
</script>			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td rowspan="2"></td>
			<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parentcd==0){	
			echo "<b>".$itemname."</b>";
			}
			else
			{
			echo $h.$cddata['itemname'];
		
			}
		  
		  
		   ?>
		</td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?php echo $stage;?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>" ><?=$cddata['itemcode'];?></td>
		<td style=" font-size:10px; color: #000000; background-color: <?php echo $colorr; ?>"><?=$cddata['weight'];?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>" ><?=$isentry1;?></td>
		<td style=" font-size:10px;  color: #000000; background-color: <?php echo $colorr; ?>"><input class="checkbox2" type="checkbox" name="sel_checkbox[]" id="sel_checkbox[]" value="<?=$itemid ?>"   form="reportsp" onclick="group_checkbox2();">		</td>
				
		</tr>
<tr>
		<td colspan="8">
			 <?php
		$cdsql_a = "select * from maindata where parentcd = '$cddata[itemid]' and isentry=1";
		$cdsqlresult_a = mysql_query($cdsql_a);
		if(mysql_num_rows($cdsqlresult_a)>0)
			 
	/*if($cddata['isentry']==1)*/
		{	
		?> 
		<script>
		function callmsgbody<?php echo $itemid; ?>()
		{
		
			var id=<?php echo $itemid; ?>;
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp3=new XMLHttpRequest();
			  } else {  // code for IE6, IE5
				xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			
			  xmlhttp3.onreadystatechange=function() {
				if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
				
					
					document.getElementById("abc"+id).innerHTML=xmlhttp3.responseText;
					document.getElementById("addnew"+id).style.display="block";
					
				 // document.getElementById("search").style.border="1px solid #A5ACB2";
				  
				
				 
				}
			  }
			
			  xmlhttp3.open("GET","reloadprogress.php?itemid="+id,true);
			  xmlhttp3.send();
			$('div[class^="msg_body"]').not('.msg_body<?php echo $itemid;?>').hide();
			$(".msg_body<?php echo $itemid;?>").show(); 
			$(this).next(".msg_body<?php echo $itemid;?>").slideToggle(600);
			
		}

		</script> 
		 <div class="msg_list" style="display:inline">
		  <div class="msg_head" onclick="callmsgbody<?php echo $itemid; ?>()">+
		   <span class="tooltiptext">Add Data</span>
		  </div>
		 
		  <div class="msg_body<?php echo $itemid; ?>" style="display:none">
	<div id="abc<?php echo $itemid; ?>"> 
			</div>	
			 	
			  <input type="button" value="Close" name="close" id="close" onclick="closediv(<?php echo $itemid; ?>)" />
			  <?php  if($spgentry_flag==1 || $spgadm_flag==1)
				{
				?>
			  <input type="button" value="Cancel" name="cancel" id="cancel" onclick="cancelp_data(<?php echo $itemid; ?>)" />
			  <?php
			  }
			  ?>

	</div>
		  </div>
		  <?php
		  }
		  ?>
		</td></tr>
<?php        
	}
}

?>
</table>
</div>
</td> 
</body>
</html>
