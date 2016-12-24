<?php

namespace jjok\Router;

use Iterator;

final class RouteMap implements Iterator
{
    private $routes = array();

    /**
     * Add a path to the collection.
     * @param string $path
     * @param Route $route
     */
    public function push(string $path, Route $route)
    {
        $this->routes[$path] = $route;
    }

    public function current()
    {
        return current($this->routes);
    }

    /**
     * @return string
     */
    public function key()
    {
        return key($this->routes);
    }
    
    public function next()
    {
        next($this->routes);
    }

    public function rewind()
    {
        reset($this->routes);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->routes[$this->key()]);
    }

    /**
     * @param $offset
     * @return bool
     */
    public function has($offset)
    {
        return isset($this->routes[$offset]);
    }

    /**
     * @param $offset
     * @return Route
     */
    public function get($offset)
    {
        return $this->routes[$offset];
    }
}
