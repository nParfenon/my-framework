<?php

define("VG_ACCESS",true);

header("Content-Type:text/html; charset=utf-8"); //гворим браузеру пользователя, в какой кодировке мы будем ему отправлять данные

require_once "config.php";
require_once "core/base/settings/internal_settings.php";

use core\base\exceptions\RouteException;
use core\base\exceptions\DbException;
use \core\base\controllers\RouteController;

try {
    RouteController::instance()->route();
}
catch(RouteException $e){
    exit($e->getMessage());
}
catch(DbException $e){
    exit($e->getMessage());
}



?>

