<?php
/**
 * order_add controller
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 15:24
 */

function order_add()
{

    global $USER;

    if (!in_array("create", $USER["PERM"])) {
        render_partial("order/list_empty", array("message" => "У вас нет прав. Никаких..."));
        return;
    }
    //throw new Exception(sprintf("Ошибка: %s", "Нет прав"));

    if (!empty($_POST)):
        $data = $_POST["data"];
        $token = get_token();
        if ($data["csrf_token"] == $token):
            $data["descr"] = isset($data["descr"]) ? $data["descr"] : "";

            $data["price"] = str_replace(",", ".", $data["price"]);

            $data["price"] = floatval($data["price"]);

            if ($data["price"] == 0 || !$data["price"]) {
                render_partial("order/success", array("message" => "Стоимость не может быть нулевой!"));
                return false;
            }

            if ($id = orders_create($data["name"], $data["descr"], $data["price"], $USER["ID"])):
                render_partial("order/success", array("message" => "Госзаказ создан и добавлен в список!"));
                return true;
            else:
                render_partial("order/success", array("message" => "Произошла ошибка в процессе создания. ФСБ уже выехало к вам)"));
                return false;
            endif;
        endif;
    else:
        render_partial("order/add", array("token" => $_COOKIE["VKDEV_USER_HASH"]));
    endif;
}