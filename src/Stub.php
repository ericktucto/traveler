<?php

namespace Traveler;

class Stub
{
    public function __call($method, $args)
    {
        return Register::getStub(get_called_class())->$method(...$args);
    }
}