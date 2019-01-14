<?php

namespace Traveler;

use Exception;
use ReflectionClass;

class Register
{
    protected static $travelers = [];

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

    public static function globals(array $travelers)
    {
        foreach ($travelers as $travelerName => $stubName) {
            self::checkIfInheritStub($stubName);
            self::createTraveler($stubName, $travelerName, null, true);
        }
    }

    public function checkIfInheritStub(string $stubName)
    {
        $traveler = new ReflectionClass($stubName);
        if (!$traveler->isSubClassOf(Stub::class)) {
            throw new Exception("Your {$stubName} must be an instance of class Traveler\Stub.");
        }
    }

    public function createTraveler(string $stubName, string $travelerName, object $class = null, bool $global = false)
    {
        class_alias($stubName, $travelerName);
        self::$travelers[$stubName] = new Traveler($travelerName, $class, $global);
    }

    public function set(string $travelerName, object $class)
    {
        self::$travelers[$travelerName]->bind($class);
    }

    public function get(string $travelerName)
    {
        return self::$travelers[$travelerName];
    }

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