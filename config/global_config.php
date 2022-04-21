<?php
// Global configuration
$_CONFIG['site_name'] 			= "ASSAM";
$_CONFIG['site_short_name'] 	= "ASSAM";

$_CONFIG['admin_email'] 		= "test@gmail.com";

if( $_SERVER['HTTP_HOST'] == "india-sdms.smecnet.com")
	{

	$_CONFIG['site_url'] 		= "https://".$_SERVER['HTTP_HOST']."/ASSAM/";
	$_CONFIG['site_path'] 		= $_SERVER['DOCUMENT_ROOT'] . "/ASSAM/";
}
else if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "14.141.114.205" || $_SERVER['HTTP_HOST'] == "10.100.65.117")
	{

	$_CONFIG['site_url'] 		= "http://".$_SERVER['HTTP_HOST']."/ASSAM/";
	$_CONFIG['site_path'] 		= $_SERVER['DOCUMENT_ROOT'] . "/ASSAM/";
}


$_CONFIG['domain_code'] 		= "0";
//$_CONFIG['C_PAGE']				= end(explode('/',$_SERVER['REQUEST_URI']));
$_CONFIG['file_ext'] 			= ".html";
$_CONFIG['site_folder'] 		= "/"; //  change this to only / if the site is in LIVE without any folder.
$_CONFIG['html_path'] 			= $_CONFIG['site_path'] . "html/";
$_CONFIG['html_url'] 			= $_CONFIG['site_url'] . "html/";
$_CONFIG['ajax_path'] 			= $_CONFIG['site_path'] . "ajax_html/";
$_CONFIG['ajax_url'] 			= $_CONFIG['site_url'] . "ajax_html/";
$_CONFIG['inc_path'] 			= $_CONFIG['site_path'] . "includes/";

// Action pages path
$_CONFIG['action_path'] 		= $_CONFIG['site_path'] . "actions/";
$_CONFIG['action_url'] 			= $_CONFIG['site_url'] . "actions/";

$_CONFIG['images_url'] 			= $_CONFIG['site_url'] . "images/";

// Security/Captcha path
$_CONFIG['sec_path'] 			= $_CONFIG['site_path'] . "security/";
$_CONFIG['sec_url'] 			= $_CONFIG['site_url'] . "security/";

// Editor path
$_CONFIG['editor_path'] 		= $_CONFIG['site_url'] . "jscript/";

// Editor path
$_CONFIG['security_path'] 		= $_CONFIG['site_path'] . "security/";
$_CONFIG['security_url'] 		= $_CONFIG['site_url'] . "security/";

// Template paths
$_CONFIG['template_url'] 		= $_CONFIG['site_url'] . "email_template/";
$_CONFIG['template_path'] 		= $_CONFIG['site_path'] . "email_template/";

// product data
$_CONFIG['product_url'] 		= $_CONFIG['site_url'] . "product_data/";
$_CONFIG['product_path'] 		= $_CONFIG['site_path'] . "product_data/";
$_CONFIG['product_thumb_url'] 	= $_CONFIG['site_url'] . "product_data/thumbs/";
$_CONFIG['product_thumb_path'] 	= $_CONFIG['site_path'] . "product_data/thumbs/";
$_CONFIG['product_medium_url'] 	= $_CONFIG['site_url'] . "product_data/medium/";
$_CONFIG['product_medium_path'] = $_CONFIG['site_path'] . "product_data/medium/";
$_CONFIG['newsletter_path'] 	= $_CONFIG['product_path'] . "newsletter/";
$_CONFIG['product_excel_url']   = $_CONFIG['site_url'] . "product_excel/";
$_CONFIG['product_excel_path']  = $_CONFIG['site_path'] . "product_excel/";

$_CONFIG['report_url']   = $_CONFIG['site_url'] . "project_reports/";
$_CONFIG['report_path']  = $_CONFIG['site_path'] . "project_reports/";

$_CONFIG['news_url']   = $_CONFIG['site_url'] . "News/";
$_CONFIG['news_path']  = $_CONFIG['site_path'] . "News/";


//partner_data
$_CONFIG['partner_medium_url'] 	= $_CONFIG['site_url'] . "partner_data/medium/";
$_CONFIG['partner_medium_path'] = $_CONFIG['site_path'] . "partner_data/medium/";
$_CONFIG['partner_thumb_url'] 	= $_CONFIG['site_url'] . "partner_data/thumbs/";
$_CONFIG['partner_thumb_path'] 	= $_CONFIG['site_path'] . "partner_data/thumbs/";




// Date format
$_CONFIG['date_format'] 		= 'm-d-Y'; # should be PHP supported date formats

// Product Image
$_CONFIG['prd_full_image_w'] 	= 340;
$_CONFIG['prd_full_image_h'] 	= 340;

$_CONFIG['prd_thumb_image_w'] 	= 75;
$_CONFIG['prd_thumb_image_h'] 	= 75;

// ideal payment config
//$_CONFIG['ideal_url'] 			= 'https://internetkassa.abnamro.nl/ncol/test/orderstandard.asp'; # Test URL
//$_CONFIG['ideal_url'] 			= 'https://internetkassa.abnamro.nl/ncol/prod/orderstandard.asp'; # Production URL
//$_CONFIG['ideal_url'] 			= 'https://i-kassa.rabobank.nl/rik/test/orderstandard.asp'; # Test URL
$_CONFIG['ideal_url'] 			= 'https://ideal.rabobank.nl/ideal/mpiPayInitRabo.do';


// paypal business email
//$_CONFIG['paypal_email'] 		= 'raju_d_1235055555_biz@hotmail.com';
//$_CONFIG['paypal_url'] 			= 'https://www.sandbox.paypal.com/cgi-bin/webscr'; # Test URL
//$_CONFIG['paypal_url'] 		= 'https://www.paypal.com/cgi-bin/webscr'; # Product URL

$_CONFIG['action_path'] 		= $_CONFIG['site_path'] . "actions/";
$_CONFIG['action_url'] 			= $_CONFIG['site_url'] . "actions/";

$_CONFIG['lang'] 				= 'NL';
$_CONFIG['site_currency'] 		= 'DOLLAR'; # EUR | GBP | 
$_CONFIG['currency_symbol'] 	= '$'; # EUR | GBP | 
$_CONFIG['code_length'] 		= 6;

$_CONFIG['ProDes_Limit']		= "150";

$_CONFIG['per_page_data'] 		= 20;
$_CONFIG['offset'] 				= 10;
$_CONFIG['TT_DATA']		 		= 10;

// Image
$_CONFIG['d_full_image_max_w'] 	= 340;
$_CONFIG['d_thumb_w'] 			= 340;

$_CONFIG['mod_rewrite'] 		= 'true'; // false | true
?>