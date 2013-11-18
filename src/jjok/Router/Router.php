<?php

namespace jjok\Router;

use jjok\String\String;

/**
 * Works out which controller and action to call from a given query.
 * @package jjok\Router
 * @author Jonathan Jefferies
 * @version 0.2.0
 */
class Router {

	/**
	 * A list of any custom routes.
	 * @todo Make this a `RouteCollection`?
	 * @var Route[]
	 */
	protected $routes = array();
	
	/**
	 * The format of the controller file.
	 * @todo Make this an array?
	 * @var string
	 */
	protected $controller_path;

// 	protected $default_action = 'index';
	
	/**
	 * 
	 * @param array $routes
	 * @param string $controller_path
	 */
	public function __construct(array $routes, $controller_path) {
		$this->routes = $routes;
		$this->controller_path = $controller_path;
	}

	/**
	 * If URL is not in $routes, work out route
	 * @param string $query The query string.
	 * @return Route
	 */
	public function getRoute($query) {
		
		$route = $this->matchRoute($query);
		if($route != null) {
			return $route;
		}
	
		return $this->automatic($query);
	}
	
	/**
	 * 
	 * @param unknown $query
	 * @return Route
	 */
	public function matchRoute($query) {
		#530600
		// 		#Exact match
		// 		if(array_key_exists($query, $this->routes)) {
		// 			echo 'Exact match';
		// 			return $this->routes[$query];
		// 		}
		
		foreach($this->routes as $path => $route) {
			if(preg_match(sprintf('#^%s$#', $path), $query, $matches)) {
// 				echo 'Preg match', PHP_EOL, $path, PHP_EOL;
// 				print_r($matches);
				$route = clone $route;
				
				if(count($matches) > 1) {
					# Remove the full match
					array_shift($matches);
					
					# Split up any grouped matches
					$new_matches = array();
					foreach($matches as $match) {
						foreach(explode('/', $match) as $param) {
							$new_matches[] = $param;
						}
					}
					$matches = $new_matches;
					
					# Set controller, if null
					if($route->getController() == null) {
						$route->setController(String::capitalise(array_shift($matches)));
					}
					
					# Set action, if null
					if($route->getAction() == null) {
						# No more matches are available
						if(count($matches) == 0) {
							continue;
						}
						
						$route->setAction(String::camelise(array_shift($matches)));
					}
					
					# Merge any additional params
					$route->setParams(
						array_merge($route->getParams(), $matches)
					);
				}
				
				return $route;
			}
		}
		
		return null;
	}
	
	/**
	 * Build a route from the given query.
	 * @param string $query
	 * @return Route
	 */
	public function automatic($query) {
		
		$url_array = explode('/', $query);
		
		$controller = sprintf($this->controller_path, String::capitalise(array_shift($url_array)));
		
		if(class_exists($controller)) {
			
// 			$action = String::camelise(array_shift($url_array));

			$possible_action = array_shift($url_array);
			$action = String::camelise($possible_action);
			
			#No action, so go to index
			if(empty($possible_action)) {
				$action = 'index';
			}
			#Second passed item is param, not action
			elseif(!is_callable(array($controller, $action))) {
				array_unshift($url_array, $possible_action);
				$action = 'index';
			}
			
			# Check index method exists
			if($action == 'index' && !is_callable(array($controller, $action))) {
			
				return null;
			}
			
			$params = $url_array;
			
			//FIXME Add RouteFactory
			return new Route($controller, $action, $params);
		}
		
		return null;
	}
}
