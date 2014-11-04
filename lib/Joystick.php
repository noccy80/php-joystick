<?php

namespace NoccyLabs\Joystick;

define("SIZEOF_JS_EVENT", 8);
define("STRUCT_JS_EVENT", "Ltime/svalue/Ctype/Cnumber");
define("JS_EVENT_PATH",   "/dev/input");
define("JS_EVENT_BUTTON",         0x01);    /* button pressed/released */
define("JS_EVENT_AXIS",           0x02);    /* joystick moved */
define("JS_EVENT_INIT",           0x80);    /* initial state of device */

/**
 * Class to access joystick events and states via /dev/input.
 *
 *
 */
class Joystick
{
    protected $fh = null;

    protected $num_axis = null;

    protected $state_axis = array();
    
    protected $num_button = null;
    
    protected $state_button = array();

    protected $mapping = array();

    protected $state = null;

    protected $dev_path = JS_EVENT_PATH;

    const FIRST = -1;
    const SECOND = -2;

    /**
     * Constructor. The parameter can either be an integer (referenced as N to
     * /dev/input/jsN) or as a string, directly pointing at the input device
     * filename. 
     *
     * Will indirectly throw a JoystickException on error, as open() is called
     * by the constructor.
     *
     * @param int|string The joystick index or device filename
     */
    public function __construct($index=self::FIRST)
    {
        if (is_int($index)) {
            if ($index > 0) {
                $jsindex = $index;
                $this->open("{$this->dev_path}/js{$jsindex}");
            } else {
                $jsdev = $this->findJoystickByIndex(abs($index));
                $this->open($jsdev);
            }
        } else {
            $this->open($index);
        }
    }
    
    protected function findJoystickByIndex($index)
    {
        $jsdev = glob("{$this->dev_path}/js*");
        $found = 0;
        foreach($jsdev as $dev) {
            $th = @fopen($dev, "rb");
            if ($th) {
                fclose($th);
                if (++$found >= $index) {
                    return $dev;
                }
            }
        }
        throw new JoystickException("Unable to open connected joystick by index ({$index})");
    }
    
    /**
     * Assign a map to the numerical indexes for buttons and axes. The array
     * can have zero to two keys, namely "button" and "axis", both having an
     * ordered array of the mapped names.
     *
     * For example, the map [ "button" => [ "A", "B", "C", "D"]] would make
     * button 0 be named A, 1 be B etc.
     *
     * @param array Controller map
     */
    public function setControllerMap(array $map = null)
    {
        $this->mapping = $map;
    }

    /**
     * Open the device.
     *
     * @internal
     */    
    protected function open($jsfile)
    {
        if (!(file_exists($jsfile) && is_readable($jsfile))) {
            throw new JoystickException("Unable to open {$jsfile}");
        }
        
        $this->fh = fopen($jsfile, "rb");
        if (!$this->fh) {
            throw new JoystickException("fopen({$jsfile}, rb) failed");
        }
    }
    
    /**
     * Close the device
     *
     * @internal
     */
    protected function close()
    {
        if ($this->fh) {
            fclose($this->fh);
        }
        $this->fh = null;
    }
    
    /**
     * Read a raw event from the opened /dev/input/jsX file. The size and 
     * unpack pattern for the struct is defined as SIZEOF_JS_EVENT and
     * STRUCT_JS_EVENT.
     *
     * Uses stream_select to avoid setting the stream to non-blocking mode.
     *
     * @return array 
     */
    public function getRawEvent()
    {
        $read = array($this->fh); $write = array(); $except = array();
        if (stream_select($read, $write, $except, 0)) {
            $evt_raw = fread($this->fh, SIZEOF_JS_EVENT);
            if (!$evt_raw) {
                return null;
            }
            $evt_arr = unpack(STRUCT_JS_EVENT, $evt_raw);
            $this->parseRawEvent($evt_arr);
            return $evt_arr;
        }
        return null;
    }

    /**
     * Update the internal state by reading and mapping all available events
     * until getRawEvent returns null. getRawEvent does the parsing by calling
     * on parseRawEvent.
     *
     * @return NoccyLabs\Joystick\JoystickState
     */
    public function update()
    {
        // Process as long as there are new events to chomp
        while ($this->getRawEvent());
        $this->state = new JoystickState($this->state_axis, $this->state_button, $this->mapping);
        return $this->state;
    }
    
    /**
     * Apply a joystick event to the local state.
     *
     * @internal
     * @param array The joystick event data
     */
    protected function parseRawEvent(array $event)
    {
        if ($event['type'] & JS_EVENT_INIT) {
            // this is an init message, configure ourselves!
            if ($event['type'] & JS_EVENT_AXIS) {
                if ($event['number'] > $this->num_button) {
                    $this->num_axis = $event['number'];
                }
            
            } elseif ($event['type'] & JS_EVENT_BUTTON) {
                if ($event['number'] > $this->num_button) {
                    $this->num_button = $event['number'];
                }
            }
        }
        // parse raw event, translate to state
        if ($event['type'] & JS_EVENT_AXIS) {
            $this->state_axis[$event['number']] = $event['value'];
        } elseif ($event['type'] & JS_EVENT_BUTTON) {
            $this->state_button[$event['number']] = $event['value'];
        }
    }
}

