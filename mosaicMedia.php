<?php 
  include("includes.php");
  ini_set('display_errors', "1");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
<title>Ecouter un témoignage</title>
<?php include("head.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/mosaicMedia.css?v=1" />
<script src="js/mosaicMedia.js?v=1" type="text/javascript"></script>
</head>

<?php

	$question = getCurrentQuestion();
	
	if (isset($_GET['page']))
	{
		$page = addslashes($_GET["page"]);
	}
	else
	{
		$page = 0;
	}
	
	$itemId = 0;
	if(!isset($_GET["itemId"]))	displayError("pas d'item selectionné");
	
	$itemId = $_GET["itemId"];
	$_SESSION["visited"][(int)$_GET["itemId"]] = 1;
	
	$item = getItem($question["id"], $itemId);
	//var_dump($item);var_dump($itemId);

	//GOT MEDIA
	$description = "";
	$mediaPath = "";
	$mediaType = "T"; // default = text
	
	$mediaPath = getItemMediaId($item);
	//echo "<p>mediaPath : ".$mediaPath."</p>";
  
	if (strlen($mediaPath) > 1) {
    
		//récupérer le type du média à partir de l'objet qui vient de l'API (S = sound, P = picture, V = video)
		$temp = explode("-", $mediaPath);
		$mediaType = $temp[2];
		//echo "Media-URL = ".$mediaPath;
		
		if (strlen($mediaType) < 1) {
			displayError("Le média n'a pas de format dans son url (mediaPath = ".$mediaPath.")");
		}
		
	}else{
		$description = $item["description"];
		if(strlen($description) < 2){
      displayError("Pas de média ni de description pour cet item (id=".$itemId.")");
    }
	}
  //echo "<p>description : ".$description."</p>";
?>
<body><div class="all" id="all-temoin">
			<?php displayMenuHeader($question, $item["title"], $page); ?>
			<?php displayButton("mosaic.php?page=".$page, "btn-close"); ?>
			<div id="media-frame-border" class="media-frame-border-popup">
				<div id="media-frame">
					<!--
					<div id="media-frame-top"><?php echo ucfirst($item["title"]); ?></div>
					-->
					<div class="media-frame-content" id="media-frame-<?php echo $mediaType; ?>">
						<?php
							if (strlen($mediaPath) > 1) {
								switch($mediaType) {
									case "A" : 
										//echo "<div class=\"audio-player-title\">".getTextToSpeech("Témoignage audio :")."</div>";
										echo "<div class=\"audio-player-frame\">";
											addApiSound($mediaPath);
										echo "</div>";
										break;
									case "V" : addApiVideo($mediaPath); break;
									case "P" : addApiImage($mediaPath); break;
								}
							}else {
								//echo "<div id=\"media-content-title\">".getTextToSpeech("Témoignage")."</div>";
								echo "<div id=\"media-description\">"
										.getTextToSpeech($description)
									."</div>";
							}
							
						?>
					</div>
					
<?php						
// BENOIT -> CLOTURE PLATEFORME
/*
					<div id="media-frame-vote">
						<div id="media-vote-frame">
							<form id="voteForm" action="uploadVote.php" method="post">
								<input type="hidden" name="item-id" value="<?php echo $itemId; ?>" />
								<input type="hidden" id="vote-value" name="vote" value="0" />
								<input type="hidden" id="question-id" name="question-id" value="<?php echo $question["id"]; ?>" />
								<input type="hidden" id="page" name="page" value="<?php echo $page; ?>" />
							</form>
							
							<div id="media-votes">
								<a href="" class="vote" id="vote-up">
									<?php echo getTextToSpeech("Je suis d'accord"); ?>
								</a>
								<a href="" class="vote" id="vote-down">
									<?php echo getTextToSpeech("Je ne suis pas d'accord"); ?>
								</a>
								<div class="clear"></div>
							</div>
							
							<div id="media-vote-thumbs">
								<div class="vote-thumbs thumbs-ok"><?php echo getTextToSpeech("D'accord"); ?></div>
								<div class="vote-thumbs thumbs-notok"><?php echo getTextToSpeech("Pas d'accord"); ?></div>
								<div class="clear"></div>
							</div>
                            
						</div>
						<div id="media-vote-thanks"><?php echo getTextToSpeech("J'ai voté !");?></div>
					</div>
*/
?>
					<?php 
						$comments = getItemComments($item);
						$countTotal = 0;
						$commentaireCG = false;
						foreach($comments as $c){
							if($c->isValid)
								$countTotal++;
							$user_id = $c->__get("users_id");
							if (in_array($user_id, array(500, 94)))
								$commentaireCG = true;
						}
					?>
					
          			<div id="media-vote-acces-commentaires">
          				<?php echo getTextToSpeech("Avant de voter, je peux écouter, lire et ajouter un commentaire <u>ici</u> !");?>
          				<div class="nb-comments <?php echo $commentaireCG ? "with-comment-cg" : "";?>"><?php echo $countTotal; ?></div>
          			</div>
                    
					<div id="media-comment">
<?php						
// BENOIT -> CLOTURE PLATEFORME
/*
						<form method="post" action="uploadComment.php">
							<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
							<input id="comment-input" name="content" value="" placeholder="Je donne mon avis" autofocus/>
							<input id="comment-submit" type="submit" value="Envoyer" />
							<?php echo getTextToSpeech("Je donne mon avis", false);?>
						</form>
*/
?>							
						<div id="comment-list">
						<?php
							
							if(count($comments) > 0){
								$count = 0;
								foreach($comments as $c){
									if(!$c->isValid)
										continue;
									$user_id = $c->__get("users_id");	// Mathieu
									if(is_object($c)) $c = (array)$c;
									$bgColor = ($count % 2) ? "#EEE" : "#CCC";
									$count++; 
									if ($countTotal == $count)
										echo '<a name="last-comment" id="last-comment"></a>';
									echo "<div class=\"comment-line user-".$user_id." ".($count==0 ? "first" : "")."\" "./*style=\"background-color:$bgColor;\"*/"><div class=\"inner\">";
										//echo "<span class=\"comment-silhouette\"></span>";
										echo "<span class=\"comment-silhouette user-".$user_id."\"></span>";	// Mathieu
										echo getTextToSpeech($c["content"]);
									echo "</div></div>";
								}
							}else{
								echo "<div id=\"media-comment-no\">".getTextToSpeech("Pas de commentaires")."</div>";
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<a href="#" id="lien_retour_top" style="display: block;"></a>
		<?php include("analytics.php"); ?>
		<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>