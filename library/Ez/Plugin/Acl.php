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

class Acl extends AbstractPlugin
{
	private static $instance = null;
	
	/**
	 * @var \Ez\Acl\IAcl
	 */
	private static $aclImplementation = null;
	
	private function __construct() {}
	
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new Acl;
		}
		
		return self::$instance;
	}
	
	public function preDispatch( \Ez\Request $request )
	{
		if(
			self::$aclImplementation
				->isAllowed(
					\Ez\Request::getInstance(),
					\Ez\Authentication::getInstance()->getUser()
			)
		)
		{
			
		}
	}
	
	public function postDispatch( \Ez\Request $request )
	{
		
	}
	
	public static function setAclInstance( \Ez\Acl\IAcl $acl)
	{
		self::$aclImplementation = $acl;
	}
}