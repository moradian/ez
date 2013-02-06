<?php
/*
 * Copyright 2011 Mehdi Bakhtiari
 * 
 * THIS SOFTWARE IS A FREE SOFTWARE AND IS PROVIDED BY THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS "AS IS".YOU CAN USE, MODIFY OR REDISTRIBUTE IT UNDER THE
 * TERMS OF "GNU LESSER	GENERAL PUBLIC LICENSE" VERSION 3. YOU SHOULD HAVE
 * RECEIVED A COPY OF FULL TEXT OF LGPL AND GPL SOFTWARE LICENCES IN ROOT OF
 * THIS SOFTWARE LIBRARY. THIS SOFTWARE HAS BEEN DEVELOPED WITH THE HOPE TO
 * BE USEFUL, BUT WITHOUT ANY WARRANTY. IN NO EVENT SHALL THE COPYRIGHT OWNER
 * OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * THIS SOFTWARE IS LICENSED UNDER THE "GNU LESSER PUBLIC LICENSE" VERSION 3.
 * FOR MORE INFORMATION PLEASE REFER TO <http://www.ez-project.org>
 */

namespace Ez;

class Request
{
	/**
	 * @var array
	 */
	private $params;

	/**
	 * @var array
	 */
	private $paramsKeys;

	/**
	 * @var array
	 */
	private $query;

	/**
	 * @var array
	 */
	private $queryKeys;

	/**
	 * @var array
	 */
	private $post;

	/**
	 * @var array
	 */
	private $postKeys;

	/**
	 * @var array
	 */
	private $files;

	/**
	 * @var array
	 */
	private $filesKeys;

	/**
	 * @var string
	 */
	private $controllerClassName;

	/**
	 * @var string
	 */
	private $controllerFileName;

	/**
	 * @var mixed
	 */
	private $requestUri;

	/**
	 * @var string
	 */
	private $queryString;

	/**
	 * @var string
	 */
	private $controllerDottedName;

	/**
	 * @var string
	 */
	private static $controllerJsFile = "scripts/controller/";

	/**
	 * @var string
	 */
	private static $controllerCssFile = "styles/controller/";

	/**
	 * @var \Ez\Request
	 */
	private static $instance;

	/**
	 * @static
	 * @return \Ez\Request
	 */
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

		$this->queryString = $_SERVER[ "QUERY_STRING" ];
		$this->requestUri  = str_replace( "?" . $this->queryString, "", $_SERVER[ "REQUEST_URI" ] );

		$this
			->generateControllerFileName()
			->generateControllerClassName();

		$this->files     = $_FILES;
		$this->filesKeys = array_keys( $_FILES );

