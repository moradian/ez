<?php

namespace Ez\Application;

abstract class AbstractApplication
{
	protected	
				// A CUSTOM TEMPLATE CAN BE SET BY PROVIDING A "ct"
				// GET PARAMETER ENCRYPTED BY M47::M4
				$customTemplate,
				
				// A DOCTRINE ENTITY MANAGER OBJECT TO BE
				// PASSED TO THE APPROPRIATE CONTROLLER
				$doctrineEntityManager;
	
	/**
	 * Is a collection is registered plugins in the ini config file of the project
	 * @var Ez\Collection\PluginCollection
	 */
	protected $pluginsRegistry;
	
	/**
	 * Includes the controller file
	 *
	 * @author	Mehdi Bakhtiari
	 * @throws	Exception
	 * @return	void
	 */
	protected function includeControllerClassFile()
	{
		$controllerPath = PATH_TO_CONTROLLERS . \Ez\Request::getInstance()->getControllerFileName();
		
		if( file_exists( $controllerPath ) )
		{
			require_once $controllerPath;
		}
		else 
		{
			throw new \Exception( "Controller file cannot be found at \"{$controllerPath}\"" );
		}
	}
	
	protected function HTTP_404()
	{
		include_once PUBLIC_PATH . "404.htm";
	}
	
	public function getControllerClassName()
	{
		return $this->controllerClassName;
	}
}
