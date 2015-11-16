<?php

	$string = "Si quelqu&#039;un t&#039;emb&ecirc;tes dis lui : stop, arr&ecirc;te et pr&eacute;viens ton &eacute;ducateur!";
	$output = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $string); 
	echo html_entity_decode($output);
?>
