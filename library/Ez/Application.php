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

class Application extends Application\AbstractApplication
{
	function __construct()
	{
		$this->queryString = $_SERVER[ "QUERY_STRING" ];
		$this->requestURI  = str_replace( "?" . $this->queryString, "", $_SERVER[ "REQUEST_URI" ] );

		$this->customTemplate = null;
		$this->customView     = null;

		$this->loadConfigs();
		$this->setUpDoctrine();

		\Ez\Plugin\Engine::getInstance()
			->initializePlugins( Request::getInstance()->getControllerClassName() )
			->runPreDispatch();

		try
		{
			$this->includeControllerClassFile();
		}
		catch( \Exception $XCP )
		{
			$this->HTTP_404();
			exit;
		}

		$this->run();
		\Ez\Plugin\Engine::getInstance()->runPostDispatch();
		$this->controller->postRun();
	}

	private function run()
	{
		// INSTANTIATE THE APPROPRIATE CONTROLLER OBJ
		$controllerClassName = Request::getInstance()->getControllerClassName();
		$this->controller    = new $controllerClassName();

		$viewContentFile =
			strtolower(
				trim(
					str_replace( ".php", "", str_replace( "/", ".", Request::getInstance()->getControllerFileName() ) )
					, "."
				)
			);

		///////////////////////////////
		// SET CONTROLLER'S VIEW OBJ //
		///////////////////////////////

		// INSTANTIATE THE APPROPRIATE VIEW OBJ
		$controllerView = $this->controller->getView();

		if( !empty( $controllerView ) )
		{
			$view = $this->controller->getView();
		}
		else
		{
			$templateConf = $this->ezConf[ "template" ];

			$view = View::getInstance();
			$view->setContentFile( $viewContentFile );
			$view->setTemplateFile( $templateConf[ "default" ] );
		}

		// SET THE CONTROLLER'S NEW VIEW
		$view->setRequest( Request::getInstance() );
		$view->setEncoding();
		$this->controller->setView( $view );

		///////////////////////////////////////////////
		// PASS THE REQUEST OBJECT TO THE CONTROLLER //
		///////////////////////////////////////////////
		$this->controller->setRequest( Request::getInstance() );

		////////////////////////
		// RUN THE CONTROLLER //
		////////////////////////
		$this->controller->run();

		/////////////
		// DISPLAY //
		/////////////
		$view->display();
	}

	private function loadConfigs()
	{
		$conf = new \Zend\Config\Reader\Ini();

		try
		{
			$this->ezConf = $conf->fromFile( PATH_TO_CONFIGS . "ez.ini" );
		}
		catch( \Exception $XCP )
		{
			exit( $XCP->getMessage() );
		}

		$timezone = $this->ezConf[ "timezone" ];

		if( !is_null( $timezone ) && isset( $timezone[ "default" ] ) )
		{
			date_default_timezone_set( $timezone[ "default" ] );
		}
	}

	/**
	 * Bootstraps doctrine, gets an instance of \Doctrine\ORM\EntityManager
	 * and holds it in $this->doctrineEntityManager
	 *
	 * @return void
	 */
	private function setUpDoctrine()
	{
		$dbConf = $this->ezConf[ "db" ];

		if( is_null( $dbConf ) )
		{
			exit( "DB config section is missing in the \"ez.ini\" file" );
		}

		$cache  = new \Doctrine\Common\Cache\ArrayCache();
		$config = new \Doctrine\ORM\Configuration();
		$config->setMetadataCacheImpl( $cache );
		$config->setMetadataDriverImpl( $config->newDefaultAnnotationDriver( PATH_TO_LIBRARY ) );
		$config->setQueryCacheImpl( $cache );
		$config->setProxyDir( PATH_TO_LIBRARY . "Proxy" );
		$config->setProxyNamespace( "Proxy" );
		$config->setAutoGenerateProxyClasses( true );

		$connOptions = array( "driver"   => $dbConf[ "driver" ],
		                      "dbname"   => $dbConf[ "dbname" ],
		                      "user"     => $dbConf[ "username" ],
		                      "password" => $dbConf[ "password" ],
		                      "host"     => $dbConf[ "host" ]
		);

		$entityManager = \Doctrine\ORM\EntityManager::create( $connOptions, $config );

		// REGISTER DOCTRINE ENTITY MANAGER IN THE EZ REGISTRY SO
		// IT IS ACCESSIBLE ACROSS ALL LAYERS AND SECTIONS OF THE
		// WEB APPLICATION
		\Ez\Registry::setDoctrineEntityManager( $entityManager );
	}

	public static function redirectToHome()
	{
		header( "Location: /" );
	}
}
