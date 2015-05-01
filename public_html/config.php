<?php
/**
 * Config
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 12:14
 */

/**
 * Загрузить файл с конфигами
 * @return array
 */
function loadConfig()
{
    $config = file_get_contents(__DIR__."/config.json");
    return !empty($config) ? json_decode($config, true) : array();
}

//загружаем конфиги
$CONFIG = loadConfig();