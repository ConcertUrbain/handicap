<?php

	require_once dirname(__FILE__) . '/Abstract.php';

	class TourATour_Service_Search extends TourATour_Service_Abstract
	{
		
		public function __construct($url)
		{
			parent::__contruct($url);
		}

	    /**
	     * Retourne toutes les métadonnées contenues dans la base de données en
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
	    public function getMetas($options = array())
	    {
	    	$respond = $this->_client->getMetas($options);
	    	return $this->_jsonToTatVo($respond);
	    }


	    /**
	     * Retourne toutes les métadonnées d'un ValueObject
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int voId Identifiant d'un VO
	     * @param  int voType Type du VO
	     * @return array(Vo_Meta)
	     */
	    public function getMetasByVo($voId, $voType)
	    {
	    	$respond = $this->_client->getMetasByVo($voId, $voType);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne une métadonnées de la base de données en fonction de son
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int metaId Identifiant d'une métadonnée
	     * @return Vo_Meta
	     */
	    public function getMetaById($metaId)
	    {
	    	$respond = $this->_client->getMetaById($metaId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Retourne une métadonnées de la base de données en fonction de son contenu
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  string metaContent Contenu de la métadonnée
	     * @return Vo_Meta
	     */
	    public function getMetaByContent($metaContent)
	    {
	    	$respond = $this->_client->getMetaByContent($metaContent);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Ajoute une métadonnée à la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Meta meta Une métadonnée
	     * @return int Identifiant de la nouvelle métadonnée
	     */
	    public function addMeta( Vo_Meta $meta)
	    {
	    	$respond = $this->_client->addMeta($meta);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Modifie une métadonnée dans la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  Vo_Meta meta Une métadonnée
	     * @return void
	     */
	    public function setMeta( Vo_Meta $meta)
	    {
	    	$respond = $this->_client->setMeta($meta);
	    	return $this->_jsonToTatVo($respond);
	    }

	    /**
	     * Supprime une métadonnée de la base de données
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  int metaId Identifiant d'une métadonnée
	     * @return void
	     */
	    public function deleteMeta($metaId)
	    {
	    	$respond = $this->_client->deleteMeta($metaId);
	    	return $this->_jsonToTatVo($respond);
	    }

	    //////////////////////////////////////////////////////////////////////////////////

	    /**
	     * Retourne tous les Value Object répondant à la requête
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  string request requêteà executer sur la base de données
	     * @param  string section type de la recherche spécifié dans le fichier de config
	     * @return array
	     */
	    public function search($request, $section = 'Default')
	    {
	    	$respond = $this->_client->search($request, $section);
	    	return $this->_jsonToTatVo($respond);
	    }
		
	}