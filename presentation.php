<div id="pres-logo">
	<a href="/"></a>
	<?php echo getTextToSpeech("Retour à  l'accueil", false); ?>
</div>
<div id="menu">
<?php
  
  //TOP MENU QUESTIONS ICONS
  
	$i = 1;
	
	/*
	   $list = array(
			"debat"=>"pres-questions",
			"video"=>"pres-video",
			"calendar"=>"pres-calendrier",
			"intro"=>"pres-intro"
	  );
	*/
	
	   $list = array(
			"debat"=>"pres-questions",
			"intro"=>"pres-intro"
	  );
	
	foreach($list as $item=>$val){
		
		// $class = "pres-link question-number-container";
		
		$class = "pres-link";
		
		if(strlen($subcat) <= 0 && $item == "intro") 
		{
			$class .= " selected";
		}
		else if(strlen($subcat) > 0)
		{
		  if($item == $subcat){
			$class .= " selected";
		  }
		}

		print '<div class="'.$class.'" id="'.$item.'" alt="'.$val.'">';
		
		if ($item == "debat")
		{
			print '<div class="pres-debat-rollover">les questions</div>';
		}
		if ($item == "intro") {
			echo getTextToSpeech("Besoin d’aide ?");
		}
		
		print '</div>';

		++$i;
	}	
?>

<div class="clear"></div>
</div>

<div id="pres-frame-border">

	<div id="pres-frame" class="pres-frame-<?php echo $item; ?>">
		
        <div class="pres-container" id="pres-intro">
		   <div id="pres-tuto-container">
                <?php
                    //modif le path dans const.php
                    //addApiVideo(TUTORIEL_VIDEO, false, "videoTutorielHtml5", "images/presentation/MC-HnLcJAGF-V.png", 482, 400);
                ?>
          </div>
          <div id="pres-contact">
            contact : <a href="mailto:mes-idees-aussi@cg94.fr"  class="pres-mail-link">mes-idees-aussi@cg94.fr</a>
          </div>
        </div>


		<div class="pres-container" id="pres-video">
		   <div id="pres-video-container">
				<?php
          			//modif le path dans const.php
					addApiVideo(PRESENTATION_VIDEO, false, "videoHtml5", "images/presentation/MC-MWEkZkGV-V.jpg");
				?>
		  </div>
			
		  <div id="pres-video-description">
		  	<?php echo /*getTextToSpeech(*/"Présentation de la plateforme Mes idées aussi et des sujets en débat par Brigitte Jeanvoine,<br/>Vice-présidente du Conseil général du Val de Marne"/*)*/; ?> 
		  </div>
            
          <div id="pres-pdfs">
            <a href="pdf/MES_IDEES_AUSSI.pdf" target="_blank" class="pres-pdf-link"><img src="images/pdf_45.png"/><?php echo getTextToSpeech("Présentation plateforme"); ?></a>
            <a href="pdf/CALENDRIER_MES_IDEES_AUSSI.pdf" target="_blank" class="pres-pdf-link"><img src="images/pdf_45.png"/><?php echo getTextToSpeech("Calendrier"); ?></a>
          </div>

		</div>

		<div class="pres-container" id="pres-questions">
            
			<?php
				$qsts = getQuestions();
				
				foreach($qsts as $q) {
				
					$path = "images/question_makatons/icone_question_".$q["id"]."_125x125.png";
					$pathLarge = "images/question_makatons/icone_question_".$q["id"].".png";
					
					if (file_exists($path)) {
						?>
						<div class="text-to-speech-container">
							<div class="pres-question-new pres-question-<?php echo $q["id"]; ?>" data-id="<?php echo $q["id"]; ?>">
								<a href="?id=<?php echo $q["id"]; ?>">
									<div class="pres-question-new-icon">
										<img src="<?php echo $path; ?>" /> 
									</div>
									<div class="pres-question-new-label"><?php echo getTextToSpeech($q["content"]); ?></div>
								</a>
							</div>
	                        <div class="pres-question-rollover-new"  id="pres-question-rollover-<?php echo $q["id"]; ?>">
								<a href="?id=<?php echo $q["id"]; ?>">
	                                <img src="<?php echo $pathLarge; ?>" /> 
								</a>
	                        </div>
						</div>
					<?php
					}
				}
			?>
            
            <div id="pres-question-video">
            </div>
            
            <div id="pres-question-video-rollover">
            	<?php /*echo getTextToSpeech("Présentation de la plateforme Mes idées aussi et des sujets en débat par Brigitte Jeanvoine,<br/>Vice-présidente du Conseil général du Val de Marne", false); */ ?>
				<?php echo getTextToSpeech("Présentation de la plateforme", false); ?>
            </div>
            
		</div>
		
		<div class="pres-container" id="pres-calendrier">
			<img src="../images/calendar.png" />
		</div>
		
		<!--<div id="valmarne-logo"></div>-->
	</div>
</div>

<script language="javascript">

  initClickMenu();
  
  
  //
  // RollOver Main (retour aux questions)
  //
  
  $("#debat").on("mouseover", function(e) {
	$(".pres-debat-rollover").css("display", "block");
  });
  
  $("#debat").on("mouseout", function(e) {
	$(".pres-debat-rollover").css("display", "none");
  });
  
  
  //
  // RollOver Question
  //
  
  $(".pres-question-new").on("mouseover", function(e) {

	// Cacher les autres icônes
	$(".pres-question-rollover-new").css("display", "none");
	$("#pres-question-video-rollover").css("display", "none");
	
	// Afficher la bonne icône
	var target = $(e.currentTarget);
	var targetRollOver = $("#pres-question-rollover-" + target.data("id"));
	
	targetRollOver.css("display", "block");
	targetRollOver.css("opacity", 0);
	targetRollOver.animate( { opacity:1 }, { duration : 200 });
  });
  
  $(".pres-question-rollover-new").on("mouseout", function(e) {	
	var target = $(e.currentTarget);
	target.css("display", "none");
  });

  //
  // RollOver Vidéo
  //

  $("#pres-question-video").on("mouseover", function(e) {
	
	// Cacher les autres icônes
	$(".pres-question-rollover-new").css("display", "none");
	
	var targetRollOver = $("#pres-question-video-rollover");
	targetRollOver.css("display", "block");
	targetRollOver.css("opacity", 0);
	targetRollOver.animate( { opacity:1 }, { duration : 200 });
  });
  
  $("#pres-question-video-rollover").on("mouseout", function(e) {	
	var target = $(e.currentTarget);
	target.css("display", "none");
  });
  
  
  $("#pres-question-video-rollover").on("click", function(e) {	
    clickCat("video");
	$("#pres-video-container").css("display", "block");
	$("#pres-video").css("display", "block");
	$("#pres-video #pres-video-container video").get(0).play();
  });
  
  $(".calendar-link").on("click", function(e) {	
    clickCat("calendar");
	$("#pres-calendrier").css("display", "block");
  });
  
  $("#pres-logo").click( function(e) { /*clickCat("debat");*/ document.location.href = "/"; } );
  
  //
  // Fin de la vidéo
  //
  document.getElementById("videoHTML5").addEventListener('ended', videoEnded, false);
  function videoEnded() {
	  clickCat("debat");
  }
  
</script>

<?php if (strlen($subcat) > 0){ ?>
  <script language="javascript">
    clickCat("<? print $subcat ?>");
  </script>
<?php } ?>
