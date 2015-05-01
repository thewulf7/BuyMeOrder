<?php
/**
 * Контроллер front метод index
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 12:08
 */

function front_index($params = array())
{
    global $USER;
    render("front/index");
}