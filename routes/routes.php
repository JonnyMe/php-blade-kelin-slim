<?php

require_once APP . '/resources/controllers/GenericController.php';

//PHP INFO
$route->respond('GET', '/info', function ($request, $response, $service, $app) {
	return phpinfo();
});

$route->respond('GET', '/hello-world', function ($request, $response, $service, $app) {

	global $blade;
	global $ini_array;

	$data = GenericController::messaggio();

	return $blade->make('hello', [
		'messaggio' => $data
	]);
});

$route->dispatch();

?>