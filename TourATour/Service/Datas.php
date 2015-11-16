<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Datas extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les datas contenues dans la base de données en fonction
	     * options
	     * Options:
	     *  - where -> array(array('cond', 'value'))
	     *  - order	-> string
	     *  - limit	-> array(count, offset)
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  array options Options pour le retour de la fonction
	     * @return array
	     */
	    public function getDatas($options = array())
	    {
	    	$respond = $this->_client->getDatas($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne une data de la base de données en fonction de son identifiant
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int dataId Identifiant d'une data
	     * @param  string dataType Type de la data
	     * @return Vo_Data_Abstract
	     */
	    public function getDataById($dataId, $dataType)
	    {
	    	$respond = $this->_client->getDataById($dataId, $dataType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Short description of method getDatasByItemId
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int itemId
	     * @return array
	     */
	    public function getDatasByItemId($itemId)
	    {
	    	$respond = $this->_client->getDatasByItemId($itemId);
	    	$result = array();
	    	foreach ($respond as $key => $value) {
	    		$result[$key] = $this->_jsonToTatVo($value);
	    	}
	    	return $result;
	    }

	    /**
	     * Short description of method getDatasByCommentId
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int commentId
	     * @return array
	     */
	    public function getDatasByCommentId($commentId)
	    {
	    	$respond = $this->_client->getDatasByCommentId($commentId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Short description of method getDatasByMediaId
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId
	     * @param  string mediaType
	     * @return array
	     */
	    public function getDatasByMediaId($mediaId, $mediaType)
	    {
	    	$respond = $this->_client->getDatasByMediaId($mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Short description of method getDatasByUserId
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId
	     * @return array
	     */
	    public function getDatasByUserId($userId)
	    {
	    	$respond = $this->_client->getDatasByUserId($userId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Short description of method getDatasByQueryId
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId
	     * @return array
	     */
	    public function getDatasByQueryId($queryId)
	    {
	    	$respond = $this->_client->getDatasByQueryId($queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une data à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Data_Abstract data Une data
	     * @return int Identifiant de la nouvelle data
	     */
	    public function addData( Vo_Data_Abstract $data)
	    {
	    	$respond = $this->_client->addData($data);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie une data dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Data_Abstract data Une data
	     * @return void
	     */
	    public function setData( Vo_Data_Abstract $data)
	    {
	    	$respond = $this->_client->setData($data);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime une data de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int dataId Identifiant d'une data
	     * @param  string dataType Type d'une data
	     * @return void
	     */
	    public function deleteData($dataId, $dataType)
	    {
	    	$respond = $this->_client->deleteData($dataId, $dataType);
	    	return $this->_jsonToTatVo($respond);
	    }
		
	}