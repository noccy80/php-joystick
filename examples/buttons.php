<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Joystick\Joystick;

$js = new Joystick;

$js->setControllerMap(array(
    "button" => array(
        "A", "B", "X", "Y",
        "Lb", "Rb",
        "back", "start", "circle",
        "stick1", "stick2"
    )
));

while(true) {
    $state = $js->update();
    
    printf("\e[J%s\r", $state->getPressedButtons());
    
    usleep(10000);
}
