<?php

namespace Application;

include_once "../../vendor/autoload.php";

$action = $_GET['action'];
$url = $_GET['url'];
$is_limited = ($_GET['limit_link'] == 'false') ? false : true;
$custom_link = $_GET['custom_link'];

session_start();
if (!isset($_SESSION['server_time'])) {
    $_SESSION['server_time'] = time();
}

$main = new Main();
$main->checkElapsedTime();

switch ($action) {
    case('redirect'): {
        $main->redirect($url);
        break;
    }
    case('minimize'): {
        $main->minimize($url, $is_limited);
        break;
    }
    case('minimizeCustomUrl'): {
        $main->minimizeCustomUrl($url, $is_limited, $custom_link);
        break;
    }
    case('getStatistic'): {
        $main->getStatistic();
        break;
    }
}

