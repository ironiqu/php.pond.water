<?php
include_once 'resrc/src/SrcConst.php';

class ImportHtml{
	private $ht = ""; //html text
	private $ar = array();
	
	function __construct($htmlName){
		if($htmlName)
			$this->getHtml($htmlName);
	}
	
	private function getHtml($htmlName){
		$this->ht = SrcConst::getHtmlData ( $htmlName );
	}
	
	private function fixPlaceholder(){
		$this->fixExtensionPlaceholder();
		
		$this->ht = SrcConst::fixHtmlPlaceholder($this->ht);
		
		$tp = "/\{text:([a-zA-Z0-9]+)\}/"; // textPattern
		$names;
		preg_match_all($tp, $this->ht, $names);
		// text fix
		$names = $names[1];
		for($i = 0, $l = count($names); $i < $l; $i++) {
			$n = $names[$i];
			$v = SrcConst::getTextData ( $n );
			$this->ht = preg_replace ( "/\{text:".$n."\}/", $v, $this->ht );
		}
		
		$this->fixExtensionPlaceholder();

		$tp = "/\{style:([a-zA-Z0-9]+)\}/"; // textPattern
		$names;
		preg_match_all($tp, $this->ht, $names);
		// text fix
		$names = $names[1];
		for($i = 0, $l = count($names); $i < $l; $i++) {
			$n = $names[$i];
			$v = SrcConst::getStyleData ( $n );
			$this->ht = preg_replace ( "/\{style:".$n."\}/", $v, $this->ht );
		}
		
		$this->fixExtensionPlaceholder();
	}
	
	private function fixExtensionPlaceholder(){
		$tp = "/\{ex:([a-zA-Z0-9]+)\}/"; // textPattern
		$names;
		preg_match_all($tp, $this->ht, $names);
		// text fix
		$names = $names[1];
		for($i = 0, $l = count($names); $i < $l; $i++) {
			$n = $names[$i];
			$v = array_key_exists($n, $this->ar)?$this->ar[$n]:"";
			$this->ht = preg_replace ( "/\{ex:".$n."\}/", $v, $this->ht );
		}
	}
	
	public function output(){
	   if($this->ht == null){
	      
	   }else{
	      echo $this->getResult();
	   }
	}
	
	public function getResult(){
		$this->fixPlaceholder();
		return $this->ht;
	}
	
	public function setExtension($array){
		$this->ar = $array;
	} 
}

?>