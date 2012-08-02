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

namespace Ez\Application;

abstract class AbstractApplication
{
	protected
		// A CUSTOM TEMPLATE CAN BE SET BY PROVIDING A "ct"
		// GET PARAMETER ENCRYPTED BY M47::M4
		$customTemplate,

		// A DOCTRINE ENTITY MANAGER OBJECT TO BE
		// PASSED TO THE APPROPRIATE CONTROLLER
		$doctrineEntityManager;

	/**
	 * Is a collection is registered plugins in the ini config file of the project
	 * @var Ez\Collection\PluginCollection
	 */
	protected $pluginsRegistry;

	/**
	 * Includes the controller file
	 *
	 * @author    Mehdi Bakhtiari
	 * @throws    \Exception
	 * @return    void
	 */
	protected function includeControllerClassFile()
	{
		$controllerPath = PATH_TO_CONTROLLERS . \Ez\Request::getInstance()->getControllerFileName();
		exit( $controllerPath );

		if( file_exists( $controllerPath ) )
		{
			require_once $controllerPath;
		}
		else
		{
			throw new \Exception( "Controller file cannot be found at \"{$controllerPath}\"" );
		}
	}

	protected function HTTP_404()
	{
		include_once PUBLIC_PATH . "404.htm";
	}
}