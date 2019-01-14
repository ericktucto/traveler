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
            $traveler = new ReflectionClass($stubName);
            if (!$traveler->isSubClassOf(Stub::class)) {
                throw new Exception("Your {$stubName} must be an instance of class Traveler\Stub.");
            }
            if (array_key_exists($stubName, self::$travelers)) {
                throw new Exception("{$stubName} is already registed.");
            }
            class_alias($stubName, $travelerName);
            self::$travelers[$stubName] = new Traveler($travelerName);
        }
    }

    public function __destruct()
    {
        foreach (self::$travelers as &$traveler) {
            if (!$traveler->isGlobal()) {
                $traveler->clear();
            }
        }
    }

    public static function globals(array $travelers)
    {
        foreach ($travelers as $travelerName => $stubName) {
            $traveler = new ReflectionClass($stubName);
            if (!$traveler->isSubClassOf(Stub::class)) {
                throw new Exception("Your {$stubName} must be an instance of class Traveler\Stub.");
            }
            class_alias($stubName, $travelerName);
            self::$travelers[$stubName] = new Traveler($travelerName, null, true);
        }
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
}