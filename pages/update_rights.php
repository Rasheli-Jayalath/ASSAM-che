<?php
error_reporting(E_ALL & ~E_NOTICE);
header("Content-Type: text/html; charset=utf-8");
include("./config/db_connect.php");

if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['cancel']=="Cancel"))
{
redirect('./?p=user_mgmt');
}
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['refresh']=="Refresh"))
{
 $u_id= $_GET["user_cd"];
redirect('./?p=update_rights&user_cd='.$u_id);
}

 $u_id= $_GET["user_cd"];
 $sql_name="Select first_name, last_name from $root_db.mis_tbl_users where user_cd=".$u_id;
 $sql_name_q=mysql_query($sql_name);
 $sql_name_res=mysql_fetch_array($sql_name_q);
 $firstnam=$sql_name_res['first_name'];
 $lastnam=$sql_name_res['last_name'];
 $name_full=$firstnam." ".$lastnam;
$mode	= "I";
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['save']=="Save"))
{
$u_id= $_GET["user_cd"];

$sql = "SELECT * FROM $pmis_db.t031project_albums where parent_album=1 order by parent_group, parent_album";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {

	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_album'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	if( $items==2 || $items==1)
	{
	$cdsql = "select * from $pmis_db.t031project_albums where albumid = ".$cdlist[0];
	$cdsqlresult = mysql_query($cdsql);
	$cddata = mysql_fetch_array($cdsqlresult);
	$category_name = $cddata['category_name'];
	$cdsql3 = "select albumid,user_ids,user_right from $pmis_db.t031project_albums where albumid = ".$cdlist[$items-1];
		$cdsqlresult3 = mysql_query($cdsql3);
		$cddata3 = mysql_fetch_array($cdsqlresult3);
		$catsid = $cddata3['albumid'];
		
		 $status_r = trim($_POST['status'.$catsid]);
		
		if($status_r==0)
				{
				
				if (strpos($cddata3['user_ids'], $u_id) !== false) 
		   					{
								
							$arr_ids=explode(",",$cddata3['user_ids']);
						
							$len=count($arr_ids);
							
							
									if($len==1)
									{
										if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$cddata3['user_ids']);
										$f_flag=1;
										
										}
									
									}
									else
									{
								
										
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$cddata3['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$cddata3['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $cddata3['user_ids'];
							$concatrights= $cddata3['user_right'];
							}
		
				}
				else
				{
				
					if(($cddata3['user_ids']=="") && ($cddata3['user_right']==""))
					{
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_r;
					}
					else
					{
						 if (strpos($cddata3['user_ids'], $u_id) !== false) 
		   					{
								$arr_uid=explode(",",$cddata3['user_ids']);
									
									$len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$cddata3['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$cddata3['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_r)
											{
											
											$concatrights1=$cddata3['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_r;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$cddata3['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$cddata3['user_ids'].",".$u_id;
							$concatrights=$cddata3['user_right'].",".$u_id."_".$status_r;
							} 
					}
				}
				
				$sqlu="UPDATE $pmis_db.t031project_albums set user_ids='$concatids',user_right='$concatrights' where albumid=$catsid"; 
				$sql_run=mysql_query($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				
}
	}
	
	
	
//////Drawings

 $sql = "SELECT * FROM $pmis_db.t031project_drawingalbums where parent_id=1 order by parent_group, parent_id";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {

	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_id'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	if( $items==2 || $items==1)
	{
	$cdsql = "select * from $pmis_db.t031project_drawingalbums where albumid = ".$cdlist[0];
	$cdsqlresult = mysql_query($cdsql);
	$cddata = mysql_fetch_array($cdsqlresult);
	$category_name = $cddata['category_name'];
	$cdsql3 = "select albumid,user_ids,user_right from $pmis_db.t031project_drawingalbums where albumid = ".$cdlist[$items-1];
		$cdsqlresult3 = mysql_query($cdsql3);
		$cddata3 = mysql_fetch_array($cdsqlresult3);
		$catsid = $cddata3['albumid'];
		
		 $status_d = trim($_POST['statusd'.$catsid]);
		
		if($status_d==0)
				{
				
				if (strpos($cddata3['user_ids'], $u_id) !== false) 
		   					{
								
							$arr_ids=explode(",",$cddata3['user_ids']);
						
							$len=count($arr_ids);
							
							
									if($len==1)
									{
										if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$cddata3['user_ids']);
										$f_flag=1;
										
										}
									
									}
									else
									{
								
										
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$cddata3['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$cddata3['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $cddata3['user_ids'];
							$concatrights= $cddata3['user_right'];
							}
		
				}
				else
				{
				
					if(($cddata3['user_ids']=="") && ($cddata3['user_right']==""))
					{
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_d;
					}
					else
					{
						 if (strpos($cddata3['user_ids'], $u_id) !== false) 
		   					{
								$arr_uid=explode(",",$cddata3['user_ids']);
									
									$len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$cddata3['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$cddata3['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_d)
											{
											
											$concatrights1=$cddata3['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_d;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$cddata3['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$cddata3['user_ids'].",".$u_id;
							$concatrights=$cddata3['user_right'].",".$u_id."_".$status_d;
							} 
					}
				}
			
				$sqlu="UPDATE $pmis_db.t031project_drawingalbums set user_ids='$concatids',user_right='$concatrights' where albumid=$catsid"; 
				$sql_run=mysql_query($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				
}
	}
	
	
	
			
	//redirect('./?p=user_mgmt');
	
	
	
	//////Non Confirmity Notices

$sql = "SELECT * FROM $pmis_db.component_tbl order by comp_id";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {

	$cdlist = array();
	
	
		$catsid = $data['comp_id'];
		
		 $status_ncn= trim($_POST['statusncn'.$catsid]);
		
		
		if($status_ncn==0)
				{
				if (strpos($data['user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['user_ids'];
							$concatrights= $data['user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['user_ids']=="") && ($data['user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_ncn;
					}
					else
					{
						
						 if (strpos($data['user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$data['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_ncn)
											{
											
											$concatrights1=$data['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_ncn;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['user_ids'].",".$u_id;
							$concatrights=$data['user_right'].",".$u_id."_".$status_ncn;
							} 
					}
				}
			
				$sqlu="UPDATE $pmis_db.component_tbl set user_ids='$concatids',user_right='$concatrights' where comp_id=$catsid"; 
				$sql_run=mysql_query($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}
	
	
	
	//////Project Issues

$sql = "SELECT * FROM $pmis_db.component_issues_tbl order by comp_id";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {

	$cdlist = array();
	
	
		$catsid = $data['comp_id'];
		
		 $status_iss= trim($_POST['statusiss'.$catsid]);
		
		
		if($status_iss==0)
				{
				if (strpos($data['user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['user_ids'];
							$concatrights= $data['user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['user_ids']=="") && ($data['user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_iss;
					}
					else
					{
						
						 if (strpos($data['user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$data['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_iss)
											{
											
											$concatrights1=$data['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_iss;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['user_ids'].",".$u_id;
							$concatrights=$data['user_right'].",".$u_id."_".$status_iss;
							} 
					}
				}
			
				$sqlu="UPDATE $pmis_db.component_issues_tbl set user_ids='$concatids',user_right='$concatrights' where comp_id=$catsid"; 
				$sql_run=mysql_query($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}	
	
	//////Pictorial Analysis

$sql = "SELECT * FROM $pmis_db.locations order by lid";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {

	$cdlist = array();
	
	
		$catsid = $data['lid'];
		
		$status_pic= trim($_POST['statuspic'.$catsid]);
		
		
		if($status_pic==0)
				{
				if (strpos($data['user_ids'], $u_id) !== false) 
		   					{								
							$arr_ids=explode(",",$data['user_ids']);						
							$len=count($arr_ids);		
							if($len==1)
								{
									if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$data['user_ids']);
										$f_flag=1;
										}
									}
									else
									{
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$data['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$data['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $data['user_ids'];
							$concatrights= $data['user_right'];
							}
		
				}
				else
				{
					
				
					if(($data['user_ids']=="") && ($data['user_right']==""))
					{
						
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_pic;
					}
					else
					{
						
						 if (strpos($data['user_ids'], $u_id) !== false) 
		   					{
								
								$arr_uid=explode(",",$data['user_ids']);
									
									 $len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$data['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$data['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_pic)
											{
											
											$concatrights1=$data['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_pic;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$data['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$data['user_ids'].",".$u_id;
							$concatrights=$data['user_right'].",".$u_id."_".$status_pic;
							} 
					}
				}
			
				$sqlu="UPDATE $pmis_db.locations set user_ids='$concatids',user_right='$concatrights' where lid=$catsid"; 
				$sql_run=mysql_query($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				

	}	
	
	
$activity="User rights updated successfully";
}

?>
<style>
.inactive
{
pointer-events: none;
opacity: 0.5;
background: #CCC;
}
</style>

<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.first_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_FIRSTNAME;?>";
		flag = false;
	}

	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>

<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
function Showactive(cd,s_value,space,user_id) {
var category_cd=cd;
var status_value=s_value;

		<?php
		
		$sql = "SELECT * FROM $pmis_db.t031project_albums";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {
	$category_cdd = $data['albumid'];
		?>
	if(category_cd==<?php echo $category_cdd ?>)
	{
	
	<?php
	$sql2 = "SELECT * FROM $pmis_db.t031project_albums where parent_album=$category_cdd";
$sqlresult2 = mysql_query($sql2);
while ($data1 = mysql_fetch_array($sqlresult2)) {
	$category_cd_main = $data1['albumid'];
	//$category_cd_main1=strlen($category_cd_main);
	if(strlen($category_cd_main)==1)
	{
	$category_cd_main1="00".$category_cd_main;
	}
	else if(strlen($category_cd_main)==2)
	{
	$category_cd_main1="0".$category_cd_main;
	}
	else
	{
	$category_cd_main1=$category_cd_main;
	}

	?>

		var strURL="active_cats.php?cat_cd="+<?php echo $category_cd_main; ?>+"&main_cat_s_value="+status_value+"&indent_space="+space+"&user_cd="+user_id;
		
		var req<?php echo $category_cd_main; ?> = getXMLHTTP();
						
						if (req<?php echo $category_cd_main; ?>) {
							//alert("if");
							
							req<?php echo $category_cd_main; ?>.onreadystatechange = function() {
								if (req<?php echo $category_cd_main; ?>.readyState == 4) {
									// only if "OK"
									if (req<?php echo $category_cd_main; ?>.status == 200) {
										
									   document.getElementById('abcd'+"<?php echo $category_cd_main1; ?>").innerHTML=req<?php echo $category_cd_main; ?>.responseText;
															
									} else {
										alert("There was a problem while using XMLHTTP:7\n" + req<?php echo $category_cd_main; ?>.statusText);
									}
								}				
							}			
							req<?php echo $category_cd_main; ?>.open("GET", strURL, true);
							req<?php echo $category_cd_main; ?>.send(null);
						}
						
						
						
						<?php
						$sql3 = "SELECT * FROM $pmis_db.t031project_albums where parent_album=$category_cd_main";
$sqlresult3 = mysql_query($sql3);
$t_rows=mysql_num_rows($sqlresult3);
if($t_rows>=1)
{
$data6 = mysql_fetch_array($sqlresult3);
$path6 = $data6['parent_group'];
$cdlist6 = explode("_",$path6);
	$items6 = count($cdlist6)-1;
?>
Showactive(<?php echo $category_cd_main; ?>,0,<?php echo $items6; ?>,user_id);
<?php
}

						}
						?>
						}
		<?php
		}
		?>
		
		}
		
		
		
function Showactiveall(s_value,userid) {
var status_value=s_value;

var strURL="all_read.php?s_value="+status_value+"&user_cd="+userid;

var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("all").innerHTML=req.responseText;	
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}

}






function Showactived(cd,s_value,space,user_id) {
		alert(cd);
alert(s_value);
var category_cd=cd;
var status_value=s_value;

		<?php
		
		$sql = "SELECT * FROM $pmis_db.t031project_drawingalbums";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {
	$category_cdd = $data['albumid'];
		?>
	if(category_cd==<?php echo $category_cdd ?>)
	{
	alert(category_cd);
	<?php
	$sql2 = "SELECT * FROM $pmis_db.t031project_drawingalbums where parent_id=$category_cdd";
$sqlresult2 = mysql_query($sql2);
while ($data1 = mysql_fetch_array($sqlresult2)) {
	$category_cd_main = $data1['albumid'];
	//$category_cd_main1=strlen($category_cd_main);
	if(strlen($category_cd_main)==1)
	{
	$category_cd_main1="00".$category_cd_main;
	}
	else if(strlen($category_cd_main)==2)
	{
	$category_cd_main1="0".$category_cd_main;
	}
	else
	{
	$category_cd_main1=$category_cd_main;
	}

	?>

		var strURL="active_cats_d.php?cat_cd="+<?php echo $category_cd_main; ?>+"&main_cat_s_value="+status_value+"&indent_space="+space+"&user_cd="+user_id;
		alert("123");
		var req<?php echo $category_cd_main; ?> = getXMLHTTP();
						
						if (req<?php echo $category_cd_main; ?>) {
							//alert("if");
							
							req<?php echo $category_cd_main; ?>.onreadystatechange = function() {
								if (req<?php echo $category_cd_main; ?>.readyState == 4) {
									// only if "OK"
									if (req<?php echo $category_cd_main; ?>.status == 200) {
										
									   document.getElementById('abcd'+"<?php echo $category_cd_main1; ?>").innerHTML=req<?php echo $category_cd_main; ?>.responseText;
															
									} else {
										alert("There was a problem while using XMLHTTP:7\n" + req<?php echo $category_cd_main; ?>.statusText);
									}
								}				
							}			
							req<?php echo $category_cd_main; ?>.open("GET", strURL, true);
							req<?php echo $category_cd_main; ?>.send(null);
						}
						
						
						
						<?php
						$sql3 = "SELECT * FROM $pmis_db.t031project_drawingalbums where parent_id=$category_cd_main";
$sqlresult3 = mysql_query($sql3);
$t_rows=mysql_num_rows($sqlresult3);
if($t_rows>=1)
{
	
$data6 = mysql_fetch_array($sqlresult3);
$path6 = $data6['parent_group'];
$cdlist6 = explode("_",$path6);
	$items6 = count($cdlist6)-1;
?>
alert("sub");
Showactived(<?php echo $category_cd_main; ?>,0,<?php echo $items6; ?>,user_id);
<?php
}

						}
						?>
						}
		<?php
		}
		?>
		
		}
		function Showactivealld(s_value,userid) {
var status_value=s_value;

var strURL="all_read_d.php?s_value="+status_value+"&user_cd="+userid;

var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("alld").innerHTML=req.responseText;	
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}

}

function Showactivencn(cd,s_value,user_id) {

var category_cd=cd;
var status_value=s_value;

		<?php
		
		$sql = "SELECT * FROM $pmis_db.component_tbl";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {
	$category_cdd = $data['comp_id'];
		?>
	if(category_cd==<?php echo $category_cdd ?>)
	{
	alert(category_cd);
	<?php
	$sql2 = "SELECT * FROM $pmis_db.component_tbl where comp_id=$category_cdd";
	$sqlresult2 = mysql_query($sql2);
	while ($data1 = mysql_fetch_array($sqlresult2)) {
	$category_cd_main = $data1['comp_id'];
	
	

	?>

		var strURL="active_cats_ncn.php?cat_cd="+<?php echo $category_cd_main; ?>+"&main_cat_s_value="+status_value+"&user_cd="+user_id;
		alert(strURL);
		
		var req<?php echo $category_cd_main; ?> = getXMLHTTP();
						
						if (req<?php echo $category_cd_main; ?>) {
							
							
							req<?php echo $category_cd_main; ?>.onreadystatechange = function() {
								if (req<?php echo $category_cd_main; ?>.readyState == 4) {
									// only if "OK"
									if (req<?php echo $category_cd_main; ?>.status == 200) {
										
									   document.getElementById('abcd_ncn'+"<?php echo $category_cd_main; ?>").innerHTML=req<?php echo $category_cd_main; ?>.responseText;
															
									} else {
										alert("There was a problem while using XMLHTTP:7\n" + req<?php echo $category_cd_main; ?>.statusText);
									}
								}				
							}			
							req<?php echo $category_cd_main; ?>.open("GET", strURL, true);
							req<?php echo $category_cd_main; ?>.send(null);
						}
						
						
						
						<?php
						/*$sql3 = "SELECT * FROM $pmis_db.component_tbl where parent_id=$category_cd_main";
$sqlresult3 = mysql_query($sql3);
$t_rows=mysql_num_rows($sqlresult3);
if($t_rows>=1)
{
$data6 = mysql_fetch_array($sqlresult3);
$path6 = $data6['parent_group'];
$cdlist6 = explode("_",$path6);
	$items6 = count($cdlist6)-1;*/
?>
//Showactived(<?php echo $category_cd_main; ?>,0,<?php echo $items6; ?>,user_id);
<?php
//}

						}
						?>
						}
		<?php
		}
		?>
		
		}

	
		</script>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? "Manage Rights &raquo; ".$name_full : "Manage Rights &raquo; ".$name_full?></div>
		<div class="menu1">
				<ul>
				<li><a href="./?p=user_mgmt" class="lnkButton"><?php echo "Back";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		<!--<div id="pageContentRight">
			<div class="menu">
				<ul>
					<li><a href="./?p=my_profile" class="lnkButton"><?php //echo "My Profile";?></a></li>				
				</ul>
				<br style="clear:left"/>
			</div>
		</div>-->
		<div class="clear"></div>
	<div style="margin-top:10px; font-size:14px; color:green"><?php echo $activity?></div>
		<div class="clear"></div>
		
		<div id="tableContainer">
		 <form name="form1" method="post" action="">
		<table width="100%" border="1px solid" bgcolor="#EFEFEF">
        <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Gallery (Photos/Videos)</td></tr>
		 <tr>
<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all" value="2" onclick="Showactiveall(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all" value="1" onclick="Showactiveall(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all" value="3" onclick="Showactiveall(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all" value="0" onclick="Showactiveall(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>
		</tr>
		</table>
		<div id="all">
		<?php
		$sql = "SELECT * FROM $pmis_db.t031project_albums where status=1 order by parent_group, parent_album";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_album'];
	$cdlist = explode("_",$path);
	 $items = count($cdlist);
	if( $items==2 || $items==1)
	{
	 $cdsql = "select * from $pmis_db.t031project_albums where albumid = ".$cdlist[0];
	$cdsqlresult = mysql_query($cdsql);
	$cddata = mysql_fetch_array($cdsqlresult);
	$category_name = $cddata['album_name'];
	//	echo $cdlist[0];
	?>
	
<div id="abcd<?php echo $cdlist[$items-1];?>">
<table border="1px solid" width="100%" >





			<tr>
			
			<?php
		
	
		$cdsql = "select albumid,album_name from $pmis_db.t031project_albums where albumid = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$category_cd = $cddata['albumid'];

			?>
			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parent_cd==0){	
			echo "<b>".$category_name."</b>";
			}
			else
			{
			echo $h.$cddata['album_name'];
		
			}
		  
		  
		   ?>



		
		</td>
		<?php
		$colorr="";
		
		 if($parent_cd==0){?>
		<td>&nbsp;</td>
		<?php
		}else
		{
			
		  $abc= $_GET["user_cd"];
		$cdsql2 = "select albumid,parent_album,user_ids,user_right from $pmis_db.t031project_albums where albumid = ".$cdlist[$items-1];
		$cdsqlresult2 = mysql_query($cdsql2);
		$cddata2 = mysql_fetch_array($cdsqlresult2);
		$category_cd2 = $cddata2['albumid'];
		$parent_cdd = $cddata2['parent_album'];
		
		$cdsqlt = "select albumid,parent_album,user_ids,user_right from $pmis_db.t031project_albums where albumid = ".$parent_cdd;
		$cdsqlresult = mysql_query($cdsqlt);
		$cddatat = mysql_fetch_array($cdsqlresult);
		$category_cdt = $cddatat['albumid'];
		
		
		
		if ((strpos($cddatat['user_right'], $abc."_1") !== false) || (strpos($cddatat['user_right'], $abc."_2") !== false) || (strpos($cddatat['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$cddatat['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if($cddatat['parent_cd']==0)
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($cddata2['user_right'], $abc."_1") !== false) || (strpos($cddata2['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$cddata2['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($cddata2['user_right'], $abc."_2") !== false) || (strpos($cddata2['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$cddata2['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($cddata2['user_right'], $abc."_3") !== false) || (strpos($cddata2['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$cddata2['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status<?php echo $category_cd2;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,2,<?php echo $items; ?>,<?php echo $abc; ?>)"  >R
  <input type="radio" name="status<?php echo $category_cd2;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,1,<?php echo $items; ?>,<?php echo $abc; ?>)" >R/W
   <input type="radio" name="status<?php echo $category_cd2;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?>  onclick="Showactive(<?php echo $category_cd2;?>,3,<?php echo $items; ?>,<?php echo $abc; ?>)" >R/W/D
  <input type="radio" name="status<?php echo $category_cd2;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,0,<?php echo $items; ?>,<?php echo $abc; ?>)"> No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		}
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist);
	}
}
			?>
			</div>
            
           <br /> 
       
            
            
            
            
           <table width="100%" border="1px solid" bgcolor="#EFEFEF">
           <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Drawings and Maps</td></tr>
		 <tr>
<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all_d" value="2" onclick="Showactivealld(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all_d" value="1" onclick="Showactivealld(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all_d" value="3" onclick="Showactivealld(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all_d" value="0" onclick="Showactivealld(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>
		</tr>
		</table> 
            
            <div id="alld">
		<?php
		$sql = "SELECT * FROM $pmis_db.t031project_drawingalbums where status=1 order by parent_group, parent_id";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_id'];
	$cdlist = explode("_",$path);
	 $items = count($cdlist);
	if( $items==2 || $items==1)
	{
	 $cdsql = "select * from $pmis_db.t031project_drawingalbums where albumid = ".$cdlist[0];
	$cdsqlresult = mysql_query($cdsql);
	$cddata = mysql_fetch_array($cdsqlresult);
	$category_name = $cddata['album_name'];
	//	echo $cdlist[0];
	?>
	
<div id="abcd<?php echo $cdlist[$items-1];?>">
<table border="1px solid" width="100%" >





			<tr>
			
			<?php
		
	
		$cdsql = "select albumid,album_name from $pmis_db.t031project_drawingalbums where albumid = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$category_cd = $cddata['albumid'];

			?>
			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parent_cd==0){	
			echo "<b>".$category_name."</b>";
			}
			else
			{
			echo $h.$cddata['album_name'];
		
			}
		  
		  
		   ?>



		
		</td>
		<?php
		$colorr="";
		
		 if($parent_cd==0){?>
		<td>&nbsp;</td>
		<?php
		}else
		{
			
		  $abc= $_GET["user_cd"];
		$cdsql2 = "select albumid,parent_id,user_ids,user_right from $pmis_db.t031project_drawingalbums where albumid = ".$cdlist[$items-1];
		$cdsqlresult2 = mysql_query($cdsql2);
		$cddata2 = mysql_fetch_array($cdsqlresult2);
		$category_cd2 = $cddata2['albumid'];
		$parent_cdd = $cddata2['parent_id'];
		
		$cdsqlt = "select albumid,parent_id,user_ids,user_right from $pmis_db.t031project_drawingalbums where albumid = ".$parent_cdd;
		$cdsqlresult = mysql_query($cdsqlt);
		$cddatat = mysql_fetch_array($cdsqlresult);
		$category_cdt = $cddatat['albumid'];
		
		
		
		if ((strpos($cddatat['user_right'], $abc."_1") !== false) || (strpos($cddatat['user_right'], $abc."_2") !== false) || (strpos($cddatat['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$cddatat['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if($cddatat['parent_id']==0)
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($cddata2['user_right'], $abc."_1") !== false) || (strpos($cddata2['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$cddata2['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($cddata2['user_right'], $abc."_2") !== false) || (strpos($cddata2['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$cddata2['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($cddata2['user_right'], $abc."_3") !== false) || (strpos($cddata2['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$cddata2['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusd<?php echo $category_cd2;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> onclick="Showactived(<?php echo $category_cd2;?>,2,<?php echo $items; ?>,<?php echo $abc; ?>)"  >R
  <input type="radio" name="statusd<?php echo $category_cd2;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?> onclick="Showactived(<?php echo $category_cd2;?>,1,<?php echo $items; ?>,<?php echo $abc; ?>)" >R/W
   <input type="radio" name="statusd<?php echo $category_cd2;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?>  onclick="Showactived(<?php echo $category_cd2;?>,3,<?php echo $items; ?>,<?php echo $abc; ?>)" >R/W/D
  <input type="radio" name="statusd<?php echo $category_cd2;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> onclick="Showactived(<?php echo $category_cd2;?>,0,<?php echo $items; ?>,<?php echo $abc; ?>)"> No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		}
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist);
	}
}
			?>
			</div>
             <br /> 
       
            
            
            
            
           <table width="100%" border="1px solid" bgcolor="#EFEFEF">
           <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Non Confirmity Notices</td></tr>
		 <!--<tr>
<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all_ncn" value="2" onclick="Showactivealld(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all_ncn" value="1" onclick="Showactivealld(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all_ncn" value="3" onclick="Showactivealld(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all_ncn" value="0" onclick="Showactivealld(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>
		</tr>-->
		</table> 
            
            <div id="allncn">
		<?php
		$sql = "SELECT * FROM $pmis_db.component_tbl  order by comp_id";
$sqlresult = mysql_query($sql);
while ($data_t = mysql_fetch_array($sqlresult)) {
	$cdlist_ncn=array();
	$comp_id=$data_t['comp_id'];
	$comp_name=$data_t['comp_name'];	
	?>
	
<div id="abcd_ncn<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['user_right'], $abc."_3") !== false) || (strpos($data_t['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusncn<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statusncn<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statusncn<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statusncn<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_ncn);
	
}
			?>
			</div>
                <br /> 
                <table width="100%" border="1px solid" bgcolor="#EFEFEF">
           <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Project Issues</td></tr>
		 <!--<tr>
<td width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</td>
<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status_all_ncn" value="2" onclick="Showactivealld(2,<?php echo $u_id; ?>)"  >R
  <input type="radio" name="status_all_ncn" value="1" onclick="Showactivealld(1,<?php echo $u_id; ?>)">R/W
  <input type="radio" name="status_all_ncn" value="3" onclick="Showactivealld(3,<?php echo $u_id; ?>)">R/W/D
  <input type="radio" name="status_all_ncn" value="0" onclick="Showactivealld(0,<?php echo $u_id; ?>)"> No
  </div>

		</td>
		</tr>-->
		</table> 
                
                <div id="alliss">
		<?php
		$sql = "SELECT * FROM $pmis_db.component_issues_tbl  order by comp_id";
$sqlresult = mysql_query($sql);
while ($data_t = mysql_fetch_array($sqlresult)) {
	$cdlist_iss=array();
	$comp_id=$data_t['comp_id'];
	$comp_name=$data_t['comp_name'];	
	?>
	
<div id="abcd_iss<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['user_right'], $abc."_3") !== false) || (strpos($data_t['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statusiss<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statusiss<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statusiss<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statusiss<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_iss);
	
}
			?>
			</div>
            
                        <br /> 
       
            
            
            
            
           <table width="100%" border="1px solid" bgcolor="#EFEFEF">
           <tr><td colspan="2" style="font-size:16px; font-weight:bold; color:#000000">Pictorial Analysis</td></tr>
		 
		</table> 
            
            <div id="allpic">
		<?php
		$sql = "SELECT * FROM $pmis_db.locations  order by lid";
$sqlresult = mysql_query($sql);
while ($data_t = mysql_fetch_array($sqlresult)) {
	$cdlist_pic=array();
	$comp_id=$data_t['lid'];
	$comp_name=$data_t['title'];	
	?>
	
<div id="abcd_pic<?php echo $comp_id;?>">
<table border="1px solid" width="100%" >

			<tr>			
						
			<?php
			$colorr="#FFF9F9";			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
				
			echo $comp_name;		  
		   ?>
		</td>
		<?php
		$colorr="";
		  $abc= $_GET["user_cd"];
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$data_t['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if(isset($comp_id))
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($data_t['user_right'], $abc."_1") !== false) || (strpos($data_t['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$data_t['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($data_t['user_right'], $abc."_2") !== false) || (strpos($data_t['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$data_t['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($data_t['user_right'], $abc."_3") !== false) || (strpos($data_t['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$data_t['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="statuspic<?php echo $comp_id;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> >R
  <input type="radio" name="statuspic<?php echo $comp_id;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?>  >R/W
   <input type="radio" name="statuspic<?php echo $comp_id;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?> >R/W/D
  <input type="radio" name="statuspic<?php echo $comp_id;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> > No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist_pic);
	
}
			?>
			</div>
			<input type="submit" name="save" value="Save" />
			<input type="submit" name="cancel" value="Cancel" />
			<input type="submit" name="refresh" value="Refresh" />
			</form>
  	    </div>
        
        
	</div>