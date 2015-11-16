<?php

	require_once(dirname(__FILE__) . '/../utils/jsonrpcphp/jsonRPCClient.php');

	abstract class TourATour_Service_Abstract
	{
		/**
	     * Client Json RPC
	     *
	     * @access protected
	     * @var jsonRPCClient
	     */
		protected $_client;
		
		public function __contruct($url)
		{
			$this->_client =  new jsonRPCClient($url, false); // last parameter is TRUE for debug mode
		}
	    
	    protected function _jsonToTatVo($params)
	    {
	    	if(is_array($params) && array_key_exists('__className', $params))
	    	{
	    		$className = $params['__className'];
	    		$params = new $className($params);
	    	}
	    	else if(is_array($params))
	    	{
	    		foreach($params as $key=>$value)
	    			$params[$key] = $this->_jsonToTatVo($value);
	    	}
	    	
	    	return $params;
	    }
	    
	    public function setSessionKey($key)
	    {
	    	if($key)
	    		$this->_client->sessionKey = $key;
	    	else
	    		$this->_client->sessionKey = null;
	    }
		
	}