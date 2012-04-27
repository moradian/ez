<?php
namespace Ez\Controller;

abstract class AbstractController
{
	/**
	 * @var \Ez\View\AbstractView
	 */
	protected	$view;
	protected	$defaultViewFileName;
	
	// ARE SET WITHIN requiresMemberUser() AND RequiresAdminUser()
	protected	$userSession,
				$adminSession;
	
	// REQUEST PARAMS
	protected	$request;
	
	// ONLY INITIALIZATION OF MEMBER PROPERTIES
	// HAPPEN IN THE CONSTRUCTOR METHOD OF THE CONTROLLER
	abstract function __construct();
	
	// THE WHOLE LOGIC OF THE CONTROLLER IS LOCATED
	// WITHIN THE run() METHOD
	abstract function run();
	
	// THIS METHOD CONTAINS ANYTHING YOU MIGHT NEED
	// TO RUN AFTER THE PAGE IS SHOWN
	abstract function postRun();
	
	public function setView( \Ez\View\AbstractView $view )
	{
		$this->view = $view;
	}
	
	public function setRequest( \Ez\Request $request )
	{
		$this->request = $request;
	}
	
	public function getdefaultViewFileName()
	{
		return $this->defaultViewFileName;
	}
	
	protected function requiresMemberUser( $freeze = false )
	{
		$loginPath = "/user/authenticate/?redir=" . urlencode( $_SERVER[ "REQUEST_URI" ] );
		
		if( !isset( $_SESSION[ USER_SESSION ] ) )
		{
			( $freeze )	? exit()
						: $this->redirectTo( $loginPath );
		}
		
		if( @get_class( unserialize( $_SESSION[ USER_SESSION ] ) ) !== "Model_Client" )
		{
			unset( $_SESSION[ USER_SESSION ] );
			
			( $freeze )	? exit()
						: $this->redirectTo( $loginPath );
		}
		
		$this->userSession = unserialize( $_SESSION[ USER_SESSION ] );
	}
	
	protected function requiresAdminUser()
	{
		if( !isset( $_SESSION[ ADMIN_SESSION ] ) )
		{
			$this->redirectToHome();
		}
		
		if( get_class( unserialize( $_SESSION[ ADMIN_SESSION ] ) ) != "Model_Administrator" )
		{
			unset( $_SESSION[ ADMIN_SESSION ] );
			$this->redirectToHome();
		}
		
		$this->adminSession = unserialize( $_SESSION[ ADMIN_SESSION ] );
	}
	
	protected function redirectToHome()
	{
		header( "Location: /" );
		exit;
	}
	
	protected function redirectTo( $path )
	{
		header( "Location: " . $path );
		exit;
	}
}