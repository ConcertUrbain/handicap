<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Plugins extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Appel le plugin
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  string name Nom du plugins défini dans le fichier config.xml
	     * @param  array params Paramètres à passer au plugin
	     * @return mixed
	     */
		public function call($name, $params)
		{
	    	$respond = $this->_client->call($name, $params);
	    	return $this->_jsonToTatVo($respond);
		}
		
	}