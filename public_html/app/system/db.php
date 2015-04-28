<?php
/**
 * DB connection
 * User: johnnyutkin
 * Date: 24.04.15
 * Time: 19:00
 */

/**
 * Создать соединение
 * @param string $dbname Имя базы
 * @return mixed
 * @throws Exception
 */
function db_connect($dbname = "")
{
    global $CONFIG;
    $dbname = !empty($dbname) ? $dbname : $CONFIG["db"]["dbname"];
    $conn = mysqli_connect($CONFIG["db"]["server"], $CONFIG["db"]["user"], $CONFIG["db"]["password"], $dbname);

    if (!$conn) throw new Exception(sprintf("Нет соединения с БД: %s", mysqli_connect_error()));
    if (!mysqli_set_charset($conn, "utf8")) throw new Exception(sprintf("Не удается установить кодировку"));

    mysqli_query($conn, "SET NAMES utf8");
    mysqli_query($conn, "SET CHARSET utf8");
    mysqli_query($conn, "SET CHARACTER SET utf8");
    mysqli_query($conn, "SET character_set_client = 'utf8'");
    mysqli_query($conn, "SET SESSION collation_connection = 'utf8_general_ci'");
    mysqli_query($conn, "SET SQL_BIG_SELECTS=1");

    return $conn;
}

/**
 * Сделать запрос
 * @param string $query запрос
 * @param array $params параметры запроса
 * @param string $dbname имя базы
 * @return resource
 * @throws Exception
 */
function l_mysql_query($query, $params = array(), $dbname = "")
{
    $DB = db_connect($dbname);

    if (!empty($params)):
        foreach ($params as $key => $param):
            $params[$key] = mysqli_real_escape_string($DB, $param);
        endforeach;
        $query = vsprintf($query, $params);
    endif;
    $result = mysqli_query($DB, $query);
    if (!$result) throw new Exception(sprintf("Ошибка: %s", mysqli_error($DB)));
    mysqli_close($DB);
    return $result;
}
