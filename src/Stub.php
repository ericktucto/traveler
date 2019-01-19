<?php

namespace Traveler;

class Stub
{
    public function __call($method, $args)
    {
        return Register::getStub(get_called_class())->$method(...$args);
    }

    public static function __callStatic($method, $args)
    {
        return Register::getStub(get_called_class())->$method(...$args);
    }

    public function __set($attribute, $value)
    {
        Register::getStub(get_called_class())->$attribute = $value;
    }

    public function __get($attribute)
    {
        return Register::getStub(get_called_class())->$attribute;
    }

    public function __unset($attribute)
    {
        unset(Register::getStub(get_called_class())->$attribute);
    }

    public function __isset($attribute)
    {
        return isset(Register::getStub(get_called_class())->$attribute);
    }

    public function __invoke(...$args)
    {
        return Register::getStub(get_called_class())->getInvokeMagic(...$args);
    }
}