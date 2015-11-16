<?php
	ini_set('display_errors', "1");
	include("includes.php");
?>
<?php
	echo "<hr>";
	$qsts = getQuestions();
	var_dump($qsts);
	echo "<hr>QUESTIONS<hr>";
	foreach($qsts as $q){
		var_dump($q);echo "<br/><br/>";
	}
	echo "<hr>EACH QUESTIONS<hr>";
	foreach($qsts as $q){
		var_dump($q["id"]);echo "<br/>";
	}
	echo "<hr>QUESTION 76<hr>";
	var_dump(getQuestion(76));	
	echo "<hr>CURRENT QUESTION<hr>";
	var_dump(getCurrentQuestion());	
	echo "<hr>ITEMS<hr>";
	$items = getItems(76);
	var_dump($items);
	echo "<hr>ITEM index 2<hr>";
	$item = $items[2];
	var_dump($item);
	echo "<hr>ITEM MORE OF ITEMS<hr>";
	$more = getItemMore($items);
	var_dump($more);
	echo "<hr>ITEM RATE<hr>";
	$voteCount = getItemRate($item);
	var_dump($voteCount);
	echo "<hr>ITEM COMMENTS<hr>";
	$voteCount = getItemComments($item);
	var_dump($voteCount);
	echo "<hr>SPECIFIC ITEM COMMENTS<hr>";
	$item = getItem(79, 1367);
	var_dump($item);
	
	$comments = getItemComments($item);
	if(count($comments) < 1)	echo "Pas de coms";
	else{
		foreach($comments as $com){
			if(is_object($com)) $com = (array)$com;
			echo $com["content"]."<br/>";
		}
	}
	echo "<br/>Media Id = ".getItemMediaId($item);
?>