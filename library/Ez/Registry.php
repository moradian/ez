<?php

namespace Ez;

class Registry
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private static $doctrineEntityManager;
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @param	\Doctrine\ORM\EntityManager $entityManager
	 * @return	void
	 */
	public static function setDoctrineEntityManager( \Doctrine\ORM\EntityManager $entityManager )
	{
		self::$doctrineEntityManager = $entityManager;
	}
	
	/**
	 * @author	Mehdi Bakhtiari
	 * @return	\Doctrine\ORM\EntityManager
	 */
	public static function getDoctrineEntityManager()
	{
		return self::$doctrineEntityManager;
	}
} 