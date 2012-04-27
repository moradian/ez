<?php
namespace Ez\Form\Element;

class Collection extends \Ez\Collection\AbstractCollection
{
	public function __construct()
	{
		$this->setType( "\Ez\Form\Element\AbstractElement" );
	}
}
