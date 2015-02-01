<?php
/**
 * User-defined exceptions here
 */

class ModelValidationFailException extends Exception {
	protected  $_validator=array();
	function __construct(Illuminate\Validation\Validator $validator, $message, $code){
		parent::__construct($message,$code);
		$this->_validator=$validator;
	}
	public function getValidator(){
		return $this->_validator;
	}
}