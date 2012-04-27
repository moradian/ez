<?php

namespace Ez\Plugin;

class Engine
{
	/**
	 * @var \Ez\Plugin\Engine
	 */
	private static $instance = null;
	private static $registeredPlugins = array();
	
	private function __construct()
	{}
	
	/**
	 * Returns an instance of this class
	 * 
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @return	\Ez\Plugin\Engine
	 */
	public static function getInstance()
	{
		if( !( self::$instance instanceof self ) )
		{
			self::$instance = new Engine;
		}
		
		return self::$instance;
	}
	
	/**
	 * Reads the list of plugins from the ini configuration file and populates the
	 * plugins registry ( self::$registeredPlugins ) with appropriate plugins to be run.
	 * 
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @param 	string $controller Class name of the responsible controller for the request
	 * @return	self::$instance
	 */
	public function initializePlugins( $controller )
	{
		$pluginsConfigFile = ROOT_PATH . "/configs/plugins.ini";
		
		if( file_exists( $pluginsConfigFile ) )
		{
			$pluginsMetaData = @parse_ini_file( $pluginsConfigFile );
			
			if( $pluginsMetaData !== false )
			{
				$this->loadPlugins( $pluginsMetaData, $controller );
			}
		}
		
		return self::$instance;
	}
	
	/**
	 * Populates self::$registeredPlugins with appropriate plugins to be run according to
	 * the responsible controller, read from the ini configuration file. 
	 * 
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @param 	array $pluginsMetaData
	 * @param 	string $controller
	 * @return	self::$instance
	 */
	private function loadPlugins( array $pluginsMetaData, $controller )
	{
		$plugins = array_keys( $pluginsMetaData );
		
		foreach( $plugins as $plugin )
		{
			if( isset( $pluginsMetaData[ $plugin ][ "black-space" ] ) )
			{
				$blackSpaceIndex = strpos( $controller, $pluginsMetaData[ $plugin ][ "black-space" ] );
				
				if( $blackSpaceIndex !== false )
				{
					if( $blackSpaceIndex === 0 )
					{
						continue;
					}
				}
			}
			
			if( isset( $pluginsMetaData[ $plugin ][ "white-space" ] ) )
			{
				$whiteSpaceIndex = strpos( $controller, $pluginsMetaData[ $plugin ][ "white-space" ] );
				
				if( ( $whiteSpaceIndex === false ) || ( $whiteSpaceIndex !== 0 ) )
				{
					continue;
				}
			}
			
			if( isset( $pluginsMetaData[ $plugin ][ "class" ] ) )
			{
				if( class_exists( $pluginsMetaData[ $plugin ][ "class" ] ) )
				{
					array_push( self::$registeredPlugins, $pluginsMetaData[ $plugin ][ "class" ]::getInstance() );
				}
			}
		}
		
		return self::$instance;
	}
	
	/**
	 * Runs the preDispatch method of plugins listed in self::$registeredPlugins
	 * 
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @return	void
	 */
	public function runPreDispatch()
	{
		foreach( self::$registeredPlugins as $plugin )
		{
			$plugin->preDispatch( \Ez\Request::getInstance() );
		}
	}
	
	/**
	 * Runs the postDispatch method of plugins listed in self::$registeredPlugins
	 * 
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @return	void
	 */
	public function runPostDispatch()
	{
		foreach( self::$registeredPlugins as $plugin )
		{
			$plugin->postDispatch( \Ez\Request::getInstance() );
		}
	}
	
	/**
	 * Returns self::$registeredPlugins
	 * 
	 * @author	Mehdi Bakhtiari <mehdone@gmail.com>
	 * @return	array self::$registeredPlugins
	 */
	public function getRegisteredPlugins()
	{
		return self::$registeredPlugins;
	}
}