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

/**
 * Получить заказ
 * @param integer $order_id номер заказа
 * @return bool
 */
function orders_get($order_id = false)
{
    if (!$order_id) return false;

    $tablename = orders_getTablename();

    $query = l_mysql_query("SELECT name,price,seller,active FROM {$tablename} WHERE id='%s'", array($order_id),$tablename);

    $order = $query ? mysqli_fetch_array($query) : array();

    return $order;

}

/**
 * Создать заказ
 * @param string $name название
 * @param string $descr описание
 * @param integer $price стоимость
 * @param integer $seller продавец
 * @return mixed
 */
function orders_create($name, $descr, $price, $seller)
{

    $tablename = orders_getTablename();
    $usertablename = user_getTablename();

    $user = l_mysql_query("SELECT salt FROM {$usertablename} WHERE id='%d' LIMIT 1", array($seller),$usertablename);

    list($salt) = mysqli_fetch_row($user);

    $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);
    $price = (int)$price;
    $price = base64_encode($price + $salt);

    $query = (int)l_mysql_query("INSERT INTO {$tablename} (name,descr,price,seller) VALUES ('%s','%s','%s','%d')", array($name, $descr, $price, $seller),$tablename);

    return $query > 0 ? $query : false;

}

/**
 * Получить список заказов
 * @param bool $active активность заказов
 * @return bool
 */
function orders_getList($active = true)
{
    global $CONFIG, $USER;

    $tablename = orders_getTablename();
    $usertablename = user_getTablename();

    $items = array();

    $active = $active ? 1 : 0;

    $commission = (float)(100 - $CONFIG["main"]["commission"]) / 100;

    $query = l_mysql_query("SELECT id,name,descr,price,seller,created FROM {$tablename} WHERE active='%d'", array($active),$tablename);

    while ($item = mysqli_fetch_array($query)):
        $arItem = array();
        //генерируем токен для проверки
        list($salt) = mysqli_fetch_row(l_mysql_query("SELECT salt FROM {$usertablename} WHERE id='%d' LIMIT 1", array($item["seller"]),$usertablename));
        $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);

        $arItem = array(
            "ID" => $item["id"],
            "NAME" => $item["name"],
            "DESCR" => $item["descr"],
            "PRICE" => base64_decode($item["price"]) - $salt,
            "DATE" => date("H:i d.m.y", strtotime($item["created"])),
            "SELLER" => $item["seller"]
        );

        $arItem["NEW_PRICE"] = round($commission * $arItem["PRICE"]);
        $arItem["csrf_token"] = md5("order:{$item["id"]}:{$item["seller"]}:{$USER["ID"]}:{$arItem["PRICE"]}");

        $items[] = $arItem;
    endwhile;
    return $items;
}

/**
 * Закрыть заказ
 * @param integer $id номер заказа
 * @return bool
 */
function orders_close($id)
{
    $tablename = orders_getTablename();

    $query = l_mysql_query("UPDATE {$tablename} SET active='%d' WHERE id='%d' AND active='1'", array("0", $id),$tablename);

    if ($query) return true;
    else return false;
}