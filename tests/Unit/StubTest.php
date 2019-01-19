<?php

namespace Traveler\Tests\Unit;

use Traveler\Register;
use Traveler\Stub;
use Traveler\Tests\Unit\Stubs\StubAttribute;
use Traveler\Tests\Unit\Stubs\StubInvoke;
use Traveler\Tests\Unit\Stubs\StubIssetUnset;
use Traveler\Tests\Unit\Stubs\StubMethod;

class StubTest extends UnitCase
{
    /**
     * @test
     */
    public function stub_get_methods()
    {
        $stub = new class extends Stub {
            public function hello() { return 'Erick'; }
            public function say($sms) { return "Hello, {$sms}"; }
        };
        $register = new Register([
            'Foo\\Bar\\StubMethod' => StubMethod::class
        ]);
        $register->set(StubMethod::class, $stub);
        $this->assertEquals('Erick', (new \Foo\Bar\StubMethod)->hello());
        $this->assertEquals('Hello, Erick', \Foo\Bar\StubMethod::say('Erick'));
    }

    /**
     * @test
     */
    public function stub_get_attributes()
    {
        $stub = new class extends Stub {
            public $name = 'Erick';
        };
        $register = new Register([
            'Foo\\Bar\\StubAttribute' => StubAttribute::class
        ]);
        $register->set(StubAttribute::class, $stub);
        $traveler = new \Foo\Bar\StubAttribute;
        $this->assertEquals('Erick', $traveler->name);
        $traveler->name = 'Traveler';
        $this->assertEquals('Traveler', $traveler->name);
    }

    /**
     * @test
     */
    public function isset_unset_stub()
    {
        $stub = new class extends Stub {
            public $name = 'Erick';
        };
        $register = new Register([
            'Foo\\Bar\\StubIssetUnset' => StubIssetUnset::class
        ]);
        $register->set(StubIssetUnset::class, $stub);
        $traveler = new \Foo\Bar\StubIssetUnset;
        $this->assertTrue(isset($traveler->name));
        unset($traveler->name);
        $this->assertFalse(property_exists($traveler, 'name'));
    }

    /**
     * @test
     */
    public function invoke_stub()
    {
        $stub = new class extends Stub {
            public function getInvokeMagic($name) { return "Hello, {$name}"; }
        };
        $register = new Register([
            'Foo\\Bar\\StubInvoke' => StubInvoke::class
        ]);
        $register->set(StubInvoke::class, $stub);
        $traveler = new \Foo\Bar\StubInvoke;
        $this->assertEquals('Hello, Erick', $traveler('Erick'));
    }
}
