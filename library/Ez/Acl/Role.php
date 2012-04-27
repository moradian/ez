<?php 

namespace Ez\Acl;

/**
 * @Entity
 * @Table( name="acl_roles" )
 */
class Role
{
	/**
	 * @Id
	 * @Column( type="integer", length=10 )
	 * @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column( type="string", length=100, nullable=false )
	 */
	protected $name;
	
	/**
	 * @Column( type="boolean", nullable=false )
	 */
	protected $isDefault;
}
