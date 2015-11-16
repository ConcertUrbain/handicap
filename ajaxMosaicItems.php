<?php
	//include all libraries
	include("includes.php");
	
	//get current question
	$question = getCurrentQuestion();
	$qstId = $question->id;
?>

<?php
	
	//ITEMS
	$data = DatabaseData::getInstance();
	$data->reload_question($qstId);
	
	//$data->display();
	
	$items = getItems($qstId);
	
	//séparation des items dans deux catégories (+ et -)
	$items_plus = array();
	$items_minus = array();
	
	foreach($items as $item) {
		if(getItemRate($item->id) >= 0)	array_push($items_plus, $item);
		else array_push($items_minus, $item);
	}
	
	//echo count($items_plus)."-".count($items_minus);
?>

	<div id="items-positive">
		<?php
			treatItemArray($items_plus);
		?>
	</div>
	
	<div id="items-negative">
		<?php
			treatItemArray($items_minus);
		?>
	</div>
	
<?php

	function treatItemArray($list){
		
		$data = DatabaseData::getInstance();
		
		$high = 0;
		$low = 0;
		
		foreach($list as $item) {
			$rate = $data->getItemVoteRate($item->id);
			if ($high == 0 || $low == 0) {
				$high = $rate;
				$low = $rate;
			}else {
				if ($rate > $high)	$high = $rate;
				if ($rate < $low)	$low = $rate;
			}
		}
		
		$gap = $high - $low;
		if ($gap == 0)	$gap = 1;
		
		$i = 0;
		foreach($list as $item) {
			
			$vote = getItemRate($item->id);
			
			//$perc = ($vote - $low) / $gap;
			
			$class = ($vote >= 0) ? "item-plus" : "item-minus";

			// Mathieu : type de media
			$class_type_media = "type-media-".getItemMediaType($item);
						
			$offset = ($vote >= 0)	? 160 : 70;
			
			if(isset($_SESSION["visited"][(int)$item->id]))	$class .= "-visited";
			
			global $question;
			
			//$position = ($offset - ($highest - $vote));
			$position = $offset - $vote * 10;
			if ($position < 30)	$position = 30;
			//$itemTitle = utf8_encode($item->title);
			$itemTitle = $item->title;
			echo "<a href=\"mosaicMedia.php?itemId=".$item->id."\" class=\"item ".$class."\" rel=\"".$class_type_media."\" ";
			
			echo "alt=\"".$itemTitle."\"";
			//echo "title=\"".$itemTitle." (vote:".$vote.")\"";
			echo "style=\"position:relative;margin-top:".$position."px;\">";
			echo getTextToSpeech($itemTitle);
			echo "</a>"; 
			
			$i++;
		}
		
	}

?>