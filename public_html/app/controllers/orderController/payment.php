<?php
/**
 * order_payment controller
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 14:39
 */

function order_payment($id = false)
{
    if (!$id) return;
    global $USER;
    if (!empty($_POST)):
        $data = $_POST["data"];
        $sign = md5("{$data["order_id"]}:{$data["seller"]}:{$data["buyer"]}:{$data["price"]}");

        if ($sign == $data["signature"]):
            bank_proceed($data["order_id"], $USER["ID"]);
        endif;
    endif;

    $order = orders_get($id);

    $result = array(
        "FORM" => array(
            "data[order_id]" => $id,
            "data[seller]" => $order["seller"],
            "data[buyer]" => $USER["ID"],
            "data[price]" => $order["price"],
            "data[signature]" => md5("{$id}:{$order["seller"]}:{$USER["ID"]}:{$order["price"]}")
        )
    );
    render("order/payment", $result);
}