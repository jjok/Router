<?php

namespace jjok\Todo\Router2;

final class Router
{
    /**
     * @var RouteMap
     */
    private $routes;

    /**
     * @var string
     */
    private $base;

    /**
     * @param RouteMap $routes
     * @param string $base
     */
    public function __construct(RouteMap $routes, string $base = '')
    {
        $this->routes = $routes;
        $this->base = $base;
    }

    /**
     * Match a path to a defined route.
     * @param string $path
     * @return MatchedRoute|null
     */
    public function match(string $path)
    {
        if($this->routes->has($path)) {
            return $this->routes->get($path)->choose();
        }

        /**
         * @var $route_path string
         * @var $route Route
         */
        foreach($this->routes as $route_path => $route) {
            if(preg_match(sprintf('#^%s%s$#', $this->base, $route_path), $path, $matches)) {
                $params = array_slice($matches, 1);

                return $route->choose($params);
            }
        }

        return null;
    }
}
