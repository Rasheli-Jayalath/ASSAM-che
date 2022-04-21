<?php 
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
$edit			= $_GET['edit'];
/*$uname			= $_SESSION['uname'];*/
$objDb  		= new Database( );
if ($uname==null  ) {
header("Location: index.php?init=3");
}
@require_once("get_url.php");
$msg	= "";
?>
<?php "SELECT itemid, weight from maindata where stage in ('Strategic Goal','Outcome','Output','Activity')";

 $sql="SELECT *  FROM  maindata " ;
$result = mysql_query($sql);
$substr_length=6;
while($resultdata=mysql_fetch_array($result))
{
	
	  $parentgroup=$resultdata["parentgroup"];
	
	$total_length= strlen(str_replace("_","",$parentgroup));
	 $mod=(int)($total_length/$substr_length);
	$modd=($total_length%$substr_length);
	
	$j=1;
	$factor=1;
	$first_str=$substr_length;
	for($i=1;$i<=$mod;$i++)
	{
		
		 $sub_str=substr($parentgroup,0,$first_str);
		
		$sub_sql="SELECT *  FROM  maindata  where parentgroup='".$sub_str."'" ;
		$sub_result = mysql_query($sub_sql);
		$subresultdata=mysql_fetch_array($sub_result);
		$factor_string = ($subresultdata["weight"]/100);
		$ffactor_string .= "(".$subresultdata["weight"]."/100".")";
		 $factor =$factor*$factor_string ;
					 if($j<$mod)
					 {
						 $ffactor_string .="*";
					
					  
					 }
		$first_str =$first_str+($substr_length+1);
		$j++;
	}
	$ffactor_string.":";
	 $factor;
	
	$up_sql="update maindata SET factor=".$factor." WHERE itemid=".$resultdata["itemid"];
	$up_result = mysql_query($up_sql);
	$factor=1;
	$ffactor_string="";
}
echo "Factor Calculation Process is complete";
 ?>
 <a class="button" href="javascript:void(null);" onclick="window.close();" ><strong>Close</strong></a>