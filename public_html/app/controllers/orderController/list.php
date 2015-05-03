<?php
/**
 * order_list controller
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 18:30
 */

function order_list()
{
    global $USER;
    $items = orders_getList();

    if (count($items) > 0):
        if (!in_array("close", $USER["PERM"])):
            render_partial("order/list_admin", array(
                "ITEMS" => $items
            ));
        else:
            render_partial("order/list", array(
                "ITEMS" => $items
            ));
        endif;
    else:
        render_partial("order/list_empty", array("message" => "Госзаказов нет"));
    endif;
}