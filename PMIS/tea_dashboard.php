<?php
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= MAINDATA;
/*$uname			= $_SESSION['uname'];
$admflag		= $_SESSION['admflag'];
$superadmflag	= $_SESSION['superadmflag'];
$payrollflag	= $_SESSION['payrollflag'];
$petrolflag		= $_SESSION['petrolflag'];
$petrolEntry	= $_SESSION['petrolEntry'];
$petrolVerify	= $_SESSION['petrolVerify'];
$petrolApproval	= $_SESSION['petrolApproval'];
$petrolPayment	= $_SESSION['petrolPayment'];
if ($uname==null  ) {
header("Location: login.php?init=3");
} else if ($admflag==0  && $superadmflag==0 && $payrollflag==0) {
header("Location: login.php?init=3");
}*/
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
$msg	= "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include ('includes/metatag.php'); ?>

<link rel="stylesheet" type="text/css" href="css/styleNew.css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
<script type="text/javascript">
function GetActivity(){
	
	var qString = '';
	
	var output_var=document.main_dash.output_id.value;
	
	var act_var=document.main_dash.act_id.value;
	
	
	if(document.main_dash.str_obj.value != "" && document.main_dash.str_obj.value != 0)
	{
		
		qString += 'obj=' + escape(document.main_dash.str_obj.value);
	}
	if(document.main_dash.outcome_id.value != "" && document.main_dash.outcome_id.value != 0)
	{
		
		qString += '&outcome=' + escape(document.main_dash.outcome_id.value);
	}
	if(document.main_dash.output_id.value != "" && document.main_dash.output_id.value != 0)
	{
		
		qString += '&output=' + escape(document.main_dash.output_id.value);
	}
	
	if(output_var!= "" && output_var != 0 &&  act_var!= "" && act_var != 0)
	{
		
		qString += '&activity=' + escape(act_var);
	}
	<?php if(isset($_REQUEST["activity"])&&$_REQUEST["activity"]!=""&&$_REQUEST["activity"]!=0)
	{?>
	
		var sub_act_str=document.getElementById('sub_act_id_' + <?php echo $_REQUEST["activity"];?>).value;
		if(sub_act_str!=0&&sub_act_str!="")
		{
		qString += '&sub_act_id_'+<?php echo $_REQUEST["activity"];?>+'='+ escape(sub_act_str);
		}
		//alert(sub_act_str);
	<?php }?>
		<?php if(isset($_REQUEST["sub_act_id_".$_REQUEST["activity"]])&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=""&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=0)
	{?>
	
		var sub_act_str_1=document.getElementById('sub_act_id_' + <?php echo $_REQUEST["sub_act_id_".$_REQUEST["activity"]];?>).value;
		if(sub_act_str_1!=0&&sub_act_str_1!="")
		{
		qString += '&sub_act_id_'+<?php echo $_REQUEST["sub_act_id_".$_REQUEST["activity"]];?>+'='+ escape(sub_act_str_1);
		}
		//alert(sub_act_str);
	<?php }?>
	document.location = 'tea_dashboard.php?' + qString;
}
</script>
</head>
<body>
<div style="display: inline-block; height:110px; background-color:#000066;">
<div style="width:auto;">
<a href="./index.php"><img src="images/logo.png"   height="106" title="Home"  align="left" style="border-color:#ccc; border-radius:1px; padding:2px" /></a>
<img src="images/water-bgtop0.png"  />
</div>
<?php include("includes/functions_tea_dashboard.php");?>
<table cellpadding="4px" cellspacing="0px" align="center" width="100%" style="border: solid 1px #ccc;" > 
<tr> 
<td width="20%" align="left" valign="top" style="border-right: solid 1px #ccc;"><div id="wrapper_MemberLogin">
  <h1 style="color:#000;"><?php echo "Tea Monitoring Dashboard";?> </h1>
  <div class="clear"></div>
  <div id="LoginBox" class="borderRound borderShadow" >
    <form action="tea_dashboard.php" method="post" name="main_dash" id="main_dash" onsubmit="return frmValidate1(this);">
      <table border="0px" cellpadding="0px" cellspacing="0px" align="center"  >
        <tr>
          <td ><strong>
            <label>Strategic Objectives</label>
          </strong></td>
          <td><div id="str_obj_div">
            <select name="str_obj" id="str_obj" onchange="GetActivity()">
             <option value="0">Select Strategic Objective..</option>
              <?php
				$str_g_query = "select * from maindata where stage='Strategic Goal' ";
				$str_g_result = mysql_query($str_g_query);
				while ($str_g_data = mysql_fetch_array($str_g_result)) {
				?>
		    <option value="<?php echo $str_g_data['itemid']; ?>"  <?php if(isset($_REQUEST["obj"])&&$_REQUEST["obj"]!=""&&$_REQUEST["obj"]==$str_g_data['itemid'])
			{?> selected="selected" <?php }?>>
								<?php echo $str_g_data['itemcode']."-".$str_g_data['itemname']; ?>
								</option>
							  <?php
				}
				?>
            </select>
          </div></td>
        </tr>
        <tr>
          <td ><strong>
            <label>Outcomes</label>
          </strong></td>
          <td><div id="outcome_div">
            <select name="outcome_id" id="outcome_id" onchange="GetActivity()">
              <option value="0">Select Outcome..</option>
               <?php
				$outcome_query = "select * from maindata where stage='Outcome'";
				$outcome_result = mysql_query($outcome_query);
				while ($outcome_data = mysql_fetch_array($outcome_result)) {
				?>
			<option value="<?php echo $outcome_data['itemid']; ?>" 
			<?php if(isset($_REQUEST["outcome"])&&$_REQUEST["outcome"]!=""&&$_REQUEST["outcome"]==$outcome_data['itemid'])
			{?> selected="selected" <?php }?>>
			<?php echo $outcome_data['itemcode']."-".$outcome_data['itemname']; ?>
			</option><?php } ?>
            </select>
          </div></td>
        </tr>
        <tr>
          <td ><strong>
            <label>Output</label>
          </strong></td>
          <td><div id="output_div">
            <select name="output_id" id="output_id" onchange="GetActivity()">
            <option value="0">Select Output..</option>
             <?php
				$output_query = "select * from maindata where stage='Output'";
				$output_result = mysql_query($output_query);
				while ($output_data = mysql_fetch_array($output_result)) {
				?>
			<option value="<?php echo $output_data['itemid']; ?>"  <?php if(isset($_REQUEST["output"])&&$_REQUEST["output"]!=""&&$_REQUEST["output"]==$output_data['itemid'])
			{?> selected="selected" <?php }?>>
			<?php echo $output_data['itemcode']."-".$output_data['itemname']; ?>
			</option><?php } ?>
            </select>
           
          </div></td>
        </tr>
        <tr>
        <td>
      <strong>Activity:</strong>
        </td>
        <td>
       
           <select name="act_id" id="act_id" onchange="GetActivity()">
            <option value="0">Select Activity..</option>
             <?php
				$activity_query = "select * from maindata where parentcd=".$_REQUEST["output"];
				$activity_result = mysql_query($activity_query);
				while ($activity_data = mysql_fetch_array($activity_result)) {
				?>
			<option value="<?php echo $activity_data['itemid']; ?>" 
			<?php if(isset($_REQUEST["activity"])&&$_REQUEST["activity"]!=""&&$_REQUEST["activity"]==$activity_data['itemid'])
			{?> selected="selected" <?php }?>>
			<?php echo $activity_data['itemcode']."-".$activity_data['itemname']; ?>
			</option><?php } ?>
            </select> 
		
        </td>
        </tr>
         <?php if(isset($_REQUEST["activity"])&&$_REQUEST["activity"]!=""&&$_REQUEST["activity"]!=0)
		{
		?>
        
        <tr>
        <td>
      <strong>Sub Activity Level:</strong>
        </td>
        <td>
           <select name="sub_act_id_<?php echo $_REQUEST["activity"];?>" id="sub_act_id_<?php echo $_REQUEST["activity"];?>" 
           onchange="GetActivity()">
            <option value="0">Select Sub Activity ..</option>
             <?php
				$subactivity_query = "select * from maindata where parentcd=".$_REQUEST["activity"];
				$subactivity_result = mysql_query($subactivity_query);
				while ($subactivity_data = mysql_fetch_array($subactivity_result)) {
				?>
			<option value="<?php echo $subactivity_data['itemid']; ?>" 
			<?php if(isset($_REQUEST["sub_act_id_".$_REQUEST["activity"]])&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!=""&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]==$subactivity_data['itemid'])
			{?> selected="selected" <?php }?>>
			<?php echo $subactivity_data['itemcode']."-".$subactivity_data['itemname']; ?>
			</option>
			<?php } ?>
            </select> 
        </td>
        </tr>
       
        <?php 
		if(isset($_REQUEST["sub_act_id_".$_REQUEST["activity"]])&&$_REQUEST["sub_act_id_".$_REQUEST["activity"]]!="")
		{
		 getSubActivity($_REQUEST["sub_act_id_".$_REQUEST["activity"]]);
		}
		} // End Main Activity Level Check?>
        <?php /*?><tr>
          <td style="padding-top:20px" align="center" colspan="2">
            <input type="submit" value="Generate Report"  id="uLogin2"/>
            </td>
          
        </tr><?php */?>
      
      </table>
      <?php
