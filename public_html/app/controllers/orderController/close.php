<?php
/**
 * order_close controller
 * User: johnnyutkin
 * Date: 30.04.15
 * Time: 13:04
 */

function order_close()
{
    global $USER;
    loader_model("bank");

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET" :
            redirect("front/index");
            break;
        case "POST":
            if (!empty($_POST)):

                $data = $_POST["data"];

                if (!$data["orderId"] || !$data["seller"] || !$data["buyer"] || !$data["price"]) {
                    render_partial("order/successOrder", array("message" => "Отсутствуют необходимые параметры", "id" => $data["orderId"]));
                    return false;
                }

                $token = md5("order:{$data["orderId"]}:{$data["seller"]}:{$data["buyer"]}:{$data["price"]}");

                if ($token == $data["csrf_token"]):

                    if (orders_close($data["orderId"])) {
                        if (bank_proceed($data["orderId"], $USER["ID"])) {
                            render_partial("order/successOrder", array("message" => "Госзаказ успешно распилен!<br/>Деньги перечислены в ваш оффшор!", "id" => $data["orderId"]));
                            return true;
                        }
                    }
                    render_partial("order/successOrder", array("message" => "Извините, но заказ уже забрали братья Роттенберги.", "id" => $data["orderId"]));
                else:
                    return false;
                endif;
            else:
                redirect("front/index");
            endif;
            break;
    }
}