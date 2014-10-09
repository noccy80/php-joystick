<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Joystick\Joystick;

$js = new Joystick;

while(true) {
    if (($ev = $js->getRawEvent())) {
        $type = $ev['type'];
        if ($type & JS_EVENT_BUTTON) { $typestr = "JS_EVENT_BUTTON"; }
        elseif ($type & JS_EVENT_AXIS) { $typestr = "JS_EVENT_AXIS"; }
        else { $typestr = "unknown"; }
        if ($type & JS_EVENT_INIT) { $typestr .= "|JS_EVENT_INIT "; }
        printf("Event type %d (%s): number %d value %d\n", $ev['type'], $typestr, $ev['number'], $ev['value']);
    }
    usleep(10000);
}
