<?php

require_once 'src/jjok/Router/Route.php';

use jjok\Router\Route;

class RouteTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \jjok\Router\Route::__construct
	 */
	public function testAttributesHaveDefaultValues() {
		$route = new Route();

		$this->assertNull($route->getController());
		$this->assertNull($route->getAction());
		$this->assertCount(0, $route->getParams());
	}
	
	/**
	 * @covers \jjok\Router\Route::__construct
	 */
	public function testConstructSetsAttributes() {
		$route = new Route('MyController');
		$this->assertSame('MyController', $route->getController());
		$this->assertNull($route->getAction());
		$this->assertCount(0, $route->getParams());
		
		$route = new Route('MyController2', 'MyAction2');
		$this->assertSame('MyController2', $route->getController());
		$this->assertSame('MyAction2', $route->getAction());
		$this->assertCount(0, $route->getParams());
		
		$route = new Route('MyController3', 'MyAction3', array('param 1', 'param 2'));
		$this->assertSame('MyController3', $route->getController());
		$this->assertSame('MyAction3', $route->getAction());
		$this->assertContains('param 1', $route->getParams());
		$this->assertContains('param 2', $route->getParams());
	}
	
	/**
	 * @covers \jjok\Router\Route::getController
	 * @covers \jjok\Router\Route::setController
	 */
	public function testControllerCanBeSet() {
		$route = new Route();
		$this->assertNull($route->getController());
		
		$route->setController('MyController');
		$this->assertSame('MyController', $route->getController());
	}
	
	/**
	 * @covers \jjok\Router\Route::getAction
	 * @covers \jjok\Router\Route::setAction
	 */
	public function testActionCanBeSet() {
		$route = new Route();
		$this->assertNull($route->getAction());
	
		$route->setAction('MyAction');
		$this->assertSame('MyAction', $route->getAction());
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetParamsOnlyAcceptsArray() {
		$route = new Route();
		$route->setParams('A param');
	}
	
	/**
	 * @covers \jjok\Router\Route::getParams
	 * @covers \jjok\Router\Route::setParams
	 */
	public function testParamsCanBeSet() {
		$route = new Route();
		$this->assertCount(0, $route->getParams());

		$route->setParams(array('param 1', 'param 2'));
		$this->assertCount(2, $route->getParams());
		
		$route->setParams(array('param 1'));
		$this->assertCount(1, $route->getParams());
	}
}
