<?php
	error_reporting(E_ALL & ~E_NOTICE);
	@session_start( );
	
	@ob_start( );
		

	@ini_set('display_errors', 1);

	@require_once("configs.php");
	@require_once("db.class.php");
	@require_once("io.class.php");
	@require_once("general.php");
	@require_once("functions.php");
	@include("fckeditor/fckeditor.php");
	//setSession($_SESSION['uid']);
	
	$uid				= $_SESSION['ne_user_cd']; 
	$uname				= $_SESSION['ne_username'];
	$mdata_flag			= $_SESSION['ne_mdata'];
	$mdataadm_flag		= $_SESSION['ne_mdataadm'];
	$mdataentry_flag	= $_SESSION['ne_mdataentry'];
	
	$mile_flag			= $_SESSION['ne_mile'];
	$mileadm_flag		= $_SESSION['ne_mileadm'];
	$mileentry_flag		= $_SESSION['ne_mileentry'];
	
	$spg_flag			= $_SESSION['ne_spg'];
	$spgadm_flag		= $_SESSION['ne_spgadm'];
	$spgentry_flag		= $_SESSION['ne_spgentry'];
	
	$kpi_flag			= $_SESSION['ne_kpi'];
	$kpiadm_flag		= $_SESSION['ne_kpiadm'];
	$kpientry_flag		= $_SESSION['ne_kpientry'];
	
	$cam_flag			= $_SESSION['ne_cam'];
	$camadm_flag		= $_SESSION['ne_camadm'];
	$camentry_flag		=$_SESSION['ne_camentry'];
	
	$boq_flag			= $_SESSION['ne_boq'];
	$boqadm_flag		= $_SESSION['ne_boqadm'];
	$boqentry_flag		= $_SESSION['ne_boqentry'];
	
	$ipc_flag			= $_SESSION['ne_ipc'];
	$ipcadm_flag		= $_SESSION['ne_ipcadm'];
	$ipcentry_flag		= $_SESSION['ne_ipcentry'];
	
	$eva_flag			= $_SESSION['ne_eva'];
	$evaadm_flag		= $_SESSION['ne_evaadm'];
	$evaentry_flag		=$_SESSION['ne_evaentry'];
	
	$padm_flag			= $_SESSION['ne_padm'];
	$actd_flag			= $_SESSION['ne_actd'];
	$miled_flag			= $_SESSION['ne_miled'];
	
	$kpid_flag			= $_SESSION['ne_kpid'];
	$camd_flag			= $_SESSION['ne_camd'];
	$kfid_flag			=$_SESSION['ne_kfid'];
?>
