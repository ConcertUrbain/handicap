<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Connection extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}
	    
	    public function login($login, $pass, $apiKey)
	    {
	    	$respond = $this->_client->login($login, $pass, $apiKey);
	    	return $this->_jsonToTatVo($respond);
	    }
	    
	    public function logout()
	    {
	    	$respond = $this->_client->logout();
	    	return $this->_jsonToTatVo($respond);
	    }
		
	}