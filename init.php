<?php
date_default_timezone_set("Asia/Shanghai");

require_once 'vendor/autoload.php';

/*
 * 控制台输出
 */
function _e($msg)
{
    echo ">>>>>";
    echo "\n";
    echo $msg;
    echo "\n";
    echo "<<<<<";
    echo "\n";
    die;
}