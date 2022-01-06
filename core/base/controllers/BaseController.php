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
    protected $Page; //ПОЛНОСТЬЮ СТРАНИЦА НАШЕГО САЙТА

    protected $Errors;

    protected $controller;
    protected $InputMethod; //хранится метод, который собирает данные из БД
    protected $OutputMethod; //имя метода, которое отвечает за подключение видов
    protected $parameters;

    protected $styles;
    protected $scripts;

    public function route(){ //public потому что обращаемся к данной функции из ВНЕ класса!

        $controller = str_replace("/","\\",$this->controller);

        try{

            $object = new \ReflectionMethod($controller,"request"); //поиск метода в классе $controller

            $args = [
                "parameters" => $this->parameters,
                "InputMethod" => $this->InputMethod,
                "OutputMethod" => $this->OutputMethod,
            ];

            $object->invoke(new $controller, $args);

        }catch(\ReflectionException $e){
            throw new RouteException($e->getMessage());
        }

    }

    public function request($args){

        $this->parameters = $args["parameters"];

        $InputData = $args["InputMethod"];
        $OutputData = $args["OutputMethod"];

        $data = $this->$InputData();

        if (method_exists($this,$OutputData)){ //если метод существует

            $page = $this->$OutputData($data);
            if($page) {
                $this->Page = $page;
            }

        }elseif ($data) {
            $this->Page = $data;
        }

        if ($this->Errors){
            $this->WriteLog($this->Errors);
        }
        $this->GetPage();

    }

    protected function Render($path = "", $parameters = []){

        extract($parameters);

        if (!$path){

            $class = new \ReflectionClass($this);

            $space = str_replace("\\","/",$class->getNamespaceName()."\\");//возвращает namespace класса
            $routes = Settings::Get("routes");

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

    protected function GetPage(){

        if (is_array($this->Page)){ //Если массив
            foreach ($this->Page as $block) echo $block;
        }else{ //Если строка
            echo $this->Page;
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

