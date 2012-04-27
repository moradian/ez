<?php
namespace Ez\Form\Element;

class Option
{
	/**
	 * @var string
	 */
	private $value;
	
	/**
	 * @var string
	 */
	private $text;
	
	/**
	 * Sets the value of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $value
	 * @throws	\Exception In case the provided $value is not a string
	 * @return	\Ez\Form\Element\Option
	 */
	public function setValue( $value )
	{
		if( is_string( $value ) )
		{
			$this->value = $value;
			return $this;
		}
		
		throw new \Exception( "Value for options must be string." );
	}
	
	/**
	 * Returns the value of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Sets the text (label) of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $text
	 * @throws	\Exception In case the provided $text is not a string
	 * return	\Ez\Form\Element\Option
	 */
	public function setText( $text )
	{
		if( is_string( $text ) )
		{
			$this->text = $text;
			return $this;
		}
		
		throw new \Exception( "Text for options must be string." );
	}
	
	/**
	 * Returns the text of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getText()
	{
		return $this->text;
	}
}