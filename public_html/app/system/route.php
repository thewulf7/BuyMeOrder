<?php
/**
 * Route file to call actions
 * User: johnnyutkin
 * Date: 24.04.15
 * Time: 19:00
 */

/**
 * Вызывает необходимый метод из вызванного контроллера
 * @return mixed
 * @throws Exception
 */
function route()
{
    global $USER;

    $uri = explode("/", substr($_SERVER["REQUEST_URI"], 1));

    if (count($uri) > 1) list($controller, $action) = $uri;

    $controller = !empty($controller) ? $controller : "front";

    $action = !empty($action) ? $action : "index";

    $func_name = $controller . "_" . $action;

    if (loader_action($controller, $action) && function_exists($func_name)) {
        call_user_func_array($func_name, array_merge(array(), explode("/", substr($_SERVER["REQUEST_URI"], (strlen($func_name) + 2)))));
    } else throw new Exception(sprintf('Метода %s не существует', $func_name));

    return true;
}

function redirect($func_name)
{

    list($controller, $action) = explode("/", $func_name);

    $func_name = str_replace("/", "_", $func_name);

    if (loader_action($controller, $action) && function_exists($func_name)) {
        call_user_func_array($func_name, array_merge(array(), explode("/", substr($_SERVER["REQUEST_URI"], (strlen($func_name) + 2)))));
    } else throw new Exception(sprintf('Метода %s не существует', $func_name));

    return true;
}