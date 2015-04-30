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
        loader_model($controller);
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

function getMenu(){
    global $USER;

    if (in_array("create", $USER["PERM"])):
        $pages = array(
            array(
                "name"=>"Создать госзаказ",
                "hash"=>"order/add",
                "url"=>"/order/add"
            ),
            array(
                "name"=>"Список госзаказов",
                "hash"=>"order/list",
                "url"=>"/order/list"
            ),
            array(
                "name"=>"История госзаказов",
                "hash"=>"order/history",
                "url"=>"/order/history"
            )
        );
    else:
        $pages = array(
            array(
                "name"=>"Мой оффшор",
                "hash"=>"front/account",
                "url"=>"/front/account"
            ),
            array(
                "name"=>"Список госзаказов",
                "hash"=>"order/list",
                "url"=>"/order/list"
            ),
            array(
                "name"=>"История госзаказов",
                "hash"=>"order/history",
                "url"=>"/order/history"
            )
        );
    endif;

    echo json_encode($pages);
}