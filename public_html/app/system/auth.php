<?php
/**
 * Проверка аутентификации пользователя
 * User: johnnyutkin
 * Date: 27.04.15
 * Time: 16:00
 */
require_once("../models/user.php");


function user_get()
{
    global $USER;

    $USER = user_getInfo();

    $USER["PERM"]=check_perm();
}