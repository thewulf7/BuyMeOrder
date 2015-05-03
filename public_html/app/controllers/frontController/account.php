<?php
/**
 * front_account controller
 * User: johnnyutkin
 * Date: 30.04.15
 * Time: 17:35
 */

function front_account()
{

    global $USER;

    $total = 0;

    $total += $USER["BALANCE"];

    render_partial("front/account", array("message" => number_format($total, 2, ".", " ")));
}