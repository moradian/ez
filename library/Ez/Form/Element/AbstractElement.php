<?php
namespace Ez\Form\Element;

abstract class AbstractElement
{
	/**
	 * ID of the element
	 * @var string
	 */
	protected $id;
	
	/**
	 * Name of the element
	 * @var string
	 */
	protected $name;
	
	/**
	 * The label of the element
	 * @var string
	 */
	protected $label;
	
	/**
	 * Style attribute of the element
	 * @var string
	 */
	protected $style;
	
	/**
	 * Class attribute of the element
	 * @var string
	 */
	protected $class;
	
	/**
	 * Value of the element
	 * @var string
	 */
	protected $value;
	
	/**
	 * @var \Ez\Form\Validator\Collection
	 */
	protected $validators;
	
	/**
	 * Enforcing all elements to declare their own toString()
	 * method to handle generating HTML output of the form.
	 */
	abstract public function __toString();
	
	/**
	 * Sets the ID attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $id
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setId( $id )
	{
		$this->id = $id;
		return $this;
	}
	
	/**
	 * Returns the ID attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Sets the name attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $name
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Returns the name attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Sets the label of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $label
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setLabel( $label )
	{
		$this->label = $label;
		return $this;
	}
	
	/**
	 * Returns the label of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getLabel()
	{
		return $this->label;
	}
	
	/**
	 * Sets the style attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $style
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setStyle( $style )
	{
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Returns the style attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getStyle()
	{
		return $this->style;
	}
	
	/**
	 * Sets the value attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $value
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setValue( $value )
	{
		$this->value = $value;
		return $this;
	}
	
	/**
	 * Returns the value of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Adds a new validator to the collection of validators to be applied
	 * for the element.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	\Ez\Form\Validator\AbstractValidator $validator
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setValidator( \Ez\Form\Validator\AbstractValidator $validator )
	{
		$this->validators->addItem( $validator );
		return $this;
	}
	
	/**
	 * Returns the validators collection of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Form\Validator\Collection
	 */
	public function getValidators()
	{
		return $this->validators;
	}
}