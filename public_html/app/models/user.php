<?php
/**
 * User model
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 13:47
 */
$USER = array();

function user_getTablename()
{
    global $CONFIG;
    return $CONFIG["db"]["prefix"] . "users";
}

function user_auth($username = false, $passwd = false)
{

    $tablename = user_getTablename();

    if (!$username || !$passwd) return false;

    $user = l_mysql_query("SELECT id,passwd,salt FROM {$tablename} WHERE name='%s' LIMIT 1", array($username));

    list($id, $password, $salt) = mysqli_fetch_row($user);

    mysqli_free_result($user);

    $hashpasswd = crypt($passwd, $salt);

    if ($hashpasswd === $password):
        $hash = md5(mt_rand());
        l_mysql_query("UPDATE {$tablename} SET userhash='" . $hash . "' WHERE id='{$id}'");
        setcookie("VKDEV_USER_ID", $id, time() + 60 * 60 * 24 * 30, "/");
        setcookie("VKDEV_USER_HASH", $hash, time() + 60 * 60 * 24 * 30, "/");
        return $id;
    else:
        return false;
    endif;

    //$salt = '$2a$10$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(),mt_rand()))), 0, 22) . '$';
}

function user_checkauth($id,$hash){

    $tablename = user_getTablename();

    if (!$id || !$hash) return false;

    $user = l_mysql_query("SELECT userhash FROM {$tablename} WHERE id='%s' LIMIT 1", array($id));

    list($hashReal) = mysqli_fetch_row($user);

    return $hashReal===$hash ? true : false;
}

function user_getInfo()
{
    $tablename = user_getTablename();

    $user_hash = $_COOKIE["VKDEV_USER_HASH"];
    $user_id = $_COOKIE["VKDEV_USER_ID"];

    if (!isset($user_id) || !isset($user_hash)) return false;

    if(user_checkauth($user_id,$user_hash)){

        $user = l_mysql_query("SELECT name FROM {$tablename} WHERE id='%s' LIMIT 1", array($user_id));

        list($user_name) = mysqli_fetch_row($user);

        return array("ID"=>$user_id,"NAME"=>$user_name);

    } else return array("NAME"=>"anonymous");
}

