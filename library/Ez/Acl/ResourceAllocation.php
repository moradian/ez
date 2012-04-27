<?php 

namespace Ez\Acl;

/**
 * @Entity
 * @Table( name="acl_resource_allocation" )
 */
class ResourceAllocation
{
	/**
	 * @Id
	 * @Column( type="integer", length=10 )
	 * @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @ManyToOne( targetEntity="\Model\Client", cascade={"persist"} )
	 * @JoinColumn( name="user", nullable=false )
	 */
	protected $user;

	/**
	 * @Column( type="string", length=200, nullable=false )
	 */
	protected $controller;
}