<?php

function __autoload($className)
{
	require_once "controller/".$className.".php";
}


$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
if(sizeof($request < 1))
{
	http_response_code(404);
}
switch ($method) 
{
	case 'POST':
		$$request[0] = new $request[0];
		$$request[0]->post();
	break;
	case 'GET':
		$$request[0] = new $request[0];
		$__data = $request[0];
		array_shift($request);
		
		extract($request, EXTR_PREFIX_ALL, "wddx");
		if(empty($request))
			$$__data->index();
		else if(sizeof($request) == 1)
			$$__data->index($wddx_0);
		else 
		{
			http_response_code(404);
		}
	break;
	case 'DELETE':
		if(empty($request[1])) { http_response_code(404);exit; }
		$$request[0] = new $request[0];
		$$request[0]->delete($request[1]);
	break;
}


