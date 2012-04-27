<?php

namespace Ez\Form;

class AbstractForm
{
	/**
	 * The name of the form
	 * @var string
	 */
	protected $name;
	
	/**
	 * Elements of the form
	 * @var \Ez\Form\Element\Collection
	 */
	protected $elements;
	
	/**
	 * URI to submit the form to
	 * @var string
	 */
	protected $action;
	
	/**
	 * Method to submit the form by
	 * @var string GET/POST
	 */
	protected $method;
	
	/**
	 * Flag to determine if the form will be submitted by an HttpXmlRequest or not
	 * @var boolean
	 */
	protected $isAjax;
	
	/**
	 * Decorator to be used to render the form
	 * @var string
	 */
	protected $decorator;
	
	/**
	 * Holds the error messages of the form, generated after the validation
	 * @var array
	 */
	protected $errorMessages = array();
	
	/**
	 * Sets the name of the form.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $name
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Returns the name of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Sets the elements of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	Element\Collection $elements
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setElements( Element\Collection $elements )
	{
		$this->elements = $elements;
		return $this;
	}
	
	/**
	 * Returns an element of the form with the name of $name
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $name
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function getElement( $name )
	{
		foreach( $this->elements->getAll() as $item )
		{
			if( strtoupper( $item->getName() ) === strtoupper( $name ) )
			{
				return $item;
			}
		}
		
		return null;
	}
	
	/**
	 * Sets the action of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $action
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setAction( $action )
	{
		$this->action = $action;
		return $this;
	}
	
	/**
	 * Returns the action of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * Sets the method of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $method
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setMethod( $method )
	{
		$this->method = $method;
	}
	
	/**
	 * Returns the method of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	/**
	 * Makes the form submit its data by ajax or a simple HTTP request
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	boolean $isAjax
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setIsAjax( $isAjax )
	{
		$this->isAjax = (bool) $isAjax;
		return $this;
	}
	
	/**
	 * Returns the isAjax property of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	boolean
	 */
	public function getIsAjax()
	{
		return (bool) $this->isAjax;
	}
	
	/**
	 * Enter description here ...
	 * @param unknown_type $decorator
	 */
	public function setDecorator( $decorator )
	{
		$this->decorator = $decorator;
	}
	
	/**
	 * Validates all elements of the form against their own validators
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	boolean
	 */
	public function isValid()
	{
		$isValid = true;
		
		foreach( $this->elements->getAll() as $element )
		{
			foreach( $element->getValidators()->getAll() as $validator )
			{
				if( !$validator->isValid( $element->getValue() ) )
				{
					$isValid = false;
					array_push( $this->errorMessages, $validator->getErrorMessage( $element ) );
				}
			}
		}
		
		return $isValid;
	}
	
	/**
	 * Returns the array of error messages generated after the validation
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	array
	 */
	public function getErrorMessages()
	{
		return $this->errorMessages;
	}
	
	public function __get( $key )
	{
		foreach( $this->elements->getAll() as $element )
		{
			if( $element->getName() === $key )
			{
				return $element;
			}
		}
		
		throw new \Exception( "There is no such element ({$key}) in form \"{$this->name}\"" );
	}
	
	/**
	 * Returns the HTML ready markup of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function __toString()
	{
		$output = "<form action=\"{$this->action}\" method=\"{$this->method}\">";
		
		foreach( $this->elements->getAll() as $element )
		{
			$output .= $element;
		}
		
		return $output .= "</form>";
	}
}