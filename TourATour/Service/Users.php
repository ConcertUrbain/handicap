<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Users extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les utilisateurs contenus dans la base de données en
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
	    public function getUsers($options = array())
	    {
	    	$respond = $this->_client->getUsers($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne un utilisateur de la base de données en fonction de son
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId Identifiant d'un utilisateur
	     * @return Vo_User
	     */
	    public function getUserById($userId)
	    {
	    	$respond = $this->_client->getUserById($userId);
	    	return $this->_jsonToTatVo($respond);
	    }
		
	    /**
	     * Ajoute un utilisateur à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_User user Un utilisateur
	     * @return int Identifiant du nouvel utilisateur
	     */
	    public function addUser( Vo_User $user)
	    {
	    	$respond = $this->_client->addUser($user);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie un utilisateur dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_User user Un utilisateur
	     * @return void
	     */
	    public function setUser( Vo_User $user)
	    {
	    	$respond = $this->_client->setUser($user);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime un utilisateur de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId Identifiant d'un utilisateur
	     * @return void
	     */
	    public function deleteUser($userId)
	    {
	    	$respond = $this->_client->deleteUser($userId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Bannir ou débannir un utilisateur
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId Identifiant d'un utilisateur
	     * @param  bool trueOrFalse True pour bannir, false pour débannir
	     * @return void
	     */
	    public function banUser($userId, $trueOrFalse)
	    {
	    	$respond = $this->_client->banUser($userId, $trueOrFalse);
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