<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= Planned;
if ($uname==null ) {
header("Location: index.php?init=3");
}
else if($spgentry_flag==0 and $spgadm_flag==0 )
{
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];

if(isset($_REQUEST['activityid']))
{
$activityid					= $_REQUEST['activityid'];
}
else
{
$activityid					= 0;
}
$month						= $_REQUEST['month'];


if(isset($saveBtn)&& $saveBtn != "")
{
 $eSql_l = "Select * from activity where aid=$activityid";
 $res_q=mysql_query($eSql_l);
 $res_q1=mysql_fetch_array($res_q);
 $itemid=$res_q1['itemid'];
 $rid=$res_q1['rid'];
$total_len=count($month);
if($total_len>0)
{
for($i=0; $i<$total_len;$i++)
{
$budgetdate=$month[$i];
$txtmonth=$month[$i]."-01";

$pdate=date('Y-m-d',strtotime($txtmonth));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;         
 $txtmonth=$pdate;
$budgetqty	= $_REQUEST['budgetqty_'.$budgetdate];


$sSQL = ("INSERT INTO planned (itemid,rid,budgetdate,budgetqty) VALUES ($itemid,$rid,'$txtmonth','$budgetqty')");

	$objDb->execute($sSQL);
	$pmid = $objDb->getAutoNumber();
	
	
	}
	}
	$flg=1;
header("location: planned.php?flg=$flg"); 
}
if(isset($updateBtn)&& $updateBtn != "")
{
$eSql_l = "Select * from activity where aid=$activityid";
 $res_q=mysql_query($eSql_l);
 $res_q1=mysql_fetch_array($res_q);
 $itemid=$res_q1['itemid'];
 $rid=$res_q1['rid'];
$total_len=count($month);
if($total_len>0)
{
for($i=0; $i<$total_len;$i++)
{
$budgetdate=$month[$i];
$txtmonth=$month[$i]."-01";

$pdate=date('Y-m-d',strtotime($txtmonth));
 $m=date('m',strtotime($pdate));
 $y=date('Y',strtotime($pdate));
 $days=cal_days_in_month(CAL_GREGORIAN, $m, $y); 
 $pdate=$y."-".$m."-".$days;         
 $txtmonth=$pdate;
$budgetqty	= $_REQUEST['budgetqty_'.$budgetdate];


$sSQL = ("update planned set
							budgetqty=$budgetqty
							where itemid=$itemid and rid=$rid and budgetdate='$txtmonth'");

	$objDb->execute($sSQL);
	$pmid = $objDb->getAutoNumber();
	
	}
	}
	$flg=2;
	$msg="Record updated successfully";
	header("location: planned.php?flg=$flg");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script>
function showResult(strmodule,strmonth,strstatus,strremarks) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	
      document.getElementById("search").innerHTML=xmlhttp.responseText;
      document.getElementById("search").style.border="1px solid #A5ACB2";
	   document.getElementById("without_search").style.display="none";
	  document.getElementById("without_search").disabled=true;
	// document.getElementById("without_search").removeClass("checkbox").addClass("");
	  var nodes = document.getElementById("without_search").getElementsByTagName('*');
			for(var i = 0; i < nodes.length; i++){
			 $("#cvcheck").attr( "class", "" ); 
				 nodes[i].disabled = true;
			}
	 
    }
  }
  xmlhttp.open("GET","searchpm.php?module="+strmodule+"&month="+strmonth+"&status="+strstatus+"&remarks="+strremarks,true);
  xmlhttp.send();
}

</script>
<script type="text/javascript">
function sel_activity(value) {
if(value==0)
{
window.location = "planned.php";
}
else
{
window.location = "planned.php?activityid="+value;
}

	
}

function validateFields() {
var activityid=document.frmstgoal.activityid.value;
if(activityid==0)
{
alert("Please select activity!");
 return false; 
}

}

</script>
<script>
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function group_checkbox2()
{
	var select_all = document.getElementById("txtChkAll2"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox2"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.with_search .checkbox2:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>
<script>
function group_checkbox()
{
	var select_all = document.getElementById("txtChkAll"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items
	
	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = select_all.checked;
		}
	});
	
	
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
}
</script>

</head>
<body>
<div id="wrap">
  <?php include 'includes/header.php'; ?>

