<?php

///////////////////////////////
// DETERMINING THE ROOT PATH //
///////////////////////////////

$rootPath = realpath( __DIR__ );

////////////////////////////////////////
// SETTING APPLICATION WIDE CONSTANTS //
////////////////////////////////////////

define( "PUBLIC_PATH"					, $rootPath . "/client/" );
define( "ROOT_PATH"						, $rootPath );
define( "PATH_TO_TEMPLATES"				, ROOT_PATH . "/templates/" );
define( "PATH_TO_VIEWS"					, ROOT_PATH . "/views/" );
define( "PATH_TO_CONTROLLERS"			, ROOT_PATH . "/controllers/" );
define( "PATH_TO_CACHE"					, ROOT_PATH . "/cache/" );
define( "PATH_TO_TRANSLATIONS"			, ROOT_PATH . "/translations/" );
define( "PATH_TO_LIBRARY"				, ROOT_PATH . "/library/" );
define( "PATH_TO_LOGS"					, ROOT_PATH . "/logs/" );
define( "USER_SESSION"					, "AUTHENTICATED_USER" );
define( "ADMIN_SESSION"					, "ADMINISTRATOR_USER" );

// INCLUDES
require_once PATH_TO_LIBRARY . "/Ez/Autoloader.php";

// SETTING UP AUTOLOADER FOR DOCTRINE
Ez\Autoloader::addPath( PATH_TO_LIBRARY );

// REGISTER AUTOLOAD METHOD
Ez\Autoloader::register();