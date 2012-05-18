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

class Translation extends AbstractPlugin
{
	/**
	 * @var \Ez\Plugin\Translation
	 */
	private static $instance;
	
	private function __construct() {}
	
	/**
	 * @return \Ez\Plugin\Translation
	 */
	public static function getInstance()
	{
		if( !( self::$instance instanceof self ) )
		{
			self::$instance = new Translation;
		}
		
		return self::$instance;
	}
	
	public function preDispatch( \Ez\Request $request )
	{
		$locale			= $this->determineLocale( $request );
		$controllerName	= $request->getControllerClassName();
		
		$translationFile =
			trim(
				trim(
					strtolower( str_replace( "\\", ".", $controllerName ) ),
					"."
				),
				"controller"
			) . ".csv";

		$translation = $this->useCache( $locale, $translationFile );
		
		
		
		
		$pathToTranslationFile = PATH_TO_LIBRARY . "Lang/" . $locale . "/{$translationFile}";
		
		if( file_exists( $pathToTranslationFile ) )
		{
			$translation	= array();
			$csvContent		=
				explode( PHP_EOL, file_get_contents( PATH_TO_LIBRARY . "Lang/" . $locale . "/{$translationFile}" ) );
				
			foreach( $csvContent as $translationPair )
			{
				$translationPair = explode( ";", $translationPair );
				$translation[ trim( $translationPair[ 0 ] ) ] = trim( $translationPair[ 1 ] );
			}
			
			\Ez\Registry::setTranslation( $translation );
		}
	}
	
	public function postDispatch( \Ez\Request $request )
	{
		
	}
	
	private function determineLocale( \Ez\Request $request )
	{
		switch( strtoupper( $request->getParam( "lang", null ) ) )
		{
			case "FA":
			case "EN":
			{
				return strtoupper( $request->getParam( "lang" ) );
			}
		}
		
		if( isset( $_SESSION[ "lang" ] ) )
		{
			switch( strtoupper( $_SESSION[ "lang" ] ) )
			{
				case "FA":
				case "EN":
				{
					return strtoupper( $_SESSION[ "lang" ] );
				}
			}
		}
		
		$host		= array_reverse( explode( ".", $_SERVER[ "HTTP_HOST" ] ) );
		$subdomain	= @$host[ 2 ];

		switch( strtoupper( $subdomain ) )
		{
			case "FA":
			case "EN":
			{
				return strtoupper( $subdomain );
			}
		}
		
		return "FA";
	}
	
	private function useCache( $locale, $translationFile )
	{
		$cache = \Ez\Cache::factory( "apc" );
		
		$cacheKey =
			str_replace(
				".csv",
				".cache",
				strtolower( "{$locale}_{$translationFile}" )
			);
		
		if( !$cache->exists( $cacheKey ) )
		{
			$cache->loadFile( PATH_TO_CACHE . "translation/{$cacheKey}" );
		}
		
	}
}