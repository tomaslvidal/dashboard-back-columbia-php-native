<?
include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/dirsGlobal.php");

include("{$dir}settings/db.inc.php");

connect_db();

date_default_timezone_set("America/Argentina/Buenos_Aires");

function curPageURL(){
	$pageURL = 'http';
	
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}

	$pageURL .= "://";

	if ($_SERVER["SERVER_PORT"] != "80"){
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	return $pageURL;
}

?>
