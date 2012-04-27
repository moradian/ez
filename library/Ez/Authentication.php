<?php

namespace Ez;

class Authentication
{
	/**
	 * @var \Ez\Authentication
	 */
	private static $instance = null;
	
	/**
	 * Namespace to use for authencation.
	 * 
	 * @var string
	 */
	private static $sessionNamespace;
	
	/**
	 * A flag to indicate whether the user has been
	 * authenticated or not
	 * 
	 * @var boolean
	 */
	private static $isAuthenticated;
	
	/**
	 * A seed to hash the passwords with. You are free to change this.
	 * This seed is used to be appended to the passwords to prevent brute force
	 * attacks to succeed finding simple passwords of users.
	 * 
	 * @var string
	 */
	private static $passwordSeed;
	
	/**
	 * The authenticated user.
	 * 
	 * @var \Ez\Acl\User
	 */
	private static $user;
	
	/**
	 * @var	array
	 */
	private static $session	= null;
	
	private function __construct()
	{
		self::$sessionNamespace = "EZ_DEFAULT_AUTHENCATION_SESSION_NAMESPACE";
		self::$isAuthenticated	= false;
		self::$passwordSeed		= "KOUROSH*KAVE\$SHIMA3_FAMILY10^123456789oncem0re!";
		self::$user				= null;
	}
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Authentication
	 */
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new Authentication();
		}
		
		return self::$instance;
	}
	
	/**
	 * Authenticates a user with the provided ID and password.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $ID
	 * @param	string $password
	 * @return	boolean
	 */
	public function doAuthenticate( $ID, $password )
	{
		if( self::$isAuthenticated )
		{
			return true;
		}
		
		$user =
			\Ez\Registry::getDoctrineEntityManager()
			->getRepository( "\Ez\Acl\User" )
			->findOneBy(
				array(
					"username"	=> $ID
				)
			);
		
		if( !( $user instanceof \Ez\Acl\User ) )
		{
			return false;
		}
		
		if( $user->password === $this->encodePassword( $password )  )
		{
			self::$user				= $user;
			self::$isAuthenticated	= true;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Encodes passwords to be saved or to be verified.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $password
	 * @return	string
	 */
	public function encodePassword( $password )
	{
		///////////////////////////////////////////
		// IMPLEMENT YOUR OWN ENCODING ALGORYTHM //
		///////////////////////////////////////////
		
		return md5( sha1( $password . self::$passwordSeed ) );
	}
	
	/**
	 * Tells whether the current user is an annonymous or
	 * an authenticated one.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	boolean
	 */
	public function isAuthenticated()
	{
		if( self::$isAuthenticated )
		{
			return true;
		}
		
		$user =
			\Ez\Registry::getDoctrineEntityManager()
			->getRepository( "\Ez\Acl\User" )
			->findOneBy(
				array(
					"username"	=> @self::$user->username
				)
			);
		
		if( !( $user instanceof \Ez\Acl\User ) )
		{
			return false;
		}
		
		return self::$isAuthenticated = true;
	}
	
	/**
	 * Enter description here ...
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	mixed
	 * 			Returns \Ez\Acl\User in case the current user is an authenticated one.
	 * 			Returns null in case the currenct user is an annonymous one.
	 */
	public function getUser()
	{
		return self::$user;
	}
}