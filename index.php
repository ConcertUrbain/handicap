<?php
  session_start();
  
  include("includes.php");
  $_SESSION[DATA_CACHE] = "";
  
  //permet de savoir ce qui est visité lors de cette session
  $_SESSION["visited"] = array();
  $_SESSION["items"] = array();
  
  $_SESSION["questionId"] = -1;
  
  //empty everything
  foreach($_SESSION as $key => $val) {
    $_SESSION[$key] = "";
  }
  
?>

<html>
	<head>
		<title>Page d'accueil de la mosaique</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css?v=1" />
		<link rel="stylesheet" type="text/css" href="styles/index.css?v=1" />
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js?v=1" type="text/javascript"></script>
    	<script src="js/jquery.cookie.js?v=1" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <script>
	      var loaded = false;
	      var nextUrl = "";
	      
	      jQuery.fn.center = function () {
	          this.css("position","absolute");
	          this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
	          this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
	          return this;
	      }
	      
	      function goNext(){
	        document.location = nextUrl;
	      }
	      
	      function loadCache(){
	      
	        $.get('cache_reload.php', function(data) {
	          loaded = true;
	          if(nextUrl.length > 0)  goNext();
	        });
	        
	      }
	      
	      $(function(){
	
	        var USE_CACHE = <?php echo (USE_CACHE == "1") ? "true" : "false"; ?>;
	
	        $("#loading-overlay-border").center();
	        $("#loading-overlay-border").hide();
	        
	        if(!USE_CACHE)  return;
	        
	        $(".next-link").click(function(e){
	          console.log("click next");
	          e.preventDefault();
	          nextUrl = $(this).attr("href");
	          if(loaded)  goNext();
	          else{
	            console.log("load cache");
	            $("#loading-overlay-border").show(200);
	          }
	          //console.log("next is "+nextUrl);
	        });
	        
	        loadCache();
	      });
	    </script>
		<script src="js/common.js?v=1" type="text/javascript"></script>
	</head>
	
  <?php
    if(isset($_GET["clean"])){
      //include("tools.php");
      //reloadCache();
    }
  ?>
  
	<body>
  
    <div id="loading-overlay-border">
      <div id="loading-overlay">
        <div id="loading-overlay-text">Veuillez patienter<br/>Chargement du site</div><div id="loading-overlay-loader"><img src="images/loading_circle.gif" /></div>
        <div class="clear"></div>
      </div>
    </div>
    
		<div class="all" id="all-index">
        
			<div id="accueil-frame-border">
				<div id="index-frame">
        			<div class="left">
	                    <div id="link-mes-idees">
	                      <a class="next-link" href="mosaic.php?cat=presentation-debat" id="index-link">
	                        <div class="cursor"><img src="images/logo_accueil.png" /></div>
	                        <div class="cursor" id="hand_cursor"></div>
	                      </a>
	                    </div>
	                    <div id="val-marne">
	                      <div id="val-marne-logo"><img src="images/home/logo_marne.png" /></div>
	                      <a class="next-link" id="val-marne-description" href="mosaic.php?cat=presentation-debat">
	                        <?php echo getTextToSpeech("Le Conseil général du Val-de-Marne s'engage pour la <br/>citoyenneté des personnes en situation de handicap mental."); ?>
	                      </a>
	                      <div class="clear"></div>
	                    </div>
	           		</div>
	           		<div class="right">
	           			<a id="link-installation" href="installation.php">
	           				<img src="images/home/ACCUEIL_motif_ordi_sansfond_1.png" border="0" />
	           				<?php echo getTextToSpeech("Installation"); ?>
	           			</a>
	           		</div>
	           		<div class="clear"></div>
              	</div>
          	</div>
		</div>
		
    <div id="warning-message">
      <?php echo getTextToSpeech("Merci pour vos témoignages et vos propositions, que vous pourrez toujours lire ou écouter.<br/>
	  								<br/>
									Le débat est clôturé.<br/>
									Il n’est plus possible de contribuer.<br/>
									<br/>
									Nous avons analysé vos réponses et <a href=\"pdf/AvisCitoyen.pdf\">la synthèse est téléchargeable ici</a>.<br/>
									<br/>
									Le Conseil départemental décidera les actions à mettre en place issues<br/>
									de vos témoignages et de vos propositions.<br/>
									<br/>
									Vous les retrouverez ici début octobre.") ?>
    </div>
    <?php
	  if(0) {
	  ?>
		<div id="index-compatibility">
          <div id="index-compat-left" class="index-compat text-to-speech-container">
          	<!-- <img src="images/home/browser_logo_220.png" /> -->
          	<a href="https://www.mozilla.org/fr/firefox/new/" target="_blank">
          		<img src="/images/home/icon_firefox.png" border="0" />
          	</a>
          	<a href="https://www.google.fr/chrome/browser/desktop/" target="_blank">
          		<img src="/images/home/icon_chrome.png" border="0" />
          	</a>
          	<div>
          		<?php echo getTextToSpeech("Ce site fonctionne sur 	<a href=\"https://www.mozilla.org/fr/firefox/new/\" target=\"_blank\">Firefox</a> et <a href=\"https://www.google.fr/chrome/browser/desktop/\" target=\"_blank\">Chrome</a>."); ?>
          	</div>
          </div>
          <div id="index-compat-right" class="index-compat text-to-speech-container">
          	<a href="http://get.adobe.com/fr/flashplayer/" target="_blank">
          		<img src="/images/home/icon_flash.png" border="0" />
          	</a>
          	<div>
            	<?php echo getTextToSpeech("L'enregistrement d'un témoignage audio en direct nécessite <a href=\"http://get.adobe.com/fr/flashplayer/\" target=\"_blank\">Flash</a>."); ?>
            </div>
          </div>
          <div class="clear"></div>
        </div>
    <?php
  }
	?>
		<div id="index-mentions">
			<a href="pdf/MENTIONS_LEGALES.pdf" target="_blank">
				<?php echo getTextToSpeech("Mentions légales"); ?>
			</a>
		</div>
    <br\>
		
    	<?php include("analytics.php"); ?>
    	<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>