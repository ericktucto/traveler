<?php
namespace Ghost\Tests\Integration;

use Ghost\Ghost;

class PersonTest extends IntegrationCase
{
    /**
     * @test
     */
    public function first_greet_person_take_name()
    {
        $ghost = new Ghost;
        $content = '
            public function check() {}
        ';

        $ghost->register([
            'Handlers\\Events' => $content
        ]);

        $ghost->start();

        $erick = new Person("Erick");
        $jorge = new Person("Jorge");
        $this->assertEquals(
            $erick->greetsTo($jorge),
            "Hola, Jorge, mi nombre es Erick"
        );
    }

    /**
     * test
     */
    public function a_person_remember_if_know_other_person()
    {
        $erick = new Person("Erick");
        $jorge = new Person("Jorge");

        $this->assertFalse($erick->knowTo($jorge));
        $this->assertFalse($jorge->knowTo($erick));

        $erick->greetsTo($jorge);

        $this->assertTrue($erick->knowTo($jorge));
        $this->assertTrue($jorge->knowTo($erick));
    }

    /**
     * test
     */
    public function a_person_greets_other_person()
    {
        $erick = new Person("Erick");
        $jorge = new Person("Jorge");
        $erick->greetsTo($jorge);
        $this->assertEquals(
            $erick->greetsTo($jorge),
            "Hola, Jorge"
        );
    }
}

