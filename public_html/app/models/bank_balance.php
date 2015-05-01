<?php
/**
 * Bank balance model
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 11:20
 */

function bank_balance_getTablename()
{
    global $CONFIG;
    return $CONFIG["db"]["prefix"] . "bank_balance";
}

/**
 * Создать счет в банке для пользователя
 * @param string $salt соль юзера
 * @return mixed
 */
function bank_balance_create($salt)
{

    $tablename = bank_balance_getTablename();

    if(!$salt) return;

    $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);
    $b = base64_encode(0 + $salt);

    $id = (int)l_mysql_query("INSERT INTO {$tablename} (balance) VALUES ('%s')", array($b),$tablename);

    return $id > 0 ? $id : false;
}

/**
 * Получить баланс для номера счета
 * @param integer $id номер счета в банке
 * @return mixed
 */
function bank_balance_get($id = false)
{
    if (!$id) return false;

    $tablename = bank_balance_getTablename();

    $query = l_mysql_query("SELECT balance FROM {$tablename} WHERE id='%d' LIMIT 1", array($id),$tablename);

    list($balance) = mysqli_fetch_row($query);

    return base64_decode($balance);
}

/**
 * Пополнить номер счета в банке
 * @param integer $user_id юзер
 * @param integer $order_price размер суммы
 * @return bool
 */
function bank_balance_add($user_id, $order_price)
{

    if (!$user_id || !$order_price) return false;

    $usertablename = user_getTablename();

    $tablename = bank_balance_getTablename();

    $query = l_mysql_query("SELECT balance,salt FROM {$usertablename} WHERE id='%d' LIMIT 1", array($user_id),$tablename);

    list($balance_id, $salt) = mysqli_fetch_row($query);

    if(!$balance_id) return;

    $balance = bank_balance_get($balance_id);

    $balance = user_helperbalance($balance, $salt) + $order_price;

    $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);
    $balance = base64_encode($balance + $salt);

    l_mysql_query("UPDATE {$tablename} SET balance='%s' WHERE id='%d'", array($balance, $balance_id),$tablename);

    return true;
}