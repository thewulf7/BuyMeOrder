<?php
/**
 * login_logout controller
 * User: johnnyutkin
 * Date: 30.04.15
 * Time: 20:14
 */

function login_logout()
{
    loader_model("user");

    user_logout();
}