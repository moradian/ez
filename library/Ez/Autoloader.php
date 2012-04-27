<?php
namespace Ez;

class Autoloader
{
	private static	$NamespaceSeparator	= "\\";
	private static $paths				= array();
	
	public static function addPath( $path )
	{
		if( strlen( $path ) )
		{
			array_push( self::$paths, $path );
		}
	}
	
	public static function load( $className )
	{
		foreach( self::$paths as $path )
		{
			if( class_exists( $className, true ) )
			{
				continue;
			}
			
			$file = $path . str_replace( self::$NamespaceSeparator, DIRECTORY_SEPARATOR, $className ) . ".php";
			
			if( file_exists( $file ) )
			{
				require_once $file;
			}
		}
	}
	
	public static function register()
	{
		spl_autoload_register( array( "self", "load" ) );
	}
	
	public static function GET( $variable )
	{
		return $this->$variable;
	}
}
