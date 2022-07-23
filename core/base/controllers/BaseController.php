<?php


namespace core\base\controllers;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

abstract class BaseController
{
    use \core\base\controllers\BaseMethods; //подключение трейта

    protected $header;
    protected $content;
    protected $footer;
    protected $page; //ПОЛНОСТЬЮ СТРАНИЦА НАШЕГО САЙТА

    protected $errors;

    protected $controller;
    protected $inputMethod; //хранится метод, который собирает данные из БД
    protected $outputMethod; //имя метода, которое отвечает за подключение видов
    protected $parameters;

    protected $styles;
    protected $scripts;

    public function route(){ //public потому что обращаемся к данной функции из ВНЕ класса!

        $controller = str_replace("/","\\",$this->controller);

        try{

            $object = new \ReflectionMethod($controller,"request"); //поиск метода в классе $controller

            $args = [
                "parameters" => $this->parameters,
                "inputMethod" => $this->inputMethod,
                "outputMethod" => $this->outputMethod,
            ];

            $object->invoke(new $controller, $args);

        }catch(\ReflectionException $e){
            throw new RouteException($e->getMessage());
        }

    }

    public function request($args){

        $this->parameters = $args["parameters"];

        $inputData = $args["inputMethod"];
        $outputData = $args["outputMethod"];

        $data = $this->$inputData();

        if (method_exists($this,$outputData)){ //если метод существует

            $page = $this->$outputData($data);
            if($page) {
                $this->page = $page;
            }

        }elseif ($data) {
            $this->page = $data;
        }

        if ($this->errors){
            $this->writeLog($this->errors);
        }
        $this->getPage();

    }

    protected function render($path = "", $parameters = []){

        extract($parameters);

        if (!$path){

            $class = new \ReflectionClass($this);

            $space = str_replace("\\","/",$class->getNamespaceName()."\\");//возвращает namespace класса
            $routes = Settings::get("routes");

            if ($space === $routes["user"]["path"]){$template = TEMPLATE;}
            else {$template = ADMIN_TEMPLATE;}

            $path = $template . explode ("controller", strtolower($class->getShortName()))[0];
        }

        ob_start();

        if (!@include_once $path . ".php"){
            throw new RouteException("Отсутствует шаблон - ".$path);
        }

        return ob_get_clean();

    }

    protected function getPage(){

        if (is_array($this->page)){ //Если массив
            foreach ($this->page as $block) echo $block;
        }else{ //Если строка
            echo $this->page;
        }

        exit;
    }

    protected function init($admin = false){ //ИНИЦИЛИЗАЦИЯ СТИЛЕЙ И СКРИПТОВ

        if (!$admin){
            if (USER_CSS_JS["styles"]){
                foreach (USER_CSS_JS["styles"] as $item){ $this->styles[] = PATH . TEMPLATE . trim($item,"/") ;}
            }
            if (USER_CSS_JS["scripts"]){
                foreach (USER_CSS_JS["scripts"] as $item){ $this->scripts[] = PATH . TEMPLATE . trim($item,"/");}
            }
        }else{
            if (ADMIN_CSS_JS["styles"]){
                foreach (ADMIN_CSS_JS["styles"] as $item){ $this->styles[] = PATH . ADMIN_TEMPLATE . trim($item,"/") ;}
            }
            if (ADMIN_CSS_JS["scripts"]){
                foreach (ADMIN_CSS_JS["scripts"] as $item){ $this->scripts[] = PATH . ADMIN_TEMPLATE . trim($item,"/");}
            }
        }

    }

}

