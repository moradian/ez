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

class Radio extends AbstractElement
{
	/**
	 * @var \Ez\Form\Element\OptionCollection
	 */
	private $options;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Sets options of the radio input group
	 * 
	 * @author	Mehdi Bakhtiari
	 * @param	\Ez\Form\Element\OptionCollection $options
	 * @return	\Ez\Form\Element\Radio
	 */
	public function setOptions( OptionCollection $options )
	{
		$this->options = $options;
		return $this;
	}
	
	/**
	 * Returns options of the radio input group
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Form\Element\OptionCollection
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Generates the markup of the element to be rendered in a browser
	 * 
	 * @author	Mehdi Bakhtiari
	 * @return	string
	 */
	public function __toString()
	{
		$output	= "";
		$i		= 0;
		$ID		= empty( $this->id ) ? $this->name : $this->id;
		
		foreach( $this->options->getAll() as $option )
		{
			$output .=	"<input type=\"radio\" name=\"{$this->name}\" id=\"{$ID}_{$i}\""
			.			" value=\"{$option->getValue()}\""
			.			( $this->value === $option->getValue() ? " checked=\"checked\" />" : " />" )
			.			"<label for=\"{$ID}_{$i}\">{$option->getText()}</label>";
			
			$i++;
		}
		
		return $output;
	}
}