<?php

function chargerClasse($classe){
	require_once $classe . '.class.php';
}

spl_autoload_register ('chargerClasse');