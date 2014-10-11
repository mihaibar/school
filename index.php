<?php

/* import the configuration files */
require_once("config/config.php");


/* autoload */
function __autoload($class) {
    require (LIBS.$class.".php");
}



/* boot up the application */
$application = new Bootstrap();