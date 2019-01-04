<?php

namespace Ghost\Tests\Unit;

use Ghost\Ghost;
use Ghost\Tests\Unit\UnitCase;

class GhostTest extends UnitCase
{
    /**
     * @test
     */
    public function ghost_asocia_llaves_de_array_a_class()
    {
        $ghost = new Ghost;
        $classname = 'App\\Handlers\\Events';
        $class = new class {};
        $this->assertFalse(class_exists('App\\Handlers\\Events'));
        $ghost->register([
            $classname => $class
        ]);
        $this->assertEquals($class, $ghost->get($classname));
    }

    /**
     * @test
     */
    public function ghost_start_es_para_asociar_todas_las_clases_con_el_composer_loader()
    {
        $ghost = new Ghost;
        $classname = 'App\\Handlers\\Events';
        $class = new class {};
        $this->assertFalse(class_exists('App\\Handlers\\Events'));
        $ghost->register([
            $classname => $class,
            'App\\Helpers\\Mailer' => new class {}
        ]);
        $ghost->start();
        $this->assertTrue(class_exists('App\\Handlers\\Events'));
    }


    /**
     * test
     */
    public function instanciar_una_clase_despues_de_crear_ghost()
    {
        $ghost = new Ghost;
        $classname = 'App\\Handlers\\Events';
        $ghost->createClass($classname);
        $ghost->start();
        $events = new \App\Handlers\Events;
        $this->assertTrue(true);
    }
}