<?php

namespace core;

use Exception;
use JetBrains\PhpStorm\Pure;
use ReflectionException;
use ReflectionMethod;

abstract class Controller
{
    /**
     * @throws ReflectionException
     */
    public function run($action_name, $args = [])
    {
        $method = new ReflectionMethod(static::class, $action_name."Action");
        $check = true;
        $sorted_args = [];
        foreach ($method->getParameters() as $parameter) {
            if (array_key_exists($parameter->getName(), $args)){
                $sorted_args[]=$args[$parameter->getName()];
                //$method->getDocComment();
            } else {
                if (!$parameter->isDefaultValueAvailable()) {
                    throw new Exception("Параметр " . $parameter->getName() . " не имеет знаение по умолчанию, поэтому надо его передавать");
                    $check = false;
                }
                else {
                    $sorted_args[] = $parameter->getDefaultValue();
                }
            }
        }
        if ($check) return call_user_func_array([$this, $action_name.'Action'], $sorted_args);
        else return null;
    }

    #[Pure] public static function create()
    {
        return new static();
    }

}