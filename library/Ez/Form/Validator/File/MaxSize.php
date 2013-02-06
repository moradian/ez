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

namespace Ez\Form\Validator\File;

class MaxSize extends \Ez\Form\Validator\AbstractValidator
{
	/**
	 * @var integer
	 */
	private $maxSize;

	/**
	 * @param int $maxSize
	 * @throws \Exception
	 */
	public function __construct( $maxSize )
	{
		if( is_numeric( $maxSize ) )
		{
			throw new \Exception( "Provided size must be a numeric value." );
		}

		$this->maxSize = $maxSize;
	}

	/**
	 * Validates the element.
	 *
	 * @param     string $value
	 * @return    boolean
	 */
	public function isValid( $value )
	{
		return $value[ "size" ] <= $this->maxSize;
	}

	/**
	 * Returns a generated error message for an element
	 *
	 * @param     \Ez\Form\Element\AbstractElement $element
	 * @return    string
	 */
	public function getErrorMessage( \Ez\Form\Element\AbstractElement $element )
	{
		// Todo: Generate an appropriate message
		return sprintf(
			$this->errorMessagePattern,
			"BIG FILE",
			$element->getLabel(),
			""
		);
	}
}
