<?php

namespace NoccyLabs\Joystick;

class JoystickState
{
    protected $axis;
    
    protected $button;
    
    protected $mapping;

    public function __construct(array $axis, array $buttons, array $mapping = null)
    {
        $this->axis = $axis;
        $this->button = $buttons;
        $this->mapping = $mapping;
    }
    
    /**
     * Get all button states as an array.
     *
     * @return array The values of all the button states
     */
    public function getAllButtons()
    {
        return $this->button;
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
    
    public function getPressedButtons()
    {
        $pressed = array();
        foreach($this->button as $index=>$state) {
            if ($state) { $pressed[] = $this->getButtonName($index); }
        }
        return join("+",$pressed);
    }
    
    public function getButtonName($index)
    {
        if (array_key_exists("button", $this->mapping)) {
            $buttonmap = $this->mapping['button'];
            if (array_key_exists($index, $buttonmap)) {
                return $buttonmap[$index];
            }
        }
        return $index;
    }
}

