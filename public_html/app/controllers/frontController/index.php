<?php
/**
 * Контроллер front метод index
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 12:08
 */

/**
 * Метод front_index
 * @param array $params параметры
 * @return mixed
 */
function front_index($params = array())
{
    global $USER;
    //$new_user = user_create("thewulf7@gmail.com","spbfitos13","Евгений");
    user_auth("thewulf7@gmail.com","spbfitos13");
    render("front/index");
}