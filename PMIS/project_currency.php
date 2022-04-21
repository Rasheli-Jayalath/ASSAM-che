<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module			= PROJECT;
if ($uname==null)
{
	header("Location:index.php?init=3");
}
else if ($padm_flag==0)
{
	header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$revert			= $_GET['revert'];
$objDb  		= new Database( );
$objSDb  		= new Database( );
$objVSDb  		= new Database( );
$objCSDb  		= new Database( );
$objPD  		= new Database( );
@require_once("get_url.php");
$msg						= "";
$saveBtn					= $_REQUEST['save']; 
$updateBtn					= $_REQUEST['update'];
$clear						= $_REQUEST['clear'];
$next						= $_REQUEST['next'];
$txtstage				 	= "Project Currency";
$base_cur				= $_REQUEST['base_cur'];
$cur_1					= $_REQUEST['cur_1'];
$cur_1_rate			    = trim($_REQUEST['cur_1_rate']);
$cur_2					= $_REQUEST['cur_2'];
$cur_2_rate				= trim($_REQUEST['cur_2_rate']);
$cur_3					= $_REQUEST['cur_3'];
$cur_3_rate				= trim($_REQUEST['cur_3_rate']);

if($clear!="")
{
$base_cur 				= '';
$cur_1 				= '';
$cur_2					= '';
$cur_1_rate                    ='';
$cur_2_rate='';
$cur_3_rate                    ='';
$cur_3_rate='';
}
	  
if($saveBtn != "")
{

 $sSQL = ("INSERT INTO project_currency(base_cur,cur_1,cur_1_rate,cur_2,cur_2_rate,cur_3,cur_3_rate)VALUES('$base_cur','$cur_1','$cur_1_rate','$cur_2','$cur_2_rate','$cur_3','$cur_3_rate')");
	$objDb->execute($sSQL);
	$pcid = $objDb->getAutoNumber();
	$pcid = $txtid;
	
	
				
////////////////////////// Make Project Data
header("location: project_currency.php");
}
$objbck  		= new Database( );
$objrvt1  		= new Database( );
$objrvt2  		= new Database( );
$objrvt3  		= new Database( );

if($updateBtn !=""){
	
	
	////////////////////// Change Planned Data//////////////////////////
$objDbP 		= new Database( );
$objDbPP		= new Database( );

	
	$pid=$edit;
  $uSql ="Update project_currency SET 
			base_cur        		= '$base_cur',
			 cur_1  				= '$cur_1',
			 cur_1_rate             = '$cur_1_rate',
			 cur_2					= '$cur_2',
			 cur_2_rate				= '$cur_2_rate'	,
			 cur_3					= '$cur_3',
			 cur_3_rate				= '$cur_3_rate'				
			where pcid 				= 1 ";
		  
 	if($objDb->execute($uSql)){
	
		}
		
header("location: project_currency.php");
}
 $cSqls = "Select * from project_currency ";
			    $objDb -> query($cSqls);
			    $eeCount = $objDb->getCount();
			    if($eeCount > 0){
			    $cur_1_rate 					= $objDb->getField(0,cur_1_rate);
			    $cur_2_rate 					= $objDb->getField(0,cur_2_rate);
				$cur_3_rate 					= $objDb->getField(0,cur_3_rate);
			    $cur_1 					= $objDb->getField(0,cur_1);
			    $cur_2 					= $objDb->getField(0,cur_2);
				$cur_3 					= $objDb->getField(0,cur_3);
			    $base_cur 					= $objDb->getField(0,base_cur);
				}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="scripts/JsCommon.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
<script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
<script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script type="text/javascript">
 $(function() {
   $('#txtpstart').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
   $(function() {
    $('#txtpend').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  });
$("#datepicker1,#datepicker2").datepicker({dateFormat: 'dd-mm-yy', minDate: 0});
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

function AddNewSize(){
	var td1 = '<a href="javascript:void(null);" onClick="doRmTr(this);" title="Remove size">[X]</a>';
	var td2 = '<input type="text" name="yh_title[]" size="25" />';
	var td3 = '<input type="text" name="yh_date[]" style="text-align:right;" size="15" id="datepicker3"/>';
	var td4 = '<select name="yh_status[]">' + "\n";
	td4 	+= "\t" + '<option value="1">Active</option>' + "\n";
	td4 	+= "\t" + '<option value="0">Inactive</option>' + "\n";
	td4 	+= '</select>' + "\n";
	
	var arrTds = new Array(td1, td2, td3, td4);
	doAddTr(arrTds, 'tblPrdSizes');
}


function CheckProjectCDetail(frm){
	var msg = "<?php echo "Please do the following:";?>\r\n-----------------------------------------";
	var flag = true;

	if(frm.base_cur.value == ""){
		msg = msg + "\r\n<?php echo "Project Base Currency is required field";?>";
		flag = false;
	}
	if(frm.cur_1.value == ""){
		msg = msg + "\r\n<?php echo "Project Currency 1 is required field";?>";
		flag = false;
	}
	if(frm.cur_1_rate.value == ""){
		msg = msg + "\r\n<?php echo "Project Currency 1 Rate is required field";?>";
		flag = false;
	}
	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>


</head>
<body>

<div id="wrap">
  <?php include 'includes/header.php'; ?>
<div id="content">
	  <form name="frmstgoal" id="frmstgoal" action=""  method="post" 
      onsubmit="return CheckProjectCDetail(this)" enctype="multipart/form-data">
	  
<table class="project" width="100%" style="background-color:#FFF" cellspacing="0">
      
       			<?php
			if(isset($_REQUEST['edit']))
			{
			$action="Update ";
			}
			else
			{
			$action="Add ";
			}
		 	$objDbr = new Database( );
		 
			?>
			
            <tr>
            <th  width="40%"> <?php echo $action."Project Currency Details:"; ?>
           </th ><th width="60%" style="text-align:right; color:#FFF">  <a href="project_currency.php?edit=1"  class="button">Change Project Currency Detail</a></th>
            </tr>
                  
           <?php if($eeCount>0&& (!isset($_REQUEST['edit'])&&$_REQUEST['edit']==""))
			    {
				
	?>
      
            <tr>
              <td width="16%" class="label"><strong>Base Currency:</strong></td>
              <td width="74%" ><?php echo $base_cur; ?></td>
        </tr>
            <tr>
              <td class="label"><strong>Currency 1:</strong></td>
              <td ><?php echo $cur_1; ?></td>
            </tr>
            <tr>
              <td class="label"><strong>Currency 1 Rate:</strong></td>
              <td ><?php echo $cur_1_rate; ?></td>
        </tr>
        <tr>
              <td class="label"><strong>Currency 2:</strong></td>
              <td ><?php echo $cur_2; ?></td>
            </tr>
            <tr>
              <td class="label"><strong>Currency 2 Rate:</strong></td>
              <td ><?php echo $cur_2_rate; ?></td>
        </tr>
        <tr>
              <td class="label"><strong>Currency 3:</strong></td>
              <td ><?php echo $cur_3; ?></td>
            </tr>
            <tr>
              <td class="label"><strong>Currency 3 Rate:</strong></td>
              <td ><?php echo $cur_3_rate; ?></td>
        </tr>
	<?php }
	else
	{
		
	?>
			
    		 <tr>
              <td width="16%" class="label"><strong>Base Currency:<span style="color:#FF0000;">*</span></strong></td>
              <td width="74%" ><input id="base_cur" name="base_cur" type="text" value="<?php echo $base_cur; ?>"/></td>
            </tr>
             <tr>
              <td class="label"><strong>Currency 1:<span style="color:#FF0000;">*</span></strong></td>
              <td ><input id="cur_1" name="cur_1" type="text" value="<?php echo $cur_1; ?>" style="width:300px"/></td>
            </tr>
			 <tr>
			   <td class="label"><strong>Currency 1 Rate:<span style="color:#FF0000;">*</span></strong></td>
			   <td >
               <input id="cur_1_rate" name="cur_1_rate" type="text" value="<?php echo $cur_1_rate; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="label"><strong>Currency 2:</strong></td>
			   <td ><input id="cur_2" name="cur_2" type="text" value="<?php echo $cur_2; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="label"><strong>Currency 2 Rate:</strong></td>
			   <td >
               <input id="cur_2_rate" name="cur_2_rate" type="text" value="<?php echo $cur_2_rate; ?>"/></td>
	    </tr>
             <tr>
			   <td class="label"><strong>Currency 3:</strong></td>
			   <td ><input id="cur_3" name="cur_3" type="text" value="<?php echo $cur_3; ?>"/></td>
	    </tr>
			 <tr>
			   <td class="label"><strong>Currency 3 Rate:</strong></td>
			   <td >
               <input id="cur_3_rate" name="cur_3_rate" type="text" value="<?php echo $cur_3_rate; ?>"/></td>
	    </tr>
			
			<tr>
			 <td height="39"></td>
			 <td align="left" colspan="5"  >
			 <?php
			  if($edit!=""){?>
			  <input type="submit" value="Update" name="update" />
			  <?php } else { ?>
			  <input type="submit" value="Save" name="save" id="save" />
			  &nbsp;&nbsp;<input type="submit" value="Clear" name="clear"  />
			  <?php } ?></td>
			 </tr>
             
              <?php }?>
 		</table>
     </form>

	<br clear="all" />
	
	
	
<div id="search"></div>
	<div id="without_search"></div>

</div>
  <?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb  -> close( );
?>
