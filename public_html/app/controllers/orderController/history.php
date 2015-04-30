<?php
/**
 * order_history controller
 * User: johnnyutkin
 * Date: 30.04.15
 * Time: 17:40
 */
function order_history(){
    $items = orders_getList(false);
    if (count($items) > 0):
        render_partial("order/history", array(
            "ITEMS" => $items
        ));
    else:
        render_partial("order/list_empty", array("message" => "Архивных госзаказов нет"));
    endif;
}