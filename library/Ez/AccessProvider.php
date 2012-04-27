<?php
/**
 * This class has a tiny body and as it looks like, it serves
 * as a simple access provider to the protected and private properties
 * classes which extend this class.
 * 
 * THIS CLASS SHOULD BE EXTENDED WITH EXTRA CONSIDERATION AS IT PROVIDES
 * READ/WRITE ACCESS TO YOUR PROTECTED AND PRIVATE PROPERTIES 
 
 * @author Mehdi Bakhtiari
 */

namespace Ez;

abstract class AccessProvider
{
	public function __set( $key, $value )
	{
		if( property_exists( $this, $key ) )
		{
			$this->$key = $value;
		}
	}
	
	public function __get( $key )
	{
		return	property_exists( $this, $key )
				? $this->$key
				: null;
	}
}