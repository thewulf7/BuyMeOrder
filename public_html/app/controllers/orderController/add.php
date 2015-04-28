<?php
/**
 * order_add controller
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 15:24
 */

function order_add(){
    echo "123";
    if(!empty($_POST)):
        $data = $_POST["data"];
    endif;
    render("order/add");
}