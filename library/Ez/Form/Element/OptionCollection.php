<?php
namespace Ez\Form\Element;

class OptionCollection extends \Ez\Collection\AbstractCollection
{
	public function __construct()
	{
		$this->setType( "\Ez\Form\Element\Option" );
	}
}
