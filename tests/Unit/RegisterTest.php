<?php

namespace Traveler\Tests\Unit;

use Traveler\Register;
use Traveler\Tests\Unit\Stubs\GlobalStub;
use Traveler\Tests\Unit\Stubs\ExistsStub;
use Traveler\Tests\Unit\Stubs\LocalStub;

class RegisterTest extends UnitCase
{
    public static function setUpBeforeClass()
    {
        Register::globals([
            'Foo\\Bar\\ClassGlobal' => GlobalStub::class
        ]);
        Register::set(GlobalStub::class, new class {
            public function getName() { return 'Erick'; }
        });
    }

    /**
     * @test
     */
    public function exists_travelers_globals()
    {
        $this->assertEquals(
            'Erick',
            Register::getStub(GlobalStub::class)->getName()
        );
        $this->assertEquals(
            'Erick',
            (new \Foo\Bar\ClassGlobal)->getName()
        );
    }

    /**
     * @test
     */
    public function when_exists_a_class_alias_created()
    {
        $this->expectExceptionMessage(
            "Traveler\Tests\Unit\Stubs\ExistsStub is already registed."
        );
        Register::globals([
            'Foo\\Bar\\Exists' => ExistsStub::class
        ]);
        new Register(['Foo\\Bar\\OtherExists' => ExistsStub::class]);
    }

    /**
     * @test
     */
    public function create_traveler_local()
    {
        $traveler = new Register([
            'Foo\\Bar\\Local' => LocalStub::class
        ]);
        $traveler->set(LocalStub::class, new class {
            public function getLastName() { return 'Tucto'; }
        });
        $this->assertEquals(
            'Tucto',
            $traveler->getStub(LocalStub::class)->getLastName()
        );
    }

    /**
     * @test
     * @depends create_traveler_local
     */
    public function a_instance_traveler_havent_local_other_test()
    {
        $this->expectExceptionMessage(
            "Traveler\Tests\Unit\Stubs\LocalStub havent a class anonymous."
        );
        Register::getStub(LocalStub::class)->getLastName();
    }
}
