<?php

	/**
	 * Value Object de la data vote
	 *
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 * @package Vo
	 * @subpackage Data
	 */

	/**
	 * Classe d'abstraction de data
	 *
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 */
	require_once(dirname(__FILE__) . '/../Data/Abstract.php');

	/* user defined includes */

	/* user defined constants */

	/**
	 * Value Object de la data vote
	 *
	 * @access public
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 * @package Vo
	 * @subpackage Data
	 */
	class Vo_Data_Vote extends Vo_Data_Abstract
	{
	    // --- ASSOCIATIONS ---


	    // --- ATTRIBUTES ---

	    /**
	     * Value du vote
	     *
	     * @access public
	     * @var int
	     */
	    public $rate = 0;

	    /**
	     * Identifiant de auteur du vote
	     *
	     * @access private
	     * @var int
	     */
	    public $user = 0;

	    // --- OPERATIONS ---

		/**
	     * Constructeur de la classe
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  mixed item array|object|Zend_Db_Table_Row_Abstract object permettant de remplire l'instance
	     * @return mixed
	     */
	    public function __construct($item = array())
	    {
	    	parent::__construct($item);
	    }

	    protected function _getKey($key)
	    {
	    	switch($key)
	    	{
	    		case 'users_id':
	    			return 'user';
	    	}

	    	return parent::_getKey($key);
	    }

	    public function getType()
	    {
	    	return 'Vote';
	    }

	 	/**
	     * Converti le Value Object en tableau compatible avec Zend_Db_Table_Row_Abstract
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @return array
	     */
	    public function toRowArray()
	    {
	    	$returnValue = parent::toRowArray();

	    	unset($returnValue['user']);
	    	$returnValue['users_id'] = $this->user;

	    	return (array) $returnValue;
	    }

	} /* end of class Vo_Data_Vote */