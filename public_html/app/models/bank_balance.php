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

function bank_balance_create($salt)
{

    $tablename = bank_balance_getTablename();

    $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);
    $b = base64_encode(0 + $salt);

    $id = (int)l_mysql_query("INSERT INTO {$tablename} (balance) VALUES ('%s')", array($b));

    return $id > 0 ? $id : false;
}

function bank_balance_get($id=false)
{
    if(!$id) return false;

    $tablename = bank_balance_getTablename();

    $query = l_mysql_query("SELECT balance FROM {$tablename} WHERE id='%d' LIMIT 1",array($id));

    list($balance) = mysqli_fetch_row($query);

    return base64_decode($balance);
}

function bank_balance_add($user_id,$order_price){

    if(!$user_id || !$order_price) return false;

    $usertablename = user_getTablename();

    $tablename = bank_balance_getTablename();

    list($balance_id,$salt) = mysql_fetch_row(l_mysql_query("SELECT balance,salt FROM {$usertablename} WHERE id='%d'",array($user_id)));

    $balance = bank_balance_get($balance_id);

    $balance = user_helperbalance($balance,$salt)+$order_price;

    l_mysql_query("UPDATE {$tablename} SET balance='%s' WHERE id='%d'",array($balance,$balance_id));

}