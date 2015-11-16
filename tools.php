<?php

	require_once('user_agent_parser.php');
	
  function reloadCache(){
    ?><script language="javascript">$.ajax({url: "cache_reload.php"});</script><?php
  }
  
  $_SESSION["time"] = microtime(true);
  function displayExecTime($label = ""){
    $time = (microtime(true) - $_SESSION["time"]);
    //$time = ($_SESSION["time"] - microtime());
    echo "<br />".$label." | It took ".$time." sec";
  }
  
	function displayIpadLayer() {
		echo "<div id=\"ipad-layer\"><div id=\"ipad-cover\"></div></div>";
	}
	
	function addLoadingLayer() {
		echo "<div id=\"loading-layer\"><img src=\"images/loader_02.gif\" /></div>";
	}

	function isUsingFirefox() {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		return strpos($useragent,"Firefox") !== false;
	}
	
	function isUsingIE(){
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		return strpos($useragent,"MSIE") !== false;
	}
	
	function isUsingChrome(){
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		return strpos($useragent,"Safari") !== false;
	}
	
	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		
		$pageURL .= "://";
		
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
  /* génère une id uniq de la back office */
	function getUniqFileName(){
		$chars = str_split("abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
		$filename = "";
		for($i = 0; $i < 10; $i++)
			$filename .= $chars[rand(0, count($chars) - 1)];
		return $filename;
	}
	
	function includeRecurse($dirName) { 
		if(!is_dir($dirName)) 
			return false; 
		$dirHandle = opendir($dirName); 
		$incFiles = array();
		while(false !== ($incFile = readdir($dirHandle))) {
			$incFiles[] = $incFile;
		}
		asort($incFiles);
		foreach ($incFiles as $incFile) {
			if($incFile != "." 
			   && $incFile != "..") { 
				if(is_file("$dirName/$incFile")) 
					include_once("$dirName/$incFile"); 
				elseif(is_dir("$dirName/$incFile")) 
					includeRecurse("$dirName/$incFile"); 
			} 
		} 
		closedir($dirHandle); 
	} 
	
	/* dimensions doit etre une string au format WIDTHxHEIGHT */
	function addApiImage($id, $dimensions = null) {

		$path = MEDIA_PATH.$id.".jpg";
		
		//récup une lib du web pour manipuler en proportionnel !
		$dim = getimagesize($path);
		$width = $dim[0];
		$height = $dim[1];
		
		//echo $width.",".$height;
		
		$maxWidth = 600;
		$maxHeight = 300;
		
		if ($height > $maxHeight) {
			$width = ($maxHeight / $height) * $width;
			$height = $maxHeight;
		}
		
		if ($width > $maxWidth) {
			$height = ($maxWidth / $width) * $height;
			$width = $maxWidth;
		}
		
		echo "<img src=\"".$path."\" width=\"".$width."\" height=\"".$height."\" />";
		
		//echo $width.",".$height;
	}
	
	function addSound($path) {
	
		$autoplay = "";
		if(_USE_AUTOSTART_VIDEO){
			$autoplay = "autoplay=\"autoplay\"";
		}

		$ua = parse_user_agent();
		
		// if(isUsingFirefox()){
		// 	addAudioPlayer(MEDIA_PATH.$path.".mp3");
		// }else{
			?>
			
			<audio controls="controls" <?php echo $autoplay; ?>>
				
				<!-- VIDEO FORMATS -->
				<!-- <source src="<?php echo MEDIA_PATH.$path; ?>.wav" type="audio/wav" /> -->
				<?php if($ua["browser"] == 'Firefox') { ?>
					<source src="<?php echo MEDIA_PATH.$path; ?>.ogg" type="audio/ogg" />
				<?php } else { ?>
					<source src="<?php echo MEDIA_PATH.$path; ?>.mp3" type="audio/mp3" />
				<?php } ?>
				
			</audio>
			
			<?php
		// }
	}
	
	function addAudioPlayer($url){
		?>
		<!-- FLASH ALTERNATIVE -->
		<object type="application/x-shockwave-flash" data="medias/player_mp3_mini.swf" width="460" height="100">
			<param name="movie" value="medias/player_mp3_mini.swf" />
			<param name="FlashVars" value="mp3=<?php echo $url; ?>&bgcolor=FFFFFF&loadingcolor=000000&buttoncolor=000000&slidercolor=000000&autoplay=1" />
		</object>
		<?php
	}
	
	function addApiSound($id) {
		addSound($id);
	}
	
	
	/** Ancienne version FLASH
	 * Mathieu : remplacé par version au dessous (HTML5)
	 */
	/* function addApiVideo($id, $autoPlay = true, $elementName = null, $img_preview = null, $width = 576, $height = 324){
		
		$autoPlayInfo = "false";
		
		if(!$autoPlay)
		{
		  $autoPlayInfo = "false";
		}
		else if(_USE_AUTOSTART_VIDEO)
		{
		  $autoPlayInfo = "true";
		}
			
		// On peut passer l'id de l'élément div où est intégrée la video (par défaut : elementName = #videoHtml5)
		if ($elementName == null) $elementName = "videoHtml5";
			
		// On peut passer à la fonction une image de preview si celle du MediaCenter ne convient pas
		if ($img_preview == null) $img_preview = MEDIA_PATH."preview/".$id.".jpg";
			
		$path = MEDIA_PATH. '576x324/' .$id;
				
		$autoPlayInfo = "";
		if($autoPlay)
		{
		  $autoPlayInfo = "autoplay";
		}


		$ua = parse_user_agent();

		/*

			<?php if($ua["browser"] == 'Firefox') { ?>
				<source type='video/ogg; codecs="theora, vorbis"' src="<?php echo $path; ?>.ogv" />
			<?php } elseif($ua["browser"] == 'Chrome') { ?>
				<source type='video/webm; codecs="vp8.0, vorbis"' src="<?php echo $path; ?>.webm" />
			<?php } else { ?>
				<source type='video/mp4' src="<?php echo $path; ?>.mp4" />
			<?php } ?>
			
		* /

		//MEDIA ELEMENTS
		/*
    <video width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="videoPlayer" id="<?php echo $elementName; ?>" poster="<?php echo $img_preview; ?>" controls="controls" <?php echo $autoPlayInfo; ?> preload="none">

    	<source type='video/ogg;' src="<?php echo $path; ?>.ogv" />
			<source type='video/webm;' src="<?php echo $path; ?>.webm" />
			<source type='video/mp4' src="<?php echo $path; ?>.mp4" />
			
      <!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
      <object width="<?php echo $width; ?>" height="<?php echo $height; ?>" type="application/x-shockwave-flash" data="js/mediaelement/flashmediaelement.swf"> 		
        <param name="movie" value="js/mediaelement/flashmediaelement.swf" /> 
        <param name="flashvars" value="controls=true&amp;file=<?php echo $path; ?>.mp4" /> 		
        <!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
        <img src="<?php echo $img_preview; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="" title="No video playback capabilities" />
      </object> 	
    </video>
		* /

    /*
	<video width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="videoPlayer" id="<?php echo $elementName; ?>" controls>
  	<source type='video/mp4' src="<?php echo $path; ?>.mp4" />
  	<source type='video/ogg' src="<?php echo $path; ?>.ogv" />
		<source type='video/webm' src="<?php echo $path; ?>.webm" />
  </video>
    * /

  /*
  <video width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="videoPlayer" id="<?php echo $elementName; ?>" 
  		 poster="<?php echo $img_preview; ?>" controls="controls" <?php echo $autoPlayInfo; ?> preload="none">
         
        <source type='video/ogg;' src="<?php echo $path; ?>.ogv" />
        <source type='video/webm;' src="<?php echo $path; ?>.webm" />
        <source type='video/flv' src="<?php echo $path; ?>.flv" />
        <source type='video/mp4' src="<?php echo $path; ?>.mp4" />
        
        <!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
        <object width="<?php echo $width; ?>" height="<?php echo $height; ?>" type="application/x-shockwave-flash" data="js/mediaelement/flashmediaelement.swf"> 		
            <param name="movie" value="js/mediaelement/flashmediaelement.swf" /> 
            <param name="flashvars" value="controls=true&amp;file=<?php echo $path; ?>.flv" /> 		
            <!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
            <img src="<?php echo $img_preview; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="" title="No video playback capabilities" />
        </object>
    </video>
  * /

	$swfPath = "http://flv-player.net/medias/player_flv_maxi.swf";
	$flvPath = "flv=".$path.".flv&amp;startimage=".$img_preview."&amp;autoload=1"."&amp;autoplay=". ($autoPlayInfo ? 1 : 0);
?>

	<!--[if IE]>
	  <object id="videoFrame" width="<?php echo $width; ?>" height="<?php echo $height; ?>"
	    classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
	  <param name="movie" value="player_flv_maxi.swf">
	<![endif]-->

	<!--[if !IE]>-->
	<object id="videoFrame" width="<?php echo $width; ?>" height="<?php echo $height; ?>"
	        data="<?php echo $swfPath; ?>"
	        type="application/x-shockwave-flash">
	<!--<![endif]-->
	  <param name="flashvars" value="<?php echo $flvPath; ?>" />
	  <p>Fallback content for people without Flash Player</p>
	</object>
	
	<script>
   
		var v = $("#<?php echo $elementName; ?>");
		v = v.get(0);
		if(v != null){
			console.log("src : "+v.src);
			v.addEventListener('loadeddata', function(){ console.log("video is playing path : "+v.src); });
			v.addEventListener('error', function(e){ 
			console.log("video error event (path selected : "+v.src+")"); 
			console.log((e.target.error.code == e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED) ? "video format not compatible" : e.target.error.code);
		  });
		}
		
		var USE_MEDIA_ELEMENT = false;
		
		if (USE_MEDIA_ELEMENT){
			
			var autoPlayInfoJS = "<?php echo $autoPlayInfo; ?>";
			var isAutoPlay = (autoPlayInfoJS == "autoplay");
			var t = this;
			
			var success =  function(mediaElement, domObject)
			{
				if(mediaElement == null)	return;
						//mediaElement.currentTime = 0;
					
				if ((isAutoPlay == true) && (mediaElement.pluginType == 'flash')) {
					// Fin du chargement de la vidéo
					mediaElement.addEventListener('canplay', function() {
						mediaElement.play();
					}, false);
				}
			
				// Fin de la vidéo
				mediaElement.addEventListener('ended', function(e) { if (t.videoEnded) t.videoEnded("<?php echo $path; ?>"); }, false);
			}
"
			$('#<?php echo $elementName; ?>').mediaelementplayer( { mode:''auto_plugin', features: ['playpause','progress','current','duration','tracks','volume','fullscreen'], success:success } );
		}
    </script>
    <?php
	}*/
	
	
	
	/** Mathieu : Nouvelle version HTML5
	 * Ancienne version FLASH au dessus*/
	function addApiVideo($id, $autoPlay = true, $elementName = null, $img_preview = null, $width = 576, $height = 324){
		$path = MEDIA_PATH. '576x324/' .$id;
		//$path = MEDIA_PATH. '720x405' .$id;
		if ($img_preview == null) $img_preview = MEDIA_PATH."preview/".$id.".jpg";
		?>
		<video id="videoHTML5" width="576" height="324" controls="controls" preload="auto" <?php echo $autoPlay?"autoplay":"";?> name="<?php echo $elementName;?>" poster="<?php echo $img_preview; ?>"> 
			<source src="<?php echo $path;?>.mp4" type="video/mp4" />
			<source src="<?php echo $path;?>.webm" type="video/webm" />
			<source src="<?php echo $path;?>.ogv" type="video/ogg" />
			<!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
	        <object width="<?php echo $width; ?>" height="<?php echo $height; ?>" type="application/x-shockwave-flash" data="js/mediaelement/flashmediaelement.swf"> 		
	            <param name="movie" value="js/mediaelement/flashmediaelement.swf" /> 
	            <param name="flashvars" value="controls=true&amp;file=<?php echo $path; ?>.flv" /> 		
	            <!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
	            <img src="<?php echo $img_preview; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="" title="No video playback capabilities" />
	        </object>
		</video>
	    <?php
	}
	
	
	function getURL() {
		$pageURL = 'http';
		
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function getPageURL(){
		$url = getURL();
		$temp = explode("handicap/", $url);
		return $temp[1];
	}
  
	function displayTopMenuHeader($question, $itemTitle) {
		?>
		<div id="top-menu">
      <a href="mosaic.php?id=<?php echo $question["id"]; ?>" class="question-number-container icone-menu-mosaic selected"><img class="question-number" src="images/question_icons/qst-<?php echo $question["id"]; ?>.png" /></a>
			<div class="question-top-title"><?php if (strlen($itemTitle) > 0) echo getTextToSpeech($itemTitle); ?></div>
			<div class="clear"></div>
		</div>
		<?php
	}

	function displayMenuHeader($question, $itemTitle = "", $page = 0) {
		?>
		<div id="menu-record">
      <a href="mosaic.php?id=<?php echo $question["id"]; ?>&page=<?php echo $page; ?>" class="question-number-container icone-menu-mosaic selected">
      		<img class="question-number" src="images/question_icons/qst-<?php echo $question["id"]; ?>.png" />
      		<?php echo getTextToSpeech($question["content"], false); ?>
      	</a>
			<div class="question-top-title"><?php if (strlen($itemTitle) > 0) echo getTextToSpeech($itemTitle); ?></div>
			<div class="clear"></div>
		</div>
		<?php
	}
	
	function displayThanks($label = ""){
		$output = "Merci de votre participation !";
		if(strlen($label) > 0)	$output = $label;
			echo "<div id=\"bubble-thanks-frame\"><div id=\"bubble-thanks\">".getTextToSpeech($output)."</div></div>";
	}
	
	function displayError($content) {
		die("Erreur >> ".$content." (<a href=\"index.php\">Retour à l'index</a>)");
	}
	
	function displayButton($url, $class, $text = "retour") {
		echo "<div class=\"btn\" id=\"$class\">";
		
		//vire l'action
		$class = explode("-action", $class);
		$class = $class[0];
		
    $imgPath = "images/";
    if(strpos($class, "btn-close") > -1){
      $imgPath .= "btn-close";
    }else{
      $imgPath .= $class;
    }
    
		echo "<a id=\"btn-link\" href=\"".$url."\"><img src=\"$imgPath.png\" /><div id=\"btn-text\">".getTextToSpeech($text)."</div></a>";
		echo "</div>";
	}
	
	function redirect($url) {
		echo "<script>document.location.href= \"".$url."\";</script>";
	}
	
	function redirectJs($url, $delay = 1000) {
		?>
		<script>
			setTimeout("window.location='<?php echo $url; ?>'", <?php echo $delay; ?>);
		</script>
		<?php
	}
	
	function clearMem(){
		unset($_SESSION[API_ID]);
		DatabaseData::clean();
	}
	
	function createParam($obj){
		return serialize($obj);
	}
	
	function removeEmpty($obj) {
		$new = array();
		foreach($obj as $key => $value) {
			if(!empty($value))	$new[$key] = $value;
		}
		return $new;
	}
	
	function cleanObject($obj) {
		
		if (!empty($obj)) {
			
			$new = array();
			$keepPrevious = array("__className");
			$listIgnore = array("id", "addDate", "setDate", "_isBan", "password");
			
			foreach($obj as $key => $value) {
				if (!in_array($key, $listIgnore)) {
					$new[$key] = "";
					if(in_array($key, $keepPrevious))	$new[$key] = $value;
				}
			}
			
			return $new;
		}
		
		echo "<br />Tools::cleanObject error, no object";
		return null;
	}
	
	function getDatabaseDate() {
		return Date("Y-m-d H:i:s");
	}
	
	function addDates($obj) {
		$obj["addDate"] = getDatabaseDate();
		$obj["setDate"] = getDatabaseDate();
	}
	
	function cleanParam($param, $char = "#") {
		
		$stripped = array();
		foreach($param as $key => $info) {
			//skip $char keys
			if (strpos($key, $char) === false) {
				$stripped[$key] = $info;
				//if (strlen($info) < 1)	$stripped[$key] = null; // comme l'api flash
			}
		}
		
		return $stripped;
	}
	
	function cleanAll($param) {
		$param = cleanParam($param, "~");
		$param = cleanParam($param, "#");
		return $param;
	}
	
	function cURLScript() {

		if(!isset($_FILES['file']))
		{
			print('No File Error');
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
		
		if(!move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) 
			print('Move Uploaded File Error');
		
		$postdata = array();
		$postdata ['file'] = "@".$filepath.";type=".$_FILES['file']['type'];
		
		$post_url = 'http://ms.dring93.org/upload';
		
		print_r($file);
		
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
		
		unlink($filepath);
		
		return $response;
	}
	

	
	/**
	 * Mathieu
	 * Fonction qui prend les n premiers carractères d'un texte et coupent proprement selon les mots
	 * @param string $text
	 * @param int $nbCarMax
	 */
	function smartSplitText($text, $nbCarMax) {
		if (strlen($text) > $nbCarMax) {
			$text = substr($text, 0, $nbCarMax);
			$lastSpace = strrpos($text, " ");
			$text = substr($text, 0, $lastSpace);
		}
		return $text;
	}
	
	
	
	/**
	 * Mathieu
	 * Génère la synthèse vocale via google
	 * Ou la récupère depuis notre cache si elle y est déjà
	 * http://translate.google.com/translate_tts?ie=utf-8&tl=fr&q=...
	 * @param string $text
	 * @return string $mp3Path
	 */
	function getSpeechFromString($text) {
		$text = html_entity_decode(strip_tags($text));
		$sansAccent = array("idee", "demarches", "ecouter", "ecrire");
		$avecAccent = array("idée", "démarche", "écouter", "écrire");
		$text = str_ireplace($sansAccent, $avecAccent, $text);
		$key = sha1($text);
		$mp3Path = "cacheTextToSpeech".DIRECTORY_SEPARATOR.$key.".mp3";
		// si une seule requete google
		if (strlen($text) <= 100) {
			if (!file_exists($mp3Path)) {
				$url = "http://translate.google.com/translate_tts?ie=utf-8&tl=fr&q=".urlencode($text);
				$mp3data = file_get_contents($url);
				file_put_contents($mp3Path, $mp3data);
			}
		}
		// si obligé de couper en plusieurs requêtes
		else {
			// génération de la liste des mp3
			$mp3Parts = array();
			$i = 0;
			do {
				$i++;
				$textPart = smartSplitText($text, 100);
				$keyPart = sha1($textPart);
				$mp3Parts[$keyPart] = getSpeechFromString($textPart);
				$text = substr($text, strlen($textPart), strlen($text) - strlen($textPart));
			} while (trim($text) != "" && $i<10);
			// assemblage de la liste des MP3
			$mp3 = new mp3();
			foreach ($mp3Parts as $keyPart => $mp3Part) {
				$mp3->mergeBehind(new mp3($mp3Part));
			}
			file_put_contents($mp3Path, $mp3->str);
		}
		return $mp3Path;
	}
	
	
	
	/**
	 * Mathieu
	 * Retourne texte avec player audio pour la synthèse vocale 
	 * @param string $text
	 * @param bool $addText
	 * @param string $audioFile
	 * @param bool $forcePlay
	 * @return string $html
	 */
	function getTextToSpeech($text, $addText = true, $audioFile = "", $forcePlay = false) {
		if ($audioFile == "")
			$audioFile = getSpeechFromString($text);
		$html = '<audio class="text-to-speech '.($forcePlay ? 'force-play' : '').'" src="'.$audioFile.'" id="'.sha1($text).'"></audio>';
		if ($addText)
			$html .= $text;
		return $html;
	}
?>