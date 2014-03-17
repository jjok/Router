<?php

require_once '../vendor/autoload.php';

require_once 'dummies/TestController.php';

$router = new jjok\Router\Router(
	array(
		'(.*)' => new jjok\Router\Route(),
// 		'blah' => new jjok\Router\Route('MyController', 'MyAction', array('MyParam')),
// 		'blah/([a-zA-Z-]+)/([0-9]+)' => new jjok\Router\Route('MyController'),
// 		'blah/(.+)' => new jjok\Router\Route('MyController')
	), 'dummies\%s'
);

print_r($router->matchRoute('my-controller/my-action/my-param1/my-param2'));
// print_r($router->getRoute('blah'));
// print_r($router->getRoute('blah/MyAction/100'));
// print_r($router->getRoute('blah/something-else/100'));
// print_r($router->getRoute('blah/something-else/100'));
// print_r($router->getRoute('blah/something-else/100'));
// print_r($router->getRoute('TestController'));
// print_r($router->getRoute('test-controller/qwerty'));
// print_r($router->getRoute('test-controller/index'));
// print_r($router->getRoute('test-controller/index/qwett'));
// print_r($router->getRoute('test-controller/index/qwett/blaaah'));
