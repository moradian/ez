<?php

namespace Ez\Acl;

/**
 * @MappedSuperClass
 */
class User extends \Ez\AccessProvider
{
	/**
	 * @Column( type="string", length=100 )
	 */
	protected $username;
	
	/**
	 * @Column( type="string", length=200 )
	 */
	protected $password;
	
	/**
	 * @ManyToOne( targetEntity="\Ez\Acl\Role", cascade={"persist"} )
	 * @JoinColumn( name="role" )
	 */
	protected $role;
}