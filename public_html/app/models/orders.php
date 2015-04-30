<?php
/**
 * Orders model
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 14:31
 */

function orders_getTablename()
{
    global $CONFIG;
    return $CONFIG["db"]["prefix"] . "orders";
}

function orders_get($order_id = false)
{
    if (!$order_id) return false;

    $tablename = orders_getTablename();

    $query = l_mysql_query("SELECT name,price,seller,active FROM {$tablename} WHERE id='%s'", array($order_id));

    $order = $query ? mysqli_fetch_array($query) : array();

    return $order;

}

function orders_create($name, $descr, $price, $seller)
{

    $tablename = orders_getTablename();
    $usertablename = user_getTablename();

    $user = l_mysql_query("SELECT salt FROM {$usertablename} WHERE id='%s' LIMIT 1", array($seller));

    list($salt) = mysqli_fetch_row($user);

    $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);
    $price = (int)$price;
    $price = base64_encode($price + $salt);

    $query = (int)l_mysql_query("INSERT INTO {$tablename} (name,descr,price,seller) VALUES ('%s','%s','%s','%d')", array($name, $descr, $price, $seller));

    return $query > 0 ? $query : false;

}