<div id="content">
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" onsubmit="return validateFields()" enctype="multipart/form-data">
	  
	  <table class="project" width="100%" style="background-color:#FFF">
            <tr>
			<?php
			  $sqlfine="SELECT distinct(b.itemid) as itemid FROM  activity a INNER JOIN planned b ON (a.itemid = b.itemid) where a.aid=$activityid";
			$sqlfin1e=mysql_query($sqlfine);
			if(mysql_num_rows($sqlfin1e)>0)
			{
			$action="Update ";
			}
			else
			{
			$action="Add ";
			}
			?>
            <th colspan="3"><?php echo "Modify Planned Data for Default Baseline Template:" ?></th>
			</tr>
			<tr>
           <?php  if(isset($_REQUEST['flg']) && $_REQUEST['flg']==1)
		   {
		   ?>
		    <td colspan="3" ><font color="green"><strong><?php echo "Record Added Successfully" ?></strong></font></td>
		   <?php
		   }
		   else if(isset($_REQUEST['flg']) && $_REQUEST['flg']==2)
		   {?>
            <td colspan="3" ><font color="orange"><strong><?php echo "Record Updated Successfully";?></strong></font></td>
			<?php
			}
			?>
            </tr>      
           
			
            <tr>
              
              <td class="label" colspan="2">Activity:</td>
			  <td >
			  <select name="activityid" id="activityid" style="width:500px" onChange="sel_activity(this.value)">
			  <option value=0  ><?php echo "Select Activity"; ?> </option>
			  <?php $sqlg="SELECT * FROM activity";
			$resg=mysql_query($sqlg);
			
			while($row3g=mysql_fetch_array($resg))
			{
			$aid=$row3g['aid'];
			$rid=$row3g['rid'];
			$itemid=$row3g['itemid'];
			$code=$row3g['code'];
			$sqlpl="SELECT * FROM maindata where itemid=$itemid";
			$respl=mysql_query($sqlpl);
			$respln=mysql_fetch_array($respl);
			$itemname=$respln['itemname'];
			if($activityid==$aid)
			{
			$sel =" selected='selected' ";
			}
			else
			{
			$sel ="";
			}
			
			?>
			  <option value="<?php echo $aid;?>" <?php echo  $sel; ?>  ><?php echo $itemname; ?> </option>
			  <?php
			  }
			  
			  ?>
			  </select></td>
             </tr>
			  <?php
						 $sqlg="SELECT left(pd_date,7) as getmonths FROM project_days group by left(pd_date,7) order by left(pd_date,7)";
						$resg=mysql_query($sqlg);
						$tot_num=mysql_num_rows($resg);
						$h=0;
						while($row3g=mysql_fetch_array($resg))
						{
						$h=$h+1;
						$getmonth=$row3g['getmonths'];
						$sqlfin="SELECT distinct(b.itemid) as itemid FROM  activity a INNER JOIN planned b ON (a.itemid = b.itemid) where a.aid=$activityid";
						$sqlfin1=mysql_query($sqlfin);
						if(mysql_num_rows($sqlfin1)>0)
						{
						$sqlfin2=mysql_fetch_array($sqlfin1);
						$itemid=$sqlfin2['itemid'];
						$sqlpp2="SELECT budgetqty FROM planned where left(budgetdate,7)='$getmonth' and itemid=$itemid";
						$sqlpp12=mysql_query($sqlpp2);
						
						$ppdb2=mysql_fetch_array($sqlpp12);
						$budgetqty=$ppdb2['budgetqty'];
						}
						else
						{
						$budgetqty='';
						}
						?>
			 <tr>
			
              <td class="label" colspan="2"><?php echo $getmonth.": "; ?>
			  <input type="hidden" value="<?php echo $getmonth;?>" name="month[]" id="month[]"  /></td>
              <td ><input type="text" value="<?php echo $budgetqty; ?>" name="budgetqty_<?php echo $getmonth;?>" id="budgetqty_<?php echo $getmonth;?>"  />
			  
			  </td>
			 
             </tr>
			  <?php
			  }
			  ?>			
			<tr>
			 
			 <td height="39" colspan="2"></td>
			 <td align="left"   >
			 <?php
			  $sqlfinb="SELECT distinct(b.itemid) as itemid FROM  activity a INNER JOIN planned b ON (a.itemid = b.itemid) where a.aid=$activityid";
			$sqlfin1b=mysql_query($sqlfinb);
			if(mysql_num_rows($sqlfin1b)>0){?>
			  <input type="submit" value="Update" name="update"  />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save"  />
			  
			  <?php } ?></td>
			 </tr>
 		</table>
     </form>
	 <br clear="all" />
</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
