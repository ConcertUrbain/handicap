<?php
  //ini_set('display_errors', '1');
	include "includes.php";
?>

<html>
	<head>
		<?php include "head.php"; ?>
	</head>
	<body>

<?php
	displayThanks("Merci !");
	
	$questionId = $_SESSION["questionId"];
	$mediaId = $_SESSION[UPLOAD]["mediaId"];
	$text = $_SESSION[UPLOAD]["temoin-text"];
	
	// ###[CONFIRM FORM -- METAS]
	
	//choppe l'email
	$email = "";
	if(isset($_POST["email"]))	$email = htmlentities($_POST["email"]);
	
	/*
	//choppe la value de l'input "other"
	$other = "";
	if(isset($_POST["cb-autre"]) && isset($_POST["other"]))	$other = htmlentities($_POST["other"]);
	
	//créer une liste des roles
	$metas = array();
	foreach($_POST as $key => $value){
		if(strpos($key, "cb-") !== false){
			if($key == "cb-autre")	$metas[] = "cb-autre=".$other;
			else	$metas[] = $key;
		}
	}
	*/
	
	//créer une liste des roles
	$contentSwap = array("cb-first-name", "cb-etablissement");
	$metas = array();
	$count = 0;
	foreach($_POST as $key => $value){
		if (strpos($key, "cb-") !== false) {
			
			if (in_array($key, $contentSwap)) {
				$metas[] = $key."=".$value;
			}else {
				$metas[] = $key;
			}
			
			$count++;
		}
	}
	
	//créer la liste des activitées de la personne
	$activity = "";
	foreach($metas as $value){
		$activity .= $value.",";
	}
	$activity = substr($activity, 0 , -1); // remove last ','
	
	
	// ### SUBMIT
	
	$itemId = 0;
	if (strlen($text) > 0) {
		$itemId = api__addItem($questionId, "Sans Titre", $text);
	}else {
		if (strlen($mediaId) < 1)	displayError("Pas de media !");
		$itemId = api__addItem($questionId, "", "", $mediaId);
	}
	
	if ($itemId < 1)	displayError("No item created");
	
	//role
	if(strlen($activity) > 0){
		api__addItemMetas($itemId, array("handicap-activity" => $activity));
	}
	
	//mail
	if(strlen($email) > 0){
		api__addItemMetas($itemId, array("handicap-email" => $email));
	}
	
	//vote up by default
	api__vote($itemId, 1);
	
	//echo "<br />ajouté un item (".$itemId.") avec un media (".$mediaId.") à la question ".$questionId;
	//echo "<br />merci de votre participation !!";
  
  //reload cache
	if(USE_CACHE){
		DatabaseData::getInstance()->cache__reloadItems($questionId);
	  DatabaseData::cache__save();
	}
  
	//KILL ALL INFO IN SESSION
	unset($_SESSION[UPLOAD]);
?>

<?php
  $useRedirect = true;
  if($useRedirect){
    ?>
    <script language="javascript">
      document.location.href = "mosaic.php?id=<?php echo $questionId; ?>&itemId=<? echo $itemId; ?>";
    </script>
    <?php
  }
?>

	<?php include("analytics.php"); ?>
	<?php include("text-to-speech-toggle.php"); ?>
</body>
</html>