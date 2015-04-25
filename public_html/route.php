<?php
/**
 * Route file to call actions
 * Created by PhpStorm.
 * User: johnnyutkin
 * Date: 24.04.15
 * Time: 19:00
 */

function route(){
    list($controller,$action) = explode("/",substr($_SERVER["REQUEST_URI"],1));
    $func_name = $controller."_".$action;
    if(loader_action($controller,$action) && function_exists($func_name)) {
        call_user_func_array($func_name,array_merge(array(),explode("/",substr($_SERVER["REQUEST_URI"],(strlen($func_name)+2)))));
    } else {
        throw new Exception(sprintf('Метода %s не существует',$func_name));
    }
    return true;
}