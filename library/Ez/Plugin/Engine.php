<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.ez-project.org>.
 * 
 * Copyright 2011 Mehdi Bakhtiari
 */

namespace Ez\Plugin;

class Engine
{
	/**
	 * @var \Ez\Plugin\Engine
	 */
	private static $instance = null;
	private static $registeredPlugins = array();

	private function __construct()
	{
	}

	/**
	 * @return    \Ez\Plugin\Engine
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
	 * @param string $controller Class name of the responsible controller for the request
	 * @return self::$instance
	 */
	public function initializePlugins( $controller )
	{
		$pluginsConfigFile = ROOT_PATH . "/configs/plugins.ini";

		if( file_exists( $pluginsConfigFile ) )
		{
			$pluginsMetaData = @parse_ini_file( $pluginsConfigFile, true );

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
	 * @param array  $plugins
	 * @param string $controller
	 * @return Engine
	 */
	private function loadPlugins( array $plugins, $controller )
	{
		$pluginsKey = array_keys( $plugins );

		foreach( $pluginsKey as $key )
		{
			if( $this->shouldRun( $controller, $plugins[ $key ] ) )
			{
				array_push( self::$registeredPlugins, $plugins[ $key ][ "class" ]::getInstance() );
			}
		}

		return self::$instance;
	}

	/**
	 * Runs the preDispatch method of plugins listed in self::$registeredPlugins
	 *
	 * @return void
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
	 * @return void
	 */
	public function runPostDispatch()
	{
		foreach( self::$registeredPlugins as $plugin )
		{
			$plugin->postDispatch( \Ez\Request::getInstance() );
		}
	}

	/**
	 * @param string $controller
	 * @param array  $plugin
	 * @return bool
	 */
	private function shouldRun( $controller, array $plugin )
	{
		if( isset( $plugin[ "black-space" ] ) )
		{
			if( $this->isInNamespace( $controller, $plugin[ "black-space" ] ) )
			{
				return false;
			}
		}

		if( isset( $plugin[ "white-space" ] ) )
		{
			if( $this->isInNamespace( $controller, $plugin[ "white-space" ] ) )
			{
				return $this->isPluginRunnable( $plugin );
			}

			return false;
		}

		return $this->isPluginRunnable( $plugin );
	}

	/**
	 * @param string       $controller
	 * @param string|array $namespace
	 * @return bool
	 */
	private function isInNamespace( $controller, $namespace )
	{
		if( is_array( $namespace ) )
		{
			foreach( $namespace as $item )
			{
				if( $this->isControllerInNamespace( $controller, $item ) )
				{
					return true;
				}
			}

			return false;
		}

		return $this->isControllerInNamespace( $controller, $namespace );
	}

	/**
	 * @param string $controller
	 * @param string $namespace
	 * @return bool
	 */
	private function isControllerInNamespace( $controller, $namespace )
	{
		$namespace = rtrim( $namespace, "\\" ) . "\\";
		var_dump( $namespace );
		$index = strpos( $controller, $namespace );

		if( $index !== false )
		{
			if( $index === 0 )
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param array $plugin
	 * @return bool
	 */
	private function isPluginRunnable( array $plugin )
	{
		if( isset( $plugin[ "class" ] ) )
		{
			if( class_exists( $plugin[ "class" ] ) )
			{
				return true;
			}
		}

		return false;
	}
}