		$this->query      = $_GET;
		$this->queryKeys  = array_keys( $_GET );
		$this->post       = $_POST;
		$this->postKeys   = array_keys( $_POST );
		$this->params     = array_merge( $_GET, $_POST );
		$this->paramsKeys = array_keys( $this->params );
	}

	/**
	 * Tells whether the request is POST or not
	 *
	 * @return boolean
	 */
	public function isPost()
	{
		return ( strtoupper( $_SERVER[ "REQUEST_METHOD" ] ) === "POST" );
	}

	/**
	 * Tells whether the request is a XMLHttpRequest or not
	 *
	 * @return boolean
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
	 *
	 * @param string $key        Query string parameter name
	 * @param string $default    The value to return if no matching parameter is found
	 *
	 * @return string
	 */
	public function getQuery( $key, $default = null )
	{
		return $this->getInput( $key, $this->queryKeys, $this->query, $default );
	}

	/**
	 * Returns the value for the $key parameter in the POST parameters
	 *
	 * @param string $key        POST parameter name
	 * @param object $default    The value to return if no matching parameter is found
	 *
	 * @return string
	 */
	public function getPost( $key, $default = null )
	{
		return $this->getInput( $key, $this->postKeys, $this->post, $default );
	}

	/**
	 * @param string $key
	 * @param object $default
	 *
	 * @return mixed
	 */
	public function getFile( $key, $default = null )
	{
		$file = $this->getInput( $key, $this->filesKeys, $this->files, $default );
		return ( strlen( $file[ "name" ] ) === 0 || $file[ "size" ] === 0 ) ? $default : $file;
	}

	/**
	 * Returns the value for the $key parameter in the query string or either POST
	 *
	 * @param string $key        Parameter name
	 * @param object $default    The value to return if no matching parameter is found
	 *
	 * @return string
	 */
	public function getParam( $key, $default = null )
	{
		return $this->getInput( $key, $this->paramsKeys, $this->params, $default );
	}

	/**
	 * Returns filename of the responsible controller to handle the request
	 *
	 * @return    string
	 */
	public function getControllerFileName()
	{
		return $this->controllerFileName;
	}

	/**
	 * Returns name of the class of the responsible controller to handle the request.
	 *
	 * @return    string
	 */
	public function getControllerClassName()
	{
		return $this->
			controllerClassName;
	}

	/**
	 * @param object $obj
	 * @param array  $ignoreList
	 *
	 * @return void
	 */
	public function populateObj( &$obj, array $ignoreList = null )
	{
		if( is_object( $obj ) )
		{
			$objProperties = \Ez\Util\Reflection::getProperties( $obj );

			if( count( $objProperties[ \Ez\Util\Reflection::PUBLIC_PROP ] ) > 0 )
			{
				foreach( $objProperties[ \Ez\Util\Reflection::PUBLIC_PROP ] as $property )
				{
					if( in_array( $property, $ignoreList ) || !in_array( $property, $this->params ) )
					{
						continue;
					}

					$obj->$property = $this->getParam( $property );
				}
			}

			if( count( $objProperties[ \Ez\Util\Reflection::NON_PUBLIC_PROP ] ) > 0 )
			{
				foreach( $objProperties[ \Ez\Util\Reflection::NON_PUBLIC_PROP ] as $property )
				{
					if( in_array( $property, $ignoreList ) || !in_array( $property, array_keys( $this->params ) ) )
					{
						continue;
					}

					$setterMethod = "set" . ucwords( $property );
					$obj->$setterMethod( $this->getParam( $property ) );
				}
			}
		}
	}

	/**
	 * Redirects the user to / which is the root (homepage) of the web application
	 *
	 * @return void
	 */
	public function redirectToHome()
	{
		header( "Location: /" );
		exit;
	}

	/**
	 * This method is supposed to be called from templates to
	 * include the appropriate javascript file of the controller
	 *
	 * @return null|string
	 */
	public function getControllerJsFileName()
	{
		$file = $this->getControllerDottedName() . ".js";

		if( file_exists( PUBLIC_PATH . self::$controllerJsFile . $file ) )
		{
			return "/" . self::$controllerJsFile . $file;
		}

		return null;
	}

	/**
	 * This method is supposed to be called from templates to
	 * include the appropriate css file of the controller
	 *
	 * @return null|string
	 */
	public function getControllerCssFileName()
	{
		$file = $this->getControllerDottedName() . ".css";

		if( file_exists( PUBLIC_PATH . "styles/controller/{$file}" ) )
		{
			return "/styles/controller/{$file}";
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function getControllerDottedName()
	{
		if( empty( $this->controllerDottedName ) )
		{
			$this->controllerDottedName = strtolower( ltrim( rtrim( $this->getControllerFileName(), ".php" ), "/" ) );
			$this->controllerDottedName = str_replace( "/", ".", $this->controllerDottedName );
		}

		return $this->controllerDottedName;
	}

	/**
	 * @param string $key
	 * @param array  $keysArray
	 * @param array  $array
	 * @param        $default
	 *
	 * @return mixed
	 */
	private function getInput( $key, array $keysArray, array $array, $default )
	{
		return in_array( $key, $keysArray ) ? $array[ $key ] : $default;
	}

	/**
	 * Generates the filename of the responsible controller to serve the request
	 *
	 * @return    \Ez\Request
	 */
	private function generateControllerFileName()
	{
		$controllerNameParts      = explode( "/", trim( $this->requestUri, "/" ) );
		$this->controllerFileName = "";

		foreach( $controllerNameParts as &$item )
		{
			if( empty( $item ) )
			{
				continue;
			}

			$this->controllerFileName .= "/" . $this->matchCaseDashedNames( ucwords( $item ) );
		}

		$this->controllerFileName = trim( $this->controllerFileName, "/" ) . ".php";

		if( $this->controllerFileName === ".php" )
		{
			$this->controllerFileName = "Home/Index.php";
		}

		return $this;
	}

	/**
	 * If the provided URI part is dashed separated, the dash character will be
	 * used as a word separator to MatchCase the URI part.
	 *
	 * @param string $uriPart One single part of the URI delimited with forward slashes
	 *
	 * @return string
	 */
	private function matchCaseDashedNames( $uriPart )
	{
		$partParts = explode( "-", $uriPart );

		foreach( $partParts as &$part )
		{
			$part = ucwords( $part );
		}

		return implode( "", $partParts );
	}

	/**
	 * Generates  the class name of the responsible controller
	 * to serve to the request
	 *
	 * @return \Ez\Request
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

		$this->controllerClassName =
			str_replace( "/", "\\", str_replace( ".php", "", $this->controllerFileName ) ) . "Controller";

		return $this;
	}

	/**
	 * Strips potential tags off any parameter in the request
	 *
	 * @return void
	 */
	private function stripTagsOffUserInput()
	{
		$getKeys  = array_keys( $_GET );
		$postKeys = array_keys( $_POST );

		foreach( $getKeys as $key )
		{
			$_GET[ $key ] = strip_tags( $_GET[ $key ] );
		}

		foreach( $postKeys as $key )
		{
			$_POST[ $key ] = strip_tags( $_POST[ $key ] );
		}
	}
}