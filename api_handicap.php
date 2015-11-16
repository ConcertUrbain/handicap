<?php
	
	/*
		Ensemble de fonctions directement utilisé par le site.
		Tout se base sur la classe Database (api_class.php) quand on utilise le cache
	*/

	function getCurrentQuestion() {
		//MANAGE QUESTION
		$questionId = -1;
		
		if (isset($_GET["id"])){
			$questionId = $_GET["id"];
		}else if ($_SESSION["questionId"]){
			$questionId = $_SESSION["questionId"];
		}else {
			
			$qsts = getQuestions();
			$questionId = $qsts[0]["id"];
			
		}
		
		if ($questionId <= 0)	die("No question selected");
		
		$_SESSION["questionId"] = $questionId;
		$question = getQuestion($questionId);
		
  	//echo $questionId;print_r($question);
		return $question;
	}
	
	function getQuestions(){
		$qsts = api__getQueries();
		$list = Array();
		for($i = 0; $i < count($qsts); $i++){
			$list[] = (array)$qsts[$i];
		}
		$qsts = $list;
		
    	if(count($qsts) < 1)  echo "Warning :: no questions returned";
		return (array)$qsts;
	}
	
	function getQuestion($id){
		$qsts = getQuestions();
		foreach($qsts as $q){if($q["id"] == $id)	return $q;}
		return null;
	}
	
  //retourne les voItems !
  function getItems($qstId) {
    $items = api__getItems($qstId);
    return $items;
  }
  
  function getItem($qstId, $itemId){
    $items = getItems($qstId);
    foreach($items as $item){
      if(is_object($item))  $item = (array)$item;
      //var_dump($item);
      if($itemId == intval($item["id"]))  return $item;
    }
    return null;
  }

  function getMosaicItems($qstId){
  	//echo "getMosaicItems()";
    $items = getItems($qstId); // filter 'more' item
    $more = getItemMore($items);
    //if(is_object($more))  $more = (Array)$more;

    if(count($items) > 0 && empty($more)){
      echo "QST ID ".$qstId." | MORE ($more) ID ".$more["item"]["id"];print_r($items);
      die("ERROR > Warning, no more item returned");
    }
    
    $list = Array();
    foreach($items as $item){
      //if(is_object($item))  $item = (Array)$item;
      //echo $item["id"].",".$more["id"];
      if($item->id != $more["id"])  $list[] = $item;
      //else echo "found item more id : ".$more["id"];
    }

    return $list;
  }

  /* Permet de récupérer l'id du média associé à une question */
  function getItemMore($items) {
    if($items == null)  return null;
    if(empty($items)) return null;

    foreach($items as $item){
      if(is_object($item)) $item = (array)$item;
      //echo $item["description"]."<br/>";
      $description = $item["description"];

      //la description a des ""
      if(strpos($description, '"') !== false)  return $item;
    }
    return null;
  }

  function getItemRate($item){
    if (is_object($item) && $item->rate) {
      return $item->rate;
    }
    if(is_object($item))  $item = (array)$item;
    $votes = api__getVotes($item["id"]);
    // echo"<br/>item ".$item["id"]."<br/>";
    return $votes;
  }

  function getItemMediaId($item){
  	if(is_object($item))	$item = (array)$item;
  	return api__getMediaUrl($item["id"]);
  }

  function getItemComments($item){
    if(is_object($item))  $item = (array)$item;
    $comments = api__getComments($item["id"]);
    $commentsOrderAsc = array();
    foreach ($comments as $comment)
    	$commentsOrderAsc[$comment->id] = $comment;
    ksort($commentsOrderAsc);
   	return $commentsOrderAsc;
  }
  
  function getMetas($item){
    //if(is_object($item))  $item = (array)$item;
    return api__getMetas($item);
  }
  
  /** 
   * Mathieu : Retourne le type d'un media d'un item
   * T = text, A = audio, P = picture, V = video
   */
  function getItemMediaType($item) {
  	$mediaType = "T";	// default
  	$mediaPath = getItemMediaId($item);
	if (strlen($mediaPath) > 1) {
		$temp = explode("-", $mediaPath);
		$mediaType = $temp[2];
	}
	return $mediaType;
  }
?>