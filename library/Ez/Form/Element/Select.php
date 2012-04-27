<?php
namespace Ez\Form\Element;

class Select extends AbstractElement
{
	/**
	 * @var \Ez\Form\Element\SelectOptionCollection
	 */
	private $options;
	
	/**
	 * Sets options of the select box
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	\Ez\Form\Element\OptionCollection $options
	 * @return	\Ez\Form\Element\Select
	 */
	public function setOptions( OptionCollection $options )
	{
		$this->options = $options;
		return $this;
	}
	
	/**
	 * Returns options of the select box
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Form\Element\OptionCollection
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	public function __toString()
	{
		$output =	"<select name=\"{$this->name}\" id=\"{$this->id}\""
		.			( strlen( $this->style ) ? " style=\"{$this->style}\"" : "" )
		.			( strlen( $this->class ) ? " class=\"{$this->class}\">" : ">" );
		
		foreach( $this->options->getAll() as $option )
		{
			$output .=	"<option value=\"{$option->getValue()}\""
			.			( $this->value === $option->getValue() ? " selected=\"selected\">" : ">" ) . "{$option->getText()}</option>";
		}
		
		return $output .= "</option>";
	}
}