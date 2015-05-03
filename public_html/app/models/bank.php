<?php
/**
 * Bank model
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 11:19
 */

/**
 * Название таблицы
 * @return string
 */
function bank_getTablename()
{
    global $CONFIG;
    return $CONFIG["db"]["prefix"] . "bank";
}

/**
 * Провести оплату
 * @param integer $order_id номер заказа
 * @param integer $buyer покупатель
 * @return bool
 */
function bank_proceed($order_id, $buyer)
{

    global $CONFIG;

    $tablename = bank_getTablename();

    loader_model("order");
    loader_model("bank_balance");

    $order = orders_get($order_id);

    if (empty($order) || !$buyer) return false;

    $already = l_mysql_query("SELECT id FROM {$tablename} WHERE order_id='%d'", array($order_id),$tablename);

    if (mysqli_num_rows($already)>0) return false;

    $order_price = base64_decode($order["price"]) - (int)$order_id;

    $commission = (float)(100 - $CONFIG["main"]["commission"]) / 100;

    if ($commission > 0) $order_price = round($order_price * $commission);

    l_mysql_query("INSERT INTO {$tablename} (order_id,buyer,price,status) VALUES ('%d','%d','%s','%d')", array($order_id, $buyer, $order["price"], 2),$tablename);

    if (bank_balance_add($buyer, $order_price)) return true;
    else return false;
}