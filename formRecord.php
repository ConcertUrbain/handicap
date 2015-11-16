<?php
	include("includes.php");
	$question = getCurrentQuestion();
	
	//update
	$uploadData["question-id"] = $questionId;
	
	//reset upload informations
	$_SESSION[UPLOAD] = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <title>Enregistrer son témoignage</title>
  <?php include("head.php"); ?>
  <link rel="stylesheet" type="text/css" href="styles/formRecord.css?v=1" />
  <script type="text/javascript">
    var params = {
      menu: "true",
      allowfullscreen: "true",
      allowscriptaccess: "always",
      wmode: "transparent"
    };
    var attributes = {
      id: "recorder",
      name: "recorder"
    };
    //swfobject.embedSWF("medias/recorder.swf", "recorder", "700", "350", "9.0.0");
    swfobject.embedSWF("medias/AudioRecorder.swf", "recorder", "778", "385", "10.0.0", null, {}, params);

    function hide_menu() {
      $('#record-frame-bottom').css('visibility', 'hidden');
    }

  </script>
</head>

	<body>
    <div class="all" id="record-bubble">
      <?php displayMenuHeader($question, "Mon témoignage et mes propositions"); ?>
      <?php displayButton("mosaic.php", "btn-close"); ?>
      
      <div id="record-border">
        <div id="record-frame">
          <div id="record-flash"><div id="recorder"><a href="http://get.adobe.com/fr/flashplayer/" target="blank_page"> <img src="images/form/mike.png" /></a></div></div>
          <?php echo getTextToSpeech("Enregistrement en direct : installer micro et enceintes", false); ?>
        </div>
        <div id="record-frame-bottom">
          <div class="texte">
            <a href="formMedias.php">
            	<?php echo getTextToSpeech("Je peux aussi envoyer une photo,<br/>une vidéo ou écrire un texte."); ?> 
            </a>
          </div>
          <div class="images">
            <a href="formMedias.php">
            	<span>
            		<img src="images/form/TEM_icone_photo_1.png" />
            		<?php echo getTextToSpeech("Envoyer une photo", false); ?>
            	</span>
            	<span>
            		<img src="images/form/TEM_icone_video_1.png" />
            		<?php echo getTextToSpeech("Envoyer une vidéo", false); ?>
            	</span>
            	<span>
            		<img src="images/form/TEM_icone_texte_1.png" />
            		<?php echo getTextToSpeech("Ecrire un texte", false); ?>
            	</span>
            </a>
          </div>
          <div style="clear:both;"></div>
        </div>
      </div>
      
      
    </div>
    
    	<?php include("analytics.php"); ?>
    	<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>
