<?php

namespace Mana;

class AryaController extends \Ez\Controller\AbstractController
{
	public function __construct()
	{
		
	}
	
	public function run()
	{
		$this->view->setContentFile( "nonsense" );
		echo "<br />This is Arya Ghavifekr <br />";
	}
	
	public function postRun()
	{
		
	}
}