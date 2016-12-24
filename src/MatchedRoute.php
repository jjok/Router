<?php

namespace jjok\Router;

class MatchedRoute extends Route
{
    private $params;

    public function __construct(/*callable*/ $callable, array $params = array())
    {
        $this->params = $params;

        parent::__construct($callable);
    }

    public function getParams()
    {
        return $this->params;
    }
}
