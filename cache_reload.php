<?php
  ini_set('display_errors', '1');
  include("includes.php");
?>
<html>
  <head>CACHE RELOADER</head>
  <body>
    <?php
      
      //create cache file
      DatabaseData::cache__save(true);
    ?>
  </body>
</html>