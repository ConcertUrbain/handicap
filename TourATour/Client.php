<?php

	require_once dirname(__FILE__) . '/Service/Comments.php';
	require_once dirname(__FILE__) . '/Service/Connection.php';
	require_once dirname(__FILE__) . '/Service/Datas.php';
	require_once dirname(__FILE__) . '/Service/Items.php';
	require_once dirname(__FILE__) . '/Service/Medias.php';
	require_once dirname(__FILE__) . '/Service/Plugins.php';
	require_once dirname(__FILE__) . '/Service/Queries.php';
	require_once dirname(__FILE__) . '/Service/Search.php';
	require_once dirname(__FILE__) . '/Service/Sessions.php';
	require_once dirname(__FILE__) . '/Service/Users.php';
	
	class TourATour_Client
	{
		/////////// SINGLETON ////////////
		
		private static $_instance;
	    
		private function __contruct() {}
		
		
	    /**
	     * @return TourATour_Client
	     */
		public static function getInstance()
		{
			if(!isset(self::$_instance))
			{
				 $klass = __CLASS__;
				self::$_instance = new $klass;
			}
			return self::$_instance;
		}
		
		public function __clone()
	    {
	        trigger_error("Le clônage n'est pas autorisé.", E_USER_ERROR);
	    }
	    
	    ////////////////////////////////
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Comments
	     */
		public $commentsService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Connection
	     */
		public $connectionService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Datas
	     */
		public $datasService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Items
	     */
		public $itemsService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Medias
	     */
		public $mediasService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Plugins
	     */
		public $pluginsService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Queries
	     */
		public $queriesService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Search
	     */
		public $searchService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Sessions
	     */
		public $sessionsService;
	    
	 	/**
	     * @access public
	     * @var TourATour_Service_Users
	     */
		public $usersService;
		
		////////////////////////////////////////
		private $_apiKey;
		
	    /**
	     * @return TourATour_Client
	     */
		public function init($url, $apiKey)
		{
			$this->_apiKey = $apiKey;
			
			$this->commentsService 		= new TourATour_Service_Comments	($url . '/comments/json');
			$this->connectionService 	= new TourATour_Service_Connection	($url . '/connection/json');
			$this->datasService 		= new TourATour_Service_Datas		($url . '/datas/json');
			$this->itemsService 		= new TourATour_Service_Items		($url . '/items/json');
			$this->mediasService 		= new TourATour_Service_Medias		($url . '/medias/json');
			$this->pluginsService 		= new TourATour_Service_Plugins		($url . '/plugins/json');
			$this->queriesService 		= new TourATour_Service_Queries		($url . '/queries/json');
			$this->searchService 		= new TourATour_Service_Search		($url . '/search/json');
			$this->sessionsService 		= new TourATour_Service_Sessions	($url . '/sessions/json');
			$this->usersService 		= new TourATour_Service_Users		($url . '/users/json');
			return $this;
		}
		
		
	    /**
	     * @return bool
	     */
		public function connect($login, $pass)
		{
			$this->_clearSessionKey();
			$sessionKey = $this->connectionService->login($login, $pass, $this->_apiKey);
			if($sessionKey)
			{
				$_SESSION['touratour_session_key'] = $sessionKey;
				
				$this->commentsService->setSessionKey($sessionKey);
				$this->connectionService->setSessionKey($sessionKey);
				$this->datasService->setSessionKey($sessionKey);
				$this->itemsService->setSessionKey($sessionKey);
				$this->mediasService->setSessionKey($sessionKey);
				$this->pluginsService->setSessionKey($sessionKey);
				$this->queriesService->setSessionKey($sessionKey);
				$this->searchService->setSessionKey($sessionKey);
				$this->sessionsService->setSessionKey($sessionKey);
				$this->usersService->setSessionKey($sessionKey);
				
				return true;
			}
			else
				return false;
		}
		
		public function disconnect()
		{
			unset($_SESSION['touratour_session_key']);
			$this->connectionService->logout();
		}
		
		private function _clearSessionKey()
		{
			unset($_SESSION['touratour_session_key']);
				
			$this->commentsService->setSessionKey(false);
			$this->connectionService->setSessionKey(false);
			$this->datasService->setSessionKey(false);
			$this->itemsService->setSessionKey(false);
			$this->mediasService->setSessionKey(false);
			$this->pluginsService->setSessionKey(false);
			$this->queriesService->setSessionKey(false);
			$this->searchService->setSessionKey(false);
			$this->sessionsService->setSessionKey(false);
			$this->usersService->setSessionKey(false);
		}
	}