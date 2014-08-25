<?php

require '../../offline/config.inc.php';

require 'scss.inc.php';
$scss = new scssc();
$scss->setImportPaths('scss');
$scss->setFormatter( ( ( empty($_GET['min']) || !$_GET['min'] )? 'scss_formatter' : 'scss_formatter_compressed' ) );

$server = new scss_server('scss', null, $scss);
$server->serve();

