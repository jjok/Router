Router
======

[![Build Status](https://travis-ci.org/jjok/Router.png?branch=master)](https://travis-ci.org/jjok/Router)

	# Create a router instance and add some routes.
	$router = new jjok\Router\Router(array(
		'(.*)' => new jjok\Router\Route('Controller'),
		'blah' => new jjok\Router\Route('MyController', 'MyAction', array('MyParam')),
		'blah/([a-zA-Z-]+)/([0-9]+)' => new jjok\Router\Route('MyController'),
		'blah/(.+)' => new jjok\Router\Route('MyController')
	));
	
	# Try to get a matched route from the current URL.
	$route = $router->match('my-controller/my-action/my-param1/my-param2')
	
	# Create instance of controller
	$controller = new $route->getController();
	
	# Call action of controller
	call_user_func_array(array(
		$controller,
		$route->getAction()
	), $route->getParams());
	
TODO
----

* Add support for different HTTP methods?
* Add examples.

Copyright (c) 2015 Jonathan Jefferies
