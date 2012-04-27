<?php

namespace Ez;

class Acl
{
	/**
	 * @var \Ez\Acl
	 */
	private static $instance = null;
	
	private function __construct()
	{}
	
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new Acl;
		}
		
		return self::$instance;
	}
	
	public function isAllowed( Request $request, Acl\User $user )
	{
		
	}
}