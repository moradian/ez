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

namespace Ez\Form\Validator;

class MinLength extends AbstractValidator
{
	/**
	 * @var integer
	 */
	private $minLength;
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @param	integer $length
	 */
	public function __construct( $length )
	{
		if( !is_numeric( $length ) )
		{
			throw new \Exception( "Provided length for the MinLength validator must be numeric." );
		}
		
		$this->minLength = $length;
	}
	
	/**
	 * Returns the min length
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	integer
	 */
	public function getMinLength()
	{
		return $this->minLength;
	}
	
	/**
	 * Returns a generated error message for an element
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	\Ez\Form\Element\AbstractElement $element
	 * @return	string
	 */
	public function getErrorMessage( \Ez\Form\Element\AbstractElement $element )
	{
		return "Value of {$element->getLabel()} need to be at least {$this->minLength} letters.";
	}
	
	/**
	 * Validates the value of the element against $this->minLength
	 * 
	 * @author	Mehdi Bakhtiari
	 * @see		Ez\Form\Validator.AbstractValidator::isValid()
	 * @throws	Exception If the max length has not been specified yet
	 * @return	boolean
	 */
	public function isValid( $value )
	{
		if( !is_numeric( $this->minLength ) || empty( $this->minLength ) )
		{
			throw new \Exception( "Provided length for the minLength validator must be numeric." );
		}
		return	( strlen( $value ) >= $this->minLength );
	}
}
