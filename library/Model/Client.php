<?php

namespace Model;

/**
 * @Entity
 * @Table( name="clients" )
 */
class Client extends \Ez\Acl\User
{
	/**
	 * @Id
	 * @Column( type="integer", length=10 )
	 * @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column( type="string", length=60, unique=true )
	 */
	protected $email;
	
	/**
	 * @Column( type="string", length=40 )
	 */
	protected $firstName;
	
	/**
	 * @Column( type="string", length=40 )
	 */
	protected $lastName;
	
	/**
	 * @Column( type="string", length=1 )
	 */
	protected $gender;
	
	/**
	 * @Column( type="string", length=50, nullable=true )
	 */
	protected $phone;
	
	/**
	 * @Column( type="string", length=50, nullable=true )
	 */
	protected $mobile;
	
	/**
	 * @Column( type="integer", length=10 )
	 */
	protected $creditBalance = 0;
	
	/**
	 * @Column( type="string", length=200, nullable=true )
	 */
	protected $streetAddress;
	
	/**
	 * @Column( type="datetime" )
	 */
	protected $regDate;
	
	/**
	 * @Column( type="datetime", nullable=true )
	 */
	protected $lastUpdate;
	
	/**
	 * @Column( type="string", length=120, nullable=true )
	 */
	protected $verificationCode;
	
	/**
	 * @Column( type="string", length=120, nullable=true ) 
	 */
	protected $resetPasswordToken;
}