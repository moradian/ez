<?php

session_start();
ini_set( "display_errors", 1 );

// SET DEFAULT TIMEZONE
date_default_timezone_set( "Asia/Tehran" );

// THIS IS PHP SCRIPT THAT HOLDS ALL DEFINED CONSTANTS
// ABOUT THIS WHOLE WEBSITE.
require_once "../config.php";

$application = new Ez\Application;