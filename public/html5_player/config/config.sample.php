<?php
// Define Session
$session_time = 300;    // in minutes
$session_time = $session_time*60;    // to get seconds value
//echo "session_time:".$session_time."<br>\n";

// server should keep session data for AT LEAST $session_time value
ini_set('session.gc_maxlifetime', $session_time);
// each client should remember their session id for EXACTLY $session_time value
session_set_cookie_params($session_time);
session_start();
//echo "session_init:".$_SESSION['session_init']."<br>\n";
//echo "diff:".(time() - $_SESSION['session_init'])."<br>\n";
if (isset($_SESSION['session_init']) && (time() - $_SESSION['session_init'] > $session_time)) {
    echo "session EXPIRE !"."<br>\n";
    //session_unset();     // unset $_SESSION variable for the run-time 
    //session_destroy();   // destroy session data in storage
}
// Define Debug 
$debug = isset($_GET['debugmode']) ? $_GET['debugmode']:"no"; // pour l'activer rajouter "&debugmode" en fin d'url (ainsi chaque dev peut l'utiliser de son conté sans pertuber l'autre)
define('DEBUG_MODE', $debug);
$_SESSION['debugmode'] = $debug;

define('STOP_AJAX', 0);

//echo DEBUG_MODE;
if (DEBUG_MODE == "all"):
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    @ini_set('display_errors', 'on');
    @error_reporting(E_ALL | E_STRICT);
else:
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('display_errors', FALSE);
    ini_set('display_startup_errors', FALSE);
    @ini_set('display_errors', 'off');
    @error_reporting(0);
endif;

define('FORCE_SMARTY_COMPILE', true);

define('APP_DOMAIN', 'http://ov-c70599.infomaniak.ch');
define('APP_FOLDER', '/_mixte/html/');
define('APP_URL', 'http://ov-c70599.infomaniak.ch/_mixte/html/');
define('APP_ROOT', '/home/sites/default/www/_mixte/html/');
define('SERVER_ROOT', '/home/sites/default/www/');
define('FABRIQUE_URL', 'http://87.106.251.239/fabrique/api/wpc.php');

//define('DEFAULT_LANGUAGE', 'fr');
define('DEFAULT_LANGUAGE', 1); // ATTENTION : changer aussi dans open/optim.php

/*
  // Server Nabu
  define( "DB_DSN", "mysql:host=127.0.0.1;dbname=lms" );
  //// define( "DB_NAME", "lms2" );
  define( "DB_USERNAME", "root" );
  define( "DB_PASSWORD", "BKGqmh1Q" );
 */
// Local
define("DB_DSN", "mysql:host=localhost;dbname=lms");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "BKGqmh1Q");

define("SALTHASH", 'D]Jn#|LIFvx!1pW|-cF>.J6Z^W~Oz`<[K{(S+]w8|>$,ip^B{YC8 a1^yxh$ZUs6');

define("MULTILANG", false);

define("FABRIQUE_PRODUCTS_PATH", $_SERVER['DOCUMENT_ROOT']."/export_online/");
define("FABRIQUE_PRODUCTS_URL", APP_DOMAIN."/export_online/");
define("PRODUCTS_FABRIQUE_PATH", $_SERVER['DOCUMENT_ROOT']."/export_fabrique/products/");
define("PRODUCTS_FABRIQUE_URL", APP_DOMAIN."/export_fabrique/products/");

//define("FABRIQUE_PRODUCTS_PATH", "/home/sites/default/www/export_online/");
//define("PRODUCTS_FABRIQUE_PATH", "/home/sites/default/www/export_fabrique/products/");
define("PRODUCTS_ONLINE_PATH", "/home/sites/default/www/export_online/");

define("TEMPLATE_EDIT_PATH", "/home/sites/default/www/templates_edit/clients/");
define("TEMPLATE_ONLINE_PATH", "/home/sites/default/www/templates/clients/");
define("EXPORT_SCORM_PATH", "/home/sites/default/www/export_scorm/");

define("PAGINATION_ELEMENTS_PER_PAGE", 30);

// Detection du navigateur pour ouverture automatique du menu si IE --> fichier footer.tpl
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
    define("USER_NAVIGATEUR", "MSIE");
else
    define("USER_NAVIGATEUR", "OTHERS");