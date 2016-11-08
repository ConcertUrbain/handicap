<?php

  define("_USE_AUTOSTART_VIDEO", "1");
  define("_USE_AUTOSTART_SOUND", "1");

  define("USE_LOADCACHE", "0");
  define("USE_CACHE", "0");

  define("MEDIA_PATH", $_ENV["MEDIAS_CENTER_URL"]);
  define("FORM_DATA", "formdata");

  define("DATA_CACHE", "cache");
  define("UPLOAD", "upload");

  define("CACHE_FOLDER", "cache/");
  define("CACHE_FILE", "db_cache");
  define("CACHE_FILE_EXT", "json");

  define("PRESENTATION_VIDEO", "MC-MWEkZkGV-V");
  define("TUTORIEL_VIDEO", "MC-SSrTChQK-V");

	$apiKeys = array(
		"API_HANDICAP" => $_ENV["API_KEY"]
	);

  define("COMMENT_SAME_PAGE", "1");
?>
