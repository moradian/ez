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

class TwoColumn extends AbstractDecorator
{
	/**
	 * @var \Ez\Form\Decorator\TwoColumn
	 */
	private static $instance = null;
	
	private function __construct()
	{
		$this
			->setFormWrapper(
				"<table id=\"%sForm\">
					<tr>
						<td></td>
						<td></td>
						
						<td></td>
						<td></td>
					</tr>
					%s
				</table>"
			)
			->setElementWrapper( "<td id=\"\">%s</td>" )
			->setLabelWrapper( "<td id=\"\">%s</td>" )
			->setElementLabelPairWrapper( "<tr>%s</tr>" );
	}
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @return	\Ez\Form\Decorator\OneColumn
	 */
	public static function getInstance()
	{
		if( is_null( self::$instance ) )
		{
			self::$instance = new TwoColumn();
		}
		
		return self::$instance;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see		Ez\Form\Decorator\AbstractDecorator::render()
	 * @author	Mehdi Bakhtiari
	 */
	public function render( \Ez\Form\AbstractForm $form )
	{
		$output		= "";
		$elements	= $form->getElements()->getAll();
		
		for( $i = 0; $i < count( $elements ); $i++ )
		{
			$rowMarkup = "";
			
			////////////////////////////
			// OUTPUTING FIRST COLUMN //
			////////////////////////////
			
			$elementDecorator	= $elements[ $i ]->getDecorator();
			$rowMarkup 			= sprintf( $this->getLabelWrapper(), $elements[ $i ]->getLabel() );
			
			if( !empty( $elementDecorator ) )
			{
				$rowMarkup .= sprintf( $elementDecorator->getElementWrapper(), $elements[ $i ] );
			}
			else 
			{
				$rowMarkup .= sprintf( $this->getElementWrapper(), $elements[ $i ] );
			}
			
			/////////////////////////////
			// OUTPUTING SECOND COLUMN //
			/////////////////////////////
			
			$rowMarkup 			.= sprintf( $this->getLabelWrapper(), $elements[ ( $i + 1 ) ]->getLabel() );
			$elementDecorator	= $elements[ ( $i + 1 ) ]->getDecorator();
			
			if( !empty( $elementDecorator ) )
			{
				$rowMarkup .= sprintf( $elementDecorator->getElementWrapper(), $elements[ ( $i + 1 ) ] );
			}
			else
			{
				$rowMarkup .= sprintf( $this->getElementWrapper(), $elements[ ( $i + 1 ) ] );
			}
			
			$output .=	sprintf( $this->getElementLabelPairWrapper(), $rowMarkup );
			$i++;
		}
		
		return	"<form name=\"{$form->getName()}\" action=\"{$form->getAction()}\" method=\"{$form->getMethod()}\">"
		.		 sprintf( $this->getFormWrapper(), $form->getName(), $output ) . "</form>";
	}
}