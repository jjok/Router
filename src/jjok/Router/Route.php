<?php

namespace jjok\Router;

/**
 * A route.
 * @author Jonathan Jefferies
 * @version 0.2.0
 */
class Route {
	
	/**
	 * The fully-qualified class name of the controller.
	 * @var string
	 */
	protected $controller;
	
	/**
	 * The name of the action to be called.
	 * @var string
	 */
	protected $action;
	
	/**
	 * Parameters to pass to the action.
	 * @var array
	 */
	protected $params;
	
	/**
	 * Set the controller, action and params.
	 * @param string $controller
	 * @param string $action
	 * @param array $params
	 */
	public function __construct($controller = null, $action = null, array $params = array()) {
		$this->controller = $controller;
		$this->action = $action;
		$this->params = $params;
	}
	
	/**
	 * Get the name of the controller.
	 * @return string
	 */
	public function getController() {
		return $this->controller;
	}
	
	/**
	 * Set the controller class.
	 * @param string $controller
	 */
	public function setController($controller) {
		$this->controller = $controller;
	}
	
	/**
	 * Get the name of the action.
	 * @return string
	 */
	public function getAction() {
		return $this->action;
	}
	
	/**
	 * Set the action.
	 * @param string $action
	 */
	public function setAction($action) {
		$this->action = $action;
	}
	
	/**
	 * Get params to pass to the action.
	 * @return string[]
	 */
	public function getParams() {
		return $this->params;
	}
	
	/**
	 * Set params to be passed to the action.
	 * @param array $params
	 */
	public function setParams(array $params) {
		$this->params = $params;
	}
	
// 	public function pushParam($param) {
// 		$this->params[] = $param;
// 	}
}
