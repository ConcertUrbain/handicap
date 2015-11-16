<div id="menu">

  <div id="debat" class="pres-link question-number-container" alt="pres-questions">
   	<a class="menu-presentation" href="?cat=presentation-debat">
   		<span class="menu-debat-rollover">
   			<?php echo getTextToSpeech("les autres questions"); ?>
   		</span>
   	</a>
  </div>

  <div id="intro" class="pres-link question-number-container" alt="pres-intro">
  	<a href="aide.php">
  		<?php echo getTextToSpeech("Aide"); ?>
    </a>
  </div>
  
  <div class="clear"></div>
	
	<div id="menu-popup-border">
		<div id="menu-popup"></div>
	</div>
	
</div>

<div id="mosaic">

	<?php
		//print_r($_SESSION["visited"]);
		
		$moreAlt = "en savoir plus sur la question";
		$moreUrl = "mosaicQuestion.php";
		$label = $question["content"];

		$itemId = -1;

		if (isset($_GET['page']))
		{
			$pageCourante = addslashes($_GET['page']);
		}
		else
		{
			$pageCourante = 0;
		}
  ?>
  
  <?php

		$DIRECT_LOAD = true;
		
		if ($DIRECT_LOAD) {
			//ITEMS
			
			//$data->reload_question($qstId);
			//echo "QUESTION ID ? ".$qstId;
			
			// $items = getMosaicItems($qstId);
			
			$question = getCurrentQuestion();
			$qstId = $question["id"];
			$items = getMosaicItems($qstId);
			
			//s"paration des items dans deux cat"gories (+ et -)
			$items_plus = array();
			$items_minus = array();
			
			foreach($items as $item) {
				
				if(!$item->isValid)
				continue;
				
				if(getItemRate($item) >= 0)	array_push($items_plus, $item);
				else array_push($items_minus, $item);
			}
			
      		//echo "PLUS =".count($items_plus);echo "MINUS =".count($items_minus);
		}
  ?>
		
		<div id="items-frame-border">
			<div id="items-frame">
				
				<!-- REPLACED BY AJAX -->
				<div id="items-positive">
        	<div style="position:relative"><?php if($DIRECT_LOAD) $noPageMaxPlus = treatItemArray($items_plus, $pageCourante); ?></div>
				</div>
				
				<div id="items-negative">
          <div style="position:relative"><?php if($DIRECT_LOAD) $noPageMaxMinus = treatItemArray($items_minus, $pageCourante); ?></div>
				</div>
				<!-- ### -->
				
			</div>
		</div>
            
    <?php
		
      $nbPages = max($noPageMaxPlus, $noPageMaxMinus) + 1;
	  
// Benoit : Test cas enregistrement temoignage
		if (isset($_GET["itemId"]))
		{
			$pageCourante = $nbPages -1;
		}
		else if(isset($_SERVER['HTTP_REFERER']))
		{
			$caller = $_SERVER['HTTP_REFERER'];
			if (strpos(basename($caller), "formRecord.php") !== FALSE)
			{
				$pageCourante = $nbPages -1;
			}
		}
//Fin test Benoit

      if ($nbPages > 1)
      {
      $divNoPages = "";
      for ($i = 0; $i < $nbPages; $i++) {
        $no = $i + 1;
        $classNoPageActive = $i == $pageCourante ? "nopage_actif" : "";
        $divNoPages .= '<span id="nopage' . $i . '" class="nopage ' . $classNoPageActive . '" ><a href="#">' . getTextToSpeech((($classNoPageActive) ? ("Vous êtes sur la page "):(" page ")).$no, false) . $no . '</a>'.($i+1 < $nbPages ? "...." : "").'</span>';
      }

    ?>

    <div id="items_navigation_pagination">
      <div id="items_navigation_precedent_suite">
        <span id="pagePrecedente"><a href="#"><img src="images/mosaic/previous.png" /></a><?php echo getTextToSpeech("Page précédente", false);?></span>
        <span id="nopages"><?php echo $divNoPages; ?></span>
        <span id="pageSuivante"><a href="#"><img src="images/mosaic/next.png" /></a><?php echo getTextToSpeech("Page suivante", false);?></span>
        <span id="legende" class="page0" data-id="<?php echo $nbPages ?>"></span>
      </div>
    </div>

<?php
  }
?>

  <!-- CADRE BLANC CENTRE PAGE QUESTION -->
  <a class="cursor" id="question-frame" href="<?php echo $moreUrl."?id=".$question["id"]; ?>">
    <img id="question-icon" class="question-icon-<?php echo $question["id"]; ?>" src='images/question_icons/qst-<?php echo $question["id"]; ?>.png' />
    <div id="question-label" title="<?php echo $moreAlt; ?>">
      <?php echo getTextToSpeech($label); ?>
    </div>
    <div class="clear"></div>
  </a>
	
<?php
// BENOIT -> CLOTURE PLATEFORME
/*
  <a id="plus-add" href="formRecord.php?qstId=<?php echo $qstId; ?>" title="je témoigne, je propose">
  	<?php echo getTextToSpeech("je témoigne, je propose", false); ?>
  </a>
  */
