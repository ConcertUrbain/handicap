<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Items extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les items contenus dans la base de données en fonction de
	     * Options:
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
	    public function getItems($options = array())
	    {
	    	$respond = $this->_client->getItems($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne un item de la base de données en fonction de son identifiant
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int itemId Identifiant d'un item
	     * @return Vo_Item
	     */
	    public function getItemById($itemId)
	    {
	    	$respond = $this->_client->getItemById($itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne tous les items contenu dans une question
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId Identifiant d'une question
	     * @return array
	     */
	    public function getItemsByQueryId($queryId)
	    {
	    	$respond = $this->_client->getItemsByQueryId($queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un item à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Item item Un item
	     * @return void Identifiant du nouvel item
	     */
	    public function addItem( Vo_Item $item)
	    {
	    	$respond = $this->_client->addItem($item);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie un item dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Item item Un item
	     * @return void
	     */
	    public function setItem( Vo_Item $item)
	    {
	    	$respond = $this->_client->setItem($item);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime un item de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int itemId Identifiant d'un item
	     * @return void
	     */
	    public function deleteItem($itemId)
	    {
	    	$respond = $this->_client->deleteItem($itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un comment à un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Comment comment Un commentaire
	     * @param  int itemId Identifiant d'un item
	     * @return int Identifiant du nouveau commentaire
	     */
	    public function addCommentIntoItem( Vo_Comment $comment, $itemId)
	    {
	    	$respond = $this->_client->addCommentIntoItem($comment, $itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un comment à un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  string contentOfComment Contenu du nouveau commentaire
	     * @param  int itemId Identifiant d'un item
	     * @return int Identifiant du nouveau commentaire
	     */
	    public function addCommentIntoItemPatch($contentOfComment, $itemId)
	    {
	    	$respond = $this->_client->addCommentIntoItemPatch($contentOfComment, $itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire un commentaire à un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int commentId Identifiant d'un commentaire
	     * @param  int itemId Identifiant d'un item
	     * @return void
	     */
	    public function removeCommentFromItem($commentId, $itemId)
	    {
	    	$respond = $this->_client->removeCommentFromItem($commentId, $itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un média à un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Media_Abstract media Un média
	     * @param  int itemId Identifiant d'un item
	     * @return int Identifiant du nouveau média
	     */
	    public function addMediaIntoItem( Vo_Media_Abstract $media, $itemId)
	    {
	    	$respond = $this->_client->addMediaIntoItem($media, $itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire un média d'un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId Identifiant d'un média
	     * @param  string mediaType Type du média
	     * @param  int itemId Identifiant d'un item
	     * @return void
	     */
	    public function removeMediaFromItem($mediaId, $mediaType, $itemId)
	    {
	    	$respond = $this->_client->removeMediaFromItem($mediaId, $mediaType, $itemId);
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
	     * Ajoute une data dans le Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Data_Abstract data Une data
	     * @param  int voId Identifiant du Value Object
	     * @return void
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

	    /**
	     * Dans le total des votes d'un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int voId Identifiant de l'item
	     * @return int
	     */
	    public function getRateOfItem($itemId)
	    {
	    	$respond = $this->_client->getRateOfItem($itemId);
	    	return $this->_jsonToTatVo($respond);
	    }
		
	}