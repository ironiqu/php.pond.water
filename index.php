<?php
include_once 'src/ImportHtml.php';


// index.php to top
$url = $_SERVER ["REQUEST_URI"];

if (preg_match ( "/.*\/index\.php.*/", $url ) || preg_match ( "/^\/([a-z]+)\/$/", $url ) || !array_key_exists ( "content", $_GET )) {
	header ( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( "/^(\/[a-z]+\/).*$/", "$1top/", $url ) );
	exit ();
}

// page create
$pageTitle = "";
$imgPath = "../data/image/";
$c = $c = ucfirst ( $_GET ["content"]);

if (($pageTitle = SrcConst::getTextData ( "page" . $c ))=== "null") {
	header ( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( "/^(.*\/).+\/$/", "$1", $url ) );
	exit ();
}

$ih = new ImportHtml ( "index" );
$ih->setExtension ( array (
		"imgPath" => $imgPath,
		"pageTitle" => $pageTitle,
		"pageStyle" => SrcConst::getStyleData ( "page" . $c ) ,
		"pageData" => SrcConst::getPageData ( $c ),
		"pageSub" => SrcConst::getPageData("SubContents")
) );
$ih->output ();

?>