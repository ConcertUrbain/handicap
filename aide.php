<?php
	//include all libraries
	ini_set('display_errors', "1");
  include("includes.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Conseil general - Titre du site</title>
<?php include("head.php"); ?>
<link rel="stylesheet" type="text/css" href="styles/aide.css?v=1"></link>
<script src="js/mosaic.js?v=1" type="text/javascript"></script>
</head>

<body><div class="all" id="all-aide">

        <div id="menu">
			<div class="pres-link" id="debat" alt="pres-questions"><div class="menu-debat-rollover aide"><?php echo getTextToSpeech("les questions"); ?></div></div>
            <div class="clear"></div>
        </div>
            
            <div class="aide-frame2">
				<?php
                    //modif le path dans const.php
                    //addApiVideo(TUTORIEL_VIDEO, true, "videoTutorielHtml5", "images/aide/accueil_tutoriel.png", 880, 495);
					//addApiVideo(TUTORIEL_VIDEO, true, "videoTutorielHtml5", "images/aide/accueil_tutoriel.png", 1280, 720);
				?>
				<video width="1280" height="736" controls="controls" preload="auto" poster="videos/MesIdeesAussi_Tutoriel-720.png" autoplay> 
					<source src="videos/MesIdeesAussi_Tutoriel-1080.mp4" type="video/mp4" />
					<!-- source src="videos/MesIdeesAussi_Tutoriel-720.webm" type="video/webm" /-->
				</video>
            </div>
            
            <script language="javascript">
            
			  var goPresentation = function()
			  {
				  document.location = "./mosaic.php?cat=presentation-debat";
			  };
				
			  $(".pres-link").on("click", function() { goPresentation(); });
			
              //
              // Fin de la vidéo
              //
              document.getElementById("videoHTML5").addEventListener('ended', videoEnded, false);
              function videoEnded()
			  {
				  history.go(-1);
              }
              
            </script>

		</div>
		
		<?php include("analytics.php"); ?>
		<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>
