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

namespace Ez\Collection;

abstract class AbstractCollection
{
	/**
	 * Holds the type of the collection
	 * @var        string
	 * @author    Mehdi Bakhtiari
	 */
	private $type;

	/**
	 * Is the actual collection and holds items of the collection
	 * @var     array
	 * @author	Mehdi Bakhtiari
	 */
	private $collection = array();

	/**
	 * The field of each element within the collection to check if two elements
	 * are equal in the collection
	 * @var string
	 */
	private $equlityField;

	/**
	 * It is mandatory to implement the constructor for each child
	 * in the inheritance tree.
	 *
	 * @param	string $type
	 * @author  Mehdi Bakhtiari
	 */
	abstract public function __construct( $type );

	/**
	 * Is the setter for the $type property of the collection
	 *
	 * @param	string $type
	 * @throws  \Exception    If the type of the collection has already been set
	 * @return  void
	 * @author  Mehdi Bakhtiari
	 */
	protected function setType( $type )
	{
		if( strlen( trim( $this->type ) ) )
		{
			throw new \Exception( "The type of this collection has already been set to {$this->type}" );
		}

		$this->type = trim( $type );
	}

	/**
	 * Getter of $type
	 *
	 * @return	string $this->type
	 * @author  Mehdi Bakhtiari
	 */
	protected function getType()
	{
		return $this->type;
	}

	/**
	 * Enter description here ...
	 *
	 * @param	object $item
	 * @throws	\Exception    If the type of the collection is not specified yet
	 *                       If the type of the provided $item does not match with $this->type
	 *
	 * @return	\Ez\Collection\AbstractCollection
	 * @author  Mehdi Bakhtiari
	 */
	public function addItem( $item )
	{
		$this->checkElement( $item );
		array_push( $this->collection, $item );
		return $this;
	}

	/**
	 * Returns the item at the position of $index
	 *
	 * @param	integer $index
	 * @throws	\Exception    If the provided $index is not an integer
	 *                        If the desired index is greater than the length of $this->collection
	 *                        or is less than zero
	 *
	 * @return	object $this->collection[ $index ]
	 * @author  Mehdi Bakhtiari
	 */
	public function getItem( $index )
	{
		if( !ctype_digit( (string) $index ) )
		{
			throw new \Exception( "What do you mean by {$index} index!?" );
		}

		if( intval( $index ) >= count( $this->collection ) || intval( $index ) < 0 )
		{
			throw new \Exception( "There is not any item at position {$index}" );
		}

		return $this->collection[ $index ];
	}

	/**
	 * Enter description here ...
	 *
	 * @return    array $this->collection
	 * @author    Mehdi Bakhtiari
	 */
	public function getAll()
	{
		return $this->collection;
	}

	/**
	 * Populates the collection with the provided array
	 *
	 * @param    array $source
	 * @uses    $this->addItem()
	 * @return    void
	 * @author    Mehdi Bakhtiari
	 */
	public function populateWith( array $source )
	{
		foreach( $source as $item )
		{
			$this->addItem( $item );
		}
	}

	/**
	 * Removes an element from the collection
	 *
	 * @author    Mehdi Bakhtiari
	 * @param    $item
	 * @throws    \Exception
	 */
	public function removeItem( $item )
	{
		$newCollection = array();
		$equalityField = $this->equlityField;
		$this->checkElement( $item );

		if( empty( $this->equlityField ) )
		{
			throw new \Exception( "No equality field has been provided." );
		}

		foreach( $this->collection as $element )
		{
			if( @call_user_method( "get" . ucwords( $equalityField ), $element )
				=== @call_user_method( "get" . ucwords( $equalityField ), $item )
			)
			{
				continue;
			}

			$newCollection[ ] = $element;
		}

		$this->collection = $newCollection;
	}

	/**
	 * Cleans and resets $this->collection
	 *
	 * @return    void
	 * @author    Mehdi Bakhtiari
	 */
	public function clean()
	{
		$this->collection = array();
	}

	/**
	 * @param string $equlityField
	 */
	public function setEqulityField( $equlityField )
	{
		$this->equlityField = $equlityField;
	}

	private function checkElement( $item )
	{
		if( empty( $this->type ) )
		{
			throw new \Exception( "The type of the collection has not yet been specified." );
		}

		if( class_exists( $this->type, true ) )
		{
			if( get_class( $item ) !== $this->type && !is_a( $item, $this->type ) )
			{
				throw new \Exception( "The provided item is not an instance of {$this->type}" );
			}
		}
		else
		{
			if( gettype( $item ) !== $this->type )
			{
				throw new \Exception( "The provided item is not a/an {$this->type}" );
			}
		}
	}
}