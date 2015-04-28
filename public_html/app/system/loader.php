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
    chdir("app/system");
    $toload = $CONFIG["loader"]["init"];
    if (!empty($toload)):
        foreach ($toload as $file):
            if (file_exists($file.".php")):
               $fileinfo = pathinfo($file.".php");
               if ($fileinfo['extension'] === "php") require_once($file.".php");
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
    chdir("../app/controllers");
    if (is_dir($controller . "Controller")):
        if ((file_exists($controller . "Controller/" . $action . ".php"))):
            include_once($controller . "Controller/" . $action . ".php");
            return true;
        endif;
    endif;
    chdir("../");
    return false;
}

/**
 * Подключить системные файлы
 * @param string $controller контроллер
 * @return bool
 */
function loader_controller($controller = "")
{
    chdir("../app/controllers");
    $dir = $controller . "Controller";
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
    chdir("../");
    return false;
}