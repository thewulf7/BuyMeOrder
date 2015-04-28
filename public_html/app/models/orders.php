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

function orders_get($order_id=false) {
    if(!$order_id) return false;

    $tablename = orders_getTablename();

    $query = l_mysql_query("SELECT name,price,seller,active FROM {$tablename} WHERE id='%s'",array($order_id));

    $order = $query ? mysqli_fetch_array($query) : array();

    return $order;

}