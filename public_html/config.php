<?php
/**
 * Config
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 12:14
 */

function loadConfig(){
    $config = file_get_contents("./config.json");
    return json_decode($config,true);
}

$CONFIG = loadConfig();