function  getSubActivity($parentcd){
?>
<tr><td>
<strong>Sub Activity Level:</strong>
</td><td>
<select name="sub_act_id_<?php echo $parentcd;?>" id="sub_act_id_<?php echo $parentcd;?>" onchange="GetActivity()">
<option value="0">Select Sub Activity ..</option>
             <?php
				$sub_subactivity_query = "select * from maindata where parentcd=".$parentcd;
				$sub_subactivity_result = mysql_query($sub_subactivity_query);
				while ($sub_subactivity_data = mysql_fetch_array($sub_subactivity_result)) {
				?>
			<option value="<?php echo $sub_subactivity_data['itemid']; ?>" 
<?php if(isset($_REQUEST["sub_act_id_".$parentcd]) && $_REQUEST["sub_act_id_".$parentcd]!="" && $_REQUEST["sub_act_id_".$parentcd]==
$sub_subactivity_data['itemid'])
			{?> selected="selected" <?php }?>>
			<?php echo $sub_subactivity_data['itemcode']."-".$sub_subactivity_data['itemname']; ?>
			</option>
			<?php } ?>
            </select> 
        </td>
        </tr>
    		<?php
    		//getSubActivity($_REQUEST["sub_act_id_".$parentcd]);
		}
   
?>
    </form>
  </div>
