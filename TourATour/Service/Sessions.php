<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Sessions extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les sessions contenus dans la base de données en fonction
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
	    public function getSessions($options = array())
	    {
	    	$respond = $this->_client->getSessions($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne une session de la base de données en fonction de son identifiant
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int sessionId Identifiant d'une session
	     * @return Vo_Session
	     */
	    public function getSessionById($sessionId)
	    {
	    	$respond = $this->_client->getSessionById($sessionId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne toutes les sessions contenant une question
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId Identifiant d'une question
	     * @return array
	     */
	    public function getSessionsByQueryId($queryId)
	    {
	    	$respond = $this->_client->getSessionsByQueryId($queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une session à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Session session Une session
	     * @return int Identifiant de la nouvelle session
	     */
	    public function addSession( Vo_Session $session)
	    {
	    	$respond = $this->_client->addSession($session);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie une session dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Session session Une session
	     * @return void
	     */
	    public function setSession( Vo_Session $session)
	    {
	    	$respond = $this->_client->setSession($session);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime une session de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int sessionId Identifiant d'une session
	     * @return void
	     */
	    public function deleteSession($sessionId)
	    {
	    	$respond = $this->_client->deleteSession($sessionId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une question à une session dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Query query Une question
	     * @param  int sessionId Identifiant d'une session
	     * @return int Identifiant de la nouvelle question
	     */
	    public function addQueryIntoSession( Vo_Query $query, $sessionId)
	    {
	    	$respond = $this->_client->addQueryIntoSession($query, $sessionId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire une question à une session dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId Identifiant d'une question
	     * @param  int sessionId Identifiant d'une session
	     * @return void
	     */
	    public function removeQueryFromSession($queryId, $sessionId)
	    {
	    	$respond = $this->_client->removeQueryFromSession($queryId, $sessionId);
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
		
	}