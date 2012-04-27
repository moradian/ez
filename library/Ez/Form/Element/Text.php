<?php
namespace Ez\Form\Element;

class Text extends AbstractElement
{
	public function __construct()
	{
		$this->validators = new \Ez\Form\Validator\Collection();
	}
	
	public function __toString()
	{
		$output =	"<input type=\"text\" name=\"{$this->name}\" id=\"{$this->id}\""
		.			( strlen( $this->style ) ? " style=\"{$this->style}\"" : "" )
		.			( strlen( $this->class ) ? " class=\"{$this->class}\"" : "" )
		.			( strlen( $this->value ) ? " value=\"{$this->value}\"" : "" )
		.			" />";
		
		return $output;
	}
}