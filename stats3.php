<?php
	ini_set('max_execution_time', 300);

	include("includes.php");

	$outputCsv = '';
	$fileName = 'export-csv.csv';
	$nbTotalAudio = 0;
	$nbTotalVideo = 0;
	$nbTotalTexte = 0;
	$nbTotalImage = 0;
	$nbTotalComTem = 0;
	$nbTotalVotePlus = 0;
	$nbTotalVoteMoins = 0;
	

	$outputCsv.= ";Extraction des donnés de la plateforme de débat numérique 'Mes idées aussi?!'\r\n";

	$questions = getQuestions();

// QUESTIONS			
	foreach($questions as $q){
		//var_dump($q);
		//print_r($q);
		$text = "";
		$nbTem = 0;
		$nbComTem = 0;
		$votePlusQu = 0;
		$voteMoinsQu = 0;
		$nbAudio = 0;
		$nbVideo = 0;
		$nbTexte = 0;
		$nbImage = 0;

		$outputCsv.= "\r\n\r\n"; // Sauter 2 lignes avant de commencer la question
		$outputCsv.= ";".$q["content"]."\r\n";	// Titre de la question
		$outputCsv.= "Id;Titre de la contribution;Descriptif de la contribution;Nom Tag;Contenu tag;Vote favorables;Vote défavorables;Média;Commentaires\r\n";

		$medias = getItems($q["id"]);
		if(count($medias) > 0)
		{
			$nbTem = count($medias);

// TEMOIGNAGES					
			foreach($medias as $m)
			{
				$votePlus = 0;
				$voteMoins = 0;

				$datas = api__getDatas($m->id);
				foreach ($datas['Vote'] as $vote) {
					if ( intval($vote->rate) > 0 ) {
						$votePlus++;
					} elseif (intval($vote->rate) < 0) {
						$voteMoins++;
					}
				}
				
				$votePlusQu += $votePlus;
				$voteMoinsQu += $voteMoins;
				
				$comments = getItemComments($m);
				
				$metas = getMetas($m);
				$tagName = "";
				$tagContent = "";
				if(count($metas) > 0)
				{
					foreach($metas as $meta)
					{
						if(is_object($meta))
							$meta = (array)$meta;
						
						$tagName = $meta["name"];
						$tagContent = $meta["content"];
					}/*
					$tagName = $metas["name"];
					$tagContent = $metas["content"];*/
				}
				
				$typeMedia = getItemMediaType($m);
				if($typeMedia === 'T')
				{
					$typeMedia = "Texte";
					$nbTexte++;
				}
				else if($typeMedia === 'A')
				{
					$typeMedia = "Audio";
					$nbAudio++;
				}
				else if($typeMedia === 'V')
				{
					$typeMedia = "Vidéo";
					$nbVideo++;
				}
				else if($typeMedia === 'P')
				{
					$typeMedia = "Image";
					$nbImage = 0;
				}

				if(is_object($m))
					$m = (array)$m;
				    /*while(list($key,$valeur)=each($m))
					{
					echo $key." : ";
					echo $valeur;
					echo '<br />';
					}*/
				
				$title = $m["title"];
				$id = $m["id"];
				$description = $m["description"];
				$vote = $m["_rate"];
				
				$description = preg_replace("/\\n/"," ",$description);	// Suppression des sauts de ligne dans le descriptif
				$description = preg_replace("/\"/","\"\"",$description);	// Doubler les guillemets pour éviter les problèmes de séparateurs de trop
				

				if(stripos($title, "Brigitte Jeanvoine") === FALSE && stripos($title, "TEST") === FALSE)
				{
					if(strlen($title) <= 0)
					$title = "[PAS DE TITRE]";
					
					$outputCsv.= $id.";\"".trim($title)."\";\"".$description."\";\"".$tagName."\";\"".$tagContent."\";\"".$votePlus."\";\"".$voteMoins."\";\"".$typeMedia."\";";

					// Commentaires du témoignage courant
					$nbComment = count($comments);
					$textComments = "";
					if($nbComment > 0)
					{
// COMMENTAIRES
						$nbComTem += $nbComment;
						foreach($comments as $c)
						{
							if(is_object($c))
							$c = (array)$c;
							$comment = $c["content"];
							if(stripos($comment, "test") === FALSE)
							{
								$comment = preg_replace("/\\n/"," ",$comment);	// Suppression des sauts de ligne dans les commentaires
								$comment = preg_replace("/\"/","\"\"",$comment);	// Doubler les guillemets pour éviter les problèmes de séparateurs de trop
								$textComments .= "\"".trim($comment)."\";";
							}
						}
					}
					
					$outputCsv.= $textComments."\r\n";
					//echo htmlspecialchars_decode( $textComments ) . "<br/>";
				}
				else
				$nbTem --; // retirer du décompte les tests et messages officiels
			}

			$outputCsv.= "\r\n";
			$outputCsv.= ";Nombre de contribution;Audio;Vidéo;Ecrit;photos;Nombre de commentaires associés;Nombre de votes;Votes favorables;Votes défavorables\r\n";
			$sommeVotes = $votePlusQu+$voteMoinsQu;
			$outputCsv.= "\"Total ".$q["content"]."\";\"".$nbTem."\";\"".$nbAudio."\";\"".$nbVideo."\";\"".$nbTexte."\";\"".$nbImage."\";\"".$nbComTem."\";\"".$sommeVotes."\";\"".$votePlusQu."\";\"".$voteMoinsQu."\"\r\n";
			

			$nbTotalTem += $nbTem;
			$nbTotalAudio += $nbAudio;
			$nbTotalVideo += $nbVideo;
			$nbTotalTexte += $nbTexte;
			$nbTotalImage += $nbImage;
			$nbTotalComTem += $nbComTem;
			$nbTotalVotePlus += $votePlusQu;
			$nbTotalVoteMoins += $voteMoinsQu;
		}
		else
		{
			echo '<div>pas de témoignage</div>';
		}
	}
	
	$outputCsv.= "\r\n";
	$outputCsv.= "\r\n";
	$outputCsv.= ";Contributions;Audio;Vidéo;Ecrit;photos;Nombre de commentaires associés;Total votes;Votes favorables;Votes défavorables\r\n";
	$sommeTotaleVote = $nbTotalVotePlus+$nbTotalVoteMoins;
	$outputCsv.= "TOTAL GENERAL;\"".$nbTotalTem."\";\"".$nbTotalAudio."\";\"".$nbTotalVideo."\";\"".$nbTotalTexte."\";\"".$nbTotalImage."\";\"".$nbTotalComTem."\";\"".$sommeTotaleVote."\";\"".$nbTotalVotePlus."\";\"".$nbTotalVoteMoins;



// Entêtes (headers) PHP qui vont bien pour la création d'un fichier Excel CSV
	header("Content-disposition: attachment; filename=".$fileName);
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: application/vnd.ms-excel\n");
	header("Pragma: no-cache");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
	header("Expires: 0");

	$output = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $outputCsv); 
	echo html_entity_decode( $output );
	exit();
?>
