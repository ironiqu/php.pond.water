<?php

class SrcConst{
	
	private static $webdocsPath = "resrc/webdocs/";
	private static $dataPath = "resrc/data/";
	
	//text data(only hardcode)
	/*
	private static  $td = array(
			// under default text data 
			"pageTop" => "トップページ",
			"pageHotel" => "ペットホテル",
			"pageCafe" => "ペットカフェ",
			"pagePet" => "ペット詳細",
			"pageShop" => "店舗案内",
			"pageQuestion" => "Q&amp;A",
			// under admin text data 
			"adminTitle" => "ウェブページの管理",
			"pageAdminCss" => "共通CSSの編集",
			"pageAdminEvent" => "イベントページの追加・編集",
			"pageAdminShop" => "店舗ページの追加・編集",
			"pageAdminImg" => "画像の追加・編集",
			"pageAdminAnimal" => "動物の種類を追加・編集",
			"pageAdminSale" => "販売中の動物を追加・編集",
			"pageAdminWord" => "ウェブページの語句を編集",
			"pageAdminQuestion" => "質問の追加・編集",
			"shopimgs" => "店舗画像",
			"shopname" => "店舗名",
			"zipcode" => "郵便番号",
			"address" => "住所",
			"phonenumber" => "電話番号",
			"mailaddress" => "メールアドレス",
			"opentime" => "営業時間",
			"facility" => "設備",
			"intro" => "店舗紹介",
			"outline" => "概要",
			"animalname" => "動物の種類名",
			"animalimgs" => "動物の画像",
			"animaltags" => "動物のタグ付け",
			"imgs" => "画像",
			"saleflag" => "販売の有無",
			"price" => "現在価格",
			"newprice" => "新価格",
			"sex" => "性別",
			"birthday" => "誕生日",
			"bionumber" => "生体番号",
			"microchipflag" => "マイクロチップ",
			"saleoutline" => "備考",
			"color" => "色",
			"hometown" => "出身地",
			"animalremarks" => "動物名の拡張",
			"vaccine" => "ワクチン",
			"questiontitle" => "質問",
			"answer" => "回答"
	);
	*/
	
	public static function getTextData($name){
		//$r = array_key_exists($name, self::$td)?self::$td[$name]:"null";
		$r = "";
		
		if ($r == "") {
			$xml = file_get_contents ( self::$dataPath."xml/textResource.xml" );
			$texts = new SimpleXMLElement ( $xml );
			foreach ( $texts->text as $text ) {
				if ((string)$text["name"] === $name)
					$r = $text["value"];
			}
		}
		return $r;
	}
	

	public static function getHtmlData($name){
		$n = self::$webdocsPath."html/".$name.".html";
		$r = null;
		if (file_exists ( $n )) {
			$r = file_get_contents ( $n );
			$r = self::fixHtmlPlaceholder($r);
		}
		return $r;
	}
	
	public static function fixHtmlPlaceholder($src) {
		$tp = "/\{html:([a-zA-Z]+)\}/"; // textPattern
		$names;
		preg_match_all ( $tp, $src, $names );
		// text fix
		$names = $names [1];
		for($i = 0, $l = count ( $names ); $i < $l; $i ++) {
			$n = $names [$i];
			$v = self::getHtmlData ( $n );
			$src = preg_replace ( "/\{html:" . $n . "\}/", $v, $src );
		}
		return $src;
	}
	
	public static function getStyleData($name){
		$n = self::$webdocsPath."style/".$name.".css";
		$r = "";
		if(file_exists($n))
			$r = file_get_contents($n);
		return $r;
	}
	
	public static function getPageData($name){
		$n = self::$webdocsPath."page/$name.php";
		$r = "";
		if (file_exists ( $n )) {
			ob_start();
			include $n;
			$r = ob_get_contents();
			$r = self::fixHtmlPlaceholder($r);
			ob_end_clean();
		}
		return $r;
	}
}

?>