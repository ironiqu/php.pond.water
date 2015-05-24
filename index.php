<?php
include_once 'resrc/src/ImportHtml.php';

$urlPattern = "/^(\/([\w_\-\.]+\/)?).*$/";

// index.php to index
$url = $_SERVER ["REQUEST_URI"];
echo $url;

if(preg_match ( "/.*\/index\.php.*/", $url )){
   //echo "<br>2".( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index/", $url ) );
   header( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index", $url ) );
}
/*
if(!array_key_exists ( "content", $_GET )){
   echo "<br>3".( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index/", $url ) );
}
*/
$pageTitle = "";
$imgPath = preg_replace ( "/^(\/([\w_\-\.\/]+\/)?).*$/", "$1", $url )."resrc/data/image/";
$c = array_key_exists ( "content", $_GET )?$_GET ["content"] : "index";
echo "<br>4".$c;
echo "<br>5".$imgPath;
echo "<br>6<img src=\"$imgPath"."dummy.png\">";






//exit();
// page create

$ih = new ImportHtml ( $c );
$ih->setExtension ( array (
      "imgPath" => $imgPath,
      "pageStyle" => SrcConst::getStyleData ( "page" . ucfirst ( $c ) ),
      "pageData" => SrcConst::getPageData ( $c ),
      "pageSub" => SrcConst::getPageData("SubContents")
) );
$ih->output ();

?>