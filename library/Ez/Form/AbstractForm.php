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

abstract class AbstractForm
{
	const POST_METHOD = "post";
	const GET_METHOD  = "get";
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
	 * @var \Ez\Form\Decorator\AbstractDecorator
	 */
	protected $decorator;

	/**
	 * Holds the error messages of the form, generated after the validation
	 * @var array
	 */
	protected $errorMessages = array();

	/**
	 * Holds field specific error messages
	 * @var array
	 */
	protected $fieldMessages = array();

	/**
	 * Holds the fine validated fields
	 * @var array
	 */
	protected $fineFields = array();

	/**
	 * Sets the name of the form.
	 *
	 * @author    Mehdi Bakhtiari
	 * @param    string $name
	 * @return    \Ez\Form\AbstractForm
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Returns the name of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the elements of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @param    Element\Collection $elements
	 * @return    \Ez\Form\AbstractForm
	 */
	public function setElements( Element\Collection $elements )
	{
		$this->elements = $elements;
		$this->elements->setEqulityField( "id" );
		return $this;
	}

	/**
	 * Returns the elements of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    \Ez\Form\Element\Collection
	 */
	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * Returns an element of the form with the name of $name
	 *
	 * @author    Mehdi Bakhtiari
	 * @param     string $name
	 * @return    \Ez\Form\Element\AbstractElement
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
	 * @author    Mehdi Bakhtiari
	 * @param    string $action
	 * @return    \Ez\Form\AbstractForm
	 */
	public function setAction( $action )
	{
		$this->action = $action;
		return $this;
	}

	/**
	 * Returns the action of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    string
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * Sets the method of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @param    string $method
	 * @return    \Ez\Form\AbstractForm
	 */
	public function setMethod( $method )
	{
		$this->method = $method;
	}

	/**
	 * Returns the method of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * Makes the form submit its data by ajax or a simple HTTP request
	 *
	 * @author    Mehdi Bakhtiari
	 * @param    boolean $isAjax
	 * @return    \Ez\Form\AbstractForm
	 */
	public function setIsAjax( $isAjax )
	{
		$this->isAjax = (bool) $isAjax;
		return $this;
	}

	/**
	 * Returns the isAjax property of the form
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    boolean
	 */
	public function getIsAjax()
	{
		return (bool) $this->isAjax;
	}

	/**
	 * Sets the decorator to render the form with
	 *
	 * @author    Mehdi Bakhtiari
	 * @param     \Ez\Form\Decorator\AbstractDecorator $decorator
	 * @return    \Ez\Form\AbstractForm
	 */
	public function setDecorator( Decorator\AbstractDecorator $decorator )
	{
		$this->decorator = $decorator;
		return $this;
	}

	/**
	 * Populates the form with received data from the client..
	 *
	 * @author  Mehdi Bakhtiari
	 * @param   \Ez\Request $request
	 * @return  \Ez\Form\AbstractForm
	 */
	public function populateByRequest( \Ez\Request $request )
	{
		foreach( $this->elements->getAll() as $element )
		{
			if( $this->getMethod() == self::POST_METHOD )
			{
				$element->setValue( $request->getPost( $element->getName() ) );
				continue;
			}

			$element->setValue( $request->getQuery( $element->getName() ) );
		}

		return $this;
	}

	/**
	 * Validates all elements of the form against their own validators
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    boolean
	 */
	public function isValid()
	{
		$isValid                = true;
		$fineElementsCollection = $this->elements;
		$this->fineFields       = array();

		foreach( $this->elements->getAll() as $element )
		{
			// TODO:	Check element type if it is select, checkbox or radio button
			// 			and validate the selected value to see if it is picked from
			//			the list options for that element
			if( is_null( $element->getValidators() ) )
			{
				continue;
			}

			foreach( $element->getValidators()->getAll() as $validator )
			{
				if( !$validator->isValid( $element->getValue() ) )
				{
					$isValid      = false;
					$errorMessage = $validator->getErrorMessage( $element );

					$fineElementsCollection->removeItem( $element );
					array_push( $this->errorMessages, $errorMessage );

					$this->fieldMessages[ ] = array(
						"cssSelector" => $this->getElementCssSelector( $element ),
						"message"     => $errorMessage
					);
				}
			}
		}


		foreach( $fineElementsCollection->getAll() as $item )
		{
			$this->fineFields[] = $this->getElementCssSelector( $item );
		}

		return $isValid;
	}

	/**
	 * Returns the array of error messages generated after the validation
	 *
	 * @author    Mehdi Bakhtiari
	 * @return    array
	 */
	public function getErrorMessages()
	{
		return $this->errorMessages;
	}

	/**
	 * @author Mehdi Bakhtiari
	 * @return array
	 */
	public function getFieldMessages()
	{
		return $this->fieldMessages;
	}

	/**
	 * @return array
	 */
	public function getFineFields()
	{
		return $this->fineFields;
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
	 * @author    Mehdi Bakhtiari
	 * @return    string
	 */
	public function __toString()
	{
		if( !empty( $this->decorator ) )
		{
			return $this->decorator->render( $this );
		}
		else
		{
			$output = "<form action=\"{$this->action}\" method=\"{$this->method}\">";

			foreach( $this->elements->getAll() as $element )
			{
				$output .= $element;
			}

			return $output . "</form>";
		}
	}

	/**
	 * @param Element\AbstractElement $element
	 * @return string
	 */
	protected function getElementCssSelector( \Ez\Form\Element\AbstractElement $element )
	{
		$tag = "";

		switch( get_class( $element ) )
		{
			case "Ez\Form\Element\Text":
			case "Ez\Form\Element\Password":
			case "Ez\Form\Element\Button":
			case "Ez\Form\Element\Radio":
			case "Ez\Form\Element\Checkbox":
				$tag = "input";
				break;
			case "Ez\Form\Element\Select":
				$tag = "select";
				break;
			case "Ez\Form\Element\Textarea":
				$tag = "textarea";
				break;
		}

		return $tag . "[id='{$element->getId()}']";
	}
}