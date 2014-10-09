<?php

namespace NoccyLabs\Joystick;

class JoystickState
{
    public function __construct(array $axis, array $buttons)
    {
        $this->axis = $axis;
        $this->buttons = $buttons;
    }
    
    public function getAllButtons()
    {
        return $this->buttons;
    }
    
    public function getAllAxis()
    {
        return $this->axis;
    }
}

