<?php
	/*
    L'ensemble des fonctions qui font le liens avec la base de donnée
  */
	function api__connect() {
		global $client;

		$client = TourATour_Client::getInstance()->init($_ENV['SERVICE_URL'], $_ENV['API_KEY']);
		$client->connect($_ENV['USER'], $_ENV['PASS']); // id=212

		return $client;
	}

	function api__getQuery($qId){
		$queries = api__getQueries();
		for($i = 0; $i < count($queries); $i++){
			if(intval($queries[$i]["id"]) == $qId) return $queries[$i];
		}
		return null;
	}

	function api__getQueries() {
		global $client;
		return $client->queriesService->getQueries();
	}

	function api__getItems($queryId) {
		global $client;
		return $client->itemsService->getItemsByQueryId($queryId);
	}

	function api__getCurrentUserId() {
		return 212;
	}

	function api__getMedia($itemId) {
		global $client;
		$media = $client->mediasService-> getMediasByItemId($itemId);

		//structure de dingue ? ARRAY(ARRAY(params)) ????
		if ($media["Pïcture"])	$media = $media["Picture"][0];
		//print_r($media);
		return $media;
	}

	function api__getMediaUrl($itemId) {
		global $client;

		$media = $client->mediasService-> getMediasByItemId($itemId);

		if (isset($media["Picture"]))	return $media["Picture"][0]->url;
		if (isset($media["Video"]))	return $media["Video"][0]->url;
		if (isset($media["Sound"]))	return $media["Sound"][0]->url;

	}

	function api__getAllItems() {
		$items = array();
		foreach(api__getQueries() as $q) {
			$list = api__getItems($q->id);
			//echo "<br />question#".$q->id." as ".count($list)." items";
			foreach($list as $item) {
				$items[] = $item;
			}
		}
		return $items;
	}

	function api__getComments($itemId) {
		global $client;
		$comments = $client->commentsService-> getCommentsByItemId($itemId);
		return $comments;
	}

	function api__getVotes($itemId) {
		global $client;
		return $client->itemsService-> getRateOfItem($itemId);
	}

	function api__getDatas($itemId) {
		global $client;
		return $client->datasService-> getDatasByItemId($itemId);
	}

	function api__vote($itemId, $voteRate) {
		global $client;
		/*
		$comment = new Vo_Comment();
		$comment->content = "vote pour l'item ".$itemId;

		$commentId = $client->commentsService-> addComment($comment);
		$comment->id = $commentId;

		$client->itemsService->addCommentIntoItem($comment, $itemId);
		$client->commentsService-> addVoteIntoItemPatch($vote, api__getCurrentUserId(), $comment->id);
		*/

		$vote = new Vo_Data_Vote();
		$vote-> rate = $voteRate;
		$vote-> user = api__getCurrentUserId();

		$voteId = $client->itemsService-> addDataIntoVo($vote, $itemId);
		return $voteId;
	}

	function api__addComment($itemId, $content){
		$comment = new Vo_Comment();
		$comment->content = $content;
		$comment->isValid = true;

		global $client;
		$data = $client->itemsService->addCommentIntoItem($comment, $itemId);
		return $data;
	}

	function api__getMetas($obj){
		$class = get_class($obj);
		$temp = explode("_", $class);
		$class = $temp[1];

		global $client;
		$response = $client->searchService->getMetasByVo($obj->id, $class);

		if(count($response) > 0)	return $response;
		return null;
	}

	function api__addItemMetas($itemId, $metas){
		//echo "item id : ".$itemId;

		global $client;

		foreach($metas as $key => $value){
			$meta = new Vo_Meta();
			$meta->name = $key;
			$meta->content = $value;

			//public function addMetaIntoVo( Vo_Meta $meta, $voId)
			$client->itemsService->addMetaIntoVo($meta, $itemId);
		}

	}

	function api__addItem($questionId, $title, $description, $mediaUrlId = "") {

		if ($questionId < 1)	die("addItem >> ERROR with question id = ".$questionId);

		$media = null;
		if (strlen($mediaUrlId) > 0) {

			$mediaType = explode("-", $mediaUrlId);
			$mediaType = $mediaType[2];

			switch($mediaType) {
				case "V" : $media = new Vo_Media_Video(); break;
				case "A" : $media = new Vo_Media_Sound(); break;
				case "P" : $media = new Vo_Media_Picture(); break;
			}

			if ($media == null)	die("Error, no media created");

			$media->url = $mediaUrlId;
			$media->user = api__getCurrentUserId();

			/*
			if ($media != null) {
				$media->title = $_POST["title"];
				$media->description = $_POST["description"];
			}
			*/
		}

		global $client;

		$item = new Vo_Item();
		$item->title = $title;
		$item->description = $description;
		$item->isValid = true;

		//add item to DB
		$itemId = $client->itemsService-> addItem($item);

		$item->id = $itemId;

		//associate media and item
		if($media != null)	$client->itemsService->addMediaIntoItem($media, $item->id);

		// associer l'item et la question
		$client->queriesService->addItemIntoQuery($item, $questionId);

		return $item->id;
	}

	function api__sendFormFile()
	{
		global $_FILES;
		if (!isset($_FILES))	die("ERROR >> Le formulaire n'a pas envoyé de fichier");

		if(!isset($_FILES['file']))
		{
			//echo "GLOBALS<br />";
			//print_r($GLOBALS);

			echo "FILES = ";
			print_r($_FILES);

			die('<br />[API] ERROR >> FILES var is empty');
			return;
		}

		$file = $_FILES['file'];
		$chars = str_split("abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
		$filename = '';
		for($i = 0; $i < 10; $i++)
			$filename .= $chars[rand(0, count($chars) - 1)];
		$pathinfo = pathinfo($file['name']);
		$filename .= '.' . $pathinfo['extension'];

		$pathinfo = pathinfo($_FILES['file']['tmp_name']);
		$filepath = $pathinfo['dirname'] . '/' . $filename;

		if(!move_uploaded_file($_FILES['file']['tmp_name'], $filepath))	die('ERROR >> Move Uploaded File Error ('.$_FILES['file']['tmp_name'].' , '.$filepath.')');

		$postdata = array();
		$postdata ['file'] = "@".$filepath.";type=".$_FILES['file']['type'];

		/*
		UPLOAD MEDIAArray ( [file] => @C:\wamp\tmp/DpRpCCorYw.jpg;type=image/jpeg )
		post data : 1

		Array ( [file] => @C:\wamp\tmp/GPhuZUXwWs.wav;type=audio/wav )
		post data : 1
		result id => MC-wSIIzWpy-A
		*/

		//echo "<br />post data : ".print_r($postdata);

		$response = api__sendFile($postdata);
		unlink($filepath);

		return $response;
	}

	function api__sendUrlFile($url, $type = "audio/wav"){

		$postdata = array();
		$postdata ['file'] = "@".$url.";type=".$type;

		$response = api__sendFile($postdata);
		return $response;
	}

	function api__sendFile($postdata){
		$post_url = 'http://mc.chatanoo.org/upload';
		//$post_url = 'http://ms.dring93.org/upload';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $post_url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		$response = curl_exec($ch);
		curl_close ($ch);

		return $response;
	}

?>
