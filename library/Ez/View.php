<?php

namespace Ez;

class View extends View\AbstractView
{
	private static $instance = null;
	
	private function __construct()
	{
		
	}
	
	/**
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\View\AbstractView
	 */
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new View;
		}
		
		return self::$instance;
	}
}