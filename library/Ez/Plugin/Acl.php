<?php

namespace Ez\Plugin;

class Acl extends AbstractPlugin
{
	private static $instance = null;
	
	private function __construct()
	{
	}
	
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new Acl;
		}
		
		return self::$instance;
	}
	
	public function preDispatch( \Ez\Request $request )
	{
		/*
		if(
			\Ez\Acl::getInstance()
			->isAllowed(
				\Ez\Request::getInstance(),
				\Ez\Authentication::getInstance()->getUser()
			)
		)
		{
			
		}
		*/
	}
	
	public function postDispatch( \Ez\Request $request )
	{
		
	}
}