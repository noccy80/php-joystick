<?php

namespace NoccyLabs\Joystick;

class JoystickTest extends \PhpUnit_Framework_TestCase
{
    public function setup()
    {}
    
    public function teardown()
    {}
    
    public function testOpen()
    {
        $js = new Joystick(__DIR__."/../static/initial.js0");
    }
    
    /**
     * @expectedException \Exception
     */
    public function testOpenError()
    {
        $js = new Joystick(255);
    }
    
    public function testUpdateState()
    {
        $js = new Joystick(__DIR__."/../static/initial.js0");
        $state = $js->update();
        
        $this->assertInstanceOf("\\NoccyLabs\\Joystick\\JoystickState", $state);
    }
}

