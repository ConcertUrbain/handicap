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
<link rel="stylesheet" type="text/css" href="styles/installation.css?v=1"></link>
</head>
<body>
	<div class="all" id="all-global">

		<div id="pres-logo">
			<a href="/"></a>
		</div>
		<script language="javascript">
		  $("#pres-logo").click( function(e) { document.location.href = "/"; } );
		</script>

		<div id="btn-close" class="btn">
			<a href="/mosaic.php?cat=presentation-debat" id="btn-link">
				<img src="images/installation/x_1.png" />
				<?php echo getTextToSpeech("Retour", false); ?>
			</a>
		</div>
		
	
		<?php
			$nbPages = 10;
			if (isset($_GET['page']))
				$pageCourante = addslashes($_GET['page']);
			else
				$pageCourante = 0;
	 	?>
		 	 
		 	 
		<div id="installation-frame-border">
			<div id="installation-frame" class="page<?php echo $pageCourante?>">
				<div class="inner">
					<?php 
						if ($pageCourante == 0)
							echo getTextToSpeech("Mode d'emploi pour donner son avis à partir d'un ordinateur (fixe ou portable) relié à Internet.");
						elseif ($pageCourante == 1)
							echo getTextToSpeech("D'abord, utilisez Firefox ou Chrome pour accéder à Internet (attention aux mises à jour).<br/><br/>Ils sont simples à télécharger.");
						elseif ($pageCourante == 2)
							echo getTextToSpeech("Vérifiez que le son est bien réglé.<br/><br/>(C'est en bas à droite de votre écran d'ordinateur.)");
						elseif ($pageCourante == 3)
							echo getTextToSpeech("Si c'est la première fois que vous utilisez votre microphone, il se peut qu'une barre s'affiche lorsque vous commencerez votre enregistrement.<br/><br/>Il faut cliquer sur \"Autoriser\".");
						elseif ($pageCourante == 4)
							echo getTextToSpeech("Si votre ordinateur ne possède pas de micro intégré, branchez un casque ou les écouteurs de votre téléphone portable.");
						elseif ($pageCourante == 5)
							echo getTextToSpeech("C’est ici qu’il faut brancher son casque ou ses écouteurs de téléphone portable.");
						elseif ($pageCourante == 6)
							echo getTextToSpeech("Rappel :<br/>Sur le site, enregistrez votre témoignage en cliquant à droite de la mosaique.");
						elseif ($pageCourante == 7) {
							?><div class="left">
								<div>
									<img src="/images/Oreille_ON_1.png" /><br/>
									<?php echo getTextToSpeech("Sonorisation activée");?>
								</div>
								<br/><br/>
								<div>
									<img src="/images/Oreille_OFF_1.png" /><br/>
									<?php echo getTextToSpeech("Sonorisation désactivée");?>
								</div>
							</div><?php 
							echo "<div><br/><br/>".getTextToSpeech("Le site « Mes idées aussi » est sonorisé.")."</div><br/>";
  							echo "<div>".getTextToSpeech("Pour activer ou désactiver cette fonction, il faut cliquer sur l'oreille située en bas à droite de votre écran.")."</div><br/>";
						}
						elseif ($pageCourante == 8) {
							echo getTextToSpeech("Si vous rencontrez toujours des difficultés, peut être que Flash Player n'est pas installé ? Si c'est le cas, cliquez ici :");
							?>
							<br/><br/>
							<a href="http://get.adobe.com/fr/flashplayer/" target="_blank">
				          		<img src="images/installation/Installation_9_flash_1.png" border="0" style="margin-left: 150px;" />
				          	</a>
							<?php 
						}
						elseif ($pageCourante == 9)
							echo getTextToSpeech("Vous êtes maintenant prêts à donner votre avis sur la plateforme de débat numérique « Mes idées aussi ?! ».");
					?>
				</div>
				<a id="pageNextlink" href="<?php echo $pageCourante == 9 ? "/mosaic.php?cat=presentation-debat" : "installation.php?page=".($pageCourante+1); ?>">
					<img border="0" src="images/installation/fleche_droite_1.png" />
					<?php echo getTextToSpeech("Page suivante", false); ?>
				</a>
			</div>
		</div>
		
		
		<?php 
			if ($nbPages > 1)
			{
				$divNoPages = "";
				for ($i = 0; $i < $nbPages; $i++) {
					$no = $i + 1;
					$classNoPageActive = $i == $pageCourante ? "nopage_actif" : "";
					$divNoPages .= '<span id="nopage' . $i . '" class="nopage ' . $classNoPageActive . '" ><a href="installation.php?page=' . $i . '">' . getTextToSpeech((($classNoPageActive) ? ("Vous êtes sur la page "):(" page ")).$no, false) . $no . '</a>'.($i+1 < $nbPages ? "...." : "").'</span>';
				}
			}
		?>
	    <div id="items_navigation_pagination">
	      <div id="items_navigation_precedent_suite">
	        <span id="pagePrecedente"><a href="<?php echo $pageCourante == 0 ? "/" : "installation.php?page=".($pageCourante-1); ?>"><img src="images/mosaic/previous.png" /></a><?php echo getTextToSpeech("Page précédente", false);?></span>
	        <span id="nopages"><?php echo $divNoPages; ?></span>
	        <span id="pageSuivante"><a href="<?php echo $pageCourante == 9 ? "/mosaic.php?cat=presentation-debat" : "installation.php?page=".($pageCourante+1); ?>"><img src="images/mosaic/next.png" /></a><?php echo getTextToSpeech("Page suivante", false);?></span>
	        <span id="legende" class="page0" data-id="<?php echo $nbPages ?>"></span>
	      </div>
	    </div>

	</div>
	
	<?php include("analytics.php"); ?>
	<?php include("text-to-speech-toggle.php"); ?>
</body>
</html>
