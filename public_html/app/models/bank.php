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
    $usertablename = user_getTablename();

    loader_model("order");
    loader_model("bank_balance");

    $order = orders_get($order_id);

    if (empty($order) || !$buyer) return false;

    $already = l_mysql_query("SELECT id FROM {$tablename} WHERE order_id='%d'", array($order_id),$tablename);

    if (mysqli_num_rows($already)>0) return false;

    $user = l_mysql_query("SELECT salt FROM {$usertablename} WHERE id='%d' LIMIT 1", array($order["seller"]),$usertablename);

    list($salt) = mysqli_fetch_row($user);

    $salt = (int) preg_replace('/[^0-9.]+/', '', $salt);

    $order_price = (float) base64_decode($order["price"]) - $salt;

    $commission = (float)(100 - $CONFIG["main"]["commission"]) / 100;

    if ($commission > 0) $order_price = round($order_price * $commission,2);

    $order_price_hash = base64_encode($order_price+$salt);

    l_mysql_query("INSERT INTO {$tablename} (order_id,buyer,price,status) VALUES ('%d','%d','%s','%d')", array($order_id, $buyer, $order_price_hash, 2),$tablename);

    if (bank_balance_add($buyer, $order_price)) return true;
    else return false;
}