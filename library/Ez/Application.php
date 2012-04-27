<?php

namespace Ez;

class Application extends Application\AbstractApplication
{
	function __construct()
	{
		$this->queryString	= $_SERVER[ "QUERY_STRING" ];
		$this->requestURI	= str_replace(	"?" . $this->queryString, "", $_SERVER[ "REQUEST_URI" ] );
		
		$this->customTemplate	= null;
		$this->customView		= null;
		
		$this->setUpDoctrine();
		
		\Ez\Plugin\Engine::getInstance()
			->initializePlugins( Request::getInstance()->getControllerClassName() )
			->runPreDispatch();
			
		try
		{
			$this->includeControllerClassFile();
			$this->run();
			
			\Ez\Plugin\Engine::getInstance()->runPostDispatch();
		}
		catch( \Exception $XCP )
		{
			$this->HTTP_404();
		}
	}
	
	private function run()
	{
		// INSTANTIATE THE APPROPRIATE CONTROLLER OBJ
		$controllerClassName = Request::getInstance()->getControllerClassName();
		$controller = new $controllerClassName;
		
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
		$view = View::getInstance();
		$view->setRequest( Request::getInstance() );
		
		$view->setContentFile( $viewContentFile );
		$view->setTemplateFile( "MainTemplate" );
		
		// SET THE CONTROLLER'S NEW VIEW
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
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @return	void
	 */
	private function setUpDoctrine()
	{
		$cache	= new \Doctrine\Common\Cache\ArrayCache();
		$config	= new \Doctrine\ORM\Configuration();
		$config->setMetadataCacheImpl( $cache );
		$config->setMetadataDriverImpl( $config->newDefaultAnnotationDriver( PATH_TO_LIBRARY ) );
		$config->setQueryCacheImpl( $cache );
		$config->setProxyDir( PATH_TO_LIBRARY . "Proxy" );
		$config->setProxyNamespace( "Proxy" );
		$config->setAutoGenerateProxyClasses( true );
		
		$connOptions = array(	"driver"	=> "pdo_mysql",
								"dbname"	=> "chidari_new",
								"user"		=> "root",
								"password"	=> "Oncem0re^",
								"host"		=> "127.0.0.1"
		);
		
		$entityManager = \Doctrine\ORM\EntityManager::create( $connOptions, $config );
		
		$entityManager
			->getEventManager()
			->addEventSubscriber( new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit( "utf8", "utf8_unicode_ci" ) );
		
		// REGISTER DOCTRINE ENTITY MANAGER IN THE EZ REGISTRY SO
		// IT IS ACCESSIBLE ACROSS ALL LAYERS AND SECTIONS OF THE
		// WEB APPLICATION
		\Ez\Registry::setDoctrineEntityManager( $entityManager );
	}
}
