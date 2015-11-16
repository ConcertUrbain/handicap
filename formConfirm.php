<?php
	session_start();
	
	include("includes.php");
	
	$question = getCurrentQuestion();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

	<head>
		<title>Confirmer mon témoignage</title>
		<?php include("head.php"); ?>
    <script src="js/formConfirm.js?v=1" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="styles/formConfirm.css?v=1" />
	</head>
	
	<body>
		<div class="all" id="confirm-bubble">
			
			<?php
				displayMenuHeader($question);
				displayButton("mosaic.php?id=".$question["id"]."", "btn-close");
			?>
    
      <div id="confirm-border">
        
        <form action="formTreat.php" method="post" id="form">
          
          <div id="confirm-validation">
            <div id="confirm-valid-image" class="form-submit"></div>
            <div id="confirm-valid-description">
              <?php echo getTextToSpeech("J'autorise l'envoi de mon témoignage à l'espace de débat."); ?>
            </div>
            <div class="clear"></div>
          </div>	
          
          <div id="confirm-frame">
            
            <input type="hidden" name="send" value="1" />
                        
            <div id="confirm-cat" class="pointilles">
              <a href="#" class="confirm-cat-cell form-callValid confirm-seul-aidee" id="confirm-seul"><?php echo getTextToSpeech("Je participe seul"); ?> :</a>
              <a href="#" class="confirm-cat-cell form-callValid confirm-seul-aidee" id="confirm-aidee"><?php echo getTextToSpeech("Je suis aidé"); ?> :</a>
              <div class="clear"></div>
            </div>
          </div>
          
          <div class="confirm-rollovers">
              <div class="form-callValid confirm-rollover" id="confirm-seul-rollover">
                <a href="#">
                    <!-- <img src="" /> --> 
                </a>
                <?php echo getTextToSpeech("Je participe seul", false); ?>
              </div>
              <div class="form-callValid confirm-rollover" id="confirm-aidee-rollover">
                <a href="#">
                    <!-- <img src="" /> --> 
                </a>
                <?php echo getTextToSpeech("Je suis aidé", false); ?>
              </div>
		  </div>                        
          
          <div id="confirm-frame-bottom">
            <div id="confirm-other-btn"><?php echo getTextToSpeech("Ou bien, je suis un citoyen concerné.<br/><u>Cliquez ici pour nous en dire plus ?"); ?></u></div>
            
            <div id="confirm-form-detail">
              <div id="confirm-checkbox-label">
                <div class="confirm_cb_line"><input class="confirm_cb" name="cb-entourage" type="checkbox" /> <?php echo getTextToSpeech("Entourage (famille, aidant)"); ?></div>
                <div class="confirm_cb_line"><input class="confirm_cb" name="cb-pro" type="checkbox" /> <?php echo getTextToSpeech("Professionnel (en établissement)"); ?></div>
                <div class="confirm_cb_line"><input class="confirm_cb" name="cb-collec" type="checkbox" /> <?php echo getTextToSpeech("Collectivité publique (élu, agent)"); ?></div>
                <div class="confirm_cb_line"><input class="confirm_cb" name="cb-assoc" type="checkbox" /> <?php echo getTextToSpeech("Association sur le handicap"); ?></div>
                <div class="confirm_cb_line"><input class="confirm_cb" name="cb-autre" type="checkbox" /> <?php echo getTextToSpeech("Autre (citoyen concerné)"); ?></div>
              </div>
              
              <div id="confirm-mail"><?php echo getTextToSpeech("Courriel"); ?> : <input type="text" name="email" size="40" /></div>
              
              <a href="#" id="confirm-submit" class="form-callValid"><?php echo getTextToSpeech("SUITE"); ?> &gt;</a>
              <div class="clear"></div>
            </div>
            
          </div>
          
        </form>
        
      </div>
		</div>
		
		<?php include("analytics.php"); ?>
		<div id="text-to-speech-toggle"></div>
	</body>
</html>
