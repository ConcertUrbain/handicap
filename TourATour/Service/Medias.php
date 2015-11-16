<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Medias extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les médias contenus dans la base de données en fonction
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
	    public function getMedias($options = array())
	    {
	    	$respond = $this->_client->getMedias($options);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne un média de la base de données en fonction de son identifiant
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId Identifiant d'un média
	     * @param  string mediaType Type du média
	     * @return Vo_Media_Abstract
	     */
	    public function getMediaById($mediaId, $mediaType)
	    {
	    	$respond = $this->_client->getMediaById($mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne tous les média contenus dans un item
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int itemId Identifiant d'un item
	     * @return array
	     */
	    public function getMediasByItemId($itemId)
	    {
	    	$respond = $this->_client->getMediasByItemId($itemId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne tous les média contenus dans une question
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int queryId Identifiant d'une question
	     * @return array
	     */
	    public function getMediasByQueryId($queryId)
	    {
	    	$respond = $this->_client->getMediasByQueryId($queryId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un média à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Media_Abstract media Un média
	     * @return int Identifiant du nouveau média
	     */
	    public function addMedia( Vo_Media_Abstract $media)
	    {
	    	$respond = $this->_client->addMedia($media);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie un média dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Media_Abstract media Un média
	     * @return void
	     */
	    public function setMedia( Vo_Media_Abstract $media)
	    {
	    	$respond = $this->_client->setMedia($media);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime un média de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId Identifiant d'un média
	     * @param  string mediaType Type du média
	     * @return void
	     */
	    public function deleteMedia($mediaId, $mediaType)
	    {
	    	$respond = $this->_client->deleteMedia($mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute un utilisateur au média
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @return void
	     */
	    public function getUserFromMedia($mediaId, $mediaType)
	    {
	    	$respond = $this->_client->getUserFromMedia($mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire un utilisateur du média
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int userId Identifiant d'un utilisateur
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @return void
	     */
	    public function setUserOfMedia($userId, $mediaId, $mediaType)
	    {
	    	$respond = $this->_client->setUserOfMedia($userId, $mediaId, $mediaType);
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
	    public function getMediasByUserId($userId)
	    {
	    	$respond = $this->_client->getMediasByUserId($userId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une métadonnées dans le Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Meta meta Un métadonnée
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @return int Identifiant de la nouvelle métadonnée
	     */
	    public function addMetaIntoMedia( Vo_Meta $meta, $mediaId, $mediaType)
	    {
	    	$respond = $this->_client->addMetaIntoMedia($meta, $mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire une métadonnée du Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int metaId Identifiant d'une métadonnée
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @return void
	     */
	    public function removeMetaFromMedia($metaId, $mediaId, $mediaType)
	    {
	    	$respond = $this->_client->removeMetaFromMedia($metaId, $mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Valide ou invalide un média
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @param  bool trueOrFalse True pour valide et false pour invalide
	     * @return void
	     */
	    public function validateMedia($mediaId, $mediaType, $trueOrFalse)
	    {
	    	$respond = $this->_client->validateMedia($mediaId, $mediaType, $trueOrFalse);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une data au média
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Data_Abstract data Une data
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @return int Identifiant de la nouvelle data
	     */
	    public function addDataIntoMedia( Vo_Data_Abstract $data, $mediaId, $mediaType)
	    {
	    	$respond = $this->_client->addDataIntoMedia($data, $mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retire une data du média
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int dataId Identifaint d'une data
	     * @param  string dataType Type de la data
	     * @param  int mediaId Identifiant du média
	     * @param  string mediaType Type du média
	     * @return void
	     */
	    public function removeDataFromMedia($dataId, $dataType, $mediaId, $mediaType)
	    {
	    	$respond = $this->_client->removeDataFromMedia($dataId, $dataType, $mediaId, $mediaType);
	    	return $this->_jsonToTatVo($respond);
	    }
		
	}