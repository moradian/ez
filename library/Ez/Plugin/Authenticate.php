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

class Authenticate extends AbstractPlugin
{
	private static $instance;
	
	/**
	 * Session key used for authentication
	 * @var string
	 */
	private static $sessionName = "EZUser";
	
	/**
	 * Name of the class used for authentication
	 * @var string
	 */
	private static $userModel = "\Model\Client";
	
	/**
	 * @var boolean
	 */
	private static $isValid = false;
	
	/**
	 * @var \Model\Client
	 */
	private static $user;
	
	private function __construct() {}
	
	public static function getInstance()
	{
		if( !( self::$instance instanceof self ) )
		{
			self::$instance = new Authenticate;
		}
		
		return self::$instance;
	}
	
	public function preDispatch( \Ez\Request $request )
	{
		echo "Running pre-dispatch of authentication plugin!";
		
		if( isset( $_SESSION[ self::$sessionName ] ) )
		{
			if( is_numeric( $_SESSION[ self::$sessionName ] ) )
			{
				 $user = 
				 	\Ez\Registry::getDoctrineEntityManager()
				 		->getRepository( self::$userModel )
				 		->findOneBy( array( "id", $_SESSION[ self::$sessionName ] ) );
			}
		}
	}
	
	public function postDispatch( \Ez\Request $request )
	{
		echo "Running post-dispatch of authentication plugin!";
	}
	
	public function getUserRole()
	{
		return array(	"id"	=> self::$user->role->id,
						"name"	=> self::$user->role->name
		);
	}
}