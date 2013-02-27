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
	}

	private function run()
	{
		// INSTANTIATE THE APPROPRIATE CONTROLLER OBJ
		$controllerClassName = Request::getInstance()->getControllerClassName();
		$controller          = new $controllerClassName;

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
		$controllerView = $controller->getView();

		if( !empty( $controllerView ) )
		{
			$view = $controller->getView();
		}
		else
		{
			$view = View::getInstance();
			$view->setContentFile( $viewContentFile );
			$view->setTemplateFile( "MainTemplate" );
		}

		// SET THE CONTROLLER'S NEW VIEW
		$view->setRequest( Request::getInstance() );
		$view->setEncoding();
		$controller->setView( $view );

		///////////////////////////////////////////////
		// PASS THE REQUEST OBJECT TO THE CONTROLLER //
		///////////////////////////////////////////////
		$controller->setRequest( Request::getInstance() );

		////////////////////////
		// RUN THE CONTROLLER //
		////////////////////////
		$controller->run();

		/////////////
		// DISPLAY //
		/////////////
		$view->display();

		/////////////////////////////////////
		// RUN CONTROLLER'S PostRun METHOD //
		/////////////////////////////////////
		$controller->postRun();
	}

	/**
	 * Bootstraps doctrine, gets an instance of \Doctrine\ORM\EntityManager
	 * and holds it in $this->doctrineEntityManager
	 *
	 * @return void
	 */
	private function setUpDoctrine()
	{
		$dbConf = @parse_ini_file( ROOT_PATH . "/configs/db.ini" );

		if( $dbConf === false )
		{
			exit( "DB config file cannot be accessed!" );
		}

		$cache  = new \Doctrine\Common\Cache\ArrayCache();
		$config = new \Doctrine\ORM\Configuration();
		$config->setMetadataCacheImpl( $cache );
		$config->setMetadataDriverImpl( $config->newDefaultAnnotationDriver( PATH_TO_LIBRARY ) );
		$config->setQueryCacheImpl( $cache );
		$config->setProxyDir( PATH_TO_LIBRARY . "Proxy" );
		$config->setProxyNamespace( "Proxy" );
		$config->setAutoGenerateProxyClasses( true );

		$connOptions = array( "driver"      => $dbConf[ "driver" ],
							  "dbname"      => $dbConf[ "dbname" ],
							  "user"        => $dbConf[ "username" ],
							  "password"    => $dbConf[ "password" ],
							  "host"        => $dbConf[ "host" ]
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
