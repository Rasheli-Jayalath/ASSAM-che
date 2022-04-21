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
$boq_ids= explode("_",$_REQUEST['boq_ids']);
$boqsize=sizeof($boq_ids);
$boqquery="boqid=";
$boqflag=false;
if($boqsize>1)
{
for($i=0;$i<$boqsize;$i++)
{
	$boqquery.=$boq_ids[$i];
	if($i<$boqsize-1)
	{
	$boqquery.=" OR boqid=";
	}
	
}
}
else
{
	$boqquery.=$boq_ids[0];
	if($boq_ids[0]=="" || $boq_ids[0]==0)
	{
		$boqflag=true;
	}
	
}

$objDb  = new Database( );
$objDbb  = new Database( );
@require_once("get_url.php");
$eSqls = "Select * from project_currency ";
  $objDb -> query($eSqls);
  $base_currFlag=false;
  $final_basecurreny="";
  $final_basecurreny_rate=0;
   $boq_amount=0;
   $boq_amountb=0;
  $eeCount = $objDb->getCount();
if($eeCount > 0){
  $cur_1_rate 					= $objDb->getField(0,cur_1_rate);
  $cur_2_rate 					= $objDb->getField(0,cur_2_rate);
  $cur_3_rate 					= $objDb->getField(0,cur_3_rate);
  $base_cur 				= $objDb->getField(0,base_cur);
  $cur_1 					= $objDb->getField(0,cur_1);
  if($cur_1==$base_cur)
  {
	   $base_currFlag=true;
	   $final_basecurreny=$cur_1;
	   $final_basecurreny_rate=$cur_1_rate;
  }
  $cur_2 					= $objDb->getField(0,cur_2);
  if($cur_2==$base_cur)
  {
	   $base_currFlag=true;
	  $final_basecurreny=$cur_2;
	  $final_basecurreny_rate=$cur_2_rate;
  }
  $cur_3 					= $objDb->getField(0,cur_3);
  if($cur_3==$base_cur)
  {
	   $base_currFlag=true;
	   $final_basecurreny=$cur_3;
	   $final_basecurreny_rate=$cur_3_rate;
  }
  
  }
  
  if($boq_id!="")
	{
	$bSql = "Select * from `boq` where boqid=$boq_id"; 
	$sqlresultb = mysql_query($bSql); 
	$boq_rowsb = mysql_fetch_array($sqlresultb);
	$qty=$boq_rowsb["boqqty"];
	 if($boq_rowsb["boq_cur_1"]!="")
		 {
		 $boq_amountb=$boq_rowsb["cur_1_exchrate"]*$boq_rowsb["boq_cur_1_rate"]*$boq_rowsb["boqqty"];
		 }
		  if($boq_rowsb["boq_cur_2"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_2_exchrate"]*$boq_rowsb["boq_cur_2_rate"]*$boq_rowsb["boqqty"];
		 }
		  if($boq_rowsb["boq_cur_3"]!="")
		 {
		 $boq_amountb+=$boq_rowsb["cur_3_exchrate"]*$boq_rowsb["boq_cur_3_rate"]*$boq_rowsb["boqqty"];
		 }
	}
  if($type==2)
  {
	  
	if($boqflag==false)
	{
	 $aSql = "Select * from `boq` where $boqquery"; 
	$sqlresult = mysql_query($aSql);
      while ($boq_rows = mysql_fetch_array($sqlresult)) {
		 if($boq_rows["boq_cur_1"]!="")
		 {
		 $boq_amount+=$boq_rows["cur_1_exchrate"]*$boq_rows["boq_cur_1_rate"]*$boq_rows["boqqty"];
		 }
		  if($boq_rows["boq_cur_2"]!="")
		 {
		 $boq_amount+=$boq_rows["cur_2_exchrate"]*$boq_rows["boq_cur_2_rate"]*$boq_rows["boqqty"];
		 }
		  if($boq_rows["boq_cur_3"]!="")
		 {
		 $boq_amount+=$boq_rows["cur_3_exchrate"]*$boq_rows["boq_cur_3_rate"]*$boq_rows["boqqty"];
		 }
	 }
	 $boqqty=$boq_amount+$boq_amountb;
	}
	else
	{
		$boqqty=$boq_amountb;
	}
  }
  else
  {
 $eSql = "Select sum(boqqty) as totalqty from boq where $boqquery";
  $objDbb -> query($eSql);
  $eCount = $objDbb->getCount();
  $boqqty = $objDbb->getField(0,totalqty);
  $boqqty=$boqqty+$qty;
  }
?>
 <input type="text"  name="txtquantity" id="txtquantity" value="<?php echo $boqqty; ?>" />

