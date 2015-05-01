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

    $uri = substr($_SERVER["REQUEST_URI"], 1);

    if (stripos($uri, "?")) $uri = substr($uri, 0, stripos($uri, "?"));

    $uri = explode("/", $uri);


    if (count($uri) > 1) list($controller, $action) = $uri;

    $controller = !empty($controller) ? $controller : "front";

    $action = !empty($action) ? $action : "index";

    $func_name = $controller . "_" . $action;

    if (loader_action($controller, $action) && function_exists($func_name)) {
        loader_model($controller);

        if (!isset($USER["ID"]) && $controller != "login") {
            header("Location: /login/do");
        }

        call_user_func_array($func_name, array_merge(array(), explode("/", substr($_SERVER["REQUEST_URI"], (strlen($func_name) + 2)))));
    } else throw new Exception(sprintf('Метода %s не существует', $func_name));

    return true;
}

/**
 * Создать соединение
 * @param string $func_name имя контроллера/метода
 * @return bool
 * @throws Exception
 */
function redirect($func_name)
{

    list($controller, $action) = explode("/", $func_name);

    $func_name = str_replace("/", "_", $func_name);

    if (loader_action($controller, $action) && function_exists($func_name)) {
        call_user_func_array($func_name, array_merge(array(), explode("/", substr($_SERVER["REQUEST_URI"], (strlen($func_name) + 2)))));
    } else throw new Exception(sprintf('Метода %s не существует', $func_name));

    return true;
}

/**
 * Разделение меню для юзеров
 * @return string
 */
function getMenu()
{
    global $USER;

    if (!$USER["PERM"]) {
        echo "[]";
        return;
    }

    if (in_array("create", $USER["PERM"])):
        $pages = array(
            array(
                "name" => "Список госзаказов",
                "hash" => "order/list",
                "url" => "/order/list"
            ),
            array(
                "name" => "Создать госзаказ",
                "hash" => "order/add",
                "url" => "/order/add"
            ),
            array(
                "name" => "История госзаказов",
                "hash" => "order/history",
                "url" => "/order/history"
            )
        );
    else:
        $pages = array(
            array(
                "name" => "Список госзаказов",
                "hash" => "order/list",
                "url" => "/order/list"
            ),
            array(
                "name" => "Мой оффшор",
                "hash" => "front/account",
                "url" => "/front/account"
            ),
            array(
                "name" => "История госзаказов",
                "hash" => "order/history",
                "url" => "/order/history"
            )
        );
    endif;

    echo json_encode($pages);
}