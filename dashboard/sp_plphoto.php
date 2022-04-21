<?php
session_start();
$adminflag=$_SESSION['adminflag'];
if ($adminflag == 1 || $adminflag == 2) {
$pid = $_SESSION['pid'];
$_SESSION['mode'] = 0;
include_once("connect.php");
include_once("functions.php");
$data_url="dashboard_data/";
} else {
	header("Location: index.php?msg=0");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Second Irrigation and Drainage Improvement Project (IDIP-2)</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="top-box-set" style="margin-top:10px">
<h1 align="center" style="background-color:<?php echo pcolor($pid); ?> "><?php echo proj_name($pid); ?></h1>
 
<?php if ($mode == 1) { ?>
<!--<span style="position:absolute; top: 21px; right: 150px;"><form action="chart1.php" target="_self" method="post"><button type="submit" name="stop" id="stop"><img src="stop.png" width="30px" /></button></form></span> -->
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="stop" name="stop"><img src="stop.png" width="35px" height="35px" /></button>
</form></span>
<?php } else {?>
<span style="position:absolute; top: 21px; right: 180px;"><form action="chart1.php" target="_self" method="post"><button type="submit" id="resume" name="resume"><img src="start.png" width="35px" height="35px" /></button></form></span>
<?php }?>
<span style="position:absolute; top: 21px; right: 130px;"><form action="index.php?logout=1" method="post"><button type="submit" id="logout" name="logout"><img src="logout.png" width="35px" height="35px" /></button></form></span>

 
   <!--<div id="countdown"> 
    <div id="download"><strong>Refreshing Now!!</strong> </div></div>--> </td>
</div>
<div class="box-set">
  <figure class="sub_box">
  <table style="width:100%; height:100%">
  <tr style="height:10%">
    <td align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:24px; font-weight:bold;"><span>Photos/Videos</span><span style="float:right"><form action="chart1.php" method="post"><input type="submit" name="back" id="back" value="BACK" /></form></span></td></tr>
  <tr style="height:45%"><td align="center">
    <?php if($adminflag==1)
								  {
								   ?>
  <span style="text-align:right; vertical-align:top; margin:0; padding:0 "><form action="sp_plphoto_input.php" method="post"><input type="submit" name="add_new " id="add_new" value="Manage Photos" /></form></span>
  <?php
  }
  ?>
   
   <div style="overflow-y: scroll; height:400px;">
          
  <table width="650" class="table table-bordered">
                              <thead>
                              </thead>
                              <tbody>
				
                            <?php  
			
			 $cm=0;
			 $pdSQL = "SELECT phid, pid, al_file, ph_cap FROM t027project_plphotos WHERE pid = ".$pid." order by phid";
			 $pdSQLResult = mysql_query($pdSQL);
			if(mysql_num_rows($pdSQLResult) >= 1){
				while($result = mysql_fetch_array($pdSQLResult)){
				
				if($cm==0 || $cm%6==0)
				{
				echo "<tr>";
				}?>
            
           
                          <td width="26%" ><?php if($result['al_file']!="")
				{
				$file_array=explode(".",$result['al_file']);
				$file_type=$file_array[1];
				if(($file_type=="jpeg") || ($file_type=="jpg") || ($file_type=="gif") || ($file_type=="png"))
				{
				?>
				 <a href="sp_plphoto_large.php?photo=<?php echo $result['al_file'];?>&phid=<?php echo $result['phid'];?>" target="_parent" ><img src="<?php echo $data_url.$result['al_file']; ?>" width="150" height="100" border="0" /></a>
				<?php
				}
				else
				{
				?>
                 <a href="sp_plphoto_large.php?photo=<?php echo $result['al_file'];?>&phid=<?php echo $result['phid'];?>" target="_parent" >
                 <img src="images/tag_small.png"  border="0" width="150" height="100"/></a>
                 <?php
				 }
				};?></td>
            <?php 
			$cm++;
			if($cm==6 || $cm%6==0)
			{
			echo "</tr>";
			}
			}}?>
                        <?php if($pid==1)
						{?>
                         <?php /*?> <tr>
                          <td ><a href="sp_video_large.php?video=video1" target="_parent" >
                          <img src="photos/thumbs/video.jpg" width="150" height="100" /></a></td>
                          <td colspan="5" align="right">&nbsp;</td>
                          </tr><?php */?>
                          <?php }?>
                              </tbody>
      </table>
      </div></td></tr>
  
  </table>
  </figure>
</div>
</body>
</html>
