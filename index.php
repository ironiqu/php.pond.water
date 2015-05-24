<?php
include_once 'resrc/src/ImportHtml.php';

$urlPattern = "/^(\/([\w_\-\.]+\/)?).*$/";

// index.php to index
$url = $_SERVER ["REQUEST_URI"];

if(preg_match ( "/.*\/index\.php.*/", $url )){
   //echo "<br>2".( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index/", $url ) );
   redirect($urlPattern, $url);
}
$pageTitle = "";
$imgPath = preg_replace ( "/^(\/([\w_\-\.\/]+\/)?).*$/", "$1", $url )."resrc/data/image/";
$c = array_key_exists ( "content", $_GET )?$_GET ["content"] : "index";

// page create
$ih = new ImportHtml ( $c );
$ih->setExtension ( array (
      "imgPath" => $imgPath,
      "pageStyle" => SrcConst::getStyleData ( $c ),
      "pageData" => SrcConst::getPageData ( $c ),
      "pageSub" => SrcConst::getPageData("SubContents")
) );
$html = $ih->output ();
if($html == null){
   redirect($urlPattern, $url);
}else{
   echo $html;
}

function redirect($urlPattern, $url){
   header( "Location: http://" . $_SERVER ["SERVER_NAME"] . preg_replace ( $urlPattern, "$1index", $url ) );
   exit();
}

?>