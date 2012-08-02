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

class Option
{
	/**
	 * @var string
	 */
	private $value;
	
	/**
	 * @var string
	 */
	private $text;

    public function __construct( $value = null, $text = null )
    {
        if( is_string( $value ) )
        {
            $this->setValue( $value );
        }

        if( is_string( $text ) )
        {
            $this->setText( $text );
        }
    }
	
	/**
	 * Sets the value of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $value
	 * @throws	\Exception In case the provided $value is not a string
	 * @return	\Ez\Form\Element\Option
	 */
	public function setValue( $value )
	{
		if( is_string( $value ) )
		{
			$this->value = $value;
			return $this;
		}
		
		throw new \Exception( "Value for options must be string." );
	}
	
	/**
	 * Returns the value of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Sets the text (label) of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param 	string $text
	 * @throws	\Exception In case the provided $text is not a string
	 * return	\Ez\Form\Element\Option
	 */
	public function setText( $text )
	{
		if( is_string( $text ) )
		{
			$this->text = $text;
			return $this;
		}
		
		throw new \Exception( "Text for options must be string." );
	}
	
	/**
	 * Returns the text of the option
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function getText()
	{
		return $this->text;
	}
}