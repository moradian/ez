<?php
namespace Ez\Form\Validator;

class Collection extends \Ez\Collection\AbstractCollection
{
	public function __construct()
	{
		$this->setType( "\Ez\Form\Validator\AbstractValidator" );
	}
}