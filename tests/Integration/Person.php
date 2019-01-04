<?php
namespace Ghost\Tests\Integration;

use Handlers\Events;

class Person
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function knowTo($person)
    {
        return Events::check("know_to", [ $person, $this ]);
    }

    public function greetsTo(Person $person)
    {
        if ($this->knowTo($person)) {
            return "Hola, {$person->name}";
        }
        /*Events::make("first_meet", [
            $person, $this
        ]);*/

        return "Hola, {$person->name}, mi nombre es {$this->name}";
    }
}
