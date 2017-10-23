<?php

//require "../base_config.php";

define("BASEURL", $eventus_tix_base_path.'/organizer'); 
define("LANDINGPAGE", BASEURL . '/signin');
define("SIGNINPAGE", BASEURL . '/signin');

define("APPTITLE", "TechArtusFramework");
define("TEMPLATENAME", 'taf');

// Dirs
define("VIEWS_DIR", BASEURL.'/views/');
define("API_DIR", 'api/');
define("VIEWS_DATA_DIR", VIEWS_DIR . 'data/');
define("VIEWS_VIEWS_DIR", VIEWS_DIR . 'views/');

// Page Pieces
define("TEMPLATES_DIR", BASEURL."/views/templates/");
define("PIECES_DIR", TEMPLATES_DIR . "pieces/");
define("HEADPIECE", PIECES_DIR . "head.php");
define("NECKPIECE", PIECES_DIR . "neck.php");
define("TAILPIECE", PIECES_DIR . "tail.php");

// Start the session
session_start();

// includes
require_once('configuration.php');
require_once("classes/DBH.php");
require_once("classes/Authorizer.php");
require_once("classes/Wrapper.php");
require_once("api/User.php");

