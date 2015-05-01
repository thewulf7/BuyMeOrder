<?php
/**
 * Templater
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 15:58
 */

/**
 * Подключить шаблон
 * @param string $title тайтл (deprecated)
 * @param mixed $content контент внутри шаблона
 * @return bool
 */
function layout($title, $content)
{
    global $CONFIG;
    global $USER;
    $path = APP_PATH . "/template/layouts/" . $CONFIG["template"]["layout"] . ".php";
    if (file_exists($path)) include_once($path);
    else return false;
    return true;
}

/**
 * Подключить не стандартный шаблон
 * @param string $title тайтл (deprecated)
 * @param mixed $content контент внутри шаблона
 * @param string $template кастомный шаблон
 * @return bool
 */
function custom_layout($title, $template, $content)
{
    global $CONFIG;
    global $USER;
    $path = APP_PATH . "/template/layouts/" . $template . ".php";
    if (file_exists($path)) include_once($path);
    else return false;
    return true;
}

/**
 * Генерация страницы
 * @param string $template шаблон страницы
 * @param array $params параметры
 * @return mixed
 */
function render($template = "", $params = array())
{
    global $USER;
    $content = loader_template($template);

    if (!$content) return;

    layout($template, $content);

    return true;

}

/**
 * Генерация части страницы
 * @param string $template шаблон
 * @param array $params параметры
 * @return bool
 */
function render_partial($template, $params = array())
{
    global $USER;
    global $CONFIG;
    $path = APP_PATH . "/template/" . $template . ".php";

    if (file_exists($path)) include_once($path);
    return true;
}