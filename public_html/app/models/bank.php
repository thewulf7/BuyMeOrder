<?php
/**
 * Bank model
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 11:19
 */

function bank_getTablename()
{
    global $CONFIG;
    return $CONFIG["db"]["prefix"] . "bank";
}

function bank_proceed($order_id, $buyer)
{

    global $CONFIG;

    $tablename = bank_getTablename();

    loader_model("order");

    $order = orders_get($order_id);

    if (empty($order) || !$buyer) return false;

    $already = l_mysql_query("SELECT id FROM {$tablename} WHERE order_id='%d'", array($order_id));

    if (mysqli_num_rows($already)>0) return;

    $order_price = base64_decode($order["price"]) - (int)$order_id;

    $commission = (float)(100 - $CONFIG["main"]["commission"]) / 100;

    if ($commission > 0) $order_price = round($order_price * $commission);

    l_mysql_query("INSERT INTO {$tablename} (order_id,buyer,price,status) VALUES ('%d','%d','%s','%d')", array($order_id, $buyer, $order["price"], 2));

    if (bank_balance_add($buyer, $order_price)) return true;
    else return false;
}