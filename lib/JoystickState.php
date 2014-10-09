<?php

namespace NoccyLabs\Joystick;

class JoystickState
{
    public function __construct(array $axis, array $buttons)
    {
        $this->axis = $axis;
        $this->buttons = $buttons;
    }
    
    /**
     * Get all button states as an array.
     *
     * @return array The values of all the button states
     */
    public function getAllButtons()
    {
        return $this->buttons;
    }
    
    public function getButton($index)
    {
        return $this->button[$index];
    }
    
    /**
     * Get all axes (indeed the plural of axis!) as an array.
     *
     * @return array The values of all the known axes
     */
    public function getAllAxes()
    {
        return $this->axis;
    }
    
    public function getAxis($index)
    {
        return $this->axis[$index];
    }
}

