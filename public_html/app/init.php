<?php
/**
 * Набор базовых событий при каждой загрузке
 * User: johnnyutkin
 * Date: 27.04.15
 * Time: 15:49
 */
define("APP_PATH",__DIR__);

require_once("system/loader.php");

//загружаем базовые функции
loader_init();

//инициализируем юзера
$USER = array();
user_get();



var_dump($USER);
