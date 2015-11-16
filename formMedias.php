<?php
	include("includes.php");
	
	$question = getCurrentQuestion();
	$questionId = $question->id;
	
	//update
	$uploadData["question-id"] = $questionId;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

	<head>
		<title>Ajouter un témoignage</title>
		<?php include("head.php"); ?>
    <link rel="stylesheet" type="text/css" href="styles/formMedias.css?v=1" />
    <script src="js/formMedias.js?v=1" type="text/javascript"></script>
	</head>
	
	<body>
		
		<div id="loading-border">
			<div id="loading">Envoi du fichier. Veuillez patienter.<br /><br /><img id="loader-img" src="../images/loader.gif"/></div>
		</div>
		
		<div class="all" id="all-temoin">
			
			<?php displayMenuHeader($question, "J'envoie un t&eacute;moignage"); ?>
			
			<?php displayButton("mosaic.php", "btn-close"); ?>
			
		<div class="bubble media-frame-border-popup" id="media-frame-border" >
				<div id="media-frame" class="media-frame-form-medias">
					
					<?php
						$text = array("label" => "envoyer un texte");
						
						$formats = array(
							"photo" => array("label" => "envoyer une image (jpg, png)"),
							"sound" => array("label" => "envoyer un son (wav, mp3)"),
							"movie" => array("label" => "envoyer une vid&eacute;o (mov, mp4, 3gp)"),
							"text" => $text
						);
					?>
					
					<form id="formMedia" method="POST" action="upload.php" enctype="multipart/form-data">
						
						<!-- input type="hidden" name="nextPage" value="formConfirm.php" / -->
						
                        <input type="hidden" name="nextPage" value="formTreat.php" />
                        
                        <input type="hidden" name="send" value="1" />                        
						
						<div id="form-list">
							
							<?php if (isUsingIE()) { ?>
								
								<div class="form-line-upload">
									<input type="file" name="file" class="file" />
									
									<?php
									foreach($formats as $key => $value) {
										$label =  $value["label"];
										if(!strstr($label, "texte")){
											
											?>
											
											<div class="form_line">
												<div class="form-replace">
													<div class="form-line-img" style="background:url('../images/form/<?php echo $key; ?>.png');"></div>
													<div class="form-line-label"><?php echo getTextToSpeech($label); ?></div>
													<div class="clear"></div>
												</div>
											</div>
											
											<div id="form-separator"></div>
											<?php
										}
										
									}
								?>
                  
								</div>
                
                <div id="form-separator"></div>
                <div class="form_line">
                  <div  class="form-replace">
                    <div class="form-line-img" style="background:url('../images/form/text.png');"></div>
                    <div class="form-line-label"><?php echo $text["label"]; ?></div>
                    <div class="clear"></div>
                  </div>
                </div>
                
								<?php
								
							} else {
								
								?>
								
								<input name="file" class="file" type="file" />
								
								<?php
									foreach($formats as $key => $value){
										?>
										
										<div class="form_line">
											<div class="form-line-img" style="background:url('../images/form/<?php echo $key; ?>.png');"></div>
											<div class="form-line-label"><?php echo getTextToSpeech($value["label"]); ?></div>
											<div class="clear"></div>
										</div>
										
										<?php
										if ($key != "text"){
											print '<div id="form-separator"></div>';
										}
									}
								?>
								
								
							<?php } ?>
							
							<!--<input id="form-submit" type="submit" value="Envoyer" />-->
							
						</div>
						
						<div id="form-text">
							<div id="form-text-title"><?php echo getTextToSpeech("Témoignage"); ?> : </div>
							<textarea type="text" id="from-textarea" name="temoin-text"></textarea>
							<input id="form-text-input" type="submit" value="Envoyer" />
						</div>
						
					</form>
					
				</div>
				
                <div id="form-note"><?php echo getTextToSpeech("Note : ne doit pas peser plus de 20 Mo (20 méga-octets)."); ?></div>
                
			</div>
			<div class="clear"></div>
		</div>
		
		<?php include("analytics.php"); ?>
		<div id="text-to-speech-toggle"></div>
	</body>
</html>