<?php
include_once 'src/ImportHtml.php';

session_start();
session_regenerate_id();
session_set_cookie_params(1440);

//echo hash("sha256", "xxxxx");

$err="";

function certification($id, $pw){
	$r = false;
	$xml = file_get_contents ( "src/adminUsers.xml" );
	$admins = new SimpleXMLElement ( $xml );
	foreach ( $admins->admin as $admin ) {
		if (( string ) $admin ["id"] === $id){
			$h = hash((string)$admin->passHash["mode"], $pw);
			if((string)$admin->passHash === $h){
				$r = true;
			}
			break;
		}
	}
	return $r; 
}

function isSignin($id){
	$r = false;
	$xml = file_get_contents ( "src/adminUsers.xml" );
	$admins = new SimpleXMLElement ( $xml );
	foreach ( $admins->admin as $admin ) {
		if (( string ) $admin ["id"] === $id){
			$r = true;
			break;
		}
	}
	return $r; 
}

//signin or signout
if (array_key_exists ( "id", $_POST ) && array_key_exists ( "pw", $_POST )) {
	if(certification($_POST["id"], $_POST["pw"])){
		$_SESSION["user"] = $_POST["id"];
		$_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
	} else {
		$err = "IDかPWが間違っています";
	}
}else if(array_key_exists ( "mode", $_GET ) && $_GET["mode"] === "out"){
	$_SESSION = array();
	if (ini_get ( "session.use_cookies" )) {
		$params = session_get_cookie_params ();
		setcookie ( session_name (), '', time () - 42000, $params ["path"], $params ["domain"], $params ["secure"], $params ["httponly"] );
	}
	session_destroy();
	$url = $_SERVER ["REQUEST_URI"];
	header ( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( "/^(.*admin\.php)(.*)$/", "$1", $url ) );
	exit ();
}

//select output html
if(array_key_exists ( "user", $_SESSION )){
	//administrator or ...
	if ( isSignin($_SESSION ["user"]) && $_SESSION["ip"] === $_SERVER["REMOTE_ADDR"]) {
		$pageTitle = "";
		$c = "";
		if (array_key_exists ( "c", $_GET ) && $c = $_GET ["c"]) {
			if (($pageTitle = SrcConst::getTextData ( "pageAdmin" . ucfirst ( $c ) )) === "null") {
				header ( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( "/^(.*admin\.php).*$/", "$1", $_SERVER ["REQUEST_URI"] ) );
				exit ();
			}
		}
		$ih = new ImportHtml ( "admin" );
		$ih->setExtension ( array (
				"pageData" => $c===""?"左のボタンから編集画面に進んで下さい":SrcConst::getPageData ("Admin".ucfirst ( $c )),
				"pageTitle" => $pageTitle,
				"adminStyle" => SrcConst::getStyleData("admin".ucfirst ( $c ))
		) );
		$ih->output ();
	} else{
		$url = $_SERVER ["REQUEST_URI"];
		header ( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( "/^(.*admin\.php)(.*)$/", "$1?mode=out", $url ) );
		exit ();
	}
} else {
	$ih = new ImportHtml ( "unadmin" );
	$ih->setExtension ( array (
			"err" => $err 
	) );
	$ih->output ();
}



/*
$ih = new ImportHtml ( "admin" );
$ih->setExtension ( array (
		
) );
$ih->output ();
*/
?>