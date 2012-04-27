<?php
namespace Ez\Form\Element;

class Radio extends AbstractElement
{
	/**
	 * @var \Ez\Form\Element\OptionCollection
	 */
	private $options;
	
	public function __construct()
	{
		$this->validators = new \Ez\Form\Validator\Collection();
	}
	
	/**
	 * Sets options of the radio input group
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	\Ez\Form\Element\OptionCollection $options
	 * @return	\Ez\Form\Element\Radio
	 */
	public function setOptions( OptionCollection $options )
	{
		$this->options = $options;
		return $this;
	}
	
	/**
	 * Returns options of the radio input group
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Form\Element\OptionCollection
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Generates the markup of the element to be rendered in a browser
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function __toString()
	{
		$output	= "";
		$i		= 0;
		$ID		= empty( $this->id ) ? $this->name : $this->id;
		
		foreach( $this->options->getAll() as $option )
		{
			$output .=	"<input type=\"radio\" name=\"{$this->name}\" id=\"{$ID}_{$i}\""
			.			" value=\"{$option->getValue()}\""
			.			( $this->value === $option->getValue() ? " checked=\"checked\" />" : " />" )
			.			"<label for=\"{$ID}_{$i}\">{$option->getText()}</label>";
			
			$i++;
		}
		
		return $output;
	}
}