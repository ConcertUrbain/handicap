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
<link rel="stylesheet" type="text/css" href="styles/mosaic.css?v=1"></link>
<script src="js/mosaic.js?v=1" type="text/javascript"></script>
</head>
<body><div class="all" id="all-global"><?php
	//ORDRE DES ELEMENTS EST IMPORTANT
	if(strlen($cat) < 1)
	{		
		$qsts = getQuestions();
		if(count($qsts) < 1)  die("Pas de questions");
	
		$question = getCurrentQuestion();
		$qstId = $question["id"];
		
		include("mosaicContent.php");
	}
	else
	{
	  if(strpos($cat, "presentation") > -1){
		list($cat, $subcat) = explode("-", $cat);
include("presentation.php");
	  }else{
		include($cat.".php");
	  }
	}
	?>
		</div>
		
		<?php include("analytics.php"); ?>
		<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>
