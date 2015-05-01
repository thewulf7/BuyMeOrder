<?php
/**
 * Проверка аутентификации пользователя
 * User: johnnyutkin
 * Date: 27.04.15
 * Time: 16:00
 */
require_once("../models/user.php");

/**
 * Базовая аутентификация
 */
function user_get()
{
    global $USER;

    $USER = user_getInfo();

    $USER["PERM"] = check_perm();
}

/**
 * Возвращает токен текущего юзера для проверки
 * @return mixed
 */
function get_token()
{
    global $USER;

    $tablename = user_getTablename();

    $query = l_mysql_query("SELECT userhash FROM {$tablename} WHERE id='%s'", array($USER["ID"]),$tablename);
    list($hash) = mysqli_fetch_row($query);

    return $hash ? $hash : false;
}

