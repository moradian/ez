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

namespace Ez\Util;

class Reflection
{
	const PUBLIC_PROP     = "PUBLIC";
	const NON_PUBLIC_PROP = "NON-PUBLIC";

	/**
	 * @param array|Object      $obj         Object/array to be json encoded
	 * @param array             $toBeIgnored List of properties or array keys to be ignored
	 *
	 * @return array|string|null
	 */
	public static function createJsonVO( $obj, array $toBeIgnored = null )
	{
		if( is_array( $obj ) )
		{
			return self::arrayToJson( $obj, $toBeIgnored );
		}

		if( is_object( $obj ) )
		{
			return self::objectToJson( $obj, $toBeIgnored );
		}

		return null;
	}

	/**
	 * @param Object $obj
	 *
	 * @return null|array
	 */
	public static function getProperties( $obj )
	{
		if( is_object( $obj ) )
		{
			$reflector                       = new \ReflectionClass( $obj );
			$result                          = array();
			$result[ self::PUBLIC_PROP ]     = array();
			$result[ self::NON_PUBLIC_PROP ] = array();

			foreach( $reflector->getProperties() as $property )
			{
				if( $property->isStatic() )
				{
					continue;
				}

				if( $property->isPublic() )
				{
					$result[ self::PUBLIC_PROP ][ ] = $property->getName();
				}

				$setterMethod = "set" . ucwords( $property->getName() );

				if( $reflector->hasMethod( $setterMethod ) )
				{
					$result[ self::NON_PUBLIC_PROP ][ ] = $property->getName();
				}
			}

			return $result;
		}

		return null;
	}

	/**
	 * @param array $array
	 * @param array $toBeIgnored
	 *
	 * @return array|string
	 */
	private static function arrayToJson( array $array, array $toBeIgnored = null )
	{
		if( $toBeIgnored != null || count( $toBeIgnored ) > 0 )
		{
			$result = array();
			$keys   = array_keys( $array );

			if( count( $keys ) == 0 )
			{
				return json_encode( $array );
			}

			foreach( $keys as $key )
			{
				$ignore = false;

				foreach( $toBeIgnored as $k => $v )
				{
					if( $k === $key )
					{
						$ignore = true;
						break;
					}
				}

				if( !$ignore )
				{
					$result[ $key ] = $array[ $key ];
				}
			}

			return $result;
		}

		return json_encode( $array );
	}

	/**
	 * @param Object     $obj
	 * @param null       $toBeIgnored
	 *
	 * @return string
	 */
	private static function objectToJson( $obj, $toBeIgnored = null )
	{
		$reflector = new \ReflectionClass( $obj );
		$result    = array();

		foreach( $reflector->getProperties() as $property )
		{
			$ignore = false;

			foreach( $toBeIgnored as $name )
			{
				if( $property->getName() === $name )
				{
					$ignore = true;
					break;
				}
			}

			if( $ignore || $property->isStatic() )
			{
				continue;
			}

			if( $property->isPublic() )
			{
				$result[ $property->getName() ] = $property->getValue( $obj );
			}

			$getterMethod = "get" . ucwords( $property->getName() );

			if( $reflector->hasMethod( $getterMethod ) )
			{
				$result[ $property->getName() ] = $obj->$getterMethod();
			}
		}

		return json_encode( $result );
	}
}
