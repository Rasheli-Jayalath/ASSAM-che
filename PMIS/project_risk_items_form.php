<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Risk Context Items";
if ($uname==null  ) {
header("Location: index.php?init=3");
}
else if ($dp_flag==0 ) {
header("Location: index.php?init=3");
}  
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg						= "";

 $pSQL = "SELECT max(pid) as pid from project";
						 $pSQLResult = mysql_query($pSQL);
						 $pData = mysql_fetch_array($pSQLResult);
						 $pid=$pData["pid"];
if(isset($_REQUEST['risk_con_id']))
{
$risk_con_id=$_REQUEST['risk_con_id'];
$pdSQL1="SELECT risk_con_id, pid, risk_con_code, ris_con_desc FROM  tbl_risk_register_context  WHERE  risk_con_id = ".$risk_con_id;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$risk_con_code=$pdData1['risk_con_code'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['risk_con_id'])&$_REQUEST['risk_con_id']!="")
{

 mysql_query("Delete from  tbl_risk_register_context where risk_con_id=".$_REQUEST['risk_con_id']);
 header("Location: project_risk_items_form.php");
}

if(isset($_REQUEST['save']))
{ 
    $risk_con_code=$_REQUEST['risk_con_code'];
	 $ris_con_desc=$_REQUEST['ris_con_desc'];
	echo $sql_pro=mysql_query("INSERT INTO  tbl_risk_register_context(pid, risk_con_code,ris_con_desc) Values(".$pid.", '".$risk_con_code."' , '".$ris_con_desc."'"." )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error();
	}
	header("Location: project_risk_items_form.php");
	
}

if(isset($_REQUEST['update']))
{
$risk_con_code=$_REQUEST['risk_con_code'];
$pdSQL = "SELECT a.risk_con_id, a.pid,a.ris_con_desc FROM  tbl_risk_register_context a WHERE pid = ".$pid." and risk_con_id=".$risk_con_id." order by risk_con_id";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$risk_con_id=$_REQUEST['risk_con_id'];

		
	
	 $sql_pro="UPDATE  tbl_risk_register_context SET risk_con_code='$risk_con_code', ris_con_desc='$ris_con_desc' where risk_con_id=$risk_con_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error();
	}
	
header("Location: project_risk_items_form.php");
}
if(isset($_REQUEST['cancel']))
{
	print "<script type='text/javascript'>";
    print "window.location.reload();";
    print "self.close();";
    print "</script>";
}
?>
<script>
window.onunload = function(){
window.opener.location.reload();
};
</script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<div id="content">
<!--<h1> Location Control Panel</h1>-->
<table align="center">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Risk Contexts</span></td></tr>
  <tr ><td align="center">
  <?php echo $message; ?>
  <div id="LoginBox" class="borderRound borderShadow" >
  <form action="project_risk_items_form.php" target="_self" method="post"  enctype="multipart/form-data">
 <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo "Risk Context Code:";?></label></td>
  <td><input type="text" name="risk_con_code" id="risk_con_code" value="<?php echo $risk_con_code;?>"   size="100"/></td>
  </tr>
  <tr><td><label><?php echo "Risk Context Detail:";?></label></td>
  <td><input type="text" name="ris_con_desc" id="ris_con_desc" value="<?php echo $ris_con_desc;?>"   size="100"/></td>
  </tr>
  <tr><td colspan="2"> <?php if(isset($_REQUEST['risk_con_id']))
	 {
		 
	 ?>
     <input type="hidden" name="risk_con_id" id="risk_con_id" value="<?php echo $_REQUEST['risk_con_id']; ?>" />
     <input  type="submit" name="update" id="update" value="Update" />
	 <?php
	 }
	 else
	 {
	 ?>
	 <input  type="submit" name="save" id="save" value="Save" />
	 <?php
	 }
	 ?> <input  type="submit" name="cancel" id="cancel" value="Cancel" /></td></tr>
	 </table>
	
  </form> 
  </div>
  </td></tr>
  </table>
<table style="width:100%; height:100%">
  <tr>
  <td>
   <div style="overflow-y: scroll; height:360px;">
  <table class="reference" style="width:100%">
                              <thead>
                                <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
                                  <th style="text-align:center; vertical-align:middle">S#</th>
                                  <th width="70%" style="text-align:center">Code</th>
                                 <th width="70%" style="text-align:center">Detail</th>
								  <?php if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
								 <th style="text-align:center" colspan="2">Action</th>
								  <?php
								  }
								  ?>
								 
								 
								
                                </tr>
                              </thead>
                              <tbody>
							  <?php
						
						 $pdSQL = "SELECT risk_con_id, pid, risk_con_code,ris_con_desc FROM  tbl_risk_register_context WHERE pid=".$pData["pid"]." order by risk_con_id";
						 $pdSQLResult = mysql_query($pdSQL);
						$i=0;
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							  while($pdData = mysql_fetch_array($pdSQLResult))
							  { 
							  $i++;
							  ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td align="center"><?php echo $pdData['risk_con_code'];?></td>
                          <td align="center"><?php echo $pdData['ris_con_desc'];?></td>
                          <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="project_risk_items_form.php?risk_con_id=<?php echo $pdData['risk_con_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span></td>
						    <?php  
							}
							if($ncfadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right">
						   </form></span><span style="float:right"><form action="project_risk_items_form.php?risk_con_id=<?php echo $pdData['risk_con_id'] ?>" method="post">
						   
						   <input type="submit" name="delete" id="delete" value="Del" onclick="return confirm('Are you sure?')" /></form></span></td>
						  <?php
						   }
						   ?>
						  
                        </tr>
						<?php
						}
						}else
						{
						?>
						<tr>
                          <td colspan="4" >No Record Found</td>
                        </tr>
						<?php
						}
						?>
                            
                              </tbody>
                        </table>
                        </div>
                        </td>
                        </tr>
  </table>
</div>

<?php
	$objDb  -> close( );
?>
