<?php

require_once 'vendor/autoload.php';
require_once 'src/jjok/Router/Route.php';
require_once 'src/jjok/Router/Router.php';
require_once 'tests/dummies/MyController1.php';
require_once 'tests/dummies/MyController2.php';
#require_once 'tests/dummies/MyController3.php';

use jjok\Router\Route;
use jjok\Router\Router;

class RouterTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * `null` is returned when no match is found.
	 */
	public function testNullReturnedForUnknownRoute() {
		$router = new Router(array(), '');
		$this->assertNull($router->matchRoute('unknown'));
	}
	
	/**
	 * If the match is not a regex, the Route is returned without modification.
	 */
	public function testExactMatchReturnsRouteAsIs() {
		$empty_route = new Route();
		$route_with_no_action = new Route('MyController', null, array('MyParam'));
		$full_route = new Route('MyController', 'MyAction', array('MyParam'));
		
		$router = new Router(array(
			'test' => $empty_route,
			'test/test' => $route_with_no_action,
			'test/test/11' => $full_route
		), '');
		
		$this->assertEquals($empty_route, $router->matchRoute('test'));
		$this->assertEquals($route_with_no_action, $router->matchRoute('test/test'));
		$this->assertEquals($full_route, $router->matchRoute('test/test/11'));
	}
	
	/**
	 * 
	 */
	public function testControllerIsPopulatedIfNull() {
		$router = new Router(array(
			'something/([a-z-]+)' => new Route(null, 'myAction', array('my-param1')),
			'(.*)' => new Route(null, 'myAction', array('my-param1'))
		), '');
		
		$route = $router->matchRoute('something/my-controller');
		$this->assertSame('MyController', $route->getController());
		$this->assertSame('myAction', $route->getAction());
		$this->assertCount(1, $route->getParams());
		
		$route = $router->matchRoute('my-controller');
		$this->assertSame('MyController', $route->getController());
		$this->assertSame('myAction', $route->getAction());
		$this->assertCount(1, $route->getParams());
	}
	
	/**
	 * 
	 */
	public function testActionIsPopulatedIfNull() {
		$router = new Router(array(
			'something/([a-z-]+)' => new Route('MyController', null, array('my-param1')),
			'(.*)' => new Route('MyController', null, array('my-param1'))
		), '');
		
		$route = $router->matchRoute('something/my-action');
		$this->assertSame('MyController', $route->getController());
		$this->assertSame('myAction', $route->getAction());
		$this->assertCount(1, $route->getParams());
		
		$route = $router->matchRoute('my-action');
		$this->assertSame('MyController', $route->getController());
		$this->assertSame('myAction', $route->getAction());
		$this->assertCount(1, $route->getParams());
	}
	
	/**
	 * 
	 */
	public function testAdditionalWildcardMatchesAreAddedAsParams() {
		$router = new Router(array(
			'(.*)' => new Route('MyController', 'myAction')
		), '');
	
		$route = $router->matchRoute('my-param1/my-param2/my-param3');
		$this->assertSame('MyController', $route->getController());
		$this->assertSame('myAction', $route->getAction());
		$this->assertCount(3, $route->getParams());
		$this->assertContains('my-param1', $route->getParams());
		$this->assertContains('my-param2', $route->getParams());
		$this->assertContains('my-param3', $route->getParams());
	}
	
	/**
	 * 
	 */
	public function testNullReturnedIfNotEnoughMatchedParams() {
		$router = new Router(array(
			'(.*)' => new Route()
		), '');
		
		$this->assertNull($router->matchRoute('myController'));
	}
	
	/**
	 * 
	 */
	public function testNullReturnedIfClassDoesNotExist() {		
		$router = new Router(array(), '%s');
		$this->assertNull($router->automatic('some-controller'));
	}

	/**
	 * 
	 */
	public function testDefaultActionUsedIfNoneGiven() {
		$router = new Router(array(), '%s');
		$route = $router->automatic('my-controller1');
		$this->assertSame('MyController1', $route->getController());
		$this->assertSame('index', $route->getAction());
	}
	
	/**
	 * 
	 */
	public function testNullReturnedIfDefaultActionDoesNotExist() {
		$router = new Router(array(), '%s');
		$this->assertNull($router->automatic('my-controller2'));
	}
	
	/**
	 *
	 */
	public function testActionCanBeSpecified() {
		$router = new Router(array(), '%s');
		$route = $router->automatic('my-controller2/my-action');
		$this->assertSame('MyController2', $route->getController());
		$this->assertSame('myAction', $route->getAction());
	}
	
	/**
	 * 
	 */
	public function testParamsCanBeSpecified() {
		$router = new Router(array(), '%s');
		$route = $router->automatic('my-controller1/my-param1');
		$this->assertSame('MyController1', $route->getController());
		$this->assertSame('index', $route->getAction());
		$this->assertContains('my-param1', $route->getParams());
	}
}
