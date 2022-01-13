<?php

define("VG_ACCESS",true); //Константа безопасности

header("Content-Type:text/html; charset=utf-8"); //говорим браузеру пользователя, в какой кодировке будем отправлять данные

require_once "config.php";
require_once "core/base/settings/internal_settings.php"; //Расширенные настройки

use core\base\exceptions\RouteException;
use core\base\exceptions\DbException;
use core\base\controllers\RouteController;

try {
    RouteController::instance()->route();
}
catch(RouteException $e){
    exit($e->getMessage());
}
catch(DbException $e){
    exit($e->getMessage());
}




