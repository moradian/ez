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
	protected $view;

	/**
	 * @var string
	 */
	protected $defaultViewFileName;
	
	/**
	 * @var \Ez\Request
	 */
	protected $request;

	/**
	 * Execution of controllers start here
	 */
	abstract function run();

	/**
	 * This method is actually the very last piece of code that gets executed
	 */
	abstract function postRun();

	/**
	 * @param \Ez\View\AbstractView $view
	 */
	public function setView( \Ez\View\AbstractView $view )
	{
		$this->view = $view;
	}

	/**
	 * @param \Ez\Request $request
	 */
	public function setRequest( \Ez\Request $request )
	{
		$this->request = $request;
	}

    /**
     * @return \Ez\View\AbstractView
     */
    public function getView()
    {
        return $this->view;
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