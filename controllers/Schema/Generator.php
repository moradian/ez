<?php

namespace Schema;

class GeneratorController extends \Ez\Controller\AbstractController
{
	function __construct()
	{
		$this->defaultViewFileName	= "";
	}
	
	public function run()
	{
		try
		{
			$classes = array(	$this->doctrineEntityManager->getClassMetadata( "\Model\Client" ),
								$this->doctrineEntityManager->getClassMetadata( "\Ez\Acl\Role" ),
								$this->doctrineEntityManager->getClassMetadata( "\Ez\Acl\ResourceAllocation" ),
								/*
								$this->doctrineEntityManager->getClassMetadata( "Model_Province" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_AdPay" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_Category" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_StatusCode" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_JunkReport" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_Permission" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_Administrator" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_AssignedPermission" ),
								$this->doctrineEntityManager->getClassMetadata( "Model_Invoice" ),
								*/
			);
			
			$tool = new \Doctrine\ORM\Tools\SchemaTool( $this->doctrineEntityManager );
			
			
			// $mehdi = new \Doctrine\ORM\Proxy\ProxyFactory( $this->doctrineEntityManager, PATH_TO_LIBRARY . "Proxies", "Proxy" );
			// $mehdi->generateProxyClasses( $classes );
			var_dump( $tool->getCreateSchemaSql( $classes ) );
			$tool->createSchema( $classes );
		}
		catch( \Exception $XCP )
		{
			exit( $XCP->getMessage() );
		}
	}
	
	public function setViewProperties()
	{
		
	}
	
	public function postRun()
	{
		
	}
}
