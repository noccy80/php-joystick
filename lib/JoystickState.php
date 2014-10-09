<?php

namespace NoccyLabs\Joystick;

/**
 * Exposes the state of a Joystick object.
 *
 *
 */
class JoystickState
{
    protected $axis;
    
    protected $button;
    
    protected $mapping;

    /**
     * Constructor
     *
     *
     */
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

    /**
     * Get the state of a single button as an integer (1 pressed, 0 released)
     *
     * @param int The index of the button to query
     * @return int The state of the button
     */   
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
    
    /**
     * Get the value of a specific axis.
     *
     * @param int The index of the axis to query
     * @return int The axis value
     */
    public function getAxis($index)
    {
        return $this->axis[$index];
    }

    
    /**
     * Return a string representing the buttons currently pressed. The
     * separator can be customized, and the names are retrieved via the 
     * getButtonName method and thus uses the mapping provided to the base
     * Joystick instance.
     *
     * @param string The separator to use when combining the button names
     * @return string A string representation of the buttons
     */   
    public function getPressedButtons($separator="+")
    {
        $pressed = array();
        foreach($this->button as $index=>$state) {
            if ($state) { $pressed[] = $this->getButtonName($index); }
        }
        return join($separator,$pressed);
    }
    
    /**
     * Get button name as provided by mapping; return the index if the
     * button has not been mapped.
     *
     * @param int The button index to get the name for
     * @return string|int The button name
     */
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

