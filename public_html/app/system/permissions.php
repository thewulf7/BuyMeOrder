<?php
/**
 * Работа с разрешениями
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 08:38
 */

function check_perm()
{
    global $USER;
    if (isset($USER["ID"]) && (int)$USER["ID"] > 0) {
        $perm = l_mysql_query("SELECT g.permissions FROM vkdev_users_group as g,vkdev_users as u WHERE u.id='%d' AND u.usergroup=g.id AND g.active=1 LIMIT 1", array($USER["ID"]));
        $perm = mysqli_fetch_row($perm);
        return explode(",", $perm[0]);
    } else return false;
}