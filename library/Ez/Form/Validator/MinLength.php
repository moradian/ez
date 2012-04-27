<?php 

namespace Ez\Form\Validator;

class MinLength extends AbstractValidator
{
	/**
	 * @var integer
	 */
	private $minLength;
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @param	integer $length
	 */
	public function __construct( $length )
	{
		if( !is_numeric( $length ) )
		{
			throw new \Exception( "Provided length for the MinLength validator must be numeric." );
		}
		
		$this->minLength = $length;
	}
	
	/**
	 * Returns the min length
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	integer
	 */
	public function getMinLength()
	{
		return $this->minLength;
	}
	
	/**
	 * Returns a generated error message for an element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	\Ez\Form\Element\AbstractElement $element
	 * @return	string
	 */
	public function getErrorMessage( \Ez\Form\Element\AbstractElement $element )
	{
		return "Value of {$element->getLabel()} need to be at least {$this->minLength} letters.";
	}
	
	/**
	 * Validates the value of the element against $this->minLength
	 * 
	 * @author	Mehdi Bakhtiari
	 * @see		Ez\Form\Validator.AbstractValidator::isValid()
	 * @throws	Exception If the max length has not been specified yet
	 * @return	boolean
	 */
	public function isValid( $value )
	{
		if( !is_numeric( $this->minLength ) || empty( $this->minLength ) )
		{
			throw new \Exception( "Provided length for the minLength validator must be numeric." );
		}
		return	( strlen( $value ) >= $this->minLength );
	}
}
