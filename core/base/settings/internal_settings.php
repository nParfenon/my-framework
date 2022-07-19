<?php

defined("VG_ACCESS") or die('User Stop Please');

const TEMPLATE="templates/default/";//шаблон сайта
const ADMIN_TEMPLATE = "core/admin/views/";//шаблон админ панели
const UPLOAD_DIR = "userfiles/";
const LOG_FOLDER = 'log/';

const COOKIE_VERSION = "1.0";//Версия куки, нужна, чтобы пользователи перелогинились в случае изменения правил/алгоитма сайта
const CRYPT_KEY = "";//Для шифрования
const COOKIE_TIME = 60 ;//Время, которое отвечает за бездействие (минуты)
const BLOCK_TIME = 3 ; //Время на которое будем блокировать пользователя, котороый подобрал пароль к учетке не правильно (минуты)

const QTY = 9; //кол-во товаров на странице/прогружаемых товаров
const QTY_LINKS = 3;

const ADMIN_CSS_JS = [
    "styles" => ["css/main.css"],
    "scripts" => ["js/main.js"],
];

const USER_CSS_JS = [
    "styles" => [],
    "scripts" => []
];

use core\base\exceptions\RouteException;

function autoloadMainClasses($class_name){

    $class_name = str_replace('\\','/', $class_name);

    if  (!@include $class_name.".php"){
        throw new RouteException("Неверное имя файла для подключения!"." - ".$class_name);
    }
}

spl_autoload_register("autoloadMainClasses");


?>