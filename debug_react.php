<?php include("includes.php"); ?>

<?php
	if (isset($_POST["submit"])) {
		
		$vote = -1;
		if (isset($_POST["vote"])) {
			$vote = 1;
		}
		echo "<br />VOTE == ".$vote;
		
		$itemId = $_POST["item-id"];
		echo "<br />ITEM == ".$itemId;
		
		api__vote($itemId, $vote);
		
		die();
	}

	$items = api__getAllItems();
	echo "<br />".count($items)." items";
	
?>

<form method="post" enctype="multipart/form-data" action="debug_react.php">
	<select name="item-id">
		<?php
			foreach($items as $i) {
				$rate = api__getVotes($i->id);
				echo "<option name=\"item-id\" value=\"".$i->id."\">ITEM #".$i->id." -- ".$i->title." (note:".$rate.")</option>";
			}
		?>
	</select>
	<p>BIEN ? <input name="vote" type="checkbox" /></p>
	<p><input type="submit" name="submit" /></p>
</form>

<a href="index.php">back</a>