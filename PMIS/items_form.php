<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Design Progress Major Items";
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
if(isset($_REQUEST['item_id']))
{
$item_id=$_REQUEST['item_id'];
$pdSQL1="SELECT item_id, pid, title FROM  t014majoritems  WHERE  item_id = ".$item_id;
$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$pdData1 = mysql_fetch_array($pdSQLResult1);

$title=$pdData1['title'];
}
if(isset($_REQUEST['delete'])&&isset($_REQUEST['item_id'])&$_REQUEST['item_id']!="")
{

 mysql_query("Delete from  t014majoritems where item_id=".$_REQUEST['item_id']);
 header("Location: items_form.php");
}

if(isset($_REQUEST['save']))
{ 
    $title=$_REQUEST['title'];
	$sql_pro=mysql_query("INSERT INTO  t014majoritems(pid, title) Values(".$pid.", '".$title."' )");
	if ($sql_pro == TRUE) {
    $message=  "New record added successfully";
	} else {
    $message= mysql_error($db);
	}
	header("Location: items_form.php");
	
}

if(isset($_REQUEST['update']))
{
$title=$_REQUEST['title'];
$pdSQL = "SELECT a.item_id, a.pid FROM  t014majoritems a WHERE pid = ".$pid." and item_id=".$item_id." order by item_id";
$pdSQLResult = mysql_query($pdSQL);
$sql_num=mysql_num_rows($pdSQLResult);
$pdData = mysql_fetch_array($pdSQLResult);
$item_id=$_REQUEST['item_id'];

		
	
	 $sql_pro="UPDATE  t014majoritems SET title='$title' where item_id=$item_id";
	
	$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
	
		if ($sql_proresult == TRUE) {
		$message=  "Record updated successfully";
	} else {
		$message= mysql_error($db);
	}
	
header("Location: items_form.php");
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
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Major Items</span></td></tr>
  <tr ><td align="center">
  <?php echo $message; ?>
  <div id="LoginBox" class="borderRound borderShadow" >
  <form action="items_form.php" target="_self" method="post"  enctype="multipart/form-data">
 <table border="0"  height="23%" cellspacing="5" style="padding:5px 0 5px 5px; margin:5px 0 5px 5px;">
  <tr><td><label><?php echo "Item Description:";?></label></td>
  <td><input type="text" name="title" id="title" value="<?php echo $title;?>"   size="100"/></td>
  </tr>
  
  <tr><td colspan="2"> <?php if(isset($_REQUEST['item_id']))
	 {
		 
	 ?>
     <input type="hidden" name="item_id" id="item_id" value="<?php echo $_REQUEST['item_id']; ?>" />
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
                                  <th width="70%" style="text-align:center">Title</th>
                                
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
						
						 $pdSQL = "SELECT item_id, pid, title FROM  t014majoritems WHERE pid=".$pData["pid"]." order by item_id";
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
                          <td align="center"><?php echo $pdData['title'];?></td>
                          <?php  if($dpentry_flag==1 || $dpadm_flag==1)
								  {
								   ?>
						   <td align="right"><span style="float:right"><form action="items_form.php?item_id=<?php echo $pdData['item_id'] ?>" method="post"><input type="submit" name="edit" id="edit" value="Edit" /></form></span></td>
						    <?php  
							}
							if($ncfadm_flag==1)
								  {
								   ?>
						   <td align="right">
						   <span style="float:right">
						   </form></span><span style="float:right"><form action="items_form.php?item_id=<?php echo $pdData['item_id'] ?>" method="post">
						   
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
