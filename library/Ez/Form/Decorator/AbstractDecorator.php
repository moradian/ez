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

namespace Ez\Form\Decorator;

abstract class AbstractDecorator
{
	/**
	 * @var string
	 */
	protected $formWrapper = "%s";
	
	/**
	 * @var string
	 */
	protected $elementWrapper = "%s";
	
	/**
	 * @var string
	 */
	protected $labelWrapper = "%s";
	
	/**
	 * @var string
	 */
	protected $elementLabelPairWrapper = "%s";
	
	/**
	 * Enforcing all sub-children instances to implement the render method.
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	\Ez\Form\AbstractForm $form
	 * @return	string
	 */
	abstract public function render( \Ez\Form\AbstractForm $form );
	
	/**
	 * Sets the markup to be wrapped arround the whole form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $formWrapper
	 * @return	\Ez\Form\Decorator\AbstractDecorator
	 */
	public function setFormWrapper( $formWrapper )
	{
		$this->formWrapper = $formWrapper;
		return $this;
	}
	
	/**
	 * Returns the markup to be wrapped arround the whole form
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getFormWrapper()
	{
		return $this->formWrapper;
	}
	
	/**
	 * Sets the markup to be wrapped arround the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $elementWrapper
	 * @return	\Ez\Form\Decorator\AbstractDecorator
	 */
	public function setElementWrapper( $elementWrapper )
	{
		$this->elementWrapper = $elementWrapper;
		return $this;
	}
	
	/**
	 * Returns the markup to be wrapped arround the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getElementWrapper()
	{
		return $this->elementWrapper;
	}
	
	/**
	 * Sets the container markup to be wrapped arround the label
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $labelWrapper
	 * @return	\Ez\Form\Decorator\AbstractDecorator
	 */
	public function setLabelWrapper( $labelWrapper )
	{
		$this->labelWrapper = $labelWrapper;
		return $this;
	}
	
	/**
	 * Gets the container markup to be wrapped arround the element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getLabelWrapper()
	{
		return $this->labelWrapper;
	}
	
	/**
	 * Sets the container to be wrapped arround the element
	 * and its label
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $elementLabelPairWrapper
	 * @return	\Ez\Form\Decorator\AbstractDecorator
	 */
	public function setElementLabelPairWrapper( $elementLabelPairWrapper )
	{
		$this->elementLabelPairWrapper = $elementLabelPairWrapper;
		return $this;
	}
	
	/**
	 * Returns the container to be wrapped arround the element
	 * and its label
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getElementLabelPairWrapper()
	{
		return $this->elementLabelPairWrapper;
	}
}