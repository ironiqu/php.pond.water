<?php

//get PetTypeList
$p = array (
		array (
				"img" => "noimg.png",
				"name" => "トイプードル",
				"anchor" => "001" 
		),
		array (
				"img" => "noimg.png",
				"name" => "トイプードルトイプードルトイプードルトイプードルトイプードルトイプードルトイプードルトイプードルトイプードルトイプードル",
				"anchor" => "001" 
		),
		array (
				"img" => "noimg.png",
				"name" => "トイプードル",
				"anchor" => "001" 
		),
		array (
				"img" => "noimg.png",
				"name" => "トイプードル",
				"anchor" => "001" 
		),
		array (
				"img" => "noimg.png",
				"name" => "トイプードル",
				"anchor" => "001" 
		) 
);



$elem = <<<"EOE"
<a title=":name" href="../pet/?pti=:anchor"><div class="viewPetElement">
	<div class="viewPetImage">
		<img src="../data/image/:img">
	</div>
	<p class="viewPetName">:name</p>
</div></a>
EOE;

$output = "";
for($i = 0, $l = count($p); $i < $l; $i++){
	$e = preg_replace ( "/:name/", $p[$i]["name"], $elem);
	$e = preg_replace ( "/:anchor/", $p[$i]["anchor"], $e);
	$output .= preg_replace ( "/:img/", $p[$i]["img"], $e);
}
?>


<div>
	<div class="viewListPetBox">
		<div class="viewListTitle">
			<img alt="いろいろなペット" src="{ex:imgPath}i2.png">
		</div>
		<?php echo $output; ?>
	</div>
	<div class="uiFloatClear"></div>
</div>
