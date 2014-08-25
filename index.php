<?php

session_start();

require_once 'class/autoload.php';
require_once 'offline/config.inc.php';
require_once 'offline/db.inc.php';
require_once 'offline/fncs.inc.php';


if( empty($_GET['action']) ) { // créé $_GET['action']
	$_GET['action'] = 'index';
}

if( empty($_GET['lang']) ) { // créé $_GET['lang']
	$_GET['lang'] = DEFAULT_LANGUAGE;
}
elseif( $_GET['lang'] == DEFAULT_LANGUAGE ) {
	$_GET['lang'] = '';
}

$controlerObj=new controler($_GET['action']);
$controlerName=$controlerObj->getName();


header_remove('Server');
header_remove('X-Powered-By');
// require_once 'inc/antiDDos.php';
header('Content-Type: text/html; charset=utf-8');

$csp = 'script-src \'unsafe-inline\' \'unsafe-eval\' \'self\' '.PREFIX_ABSOLUTE_CDN.' maxcdn.bootstrapcdn.com code.jquery.com html5shiv.googlecode.com https://linkhelp.clients.google.com; font-src *;';
if(!DEVELOPPEMENT){
	header('X-Content-Security-Policy: ' . $csp);
	header('X-WebKit-CSP: ' . $csp);
	header('Content-Security-Policy: ' . $csp);
}


if( !isset($_SERVER['HTTP_USER_AGENT']) || false !== strpos($_SERVER['HTTP_USER_AGENT'], 'SiteSucker') ) { // Block some bad bots & SiteSucker
	?><!doctype html><html><head><title>Are you a bot ?</title></head><body><h1>Are you a bot ?</h1><p>We are suspecting you to be a bot. If this is not the case, thank you to change browers to :</p><ul><li><a href="https://www.mozilla.org/fr/firefox/new/#download-fx">Mozilla Firefox</a></li><li><a href="https://google.com/chrome">Google Chrome</a></li><li><a >or Safari</a></li></ul></body></html><?php
	
	exit;

}


$html=new html();


define('USER_LANGUAGE', $html->lang());


if(USER_LANGUAGE==DEFAULT_LANGUAGE){
	define('PREFIX_LINK_LANG', PREFIX_LINK);
	define('PREFIX_ABSOLUTE_LINK_LANG', PREFIX_ABSOLUTE_LINK);
	define('PREFIX_ABSOLUTE_CDN_LANG', PREFIX_ABSOLUTE_CDN);
	define('PREFIX_ABSOLUTE_TINY_LINK_LANG', PREFIX_ABSOLUTE_TINY_LINK);
}
else{
	define('PREFIX_LINK_LANG', PREFIX_LINK.USER_LANGUAGE.'/');
	define('PREFIX_ABSOLUTE_LINK_LANG', PREFIX_ABSOLUTE_LINK.USER_LANGUAGE.'/');
	define('PREFIX_ABSOLUTE_CDN_LANG', PREFIX_ABSOLUTE_CDN.USER_LANGUAGE.'/');
	define('PREFIX_ABSOLUTE_TINY_LINK_LANG', PREFIX_ABSOLUTE_TINY_LINK.USER_LANGUAGE.'/');
}

if($_GET['action']!='changeLang' && USER_LANGUAGE != $_GET['lang'] /*&& USER_LANGUAGE != DEFAULT_LANGUAGE*/ ){
	
	
	$requestUri = $_SERVER['REQUEST_URI'];
	if(strpos($requestUri, PREFIX_LINK.$_GET['lang'].'/')===0){
		$requestUri = substr($requestUri, strlen(PREFIX_LINK.$_GET['lang'].'/'));
	}
	
	if(strpos($requestUri, PREFIX_LINK)===0){
		$requestUri = substr($requestUri, strlen(PREFIX_LINK));
	}
	
	http_redirect(PREFIX_LINK_LANG.$requestUri, array(), false, HTTP_REDIRECT_TEMP);
	exit;
}

$langNames = array(
					'en' => 'English',
					'fr' => 'Français',
					'es' => 'Español'
				);


$controlerObj->exec($_GET);
