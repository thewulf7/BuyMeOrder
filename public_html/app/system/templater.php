<?php
/**
 * Templater
 * User: johnnyutkin
 * Date: 28.04.15
 * Time: 15:58
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

function render($template = "", $params = array())
{
    global $USER;
    $content = loader_template($template);

    if (!$content) return;

    layout($template, $content);

}

function render_partial($template, $params=array())
{
    global $USER;
    $path = APP_PATH . "/template/" . $template. ".php";
    if (file_exists($path)) include_once($path);
    return true;
}