<?php include("includes.php"); ?>

<?php
	$questions = api__getQueries();
?>

<div style="margin-left:50px;border-style:solid;width:500px;">

<form method="post" enctype="multipart/form-data" action="upload.php">
	<input type="hidden" value="1" name="add-item" />
	
	<select name="question-id">
		<?php
			foreach($questions as $q) {
				echo "<option value=\"".$q->id."\">QUESTION #".$q->id." -- ".$q->content."</option>";
			}
		?>
	</select>
	<p>ITEM-TITLE<input name="title" /></p>
	<p>ITEM-DESCRIPTION<input name="description" /></p>
	<p><input name="file" id="file" type="file" /></p>
	<p><input type="submit" name="submit" /></p>
</form>

</div>

<a href="index.php">BACK</a>

<hr />

<div style="font-size:0.6em">
<?php
	echo "QUESTIONS COUNT = ".count($questions);
	foreach($questions as $q) {
		$items = api__getItems($q->id);
		echo "<br />QST #".$q->id." has ".count($items)." items";
		echo "<ul>";
		foreach($items as $item){
			echo "<li>ITEM #".$item->id." -- ".$item->title."</li>";
		}
		echo "</ul>";
	}
?>
</div>