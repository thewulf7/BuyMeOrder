<?php
/**
 * Функции подключения файлов и каталогов
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 12:10
 */

/**
 * Подключить системные файлы из конфига
 * @return bool
 */
function loader_init()
{
    global $CONFIG;
    chdir(APP_PATH . "/system");
    $toload = $CONFIG["loader"]["init"];
    if (!empty($toload)):
        foreach ($toload as $file):
            if (file_exists($file . ".php")):
                $fileinfo = pathinfo($file . ".php");
                if ($fileinfo['extension'] === "php") require_once($file . ".php");
            endif;
        endforeach;
    endif;
    chdir("../");
    return true;
}

/**
 * Подключить метод
 * @param string $controller контроллер
 * @param string $action метод
 * @return bool
 */
function loader_action($controller = "", $action = "")
{
    if (is_dir(APP_PATH . "/controllers/" . $controller . "Controller")):
        if (file_exists(APP_PATH . "/controllers/" . $controller . "Controller/" . $action . ".php")):
            include_once(APP_PATH . "/controllers/" . $controller . "Controller/" . $action . ".php");
            return true;
        endif;
    endif;
    return false;
}

/**
 * Подключить контроллер
 * @param string $controller контроллер
 * @return bool
 */
function loader_controller($controller = "")
{
    $dir = APP_PATH . "/controllers/" . $controller . "Controller";
    if (is_dir($dir)):
        if ($handle = opendir($dir)) {
            chdir($dir);
            while (false !== ($file = readdir($handle))) {
                $fileinfo = pathinfo($dir . "/" . $file);
                if ($fileinfo['extension'] === "php") {
                    include_once($dir . "/" . $file);
                }
            }
            chdir("../");
        }
        closedir($handle);
        return true;
    endif;
    return false;
}

/**
 * Подключить модель
 * @param string $model метод
 * @return bool
 */
function loader_model($model)
{
    if (file_exists(APP_PATH . "/models/" . $model . ".php")):
        include_once(APP_PATH . "/models/" . $model . ".php");
        return true;
    endif;
    return false;
}

/**
 * Подключить шаблон
 * @param string $file шаблон
 * @return mixed
 */
function loader_template($file)
{
    if ((file_exists(APP_PATH . "/template/" . $file . ".php"))):
        $content = file_get_contents(APP_PATH . "/template/" . $file . ".php");
        return $content;
    endif;
    return false;
}

