<?php
	include "includes.php";
  ini_set('display_errors', "1");
?>

<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	<body>

    <?php

      //récup l'avis
      $content = $_POST["content"];
      $content = htmlentities($content, ENT_QUOTES, "UTF-8");
      //$content = htmlspecialchars($content);
      //$content = html_entity_decode($content);
      
      //récup l'id de l'item
      $itemId = htmlentities($_POST["itemId"]);
      
      //var_dump($itemId);var_dump($content);

      if($itemId > 0){
        //envoi l'avis à la db
        if (strlen($content) > 0) {
          if ($content != "Donner son avis") {
            $voteId = api__addComment($itemId, $content);
            //echo "commentaire ajouté ! ID = ".$voteId;
            //echo "Commentaire ajouté !";
            displayThanks("Merci !");

            if(USE_CACHE){
              DatabaseData::getInstance()->cache__reloadComments($itemId);
              DatabaseData::cache__save();  
            }
          }
        }
      }
      
      if(COMMENT_SAME_PAGE){
        //reviens sur la meme page
        $url = "mosaicMedia.php?itemId=".$itemId."&com=1#last-comment";
      }else{
        //$qst = getCurrentQuestion();
        $url = "mosaic.php";
      }
      
    ?>

    <?php
      $useRedirect = true;
      if($useRedirect){
        ?><script language="javascript">document.location.href = "<?php echo $url; ?>";</script><?php
      }
    ?>
  
  
  		<?php include("analytics.php"); ?>
  		<?php include("text-to-speech-toggle.php"); ?>
	</body>
</html>