</div>
  <script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" />      
</td>
<td width="80%" align="left" valign="top">
<script src="highcharts/js/highcharts.js"></script>
<script src="highcharts/js/modules/exporting.js"></script>
<script src="highcharts/js/modules/jquery.highchartTable.js"></script>
<?php  //////////Activity  Title here
$url=basename($_SERVER['REQUEST_URI']);
list($str1,$str2)=explode('?',$url);
$param=explode('&',$str2);
$para_count= count($param);
$last_data_level=$para_count-1;
$data_level=explode('=',$param[$last_data_level]);
$data_level_id=$data_level[1];
$data_level_param=$data_level[0];
/// Check Entry Level

$adata=getActDataLevel($data_level_id);
$adetail=$adata["itemcode"]."-".$adata["itemname"];
$aweight=$adata["weight"];
$aparentgroup=$adata["parentgroup"];
?>
<?php /// Calculate MaX Activity Level
		if(isset($data_level_id)&&$data_level_id!=""&&$data_level_id!=0)
		{
		$act_level_query="Select MAX(activitylevel) as max_level  from maindata where parentcd=".$data_level_id;
		$max_level_result = mysql_query($act_level_query);
		$max_level_data=mysql_fetch_array($max_level_result);
		$max_level=$max_level_data["max_level"];
		}
		?>
 <?php include("includes/pdo_level_tea_dashboard.php");?>
<?php include("includes/outcome_level_tea_dashboard.php");?>
<?php include("includes/output_level_tea_dashboard.php");?>
<?php include("includes/mainactivity_level_tea_dashboard.php");?>
<?php include("includes/activity_level_tea_dashboard.php");?>
<?php include("includes/data_level_tea_dashboard.php");?>
</td>
</tr>
</table>
 
<?php include ("includes/footer.php"); ?>
</div>
</body>
</html>
<?php
	$objDb ->close( );
?>
