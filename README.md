noccylabs/joystick: Joystick access via /dev/input
==================================================

This is a small library to read connected gamepads via `/dev/input/js0` etc. As
it uses `/dev/input` it only supports Linux. It can be used to create configs
with keybindings for games, xboxdrv etc.


## Install

For development version:

    $ composer require noccylabs/joystick:dev-master


## Examples

Example 1: Using raw events


    $js = new \NoccyLabs\Joystick\Joystick(0);
    echo "Press a button on joystick 0 ... ";
    while (true) {
        $raw = $js->getRawEvent();
        if ($raw['type'] & JS_EVENT_BUTTON) {
            echo "Thank you!\n";
            break;
        }
    }


Example 2: Using the JoystickState

    $js = new \NoccyLabs\Joystick\Joystick(0);
    echo "Press button 1 on joystick 0 ... ";
    while ($state = $js->update()) {
        if ($state->getButton(1)) {
            echo "Thank you!\n";
            break;
        }
    }

