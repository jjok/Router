<?php

namespace jjok\Router;

class Route
{
    private $callable;
    private $param_names;

    public function __construct(/*callable*/ $callable, array $param_names = array())
    {
        $this->callable = $callable;
        $this->param_names = $param_names;
    }

    public function getCallable()
    {
        return $this->callable;
    }

    public function choose(array $param_values = array())
    {
        $params = array_combine($this->param_names, $param_values);

        if($params === false) {
            throw new \InvalidArgumentException('Param values not the expected number.');
        }

        return new MatchedRoute($this->callable, $params);
    }
}
