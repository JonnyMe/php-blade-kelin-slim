<?php
	
	if ( ! session_id() ) @ session_start();

    //DEBUG
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	//LOCALE
	setlocale(LC_ALL, 'Italian_Italy.1250');

	//COSTANTI
	define("APP", __DIR__ . '/../');
	define("VIEWS", APP . "/resources/views");
	define("CACHE", APP . "/resources/cache");

	//REQUIRES/INCLUDES
	require_once APP . '/vendor/autoload.php';

	include APP . '/config/misc/file-upload.php';
	include APP . '/config/misc/form-sanitizer.php';
	include APP . '/config/misc/database.class.php';

    //VARIABILI GLOBALI
	$route 		= new \Klein\Klein();
	$blade 		= new \Jenssegers\Blade\Blade(VIEWS, CACHE);
	$ini_array 	= parse_ini_file(APP . '/config.ini', true);

	//FUNZIONI
	function include_route($route_file){
		global $route;
		require_once __DIR__ . '/routes/' . $route_file . '.routes.php';
	}

	function successJSON($data){
	    return genericResponse(0, $data, true);
	}
	
	function errorJSON($data){
	    return genericResponse(1, $data, true);
	}

	function success($data){
	    return genericResponse(0, $data);
	}
	
	function error($data){
	    return genericResponse(1, $data);
	}

	function genericResponse($status, $data, $json = false){

		$jsonResponse = array(
	        "errori" => $status,
	        "data" => $data
	    );

		if($json){
			return json_encode($jsonResponse);
		}
	    
	    return $jsonResponse;
	}
?>
