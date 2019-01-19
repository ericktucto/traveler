<?php

namespace Traveler;

use Exception;
use ReflectionClass;

class Register
{
    /**
     * Array to Travelers
     *
     * @var array
     */
    protected static $travelers = [];

    /**
     * Register to travelers
     * 
     * @param array $travelers
     * @throws Exception
     */
    public function __construct(array $travelers)
    {
        foreach ($travelers as $travelerName => $stubName) {
            $this->checkIfInheritStub($stubName);
            if (array_key_exists($stubName, self::$travelers)) {
                throw new Exception("{$stubName} is already registed.");
            }
            $this->createTraveler($stubName, $travelerName);
        }
    }

    /**
     * Register global travelers
     * 
     * @param array $travelers
     */
    public static function globals(array $travelers)
    {
        foreach ($travelers as $travelerName => $stubName) {
            self::checkIfInheritStub($stubName);
            self::createTraveler($stubName, $travelerName, null, true);
        }
    }

    /**
     * Check if stub use \Traveler\Stub
     * 
     * @param string $stubName
     * @throws Exception
     */
    protected function checkIfInheritStub(string $stubName)
    {
        $traveler = new ReflectionClass($stubName);
        if (!$traveler->isSubClassOf(Stub::class)) {
            throw new Exception("Your {$stubName} must be an instance of class Traveler\Stub.");
        }
    }

    /**
     * Create and register new traveler
     * 
     * @param string $stubName
     * @param string $travelerName
     * @param object|null $class
     * @param bool $global
     */
    public function createTraveler(string $stubName, string $travelerName, object $class = null, bool $global = false)
    {
        class_alias($stubName, $travelerName);
        self::$travelers[$stubName] = new Traveler($travelerName, $class, $global);
    }

    /**
     * Set class anonymous to registered traveler
     * 
     * @param string $travelerName
     * @param object $class
     */
    public function set(string $travelerName, object $class)
    {
        self::$travelers[$travelerName]->bind($class);
    }

    /**
     * Get traveler
     * 
     * @param string $travelerName
     * @return \Traveler\Traveler
     */
    public function get(string $travelerName)
    {
        return self::$travelers[$travelerName];
    }

    /**
     * Get Stub of Traveler
     * 
     * @param string $travelerName
     * @return \Traveler\Stub
     * @throws Exception
     */
    public function getStub(string $travelerName)
    {
        $class = self::get($travelerName);
        if ($class->isEmpty()) {
            throw new Exception("{$travelerName} havent a class anonymous.");
        }
        return $class->getStub();
    }

    public function __destruct()
    {
        foreach (self::$travelers as &$traveler) {
            if (!$traveler->isGlobal()) {
                $traveler->clear();
            }
        }
    }
}