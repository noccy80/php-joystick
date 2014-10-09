<?php

extension_loaded("xdebug") || (is_callable("dl") && @dl("xdebug.so"));

require_once __DIR__."/../vendor/autoload.php";
