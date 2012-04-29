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

namespace Ez\Form;

class AbstractForm
{
	/**
	 * The name of the form
	 * @var string
	 */
	protected $name;
	
	/**
	 * Elements of the form
	 * @var \Ez\Form\Element\Collection
	 */
	protected $elements;
	
	/**
	 * URI to submit the form to
	 * @var string
	 */
	protected $action;
	
	/**
	 * Method to submit the form by
	 * @var string GET/POST
	 */
	protected $method;
	
	/**
	 * Flag to determine if the form will be submitted by an HttpXmlRequest or not
	 * @var boolean
	 */
	protected $isAjax;
	
	/**
	 * Decorator to be used to render the form
	 * @var string
	 */
	protected $decorator;
	
	/**
	 * Holds the error messages of the form, generated after the validation
	 * @var array
	 */
	protected $errorMessages = array();
	
	/**
	 * Sets the name of the form.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $name
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Returns the name of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Sets the elements of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	Element\Collection $elements
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setElements( Element\Collection $elements )
	{
		$this->elements = $elements;
		return $this;
	}
	
	/**
	 * Returns an element of the form with the name of $name
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $name
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function getElement( $name )
	{
		foreach( $this->elements->getAll() as $item )
		{
			if( strtoupper( $item->getName() ) === strtoupper( $name ) )
			{
				return $item;
			}
		}
		
		return null;
	}
	
	/**
	 * Sets the action of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $action
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setAction( $action )
	{
		$this->action = $action;
		return $this;
	}
	
	/**
	 * Returns the action of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * Sets the method of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $method
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setMethod( $method )
	{
		$this->method = $method;
	}
	
	/**
	 * Returns the method of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	/**
	 * Makes the form submit its data by ajax or a simple HTTP request
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	boolean $isAjax
	 * @return	\Ez\Form\AbstractForm
	 */
	public function setIsAjax( $isAjax )
	{
		$this->isAjax = (bool) $isAjax;
		return $this;
	}
	
	/**
	 * Returns the isAjax property of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	boolean
	 */
	public function getIsAjax()
	{
		return (bool) $this->isAjax;
	}
	
	/**
	 * Enter description here ...
	 * @param unknown_type $decorator
	 */
	public function setDecorator( $decorator )
	{
		$this->decorator = $decorator;
	}
	
	/**
	 * Validates all elements of the form against their own validators
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	boolean
	 */
	public function isValid()
	{
		$isValid = true;
		
		foreach( $this->elements->getAll() as $element )
		{
			foreach( $element->getValidators()->getAll() as $validator )
			{
				if( !$validator->isValid( $element->getValue() ) )
				{
					$isValid = false;
					array_push( $this->errorMessages, $validator->getErrorMessage( $element ) );
				}
			}
		}
		
		return $isValid;
	}
	
	/**
	 * Returns the array of error messages generated after the validation
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	array
	 */
	public function getErrorMessages()
	{
		return $this->errorMessages;
	}
	
	public function __get( $key )
	{
		foreach( $this->elements->getAll() as $element )
		{
			if( $element->getName() === $key )
			{
				return $element;
			}
		}
		
		throw new \Exception( "There is no such element ({$key}) in form \"{$this->name}\"" );
	}
	
	/**
	 * Returns the HTML ready markup of the form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function __toString()
	{
		$output = "<form action=\"{$this->action}\" method=\"{$this->method}\">";
		
		foreach( $this->elements->getAll() as $element )
		{
			$output .= $element;
		}
		
		return $output .= "</form>";
	}
}