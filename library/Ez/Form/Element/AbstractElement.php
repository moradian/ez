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

namespace Ez\Form\Element;

abstract class AbstractElement
{
	/**
	 * ID of the element
	 * @var string
	 */
	protected $id;
	
	/**
	 * Name of the element
	 * @var string
	 */
	protected $name;
	
	/**
	 * The label of the element
	 * @var string
	 */
	protected $label;
	
	/**
	 * Style attribute of the element
	 * @var string
	 */
	protected $style;
	
	/**
	 * Class attribute of the element
	 * @var string
	 */
	protected $class;
	
	/**
	 * Value of the element
	 * @var string
	 */
	protected $value;
	
	/**
	 * @var \Ez\Form\Validator\Collection
	 */
	protected $validators;
	
	/**
	 * Enforcing all elements to declare their own toString()
	 * method to handle generating HTML output of the form.
	 */
	abstract public function __toString();
	
	/**
	 * Sets the ID attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $id
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setId( $id )
	{
		$this->id = $id;
		return $this;
	}
	
	/**
	 * Returns the ID attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Sets the name attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $name
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setName( $name )
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Returns the name attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Sets the label of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $label
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setLabel( $label )
	{
		$this->label = $label;
		return $this;
	}
	
	/**
	 * Returns the label of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getLabel()
	{
		return $this->label;
	}
	
	/**
	 * Sets the style attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $style
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setStyle( $style )
	{
		$this->style = $style;
		return $this;
	}
	
	/**
	 * Returns the style attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getStyle()
	{
		return $this->style;
	}
	
	/**
	 * Sets the value attribute of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	string $value
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setValue( $value )
	{
		$this->value = $value;
		return $this;
	}
	
	/**
	 * Returns the value of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Adds a new validator to the collection of validators to be applied
	 * for the element.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	\Ez\Form\Validator\AbstractValidator $validator
	 * @return	\Ez\Form\Element\AbstractElement
	 */
	public function setValidator( \Ez\Form\Validator\AbstractValidator $validator )
	{
		$this->validators->addItem( $validator );
		return $this;
	}
	
	/**
	 * Returns the validators collection of the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Form\Validator\Collection
	 */
	public function getValidators()
	{
		return $this->validators;
	}
}