<?php
/**
 * order_add controller
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 15:24
 */

function order_add(){

    global $USER;

    if(!in_array("create",$USER["PERM"])) throw new Exception(sprintf("Ошибка: %s","Нет прав"));

    if(!empty($_POST)):
        $data = $_POST["data"];
    endif;

    render_partial("order/add");
}