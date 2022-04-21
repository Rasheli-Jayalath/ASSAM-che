<?php
	error_reporting(E_ALL & ~E_NOTICE);
	define(PNAME,"ASSAM");
	session_name(PNAME);
	@session_start( );
	
	@ob_start( );
		

	@ini_set('display_errors', 1);

	@require_once("configs.php");
	@require_once("db.class.php");
	// @require_once("io.class.php");
	// @require_once("general.php");
	// @require_once("functions.php");
	// @include("fckeditor/fckeditor.php");
	//setSession($_SESSION['uid']);
	
	$uid				= $_SESSION['ne_user_cd']; 
	$uname				= $_SESSION['ne_username'];
	$superadmin_flag 		= $_SESSION['ne_sadmin'];
	$res_flag			= $_SESSION['ne_res'];
	$resadm_flag		= $_SESSION['ne_resadm'];
	$resentry_flag	= $_SESSION['ne_resentry'];
	
	$mdata_flag			= $_SESSION['ne_mdata'];
	$mdataadm_flag		= $_SESSION['ne_mdataadm'];
	$mdataentry_flag	= $_SESSION['ne_mdataentry'];
	
	$mile_flag			= $_SESSION['ne_mile'];
	$mileadm_flag		= $_SESSION['ne_mileadm'];
	$mileentry_flag		= $_SESSION['ne_mileentry'];
	
	$spg_flag			= $_SESSION['ne_spg'];
	$spgadm_flag		= $_SESSION['ne_spgadm'];
	$spgentry_flag		= $_SESSION['ne_spgentry'];
	
	$spln_flag			= $_SESSION['ne_spln'];
	$splnadm_flag		= $_SESSION['ne_splnadm'];
	$splnentry_flag		= $_SESSION['ne_splnentry'];
	
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
	$issueAdm_flag			= $_SESSION['ne_issueAdm'];
	
	$actd_flag			= $_SESSION['ne_actd'];
	$miled_flag			= $_SESSION['ne_miled'];
	
	$kpid_flag			= $_SESSION['ne_kpid'];
	$camd_flag			= $_SESSION['ne_camd'];
	$kfid_flag			=$_SESSION['ne_kfid'];
	$evad_flag			=$_SESSION['ne_evad'];
	
	$pic_flag			= $_SESSION['ne_pic'];
	$picadm_flag		= $_SESSION['ne_picadm'];
	$picentry_flag		=$_SESSION['ne_picentry'];
	
	$draw_flag			= $_SESSION['ne_draw'];
	$drawadm_flag		= $_SESSION['ne_drawadm'];
	$drawentry_flag		=$_SESSION['ne_drawentry'];
	
	///Non Confirmity
	$ncf_flag			= $_SESSION['ne_ncf'];
	$ncfadm_flag		= $_SESSION['ne_ncfadm'];
	$ncfentry_flag		=$_SESSION['ne_ncfentry'];
	
	///Design Progress
	$dp_flag			= $_SESSION['ne_dp'];
	$dpadm_flag		= $_SESSION['ne_dpadm'];
	$dpentry_flag		=$_SESSION['ne_dpentry'];
	
	$process_flag		=$_SESSION['ne_process'];
	//This is the default language. We will use it 2 places, so i am put it 
//into a varaible.
$defaultLang = 'en';

//Checking, if the $_GET["language"] has any value
//if the $_GET["language"] is not empty
if (!empty($_GET["language"])) { //<!-- see this line. checks 
    //Based on the lowecase $_GET['language'] value, we will decide,
    //what lanuage do we use
    switch (strtolower($_GET["language"])) {
        case "en":
            //If the string is en or EN
            $_SESSION['lang'] = 'en';
            break;
        case "tr":
            //If the string is tr or TR
            $_SESSION['lang'] = 'rus';
            break;
        default:
            //IN ALL OTHER CASES your default langauge code will set
            //Invalid languages
            $_SESSION['lang'] = $defaultLang;
            break;
    }
}

//If there was no language initialized, (empty $_SESSION['lang']) then
if (empty($_SESSION["lang"])) {
    //Set default lang if there was no language
    $_SESSION["lang"] = $defaultLang;
}

?>
