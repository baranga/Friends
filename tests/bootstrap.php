<?php

function autoload($class) {
    $file = str_replace('_', '/', $class) . '.php';
    @include_once $file;
}
spl_autoload_register('autoload');

set_include_path(implode(
    PATH_SEPARATOR,
    array(
        get_include_path(),
        realpath(dirname(__FILE__) . '/../library'),
        realpath(dirname(__FILE__)),
    )
));
