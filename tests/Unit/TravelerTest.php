<?php

namespace Traveler\Tests\Unit;

use Traveler\Tests\Unit\UnitCase;
use Traveler\Traveler;

class TravelerTest extends UnitCase
{
    /**
     * @test
     */
    public function can_bin_class_anonymous_to_traveler()
    {
        $traveler = new Traveler('Foo\\Bar');
        $traveler->bind(new class { public function hello() { return 'Erick'; } });
        $this->assertEquals('Erick', $traveler->getStub()->hello());
    }

    /**
     * @test
     */
    public function check_if_traveler_is_global()
    {
        $traveler = new Traveler('Foo\\Bar', null, true);
        $this->assertTrue($traveler->isGlobal());
    }

    /**
     * @test
     */
    public function check_if_traveler_have_a_stub_bind()
    {
        $traveler = new Traveler('Foo\\Bar');
        $this->assertTrue($traveler->isEmpty());
        $traveler->bind(new class {});
        $this->assertFalse($traveler->isEmpty());
    }

    /**
     * @test
     */
    public function clear_stub_of_traveler()
    {
        $class = new class {};
        $traveler = new Traveler('Foo\\Bar', $class);
        $this->assertFalse($traveler->isEmpty());
        $this->assertEquals($class, $traveler->getStub());
        $traveler->clear();
        $this->assertNull($traveler->getStub());
    }
}
