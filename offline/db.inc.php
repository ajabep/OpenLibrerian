<?php

$db;

function open_db(){
	
	global $db;
	
	$dbDsn = 'mysql:host=HOST;dbname=DBNAME;charset=utf8';
	$dbUsername = 'USERNAME';
	$dbPassword = 'PASSWORD';

	
	
	if(!($db instanceof PDO)){
		try{
			$db=new PDO(
							$dbDsn,
							$dbUsername,
							$dbPassword,
							array(
								PDO::ATTR_ERRMODE => (PDO::ERRMODE_EXCEPTION * DEVELOPPEMENT  +  PDO::ERRMODE_SILENT * !DEVELOPPEMENT),
								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
							)
					);
		}
		catch(Exception $e){
			error_log($e->getMessage().' - CODE '.$e->getCode());
			header('HTTP/1.0 503 Service unavailable');
			if($e->getCode()==1040 || $e->getCode()==1226){
				error_log('The database is unreachable.'."\r\n".'Message : '.$e->getMessage()."\r\n".'ERROR CODE : '.$e->getCode(), 1, DEVELOPPER_EMAIL);
				exit('The database is currently unreachable. Thank you try again later.');
			}
			error_log('The database have a problem :'."\r\n".'Message : '.$e->getMessage()."\r\n".'ERROR CODE : '.$e->getCode(), 1, DEVELOPPER_EMAIL);
			exit('The database or the scripts have an error. Thank you try again later. If it\'s continu, contact the webmaster at "'.DB_EMAIL.'".');
		}
	}
}

function close_db(){
	
	global $db;
	
	unset($db);
	$db;
	
	
}