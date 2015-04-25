<?php
/**
 * Loader - loads all files with functions
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 12:10
 */

function loader_init()
{
    global $CONFIG;
    $toload = $CONFIG["loader"]["init"];
    if (!empty($toload)):
        foreach ($toload as $file):
            if ((file_exists($file . ".php"))):
                include_once("./" . $file . ".php");
            endif;
        endforeach;
    endif;
    return true;
}

function loader_action($controller = "", $action = "")
{
    if (is_dir($controller . "Controller")):
        if ((file_exists($controller . "Controller/" . $action . ".php"))):
            include_once($controller . "Controller/" . $action . ".php");
            return true;
        endif;
    endif;
    return false;
}

function loader_controller($controller = "")
{
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
    return false;
}

loader_init();