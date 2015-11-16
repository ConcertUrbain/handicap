<?php

	require_once dirname(__FILE__) . '/Abstract.php';
	require_once dirname(__FILE__) . '/../Vo/Comment.php';

	class TourATour_Service_Comments extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}
		
	    /**
	     * Retourne toutes les commentaires contenus dans la base de données en
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
	    public function getComments($options = array())
	    {
	    	$respond = $this->_client->getComments($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne un commentaire de la base de données en fonction de son
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int commentId Identifiant d'un commentaire
	     * @return Vo_Comment
	     */
	    public function getCommentById($commentId)
	    {
	    	$respond = $this->_client->getCommentById($commentId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne tous les commentaire contenus dans un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int itemId Identifiant d'un item
	     * @return array
	     */
	    public function getCommentsByItemId($itemId)
	    {
	    	$respond = $this->_client->getCommentsByItemId($itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un commentaire à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Comment comment Un commentaire
	     * @return int Identifiant du nouveau commentaire
	     */
	    public function addComment( Vo_Comment $comment)
	    {
	    	$respond = $this->_client->addComment($comment);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie un commentaire dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Comment comment Un commentaire
	     * @return void
	     */
	    public function setComment( Vo_Comment $comment)
	    {
	    	$respond = $this->_client->setComment($comment);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie le lien entre un commentaire et un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Comment comment Un commentaire
	     * @param  int itemId Identifiant d'un item
	     * @return void
	     */
	    public function setItemOfComment( Vo_Comment $comment, $itemId)
	    {
	    	$respond = $this->_client->setItemOfComment($comment, $itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime un commentaire de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int commentId Identifiant d'un commentaire
	     * @return void
	     */
	    public function deleteComment($commentId)
	    {
	    	$respond = $this->_client->deleteComment($commentId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne l'utilisateur dans le Value Object
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
	     * Change l'utilisateur du Value Object
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
	     * Ajoute un vote au commentaire
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int rate Vote
	     * @param  int userId Identifiant du votant
	     * @param  int commentId Identifiant du commentaire
	     * @return void
	     */
	    public function addVoteIntoItemPatch($rate, $userId, $commentId)
	    {
	    	$respond = $this->_client->addVoteIntoItemPatch($rate, $userId, $commentId);
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