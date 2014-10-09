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
        // Open a captured state file instead of the actual device
        $js = new Joystick(__DIR__."/../static/initial.js0");
    }
    
    /**
     * @expectedException NoccyLabs\Joystick\JoystickException
     */
    public function testOpenError()
    {
        // There is hopefully no /dev/input/js255
        $js = new Joystick(255);
    }
    
    public function testUpdateState()
    {
        $js = new Joystick(__DIR__."/../static/initial.js0");
        $state = $js->update();
        
        $this->assertInstanceOf("\\NoccyLabs\\Joystick\\JoystickState", $state);
    }
}

