<?php

define('IS_DEBUG_FILE', $_SERVER["DOCUMENT_ROOT"] . '/test/debug.txt');
define('IS_DEBUG_PAY_FILE', $_SERVER["DOCUMENT_ROOT"] . '/test/pay.txt');

//AddEventHandler("main", "OnBeforeLocalRedirect", function(&$url, $skip_security_check, $bExternal) {
//    preExit(func_get_args());
//});

function isDebug() {
//    return false;
//    return true;
    if (defined('IS_DEBUG') or in_array(cUser::GetId(), Project\Core\Config::ADMIN_DEBUG)  or ( isset($_COOKIE['is-debug-3985']) and $_COOKIE['is-debug-3985'] == '2352536'))
        return true;
    return false;
}

function preTrace() {
    if (!isDebug())
        return;
    $e = new Exception();
    ?><pre><?= $e->getTraceAsString() ?></pre><?
}

function preTime() {
    if (!isDebug())
        return;
    if (func_num_args()) {
        pre(func_get_args());
    }
    pre(date('d.m.Y H:i:s') . ' ' . (memory_get_usage(true) / 1024 / 2014));
}

function pre() {
    if (!isDebug())
        return;
//    preTrace();
//    exit;
    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
    echo '</pre>';
}
function preCore() {
    if (!defined('IS_DEBUG'))
        return;
//    preTrace();
//    exit;
    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
    echo '</pre>';
}

function preDate($isPre = true) {
    if (!isDebug())
        return;
//    preTrace();
//    exit;
    if ($isPre) {
        echo '<pre>';
    }
    echo PHP_EOL . date('d.m.Y H:i:s') . PHP_EOL;
    if ($isPre) {
        echo '</pre>';
    }
}

function preHtml() {
    if (!isDebug())
        return;
    echo '<pre>';
    foreach (func_get_args() as $value) {
        $value = preg_replace('~(</[^>]+>)~', '$1' . PHP_EOL, $value);
        $value = str_replace('/><', '/>' . PHP_EOL . '<', $value);
        echo htmlspecialchars($value);
    }
    echo '</pre>';
}

function preDebugStart() {
    file_put_contents(IS_DEBUG_FILE, PHP_EOL . date('d.m.Y H:i:s'), FILE_APPEND);
}

if (defined('IS_DEBUG')) {
    preDebugStart();
}

function preDebug() {
//    if (!isDebug())
//        return;
    ob_start();
    preDate(false);
//    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
//    echo '</pre>';
    file_put_contents(IS_DEBUG_FILE, ob_get_clean() . PHP_EOL . file_get_contents(IS_DEBUG_FILE));
}

function payDebug() {
    ob_start();
    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
    echo '</pre>';
    file_put_contents(IS_DEBUG_PAY_FILE, ob_get_clean() . PHP_EOL . file_get_contents(IS_DEBUG_PAY_FILE));
}

function preExit() {
    if (!isDebug())
        return;
    preTrace();
    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
    echo '</pre>';
    exit;
}

function preExport() {
    if (!isDebug())
        return;
    preTrace();
    echo '<pre>';
    echo var_export(func_get_args(), true);
    echo '</pre>';
    exit;
}

function preExitOne() {
    if (!isDebug())
        return;
    $GLOBALS['APPLICATION']->RestartBuffer();
    echo '<pre>';
    foreach (func_get_args() as $value)
        if (is_array($value) or is_object($value)) {
            print_r($value);
        } else {
            var_dump($value);
        }
    echo '</pre>';
    exit;
}

function preMemory() {
    pre('memory: ' . round(memory_get_usage() / 1024 / 1024, 3));
}
