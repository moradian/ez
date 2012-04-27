<?php
namespace Ez\Form\Validator;

abstract class AbstractValidator
{
	protected $name;
	protected $clientSideCode;
	
	/**
	 * Validates the element.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $value
	 * @return	boolean
	 */
	abstract public function isValid( $value );
	
	/**
	 * Returns a generated error message for an element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	\Ez\Form\Element\AbstractElement $element
	 * @return	string
	 */
	abstract public function getErrorMessage( \Ez\Form\Element\AbstractElement $element );
}