<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles/reset.css?v=1"></link>
<link rel="stylesheet" type="text/css" href="styles/main.css?v=1"></link>
<?php	if(isUsingIE()){	?>
  <link rel="stylesheet" type="text/css" href="styles/form-hack.css?v=1"></link>
<?php } ?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js?v=1" type="text/javascript"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js?v=1" type="text/javascript"></script>
<script src="js/jquery.cookie.js?v=1" type="text/javascript"></script>
<script src="js/common.js?v=1" type="text/javascript"></script>
<script src="js/script.js?v=1" type="text/javascript"></script>
<script type="text/javascript" src="js/swfobject.js?v=1"></script>

  <script src="js/mediaelement/mediaelement-and-player.min.js?v=1"></script>
  <link rel="stylesheet" href="js/mediaelement/mediaelementplayer.min.css?v=1" />
<?php
  // Le cas par cas
	$cat = "";
	if (isset($_GET["cat"]))	$cat = $_GET["cat"];
	
	if (strlen($cat) > 0) {
		$style = $cat;
		if ($style == "restitution")	$style = "presentation";
		
    //ajout des JS particuliers
    if(strpos($cat, "presentation") > -1){
      ?>
        <link rel="stylesheet" type="text/css" href="styles/presentation.css?v=1"></link>
        <script src="js/presentation.js?v=1" type="text/javascript"></script>
      <?php
    }
	}
?>