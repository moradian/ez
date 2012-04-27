<?php
namespace Home;

class IndexController extends \Ez\Controller\AbstractController
{
	public function __construct()
	{
		
	}
	
	public function run()
	{
		$form = new \Model\Simple();
		
		$firstName = new \Ez\Form\Element\Text();
		$firstName
			->setName( "firstName" )
			->setId( "fn" )
			->setStyle( "width:100px; font-size:12px" )
			->setValue( "Shima" )
			->setLabel( "First Name" )
			->setValidator( new \Ez\Form\Validator\MinLength( 3 ) )
			->setValidator( new \Ez\Form\Validator\MaxLength( 6 ) );
			
		$lastName = new \Ez\Form\Element\Text();
		$lastName
			->setName( "lastName" )
			->setId( "ln" )
			->setStyle( "width:150px; font-size:14px" )
			->setValue( "Moradian" )
			->setLabel( "Surname" )
			->setValidator( new \Ez\Form\Validator\MinLength( 10 ) )
			->setValidator( new \Ez\Form\Validator\MaxLength( 20 ) );
		
		$gender = new \Ez\Form\Element\Select();
		$male = new \Ez\Form\Element\Option();
		$male
			->setText( "مرد" )
			->setValue( "M" );

		$female = new \Ez\Form\Element\Option();
		$female
			->setText( "زن" )
			->setValue( "F" );
		
		$genderOptions = new \Ez\Form\Element\OptionCollection();
		$genderOptions
			->addItem( $male )
			->addItem( $female );
		
		$gender
			->setName( "gender" )
			->setId( "sex" )
			->setValue( "F" )
			->setOptions( $genderOptions );
			
		$genderRadio = new \Ez\Form\Element\Radio();
		
		$genderRadio
			->setName( "gender" )
			->setId( "sex" )
			->setValue( "M" )
			->setOptions( $genderOptions );	
			
		$elements = new \Ez\Form\Element\Collection();
		$elements
			->addItem( $firstName )
			->addItem( $lastName )
			->addItem( $gender )
			->addItem( $genderRadio );

		$form
			->setElements( $elements )
			->setAction( "/personal" )
			->setMethod( "post" );
			
		echo $form;
		
	}
	
	public function postRun()
	{
		
	}
}