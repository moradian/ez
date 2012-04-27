<?php 

namespace Ez\Form\Validator;

class MaxLength extends AbstractValidator
{
	/**
	 * @var integer
	 */
	private $maxLength;
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @param	integer $length
	 */
	public function __construct( $length )
	{
		if( !is_numeric( $length ) )
		{
			throw new \Exception( "Provided length for the MaxLength validator must be numeric." );
		}
		
		$this->maxLength = $length;
	}
	
	/**
	 * Returns the max length
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	integer
	 */
	public function getMaxLength()
	{
		return $this->maxLength;
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
		return "Value of {$element->getLabel()} need not to be longer than {$this->maxLength} letters.";
	}
	
	/**
	 * Validates the value of the element against $this->maxLength
	 * 
	 * @author	Mehdi Bakhtiari
	 * @see		Ez\Form\Validator.AbstractValidator::isValid()
	 * @throws	Exception If the max length has not been specified yet
	 * @return	boolean
	 */
	public function isValid( $value )
	{
		if( !is_numeric( $this->maxLength ) || empty( $this->maxLength ) )
		{
			throw new \Exception( "Provided length for the MaxLength validator must be numeric." );
		}
		return	!( strlen( $value ) > $this->maxLength );
	}
}
