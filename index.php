<?php
include_once 'src/ImportHtml.php';

$urlPattern = "/^(\/([\w_\-\.]+\/)?).*$/";

// index.php to index
$url = $_SERVER ["REQUEST_URI"];
$url = preg_replace ( "/^(\/([\w_\-\.\/]+\/)?).*$/", "$1", $url );
echo "<br>".$url;

if(preg_match ( "/.*\/index\.php.*/", $url )){
	echo "<br>1".( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index/", $url ) );
}
if(!array_key_exists ( "content", $_GET )){
	echo "<br>3".( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index/", $url ) );
}
$pageTitle = "";
$imgPath = $url."data/image/";
$c = ucfirst ( array_key_exists ( "content", $_GET )?$_GET ["content"] : "index");
echo "<br>4".$c;
echo "<br>5".$imgPath;
echo "<br>6<img src=\"$imgPath/dummy.png\">";






exit();
if (preg_match ( "/.*\/index\.php.*/", $url ) || preg_match ( "/^\/(\/[\w_\-\.]+\/)\/$/", $url ) || !array_key_exists ( "content", $_GET )) {
	header ( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( "/^(\/([\w_\-\.]+\/)?).*$/", "$1index/", $url ) );
	exit ();
}
// page create
$pageTitle = "";
$imgPath = "../data/image/";
$c = ucfirst ( $_GET ["content"]);
echo $c;
echo "<br>".$url;
exit();
if (($pageTitle = SrcConst::getTextData ( "page" . $c )) === "null") {
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