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

function bank_proceed($order_id,$buyer){

    $tablename = bank_getTablename();


    loader_model("orders");

    $order = orders_get($order_id);

    if(empty($order) || $order["active"]!=1 || !$buyer) return false;

    $order_price = base64_decode($order["price"]) - (int)$order_id;

    l_mysql_query("INSERT INTO {$tablename} (order_id,buyer,price,status) VALUES ('%d','%d','%s','%d')",array($order_id,$buyer,$order["price"],2));

    bank_balance_add($buyer,$order_price);

    orders_setStatus($order_id,"disable");

}