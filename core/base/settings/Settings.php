<?php


namespace core\base\settings;


use core\base\controllers\SingleTon;

class Settings
{
    use SingleTon;

    private $routes = [
        "admin" => [
            "alias" => "admin",
            "path" => "core/admin/controllers/",
            "hrUrl"=> false, //удобное оформление ссылок
            "routes"=>[]
        ],

        "settings" => [ //настройки нашего сайта
            "path" => "core/base/settings/"
        ],

        "plugins" => [
            "path" => "core/plugins/",
            "hrUrl"=> false,
            "dir" => ""
        ],

        "user" => [
            "path" => "core/user/controllers/", //namespace :)
            "hrUrl"=> true,
            "routes" => [
                "site" => "ikkdex/hello/eee"
            ]
        ],

        "default" => [ //настройки по умолчания
            "controller" => "IndexController", //контроллер по умолчанию
            "InputMethod"=> "InputData", //метод по умолчанию
            "OutputMethod" => "OutputData" // одтает данные в польз. шаблоны
        ],
    ];

    private  $expansion = "core/admin/expansion/";

    private $defaultTable = "teachers";

    private $projectTables = [
        "teachers" => ["name" => "Учителя", "img" => "pages.png"],
        "students" => ["name" => "Ученики"]
    ];

    private $templateArr = [ // Общие поля
        "text" => ["name","phone","address"],
        "textarea" => ["content","keywords"]
    ];

    static public function Get($property){ //Получение свойств класса
        return self::instance()->$property;
    }

    public function ClueProperties($class){ //Склейка массивов

        foreach ($this as $name => $item){

            $property = $class::Get($name);

            if (!$property) $baseProperties[$name] = $this->$name;

            if  (is_array($property) && is_array($item)){

                $baseProperties[$name] = $this->arrayMergeRecursive($this->$name,$property);
                continue;
            }

        }
        return $baseProperties;
    }

    public function arrayMergeRecursive() //5
    {
       $arrays = func_get_args();

       $base = array_shift($arrays);

       foreach ($arrays as $array){

           foreach ($array as $key => $value){

                if (is_array($value) && is_array($base[$key]) )
                {
                    $base[$key] = $this->arrayMergeRecursive($base[$key],$value);

                }else{

                    if (is_int($key)) {

                        if (!in_array($value, $base)) {

                            array_push($base, $value);
                            continue;
                        }
                    }
                    $base[$key] = $value;
                }
           }
       }
       return $base;
    }

}

