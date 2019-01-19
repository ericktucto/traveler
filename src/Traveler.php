<?php

namespace Traveler;

use Exception;

class Traveler
{
    /**
     *
     * @var string
     */
    protected $name;


    /**
     *
     * @var \Traveler\Stub
     */
    protected $stub = null;

    /**
     *
     * @var bool
     */
    protected $global = false;

    public function __construct(string $name, object $stub = null, $global = false)
    {
        $this->name = $name;
        $this->stub = $stub;
        $this->global = $global;
    }

    /**
     * Bind a class anonymous on traveler
     * 
     * @param object $stub
     * @throws Exception
     */
    public function bind(object $stub)
    {
        if (!is_null($this->stub)) {
            throw new Exception("Already exists stub on traveler");
        }
        $this->stub = $stub;
    }

    /**
     * Clear this stub
     */
    public function clear()
    {
        $this->stub = null;
    }

    /**
     * Check if traveler is global
     * 
     * @return bool
     */
    public function isGlobal()
    {
        return $this->global;
    }

    /**
     * Check if exist a stub on traveler
     * 
     * @return bool
     */
    public function isEmpty()
    {
        return is_null($this->stub);
    }

    /**
     * Return the stub
     * 
     * @return \Traveler\Stub|null
     */
    public function getStub()
    {
        return $this->stub;
    }
}