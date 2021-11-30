<?php

require_once("../../vendor/autoload.php");

use web\MainController;

ini_set('display_errors', '1');
ini_set('session.cookie_httponly', '1');
ini_set('xdebug.collect_vars', 'on');
ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
ini_set('xdebug.collect_params', '4');
ini_set('xdebug.dump_globals', 'on');
ini_set('xdebug.show_local_vars', 'on');
if (function_exists('xdebug_disable')) {
    xdebug_disable();
}
error_reporting(-1);

try {
    session_start();
    $get = explode("?", $_SERVER["REQUEST_URI"])[1]??"";
    $get = explode("&", $get);
    $getArgs = [];
    foreach ($get as $keyValue)
    {
        $keyValue = explode("=", $keyValue);
        $getArgs[$keyValue[0]] = htmlspecialchars($keyValue[1]??"");
    }

    $args = array_merge($_POST, $_GET, $getArgs);

    $path = explode("?", $_SERVER["REQUEST_URI"])[0] ?? $_SERVER["REQUEST_URI"];

    if ($path == "/" || $path == "")
        $action = "index";
    else
        $action = mb_strcut($path, 1, mb_strlen($path));

    $result = MainController::create()->run($action, $args);
    if ($result!==null)
    {
        $html = core\View::render($result);
        echo $html;
    } else {
        echo "Тут явно что-то не то...";
    }

} catch (ReflectionException $e) {
    file_put_contents(__DATA__."/logs/web.log", $e->__toString(), FILE_APPEND);
    echo "В разаработке";
}