?>
	<!-- popups resources -->
	<div class="popup-border">
		<div class="popup">Nadia : Les transports sont dangereux.</div>
	</div>
  
	<div id="popup-question">
        <!--
        <div id="popup-question-val"></div>
        <div id="popup-question-media" style="background-image:url('images/question_makatons/qst-<?php echo $qstId; ?>.jpg');"></div>
        -->
        <div id="popup-question-talker"><a class="cursor" href="<?php echo $moreUrl."?id=".$question["id"]; ?>"></a></div>
    	<div class="clear"></div>
  </div>
  
  <!-- POPUP TOOL -->
  <div id="popup-info"></div>
  
</div>




<?php
	
	function treatItemArray($list, $pageCourante){
    
		$high = 0;
		$low = 0;
		
    for($i = 0; $i < count($list); $i++){
      $item = $list[$i];
			$rate = getItemRate($item);
      
      $list[$i]->rate = $rate;
      
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
		$left = 0;
		$pageNo = 0;
		
		// Nombre de témoignages par page (en X)
		$nbTemoignagesMax = 22;
		
		// Benoit (affichage dernier item créé - via itemId s'il était présent, mais juste le dernier de la liste puisqu'on ne peut actuellement pas le récupérer en sortant de l'enregistrement)
		$sizeList = sizeof($list);
		$itemNew = false;
		
		if (isset($_GET["itemId"]))
		{
			$itemId = $_GET["itemId"];
			$pageCourante = floor($sizeList / $nbTemoignagesMax);
		}
		else if(isset($_SERVER['HTTP_REFERER']))
		{
			$caller = $_SERVER['HTTP_REFERER'];
			if (strpos(basename($caller), "formRecord.php") !== FALSE)
			{
				$itemNew = true;
				$pageCourante = floor($sizeList / $nbTemoignagesMax);
			}
		}
		// Fin traitement Benoit
	
		foreach($list as $item) {
			
			// PAGE :
			
			$pageNo = floor($i / $nbTemoignagesMax);
			
			
			// LEFT : (on repart à x = 0 à chaque page)
			
			$left = ($i % $nbTemoignagesMax) * 35;

			
			// TOP : (on place le plus près du centre vertical, et on retire un nombre de pixels par vote)
			
			$vote = $item->rate;
			
			$limit = 10; // limit haute et basse du nombre de vote qui amène le pouce au bord

			// Pour tester les positions minimales
			//$vote = ($vote >= 0)	? 0 : -1;

			// Pour tester les positions extremes
			//$vote = ($vote >= 0)	? $limit : -$limit;


			//$perc = ($vote - $low) / $gap;
			
			$class = ($vote >= 0) ? "item-plus" : "item-minus";

			// Mathieu : type de media
			$class_type_media = "type-media-".getItemMediaType($item);
			
  			// 140 : 70 rapproche les pouces du centre, 200 : 100 éloigne les pouces du centre
			$offset = ($vote >= 0)	? 170 : 20; // 0 c'est soit le top de la zone verte, soit le top de la zone rouge en fonction du Math.abs()
			
			if(isset($_SESSION["visited"][(int)$item->id]))
				$class .= "-visited";
			
			// Benoit (affichage dernier item créé - via itemId s'il était présent, mais juste le dernier de la liste puisqu'on ne peut actuellement pas le récupérer en sortant de l'enregistrement)
			else if(isset($itemId) && $item->id === $itemId)
			{
				if($vote >= 0)
					$class .= "-new";
			}
			else if($itemNew === true)
			{
				if($vote >= 0)
					if($i === $sizeList - 1)
						$class .= "-new";
			}
			
			//$position = ($offset - ($highest - $vote));
			
			// RQ DENIS : les placements en Y n'étant pas proportionnels (?), on limite le vote pour le calcul de la position en Y...
      			$sign = ($vote >= 0) ? 1 : -1;
			if ($vote > $limit * $sign) $vote = $limit * $sign; // position maximum en hauteur

			$position = $offset - ($vote * 14);
			
			// ??? if ($position < 40)	$position = 40; // position maximum en hauteur
			
			//$itemTitle = utf8_encode($item->title);
			
			// On masque les pages suivantes
			$displayClass = $pageNo != $pageCourante ? "item_hidden" : "";
		
			$itemTitle = $item->title;
			echo '<a href="mosaicMedia.php?itemId='.$item->id.'&page='.$pageNo.'" class="' . $displayClass .  ' item ' . $class . ' page'. $pageNo . '" rel="'.$class_type_media.'"';
			
      		// Titre du témoignage pour la bulle de mouse hover
			if(strlen($itemTitle) > 0) echo ' alt="'.$itemTitle.'"';

			//echo "title=\"".$itemTitle." (vote:".$vote.")\"";
			echo ' style="position:absolute;left:'.$left.'px;top:'.$position.'px;" rel="position:'.$position.', vote:'.$vote.'">';
			echo getTextToSpeech($itemTitle);
			echo '</a>'; 
			
			$i++;
		}
		
		return $pageNo;
	}
	
?>
