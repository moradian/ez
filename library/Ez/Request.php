<?php

namespace Ez;

class Request
{
	private	$params,
			$paramsKeys,
			$query,
			$queryKeys,
			$post,
			$postKeys;
	
	private $controllerClassName;
	
	private $controllerFileName;
	
	private $requestUri;
	
	private $queryString;
	
	private static $instance;
	
	public static function getInstance()
	{
		if( !( self::$instance instanceof self ) )
		{
			self::$instance = new Request();
		}
		
		return self::$instance;
	}		
	
	private function __construct()
	{
		$this->stripTagsOffUserInput();
		
		$this->queryString	= $_SERVER[ "QUERY_STRING" ];
		$this->requestUri	= str_replace(	"?" . $this->queryString, "", $_SERVER[ "REQUEST_URI" ] );
		
		$this
			->generateControllerFileName()
			->generateControllerClassName();
		
		$this->query		= $_GET;
		$this->queryKeys	= array_keys( $_GET );
		$this->post			= $_POST;
		$this->postKeys		= array_keys( $_POST );
		$this->params		= array_merge( $_GET, $_POST );
		$this->paramsKeys	= array_keys( $this->params );
	}
	
	/**
	 * Strips potential tags off any parameter in the request
	 * @return void
	 * @author Mehdi Bakhtiari
	 */
	private function stripTagsOffUserInput()
	{
		$getKeys	= array_keys( $_GET );
		$postKeys	= array_keys( $_POST );
		
		foreach( $getKeys as $key )
		{
			$_GET[ $key ] = strip_tags( $_GET[ $key ] );
		}
	
		foreach( $postKeys as $key )
		{
			$_POST[ $key ] = strip_tags( $_POST[ $key ] );
		}
	}
	
	/**
	 * Tells whether the request is POST or not
	 * @return boolean
	 * @author Mehdi Bakhtiari
	 */
	public function isPost()
	{
		return ( strtoupper( $_SERVER[ "REQUEST_METHOD" ] ) === "POST" );
	}
	
	/**
	 * Tells whether the request is a XMLHttpRequest or not
	 * @return boolean
	 * @author Mehdi Bakhtiari
	 */
	public static function isAjax()
	{
		if( isset( $_SERVER[ "HTTP_X_REQUESTED_WITH" ] ) )
		{
			if( $_SERVER[ "HTTP_X_REQUESTED_WITH" ] === "XMLHttpRequest" )
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Returns the value for the $key parameter in the query string
	 * @param string $key		Query string parameter name
	 * @param string $default	The value to return if no matching parameter is found
	 * @return string
	 * @author Mehdi Bakhtiari
	 */
	public function getQuery( $key, $default = null )
	{
		if( in_array( $key, $this->queryKeys ) )
		{
			return $this->query[ $key ];
		}
		
		return $default;
	}
	
	/**
	 * Returns the value for the $key parameter in the POST parameters
	 * @param string $key		POST parameter name
	 * @param string $default	The value to return if no matching parameter is found
	 * @return string
	 * @author Mehdi Bakhtiari
	 */
	public function getPost( $key, $default = null )
	{
		if( in_array( $key, $this->postKeys ) )
		{
			return $this->post[ $key ];
		}
		
		return $default;
	}
	
	/**
	 * Returns the value for the $key parameter in the query string or either POST
	 * @param string $key		Parameter name
	 * @param string $default	The value to return if no matching parameter is found
	 * @return string
	 * @author Mehdi Bakhtiari
	 */
	public function getParam( $key, $default = null )
	{
		if( in_array( $key, $this->paramsKeys ) )
		{
			return $this->params[ $key ];
		}
		
		return $default;
	}
	
	/**
	 * Generates  the class name of the responsible controller
	 * to serve to the request
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Request
	 */
	private function generateControllerClassName()
	{
		// THIS METHOD MUST BE INVOKED AFTER GENERATING CONTROLLER CLASS FILENAME
		// IN generatecontrollerFileName() AND VALIDATING IF THE CONTROLLER CLASS FILE
		// EXISTS BY CALLING includeControllerClassFile().
		// BY CALLING THIS METHOD THE CONTROLLER CLASS NAME IS BUILT AND READY TO
		// BE INSTANCIATED.
		
		// WE ARE ASSUMING THAT $this->controllerFileName HAS BEEN GENERATED
		// AND FILLED WITH PROPER VALUE BY INVOKING generatecontrollerFileName()
		
		$this->controllerClassName = str_replace(	"/",
													"\\",
													str_replace(	".php",
																	"",
																	$this->controllerFileName
													)
		) . "Controller";
		
		return $this;
	}
	
	/**
	 * Generates the filename of the responsible controller to serve the request
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Request
	 */
	private function generateControllerFileName()
	{
		$this->controllerFileName = explode( "/", trim( $this->requestUri, "/" ) );
		
		foreach( $this->controllerFileName as &$item )
		{
			$item = ucwords( $item );
		}
		
		$this->controllerFileName = "/" . implode( "/", $this->controllerFileName ) . ".php";
		
		if( $this->controllerFileName === "/.php" )
		{
			$this->controllerFileName = "/Home/Index.php";
		}
		
		return $this;
	}
	
	/**
	 * Returns filename of the responsible controller to handle the request
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getControllerFileName()
	{
		return $this->controllerFileName;
	}
	
	/**
	 * Returns name of the class of the responsible controller to handle the request.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getControllerClassName()
	{
		return $this->controllerClassName;
	}
}