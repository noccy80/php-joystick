<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Joystick\Joystick;

$js = new Joystick;

// Basic controller map for xbox360 usb gamepad
$js->setControllerMap(array(
    "button" => array(
        0 => "A",
        1 => "B",
        2 => "X",
        3 => "Y",
        4 => "Lb",
        5 => "Rb",
        6 => "back",
        7 => "start",
        8 => "circle",
        9 => "stick1",
        10 => "stick2"
    )
));

while(true) {
    $state = $js->update();
    
    printf("\e[J%s\r", $state->getPressedButtons());
    
    usleep(10000);
}
