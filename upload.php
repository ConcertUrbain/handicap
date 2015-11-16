<?php 
	include("includes.php");
	
	//ini_set("error_reporting","E_ALL");
	//error_reporting( E_ALL );
?>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	
	<body>
<?php
	
	//echo "\nUPLOAD MEDIA";
	//echo "<br />"; print_r($_FILES);
	//echo "<br />"; print_r($_POST);
	
	//MC-pmkRruaZ-V
	$mediaId = "test-id";
	
	if (isset($_POST["add-item"])) {
		
		$mediaId = api__sendFormFile();
		//echo "<br />[FILE] >> media id : ".$mediaId;
		
		$qstId = $_POST["question-id"];
		api__addItem($qstId, $_POST["title"], $_POST["description"], $mediaId);
		DatabaseData::getInstance()->cache__reloadItems($qstId);
    
	}else if (isset($_POST["record"])) {
	
		$_FILE = $_POST["bytes"];
		$mediaId = api__sendFormFile();
		//echo "<br />[RECORD] >> media id : ".$mediaId;
		
	}else {
		
		//echo "<br />[DEFAULT]";
		
		$text = "";
		$mediaId = -1;
		
		//TEXT
		if (!empty($_POST["temoin-text"])) {
			$text = $_POST["temoin-text"];
			$_SESSION[UPLOAD]["temoin-text"] = $text;
			//echo "<br />[RESULT] Got text from form";
		}else {
			
			//MEDIA
			$mediaId = api__sendFormFile();
			
			//echo "<br />[RESULT] Got media from form (".$mediaId.")";
		}
	}
	
	//REF MEDIA ID
	if (strlen($mediaId) > 1) {
		//echo "Api is done send file, media id is : ".$mediaId;
		$_SESSION[UPLOAD]["mediaId"] = $mediaId;
	}
	
	//REDIRECT
	if (isset($_POST["nextPage"])) {
		$next = $_POST["nextPage"];
		
		?>
		<script language="javascript">
			document.location.href = "<?php echo $next; ?>";
		</script>
		<?php
		
	}
?>

		<?php include("analytics.php"); ?>
		<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>