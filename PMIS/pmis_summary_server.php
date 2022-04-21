<?php
error_reporting(E_ALL & ~E_NOTICE);
$user_name_text=$_REQUEST['u'];
$password_text=$_REQUEST['p'];
$db = mysqli_connect('localhost', 'root', '', 'fbr');
//$db = mysqli_connect('localhost', 'root', '', 'ccorr');
//require_once("config/config.php");
$authSQL = "select count(username) as username from mis_tbl_users where username = '$user_name_text' and passwd = '$password_text'";
$authResult = mysqli_query($db,$authSQL);
$authData = mysqli_fetch_array($authResult);
$authStatus = $authData['username'];
if ($authStatus > 0 ) {

$userSQL = "select user_type, user_cd from mis_tbl_users where username = '$user_name_text' and passwd = '$password_text' limit 0,1";
$userResult = mysqli_query($db,$userSQL);
$userData = mysqli_fetch_array($userResult);


$db1 = mysqli_connect('localhost', 'root', '', 'fbr_pmis');

$user_type=$userData['user_type'];
$user_cd	= $userData['user_cd'];  
$last_date = date("Y-m-d");
$first_date = date('Y-m-d', strtotime("-7 days"));

///KPI
$sql2d_kpi="Select max(pmonth) as last_updated_date from progressmonth";
$res2d_kpi=mysqli_query($db1,$sql2d_kpi);
$row2d_kpi=mysqli_fetch_array($res2d_kpi);
$kpi_updated_date=$row2d_kpi['last_updated_date'];
if($kpi_updated_date!=NULL)
{
$kpi_updated_date=$kpi_updated_date;   
}
else
{
$kpi_updated_date="No Data";
}

///IPC
$sql2d_ipc="Select max(ipcmonth) as last_updated_date from ipc";
$res2d_ipc=mysqli_query($db1,$sql2d_ipc);

$row2d_ipc=mysqli_fetch_array($res2d_ipc);
$ipc_updated_date=$row2d_ipc['last_updated_date'];
if($ipc_updated_date!=NULL)
{
$ipc_updated_date=$ipc_updated_date;   
}
else
{
$ipc_updated_date="No Data";
}
///EVA
//$sql2d_eva="Select max(rmonth) as last_updated_date from `s009-eva-results`";
//$res2d_eva=mysqli_query($db1,$sql2d_eva);

//$row2d_eva=mysqli_fetch_array($res2d_eva);
//$eva_updated_date=$row2d_eva['last_updated_date'];
$eva_updated_date="No Data";
if($eva_updated_date!=NULL)
{
$eva_updated_date=$eva_updated_date;   
}
else
{
$eva_updated_date="No Data";
}
///Pictorial Analysis

$sql2d_pic="Select max(date_p) as last_updated_date from project_photos";
$res2d_pic=mysqli_query($db1,$sql2d_pic);
$row2d_pic=mysqli_fetch_array($res2d_pic);
$pic_updated_date=$row2d_pic['last_updated_date'];
if($pic_updated_date!=NULL)
{
$pic_updated_date=$pic_updated_date; 
}
else
{
$pic_updated_date="No Data";
}

echo "<td style='border:1px solid #d4d4d4;text-align:center;'>".$kpi_updated_date."</td><td style='border:1px solid #d4d4d4;text-align:center;'>".$ipc_updated_date."</td><td style='border:1px solid #d4d4d4;text-align:center;'>".$eva_updated_date."</td><td style='border:1px solid #d4d4d4;text-align:center;'>".$pic_updated_date."</td>";

}
else{
	echo "Invalid Username or Password!!!";
}
?>
