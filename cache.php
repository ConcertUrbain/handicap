<?php include("includes.php"); ?>
<?php
  /*
    # Le cache est chargé au lancement du site en variable de SESSION
    # Le cache a une unique ID qui permet de savoir si la session a la bonne version du cache
    # On compare donc l'id avec celle en session pour savoir si il faut reload le contenu
  */
?>
<html>
  <head><title>CACHE MANAGER</title></head>
  <body>
    <?php
      
      $filePath = CACHE_FOLDER.CACHE_FILE.".".CACHE_FILE_EXT;
      //echo "<br/>Opening cache file (".$filePath.")";
      $fileContent = file_get_contents($filePath);
      
      //echo "<br/>Decode file to json";
      //echo "FILE=".$fileContent;
      $data = Zend_Json_Decoder::decode($fileContent);
      
      $db = DatabaseData::getInstance();
      
      echo "<br />CACHE ID = ".$data["uniq"];
      echo "<br/>SESSION ID = ".$db->uniq;
      
      if($data["uniq"] != $db->uniq) echo "<div style=\"color:#a00;\">Cache is OUT OF DATE</div>";
      echo "<div style=\"color:#0a0;\">Cache is loaded</div>";
      
      echo "<br/>";
      
      echo "<div><b>CONTENT DATA</b></div>";
      print_r($db);
    ?>
  </body>
</html>