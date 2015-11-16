<?php error_reporting(E_ALL); ?>
<html>
	<head>
		<meta charset='utf-8' />
		<link rel="stylesheet" type="text/css" href="styles/reset.css?v=1" />
		<link rel="stylesheet" type="text/css" href="styles/main.css?v=1" />
	</head>
	<body style="background-color:#fff;font-family:Arial;color:#000;text-align:left;padding:20px;">
		<?php
			//ini_set('display_errors', '1');
			include("includes.php");
			
			$questions = getQuestions();
			foreach($questions as $q){
				//var_dump($q);
				//print_r($q);
				$text = "";
				$nbTem = 0;
				
				echo '<div style="padding-left:10px;padding-top:20px;font-size:1.2em;">'.$q["content"].'</div>';
				echo '<div style="padding-left:20px;font-size:0.8em;">';
				
				$medias = getItems($q["id"]);
				if(count($medias) > 0)
				{
					$nbTem = count($medias);
					//echo '<div style="font-weight:bold;padding:5px;">'.count($medias).' témoignages</div>';
					
					// Témoignages
					foreach($medias as $m)
					{
						$comments = getItemComments($m);
						$metas = getMetas($m);
						$typeMedia = getItemMediaType($m);
						if($typeMedia === 'T')
							$typeMedia = "Texte";
						else if($typeMedia === 'A')
							$typeMedia = "Audio";
						else if($typeMedia === 'V')
							$typeMedia = "Vidéo";
						else if($typeMedia === 'P')
							$typeMedia = "Image";
						
						if(is_object($m))
						$m = (array)$m;
						$title = $m["title"];
						$description = $m["description"];
						
						if(stripos($title, "Brigitte Jeanvoine") === FALSE && stripos($title, "TEST") === FALSE)
						{
							if(strlen($title) <= 0)
							$title = "[PAS DE TITRE]";
							
							// Commentaires du témoignage courant
							$nbComment = count($comments);
							$textComments = "";
							if($nbComment > 0)
							{
								foreach($comments as $c)
								{
									if(is_object($c))
									$c = (array)$c;
									$comment = $c["content"];
									if(stripos($comment, "test") === FALSE)
										$textComments .= '<div style="padding-left:10px;padding-top:5px">└ '.$comment.'</div>';
								}
							}/*
							else
							{
								$textComments .= '<div>pas de commentaire</div>';
							}*/
							
							$text .= '<div style="padding-left:10px;padding-top:5px">└ '.$title.' - '.$typeMedia.' - '.$nbComment.' commentaire(s)</div>';
							$text .= '<div style="padding-left:10px;padding-top:5px">Description : '.$description.'</div>';
							$text .= '<div style="padding-left:10px;">';
							$text .= $textComments;
							$text .= '</div>';
							
							
							//var_dump($metas);
							if(count($metas) > 0)
							{
								foreach($metas as $meta)
								{
									if(is_object($meta))
									$meta = (array)$meta;
									//var_dump($meta);
									//echo '<div style="padding-left:30px;">'.$meta["name"]." : ".$meta["content"].'</div>';
									$text .= '<div style="padding-left:30px;">'.$meta["name"]." : ".$meta["content"].'</div>';
								}
							}
							
							
							//var_dump($metas);
						}
						else
						$nbTem --; // retirer du décompte les tests et messages officiels
					}
					$text = '<div style="font-weight:bold;padding:5px;">'.$nbTem.' témoignages</div>' . $text;
					echo $text;
				}
				else
				{
					echo '<div>pas de témoignage</div>';
				}
				echo '</div>';
				
			}
			//print_r($data->queries);
		?>
		
		<?php include("analytics.php"); ?>
		<?php include("text-to-speech-toggle.php"); ?>
	</body>
	
</html>
