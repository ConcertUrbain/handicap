<?php
	include "includes.php";
?>

<?php

	$output = array();
	$output["content"] = "";
	
	//récup l'avis
	$rate = $_POST["vote"];
	
	//récup l'id de l'item
	$itemId = $_POST["item-id"];
	//$itemId = $_POST["itemId"];
	
	$output["result"] += $itemId;
	
	//echo "RATE = ".$rate;
	//echo "ITEMID = ".$itemId;
	
	//envoi l'avis à la db
	$voteId = api__vote($itemId, $rate);
	if(USE_CACHE){
		DatabaseData::getInstance()->cache__reloadVotes($itemId);
	  	DatabaseData::cache__save();
	}
	
	//resultat
	$output = "item id : ".$itemId.", vote id : ".$voteId;
	echo JSON_encode($output);
	//displayThanks();
	
	//DatabaseData::clean();
?>