<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Queries extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les questions contenues dans la base de données en
	     * de options
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
	    public function getQueries($options = array())
	    {
	    	$respond = $this->_client->getQueries($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne une question de la base de données en fonction de son
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId Identifiant d'une question
	     * @return Vo_Query
	     */
	    public function getQueryById($queryId)
	    {
	    	$respond = $this->_client->getQueryById($queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne toutes les questions contenues dans une session
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int sessionId Identifiant d'une session
	     * @return array
	     */
	    public function getQueriesBySessionId($sessionId)
	    {
	    	$respond = $this->_client->getQueriesBySessionId($sessionId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne toutes les questions contenant un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int sessionId Identifiant d'une session
	     * @return array
	     */
	    public function getQueriesByItemId($itemId)
	    {
	    	$respond = $this->_client->getQueriesByItemId($itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une question à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Query query Une question
	     * @return int Identifiant de la question
	     */
	    public function addQuery( Vo_Query $query)
	    {
	    	$respond = $this->_client->addQuery($query);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie une question dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Query query Une question
	     * @return void
	     */
	    public function setQuery( Vo_Query $query)
	    {
	    	$respond = $this->_client->setQuery($query);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime une question de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId Identifiant d'une question
	     * @return void
	     */
	    public function deleteQuery($queryId)
	    {
	    	$respond = $this->_client->deleteQuery($queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un item à une question
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Item item Un item
	     * @param  int queryId Identifiant d'une question
	     * @return int Identifiant du nouvel item
	     */
	    public function addItemIntoQuery( Vo_Item $item, $queryId)
	    {
	    	$respond = $this->_client->addItemIntoQuery($item, $queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire un item d'une question
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int itemId Identifiant d'un item
	     * @param  int queryId Identifiant d'une question
	     * @return void
	     */
	    public function removeItemFromQuery($itemId, $queryId)
	    {
	    	$respond = $this->_client->removeItemFromQuery($itemId, $queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un média à un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Media_Abstract media Un média
	     * @param  int queryId Identifiant d'une question
	     * @return void
	     */
	    public function addMediaIntoQuery( Vo_Media_Abstract $media, $queryId)
	    {
	    	$respond = $this->_client->addMediaIntoQuery($media, $queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire un média d'un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId Identifiant d'un média
	     * @param  string mediaType Type du média
	     * @param  int queryId Identifiant d'une question
	     * @return void
	     */
	    public function removeMediaFromQuery($mediaId, $mediaType, $queryId)
	    {
	    	$respond = $this->_client->removeMediaFromQuery($mediaId, $mediaType, $queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une métadonnées dans le Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Meta meta Un métadonnée
	     * @param  int voId Identifiant du Value Object
	     * @return int Identifiant de la nouvelle métadonnée
	     */
	    public function addMetaIntoVo( Vo_Meta $meta, $voId)
	    {
	    	$respond = $this->_client->addMetaIntoVo($meta, $voId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire une métadonnée du Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int metaId Identifiant d'une métadonnée
	     * @param  int voId Identifiant du Value Object
	     * @return void
	     */
	    public function removeMetaFromVo($metaId, $voId)
	    {
	    	$respond = $this->_client->removeMetaFromVo($metaId, $voId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un utilisateur dans le Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int voId Identifiant du Value Object
	     * @return void
	     */
	    public function getUserFromVo($voId)
	    {
	    	$respond = $this->_client->getUserFromVo($voId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire un utilisateur du Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId Identifiant d'un utilisateur
	     * @param  int voId Identifiant du Value Object
	     * @return void
	     */
	    public function setUserOfVo($userId, $voId)
	    {
	    	$respond = $this->_client->setUserOfVo($userId, $voId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne tous les Values Objects du type du service ayant pour
	     * celui précisé
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId Identifiant d'un utilisateur
	     * @return array
	     */
	    public function getVosByUserId($userId)
	    {
	    	$respond = $this->_client->getVosByUserId($userId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Valide ou invalide un Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int voId Identifiant du Value Object
	     * @param  bool trueOrFalse True pour valide et false pour invalide
	     * @param  bool all Si true, alors tous les enfants du Value Object seront validés ou invalidés
	     * @return void
	     */
	    public function validateVo($voId, $trueOrFalse, $all = false)
	    {
	    	$respond = $this->_client->validateVo($voId, $trueOrFalse, $all);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une data dans le Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Data_Abstract data Une data
	     * @param  int voId Identifiant du Value Object
	     * @return int Identifiant de la nouvelle data
	     */
	    public function addDataIntoVo( Vo_Data_Abstract $data, $voId)
	    {
	    	$respond = $this->_client->addDataIntoVo($data, $voId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire une data du Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int dataId Identifaint d'une data
	     * @param  string dataType Type de la data
	     * @param  int voId Identifiant du Value Object
	     * @return void
	     */
	    public function removeDataFromVo($dataId, $dataType, $voId)
	    {
	    	$respond = $this->_client->removeDataFromVo($dataId, $dataType, $voId);
	    	return $this->_jsonToTatVo($respond);
	    }
		
	}