<?php
/**
 * User model
 * User: johnnyutkin
 * Date: 25.04.15
 * Time: 13:47
 */
function user_getTablename()
{
    global $CONFIG;
    return $CONFIG["db"]["prefix"] . "users";
}

/**
 * Авторизовать пользователя
 * @param string $username
 * @param string $passwd
 * @return mixed
 */
function user_auth($username = false, $passwd = false)
{
    global $USER;

    $tablename = user_getTablename();

    if (!$username || !$passwd) return false;

    $user = l_mysql_query("SELECT id,passwd,salt FROM {$tablename} WHERE email='%s' LIMIT 1", array($username),$tablename);

    list($id, $password, $salt) = mysqli_fetch_row($user);

    mysqli_free_result($user);

    $hashpasswd = crypt($passwd, $salt);

    if ($hashpasswd==$password):
        $hash = md5(mt_rand());
        l_mysql_query("UPDATE {$tablename} SET userhash='%s' WHERE id='%d'", array($hash, $id),$tablename);
        setcookie("VKDEV_USER_ID", $id, time() + 60 * 60 * 24 * 30, "/");
        setcookie("VKDEV_USER_HASH", $hash, time() + 60 * 60 * 24 * 30, "/");
        $USER = user_getInfo();
        return $id;
    else:
        return false;
    endif;
}

/**
 * Разлогинить
 * @return bool
 */
function user_logout()
{
    global $USER;

    if (isset($_COOKIE["VKDEV_USER_ID"]) && isset($_COOKIE["VKDEV_USER_HASH"])):

        setcookie("VKDEV_USER_ID", null, -1, "/");
        setcookie("VKDEV_USER_HASH", null, -1, "/");

        header('Location: /');

        return true;

    endif;

}

/**
 * Проверить юзера на залониненость
 * @param $id
 * @param $hash
 * @return bool
 */
function user_checkauth($id, $hash)
{

    $tablename = user_getTablename();

    if (!$id || !$hash) return false;

    $user = l_mysql_query("SELECT userhash FROM {$tablename} WHERE id='%s' LIMIT 1", array($id),$tablename);

    list($hashReal) = mysqli_fetch_row($user);

    return $hashReal === $hash ? true : false;
}

/**
 * Получить информацию о текущем пользователе
 * @return bool
 */
function user_getInfo()
{
    $tablename = user_getTablename();

    loader_model("bank_balance");

    $user_hash = isset($_COOKIE["VKDEV_USER_HASH"]) ? $_COOKIE["VKDEV_USER_HASH"] : false;
    $user_id = isset($_COOKIE["VKDEV_USER_ID"]) ? $_COOKIE["VKDEV_USER_ID"] : false;

    if (!isset($user_id) || !isset($user_hash)) return false;

    if (user_checkauth($user_id, $user_hash)) {

        $user = l_mysql_query("SELECT email,username,balance,salt FROM {$tablename} WHERE id='%s' LIMIT 1", array($user_id),$tablename);

        list($email, $user_name, $balance, $salt) = mysqli_fetch_row($user);

        $balance = bank_balance_get($balance);

        return array("ID" => $user_id, "NAME" => $user_name, "EMAIL" => $email, "BALANCE" => user_helperbalance($balance, $salt));

    } else return array("NAME" => "anonymous");
}

/**
 * Создать юзера
 * @param string $email
 * @param string $passwd
 * @param string $username
 * @param int $group
 * @return mixed
 */
function user_create($email, $passwd, $username, $group = 2)
{
    if (empty($email) || empty($passwd) || empty($username)) return false;

    loader_model("bank_balance");

    $tablename = user_getTablename();

    $salt = '$2a$10$' . substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22) . '$';
    $hashpasswd = crypt($passwd, $salt);

    //select already user

    $users = l_mysql_query("SELECT id FROM {$tablename} WHERE email='%s'",array($email),$tablename);

    if(mysqli_num_rows($users)>0) return false;

    //create balance
    $balance = bank_balance_create($salt);

    $user_id = l_mysql_query("INSERT INTO {$tablename} (username,email,usergroup,passwd,salt,balance) VALUES ('%s','%s','%s','%s','%s','%d')", array($username, $email, $group, $hashpasswd, $salt, $balance),$tablename);


    return $user_id > 0 ? $user_id : 0;
}

/**
 * Вспомогательная функция преобразования баланса
 * @param int $balance баланс
 * @param string $salt соль юзера
 * @return bool
 */
function user_helperbalance($balance = 0, $salt)
{
    $salt = (int)preg_replace('/[^0-9.]+/', '', $salt);
    return (float)($balance - $salt);
}

