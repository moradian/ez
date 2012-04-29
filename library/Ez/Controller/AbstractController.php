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

namespace Ez\Controller;

abstract class AbstractController
{
	/**
	 * @var \Ez\View\AbstractView
	 */
	protected	$view;
	protected	$defaultViewFileName;
	
	// ARE SET WITHIN requiresMemberUser() AND RequiresAdminUser()
	protected	$userSession,
				$adminSession;
	
	// REQUEST PARAMS
	protected	$request;
	
	// ONLY INITIALIZATION OF MEMBER PROPERTIES
	// HAPPEN IN THE CONSTRUCTOR METHOD OF THE CONTROLLER
	abstract function __construct();
	
	// THE WHOLE LOGIC OF THE CONTROLLER IS LOCATED
	// WITHIN THE run() METHOD
	abstract function run();
	
	// THIS METHOD CONTAINS ANYTHING YOU MIGHT NEED
	// TO RUN AFTER THE PAGE IS SHOWN
	abstract function postRun();
	
	public function setView( \Ez\View\AbstractView $view )
	{
		$this->view = $view;
	}
	
	public function setRequest( \Ez\Request $request )
	{
		$this->request = $request;
	}
	
	public function getdefaultViewFileName()
	{
		return $this->defaultViewFileName;
	}
	
	protected function requiresMemberUser( $freeze = false )
	{
		$loginPath = "/user/authenticate/?redir=" . urlencode( $_SERVER[ "REQUEST_URI" ] );
		
		if( !isset( $_SESSION[ USER_SESSION ] ) )
		{
			( $freeze )	? exit()
						: $this->redirectTo( $loginPath );
		}
		
		if( @get_class( unserialize( $_SESSION[ USER_SESSION ] ) ) !== "Model_Client" )
		{
			unset( $_SESSION[ USER_SESSION ] );
			
			( $freeze )	? exit()
						: $this->redirectTo( $loginPath );
		}
		
		$this->userSession = unserialize( $_SESSION[ USER_SESSION ] );
	}
	
	protected function requiresAdminUser()
	{
		if( !isset( $_SESSION[ ADMIN_SESSION ] ) )
		{
			$this->redirectToHome();
		}
		
		if( get_class( unserialize( $_SESSION[ ADMIN_SESSION ] ) ) != "Model_Administrator" )
		{
			unset( $_SESSION[ ADMIN_SESSION ] );
			$this->redirectToHome();
		}
		
		$this->adminSession = unserialize( $_SESSION[ ADMIN_SESSION ] );
	}
	
	protected function redirectToHome()
	{
		header( "Location: /" );
		exit;
	}
	
	protected function redirectTo( $path )
	{
		header( "Location: " . $path );
		exit;
	}
}