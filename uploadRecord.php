<?php
	include("includes.php");
?>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	<body>

<?php
	
	ini_set('display_errors', '1');
	
	// ### create wav file on server
	$file = $GLOBALS["HTTP_RAW_POST_DATA"];
	// $filename = "records/".getUniqFileName().".wav";
	$filename = "records/".getUniqFileName().".mp3";
	if(file_put_contents($filename, $file) === false)	die("ERREUR : Impossible d'enregistrer le fichier sur le serveur");
	
	// ### send file to MC
	// "type=audio/wav"
	// $mediaId = api__sendUrlFile($filename, "audio/wav");
	$mediaId = api__sendUrlFile($filename, "audio/mp3");
	
	// ### delete file on server
	//unlink($filename);
	
	if(strlen($mediaId) < 1){
		die("[error] L'api n'a pas retourné d'id ...");
	}
	
	// ### result
	$_SESSION[UPLOAD]["mediaId"] = $mediaId;
	//echo "Response from curl exec = ".$mediaId;
?>
		<?php include("analytics.php"); ?>
		<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>