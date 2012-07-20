<?php

function autoload($class) {
    $file = str_replace('_', '/', $class) . '.php';
    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    foreach ($includePaths as $includePath) {
        $fullPath =
            rtrim($includePath, DIRECTORY_SEPARATOR) .
            DIRECTORY_SEPARATOR .
            ltrim($file, DIRECTORY_SEPARATOR);
        if (is_file($fullPath)) {
            include_once $fullPath;
            break;
        }
    }
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
