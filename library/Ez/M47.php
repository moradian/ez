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

class M47
{
	public static function M4( $str = "" )
	{
		$encStr		= "";
		$reverseStr	= strrev( $str );
		$strLen		= strlen( $str );
		$str		= str_split( $str, 1 );
		
		if( !$strLen )
		{
			return 0;
		}
		
		for( $i = 0; $i < $strLen; $i++ )
		{
			$randomChar	= chr( rand( 65, 90 ) );
			$initChar	= $reverseStr{ $i };
			
			while( $randomChar == $initChar )
			{
				$randomChar	= chr( rand( 65, 90 ) );
			}
			
			if( ord( $randomChar ) > ord( $initChar ) )
			{
				$twoPower		= rand( 0, 9 );
				$charsDistance	= ord( $randomChar ) - ord( $initChar );
				
				$tens	= floor( $charsDistance / 10 );
				$unit	= $charsDistance - ( $tens * 10 );
				
				$tens	= self::upperOrWhat( chr( 81 + $tens ) );
				$unit	= self::upperOrWhat( chr( 81 + $unit ) );
				
				$encStr .= self::upperOrWhat( $randomChar ) . $twoPower . $tens . $unit;
				continue;
			}
			
			$temp		= ord( $randomChar );
			$twoPower	= 0;
			
			while( $temp < ord( $initChar ) )
			{
				$twoPower++;
				$temp *= 2;
			}
			
			if( $temp > ord( $initChar ) )
			{
				$twoPower--;
				$temp /= 2;
			}
			
			if( !$twoPower )
			{
				$twoPower	= self::upperOrWhat( chr( rand( 65, 67 ) ) );
				$charsDistance	= ord( $initChar ) - ord( $randomChar );
				
				$tens	= floor( $charsDistance / 10 );
				$unit	= $charsDistance - ( $tens * 10 );
				
				$tens	= self::upperOrWhat( chr( 71 + $tens ) );
				$unit	= self::upperOrWhat( chr( 71 + $unit ) );
				
				$encStr .= self::upperOrWhat( $randomChar ) . $twoPower . $tens . $unit;
				continue;
			}
			
			$twoPower	= self::upperOrWhat( chr( 68 + $twoPower ) );
			$charsDistance	= ord( $initChar ) - $temp;
			
			$tens	= floor( $charsDistance / 10 );
			$unit	= $charsDistance - ( $tens * 10 );
			
			$tens	= self::upperOrWhat( chr( 65 + $tens ) );
			$unit	= self::upperOrWhat( chr( 65 + $unit ) );
			
			$encStr .= self::upperOrWhat( $randomChar ) . $twoPower . $tens . $unit;
		}
		
		return $encStr;
	}
	
	public static function M7( $str = "" )
	{
		$decStr		= "";
		$encStrLen	= strlen( trim( $str ) );
		
		if( ( $encStrLen % 4 ) )
		{
			return 0;
		}
		
		if( !$encStrLen )
		{
			return 0;
		}
		
		$str		= str_split( strtoupper( $str ),4 );
		$decStrLen	= count( $str );
		
		for( $i = 0; $i < $decStrLen; $i++ )
		{
			if( is_numeric( $str[ $i ][ 1 ] ) )
			{
				$tens	= ord( $str[ $i ][ 2 ] ) - 81;
				$unit	= ord( $str[ $i ][ 3 ] ) - 81;
				
				$charsDistance	= $tens . $unit;
				$origChar	= chr( ord( $str[ $i ][ 0 ] ) - $charsDistance );
				
				$decStr .= $origChar;
				continue;
			}
			
			if( ( ord( $str[ $i ][ 1 ] ) < 68 ) )
			{
				$tens	= ord( $str[ $i ][ 2 ] ) - 71;
				$unit	= ord( $str[ $i ][ 3 ] ) - 71;
				
				$charsDistance	= $tens . $unit;
				$origChar	= chr( ord( $str[ $i ][ 0 ] ) + $charsDistance );
				
				$decStr .= $origChar;
				continue;
			}
			
			if( ord( $str[ $i ][ 1 ] ) > 68 )
			{
				$twoPower	= pow( 2, ord( $str[ $i ][ 1 ] ) - 68 );
				
				$tens	= ord( $str[ $i ][ 2 ] ) - 65;
				$unit	= ord( $str[ $i ][ 3 ] ) - 65;
				
				$charsDistance	= $tens . $unit;
				$origChar		= chr( ( ord( $str[ $i ][ 0 ] ) * $twoPower ) + $charsDistance );
				
				$decStr .= $origChar;
				continue;
			}
		}
		
		return strrev( $decStr );
	}
	
	static private function upperOrWhat( $chr )
	{
		if( rand( 0, 1 ) )
		{
			return strtolower( $chr );
		}
		return $chr;
	}
}
