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

class OneColumn extends AbstractDecorator
{
	/**
	 * @var \Ez\Form\Decorator\OneColumn
	 */
	private static $instance = null;

    /**
     * @var int
     */
    private $cellSpacing = 2;

    /**
     * @var string
     */
    private $labelsColor = "#000000";
	
	private function __construct()
	{
		$this
			->setFormWrapper(
				"<table id=\"%sForm\" cellspacing=\"%s\">
					<tr>
						<td></td>
						<td></td>
					</tr>
					%s
				</table>"
			)
			->setElementWrapper( "<td>%s</td>" )
			->setLabelWrapper( "<td style=\"color: %s\" align=\"right\">%s</td>" )
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
			self::$instance = new OneColumn();
		}
		
		return self::$instance;
	}

    /**
     * @param $cellSpacing
     * @return Ez\Form\Decorator\OneColumn
     */
    public function setCellSpacing($cellSpacing)
    {
        $this->cellSpacing = $cellSpacing;
        return $this;
    }

    /**
     * @return int
     */
    public function getCellSpacing()
    {
        return $this->cellSpacing;
    }

    /**
     * @param $labelsColor
     * @return OneColumn
     */
    public function setLabelsColor($labelsColor)
    {
        $this->labelsColor = $labelsColor;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelsColor()
    {
        return $this->labelsColor;
    }

	/**
	 * (non-PHPdoc)
	 * @see		Ez\Form\Decorator\AbstractDecorator::render()
	 * @author	Mehdi Bakhtiari
	 */
	public function render( \Ez\Form\AbstractForm $form )
	{
		$output = "";
		
		foreach( $form->getElements()->getAll() as $element )
		{
			$elementMarkup 		= sprintf( $this->getLabelWrapper(), $this->labelsColor, $element->getLabel() );
			$elementDecorator	= $element->getDecorator();
			
			
			if( !empty( $elementDecorator ) )
			{
				$elementMarkup .= sprintf( $element->getDecorator(), $element );
			}
			else 
			{
				$elementMarkup .= sprintf( $this->getElementWrapper(), $element );
			}
			
			$output .=	sprintf( $this->getElementLabelPairWrapper(), $elementMarkup );
		}
		
		$output = sprintf( $this->getFormWrapper(), $form->getName(), $this->cellSpacing, $output );

		return	"<form name=\"{$form->getName()}\" action=\"{$form->getAction()}\" method=\"{$form->getMethod()}\">"
		.		sprintf( $this->getFormWrapper(), $form->getName(), $this->cellSpacing, $output ) . "</form>";
	}
}