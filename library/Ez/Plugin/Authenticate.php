<?php

namespace Ez\Plugin;

class Authenticate extends AbstractPlugin
{
	private static $instance;
	
	/**
	 * Session key used for authentication
	 * @var string
	 */
	private static $sessionName = "EZUser";
	
	/**
	 * Name of the class used for authentication
	 * @var string
	 */
	private static $userModel = "\Model\Client";
	
	/**
	 * @var boolean
	 */
	private static $isValid = false;
	
	/**
	 * @var \Model\Client
	 */
	private static $user;
	
	private function __construct() {}
	
	public static function getInstance()
	{
		if( !( self::$instance instanceof self ) )
		{
			self::$instance = new Authenticate;
		}
		
		return self::$instance;
	}
	
	public function preDispatch( \Ez\Request $request )
	{
		echo "Running pre-dispatch of authentication plugin!";
		
		if( isset( $_SESSION[ self::$sessionName ] ) )
		{
			if( is_numeric( $_SESSION[ self::$sessionName ] ) )
			{
				 $user = 
				 	\Ez\Registry::getDoctrineEntityManager()
				 		->getRepository( self::$userModel )
				 		->findOneBy( array( "id", $_SESSION[ self::$sessionName ] ) );
			}
		}
	}
	
	public function postDispatch( \Ez\Request $request )
	{
		echo "Running post-dispatch of authentication plugin!";
	}
	
	public function getUserRole()
	{
		return array(	"id"	=> self::$user->role->id,
						"name"	=> self::$user->role->name
		);
	}
}