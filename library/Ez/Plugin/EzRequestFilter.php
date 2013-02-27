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

class EzRequestFilter extends AbstractPlugin
{
	/**
	 * @var \Ez\Plugin\EzRequestFilter
	 */
	private static $instance = null;

	/**
	 * @return \Ez\Plugin\EzRequestFilter
	 */
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new EzRequestFilter();
		}

		return self::$instance;
	}

	private function __construct()
	{
	}

	public function preDispatch( \Ez\Request $request )
	{
		$this->loopThroughAndCheckParams( $_POST );
		$this->loopThroughAndCheckParams( $_GET );
		\Ez\Request::reload();
	}

	public function postDispatch( \Ez\Request $request )
	{

	}

	/**
	 * @param array $params
	 */
	private function loopThroughAndCheckParams( array &$params )
	{
		$keys = array_keys( $params );

		foreach( $keys as $key )
		{
			$params[ $key ] = $this->securityCheckParam( $params[ $key ] );
		}
	}

	/**
	 * @param string $value
	 * @return string
	 */
	private function securityCheckParam( $value )
	{
		return strip_tags( $value );
	}
}
