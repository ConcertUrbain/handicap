<?php

	/**
	 * ValueObject d'un item
	 *
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 * @package Vo
	 */

	/**
	 * Classe d'abstraction de Value Object
	 *
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 */
	require_once(dirname(__FILE__) . '/Abstract.php');

	/**
	 * Interface des Values Objects pour être modérés
	 *
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 */
	require_once(dirname(__FILE__) . '/Interface/Validate.php');

	/* user defined includes */

	/* user defined constants */

	/**
	 * ValueObject d'un item
	 *
	 * @access public
	 * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	 * @package Vo
	 */
	class Vo_Item extends Vo_Abstract implements Vo_Interface_Validate
	{
	    // --- ASSOCIATIONS ---


	    // --- ATTRIBUTES ---

	    /**
	     * Identifiant de l'item
	     *
	     * @access public
	     * @var int
	     */
	    public $id = 0;

	    /**
	     * Tableau des identifiant toutes les questions contenant l'item
	     *
	     * @access private
	     * @var array
	     */
	    protected $_queries = array();

	    /**
	     * Identifiant de auteur de l'item
	     *
	     * @access private
	     * @var int
	     */
	    protected $_user = 0;

	    /**
	     * Titre de l'item
	     *
	     * @access public
	     * @var string
	     */
	    public $title = '';

	    /**
	     * Description de l'item
	     *
	     * @access public
	     * @var string
	     */
	    public $description = '';

	    /**
	     * Date d'ajout de l'item
	     *
	     * @access public
	     * @var Zend_Date
	     */
	    protected $_addDate = null;

	    /**
	     * Date de modification de l'item
	     *
	     * @access public
	     * @var Zend_Date
	     */
	    protected $_setDate = null;

	    /**
	     * Note de l'item
	     *
	     * @access public
	     * @var int
	     */
	    protected $_rate = 0;

	    /**
	     * Boolean permettant la modération
	     *
	     * @access private
	     * @var bool
	     */
	    protected $_isValid = false;

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
	    		case 'user':
	    		case 'rate':
	    		case 'comments':
	    		case 'datas':
	    		case 'metas':
	    			return '_' . $key;
	    		case 'users_id':
	    			return '_user';
	    		case 'queries_id':
	    		case 'items_id':
	    		case 'metas_id':
	    		case 'sessions_id':
	    		case '__className':
	    			return null;
	    		default:
	    			return $key;
	    	}
	    	return $key;
	    }

	    /**
	     * Permet de valider et d'invalider le Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @param  bool trueOrFalse True pour valide et false pour invalide
	     * @return void
	     */
	    public function validate($trueOrFalse)
	    {
	    	$this->_isValid = (bool) $trueOrFalse;
	    }

	    /**
	     * Retourne un boolean indiquant l'état de validation du Value Object
	     *
	     * @access public
	     * @author Mathieu Desvé, <mathieu.desve@unflux.fr>
	     * @return bool
	     */
	    public function isValid()
	    {
	        return (bool) $this->_isValid;
	    }

	    public function __set($variableName, $value)
	    {
			switch($variableName)
			{
				case 'addDate':
				case 'setDate':
					$variableName = '_' . $variableName;

					if(is_null($value) || $value == '')
					{
						$this->$variableName = null;
						return;
					}

					if($value instanceof Zend_Date)
					{
						$this->$variableName = $value;
						return;
					}

					if(Zend_Date::isDate($value, 'YYYY.MM.dd HH:mm:ss'))
					{
						$this->$variableName = new Zend_Date($value, 'YYYY.MM.dd HH:mm:ss');
						return;
					}

					throw new Vo_Exception("La chaine de caractères n'est pas une date ou n'est pas au format ISO 8601 ('$variableName': '$value')", 4);
					break;
				case 'user':
				case 'rate':
					$variableName = '_' . $variableName;

					if(is_null($value))
					{
						$this->$variableName = null;
						return;
					}

					$this->$variableName = $value;
					return;

					break;
				case "isValid":
					$this->validate($value);
					return;
					break;
				case 'users_id':
					$this->_user = $value;
					return;
					break;
			}
	    	parent::__set($variableName, $value);
	    }

	    public function __get($variableName)
	    {
			switch($variableName)
			{
				case 'addDate':
				case 'setDate':
				case 'user':
				case 'rate':
					$variableName = '_' . $variableName;
					return $this->$variableName;
					break;
				case 'isValid':
					return $this->isValid();
				case 'users_id':
					return $this->_user;
			}
	    	parent::__get($variableName);
	    }

	    public function toArray()
	    {
	    	$returnValue = parent::toArray();

	    	$returnValue['_isValid'] = $this->_isValid;
	    	$returnValue['_user'] = $this->_user;
	    	$returnValue['addDate'] = is_null($this->addDate)?null:$this->addDate->toString('YYYY.MM.dd HH:mm:ss');
	    	$returnValue['setDate'] = is_null($this->setDate)?null:$this->setDate->toString('YYYY.MM.dd HH:mm:ss');

	    	return (array) $returnValue;
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

	    	$returnValue['isValid'] = $this->_isValid;
	    	$returnValue['users_id'] = $this->_user;
	    	$returnValue['addDate'] = is_null($this->addDate)?null:$this->addDate->toString('YYYY.MM.dd HH:mm:ss');
	    	$returnValue['setDate'] = is_null($this->setDate)?null:$this->setDate->toString('YYYY.MM.dd HH:mm:ss');

	    	return (array) $returnValue;
	    }

	    public function getType()
	    {
	    	return 'Item';
	    }

	} /* end of class Vo_Item */