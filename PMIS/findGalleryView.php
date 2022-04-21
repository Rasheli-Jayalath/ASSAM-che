<?php    
error_reporting(E_ALL & ~E_NOTICE);
@require_once("requires/session.php");
$module		= "Pictorial Analysis";
if ($uname==null  ) {
header("Location: index.php?init=3");
} 
else if ($pic_flag==0  ) {
header("Location: index.php?init=3");
}
$edit			= $_GET['edit'];
$objDb  		= new Database( );
@require_once("get_url.php");
?>
<?php 
$file_path="pictorial_data";
//include_once("includes/dbconnect.php");
$pid=1;
$pdSQLq="";
$pdSQLq = "SELECT a.phid, a.pid, a.al_file, a.ph_cap, a.date_p, b.title FROM  project_photos a inner join locations b on(a.ph_cap=b.lid) WHERE a.pid=".$pid;
		if(!empty($_REQUEST['date_p'])){
			$date_p = urldecode($_REQUEST['date_p']);
			$pdSQLq .=" AND date_p='".$date_p."'";
		}
		if(!empty($_REQUEST['date_p2'])){
			$date_p2 = urldecode($_REQUEST['date_p2']);
			$pdSQLq .=" AND date_p='".$date_p2."'";
		}
		if(!empty($_REQUEST['location'])){
			$location = urldecode($_REQUEST['location']);
			echo $pdSQLq .=" AND ph_cap='".$location."'";
			
			/*$pdSQL = "SELECT title FROM  locations WHERE pid=".$location;
						 $pdSQLResult = mysql_query($pdSQL);
						
							  if(mysql_num_rows($pdSQLResult)>=1)
							  {
							 $pdData = mysql_fetch_array($pdSQLResult);
							 $location_title=$pdData ["title"];
							  }*/
		}
						
							  		
?>
 <?php  
  if(!empty($_GET['date_p'])&&!empty($_GET['location']))
  {

					
			 
			 $pdSQLResult = mysql_query($pdSQLq);
			if(mysql_num_rows($pdSQLResult) >= 1){
			while($result = mysql_fetch_array($pdSQLResult))
			{
				 if($result['al_file']!="")
				{
			
				?>
                <strong><?php echo $location_title."&nbsp; as on &nbsp;&nbsp;".date('d F, Y',strtotime($date_p)); ?>:</strong>
                <a href="<?php echo $file_path."/".$result['al_file']; ?>" data-lightbox="roadtrip" data-title="" style="text-decoration:none"><img src="<?php echo $file_path."/thumb/".$result['al_file']; ?>" title="<?php echo date('d F, Y',strtotime($result['date_p'])); ?>"  style=" border:3px solid #000; border-radius:6px;margin-top:10px;" width="340"  height="100"/></a>
			<br/><br/>
				 <?php 
				}
			}
				}
				
  }
				
  ?>
            



