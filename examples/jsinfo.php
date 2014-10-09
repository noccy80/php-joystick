<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Joystick\Joystick;

$js = new Joystick;

while(true) {
    $state = $js->update();
    
    foreach ($state->getAllButtons() as $index=>$button) {
        printf("Btn%d: %1d ", $index, $button);
    }
    printf("\r");
    
    usleep(10000);
}
