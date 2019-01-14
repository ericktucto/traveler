<?php

namespace Traveler;

use Exception;
use ReflectionClass;

class Traveler
{
    protected $name;

    protected $stub = null;

    protected $global = false;

    public function __construct(string $name, object $stub = null, $global = false)
    {
        $this->name = $name;
        $this->stub = $stub;
        $this->global = false;
    }

    public function bind(object $stub)
    {
        if (!is_null($this->stub)) {
            throw new Exception("No se puede atar por que ya existe");
        }
        $this->stub = $stub;
    }

    public function clear()
    {
        $this->stub = null;
    }

    public function isGlobal()
    {
        return $this->global;
    }

    public function isEmpty()
    {
        return is_null($this->stub);
    }

    public function getStub()
    {
        return $this->stub;
    }
}