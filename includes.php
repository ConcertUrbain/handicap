<?php
	session_start();
	
	//ZEND
	defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));
	set_include_path('Library/');
	
	require_once 'Zend/Debug.php';
	require_once 'Zend/Date.php';
	
	//LOCAL TOOLS
	require("const.php");
	require("mp3.php");
	require("tools.php");
	//include("lib/Yml.php");
  
	//API classes
	includeRecurse("TourATour");
	
	//API related TOOLS
	require("api_tools.php");
	require("api_handicap.php");
	
	require("api_class.php");
	
	api__connect();
	

?>