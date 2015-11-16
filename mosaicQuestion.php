<!DOCTYPE html>
<html>
  <?php
    include("includes.php");
    
    $question = getCurrentQuestion();
    
    //MC-bJSOzCRo-V
    	
    $moreItem = getItemMore(getItems($question["id"]));
    $moreId = $moreItem["id"];
    	
    $url = getItemMediaId($moreItem);
    $info = $moreItem["description"];
    
	// echo($moreId . "--> url" . $url . "--> description" . $info);
	
    $temp = explode("-", $info);
    $author = $temp[0];
    $description = $temp[1];
    
    //echo "MORE ID = ".$moreId;
  ?>
<head>
    <title>Question : <?php echo $question["content"]; ?></title>
    <?php include("head.php");  ?>
    <link rel="stylesheet" type="text/css" href="styles/mosaicQuestion.css?v=1" />
    <script type="text/javascript" src="js/loading.js?v=1"></script>
</head>
<body>
<div class="all" id="all-question">
	<?php displayMenuHeader($question, $question["content"]); ?>
	<?php displayButton("mosaic.php?id=".$question["id"], "btn-close"); ?>
			
			<div id="info-frame-border">
				
				<div id="info-frame-content">
				
					<div id="info-media-frame">
						
						<div id="info-media-title">Nous écoutons votre témoignage et vos propositions...</div>
						
						<!-- VIDEO -->
						<?php 
							addApiVideo($url, true);
						?>
						
            <?php
              $titre = $qst["content"];
              if(strlen($titre) > 0){
                echo '<div id="info-media-content">';
                //$titre = str_replace('"', '', $titre);
                echo $titre;
                echo '</div>';
              }
						?>

						<div id="info-media-author">
            <?php 
              //virer le premier et le dernier ""
              //var_dump($author);
              //$author = substr($author, 1, strlen($author) - 2);

              //$author = str_replace('"', '', $author);
              echo $author;
            ?>
            </div>

					</div>
					
				</div>
				
				
				
			</div>
			
		</div>

		<script language="javascript">
      //on video end
      document.getElementById("videoHTML5").addEventListener('ended', videoEnded, false);
      function videoEnded() {
        document.location = "mosaic.php?id=<? echo $question['id']; ?>";
      }
    </script>

    <script type="text/javascript" src="js/mosaicQuestion.js?v=1"></script>
    
    	<?php include("analytics.php"); ?>
    	<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>
