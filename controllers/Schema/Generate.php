<?php

/**
 * This controller simply generates your database from your previously
 * coded and prepared model classes.
 *
 * To use this controller to create your tables, code your entity classes first,
 * then address them just like the example below. Just add them to the $classes
 * array. You're wondering what next you gotta do!? Just point your browser to
 * http://<your-domain>/schema/generate
 *
 * If everything goes well, you will see the DDL SQL statements. And if anything
 * goes wrong, you will see the exception message indicating the problem.
 */

namespace Schema;

class GenerateController extends \Ez\Controller\AbstractController
{
	public function run()
	{
		try
		{
			$classes = array( $this->doctrineEntityManager->getClassMetadata( "\Model\Client" ) );

			$tool = new \Doctrine\ORM\Tools\SchemaTool( $this->doctrineEntityManager );
			$tool->createSchema( $classes );
			print( $tool->getCreateSchemaSql( $classes ) );
		}
		catch( \Exception $XCP )
		{
			exit( $XCP->getMessage() );
		}
	}

	public function postRun()
	{
	}
}
