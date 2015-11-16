<?php
  ini_set('display_errors', "1");
  //include("includes.php");
?>
<html>
  <head>
    <meta charset='utf-8' />
    <link rel="stylesheet" type="text/css" href="styles/reset.css?v=1" />
    <link rel="stylesheet" type="text/css" href="styles/main.css?v=1" />
  </head>
  <body style="background-color:#fff; color:#000;text-align:left;padding:20px;">
    <?php
      /*
      $data = DatabaseData::getInstance(true);
      //$data->display_simple();
      print_r($data->display_query_info(76));
      */
    ?>
    <?php
      
      function showQuestions(){
        $data = mysql_query("SELECT * FROM `queries` ORDER BY id DESC");
        $out = array();
        while($row = mysql_fetch_array($data, MYSQL_ASSOC)){
          array_push($out, $row);
        }
        
        echo mysql_num_rows($data)." questions<br />";
        
        foreach($out as $o){
          echo "<div>(".$o["id"].") ".$o["content"]."</div>";
          //print_r($o);
        }
      }
      
      //root@ns368978.ovh.net
      //http://ns368978.ovh.net:3306
      
      $handle = mysql_connect("ns368978.ovh.net", "ws_users_preprod", "tat-preprod") or die("Connection error");
      mysql_select_db("admin_tour-a-tour_preprod") or die ("Selection error");
      echo "<br /><div>DB = admin_tour-a-tour_preprod</div>";
      showQuestions();
      mysql_close($handle);
      
      $handle = mysql_connect("ns368978.ovh.net", "ws_user", "concert") or die("Connection error");
      mysql_select_db("dring93_tour-a-tour") or die ("Selection error");
      echo "<br /><div>DB = dring93_tour-a-tour</div>";
      showQuestions();
      mysql_close($handle);
      
      
    ?>
    
    <?php include("analytics.php"); ?>
    <?php include("text-to-speech-toggle.php"); ?>
  </body>

</html>
