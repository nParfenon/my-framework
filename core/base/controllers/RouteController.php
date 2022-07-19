<?php

namespace core\base\controllers;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

class RouteController extends BaseController
{
    use SingleTon;

    protected $routes;

    private function __construct()
    {
        $address_str = $_SERVER['REQUEST_URI']; //получение ссылки (глав. ссылка не в счет)

        $path = substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'], "index.php"));

        if ($path === PATH){

            if (strrpos($address_str, "/") === strlen($address_str) - 1 &&
                strrpos($address_str, "/") !== strlen(PATH) - 1){ //если в конце ссылки есть знак - "/"

                $this->redirect(rtrim($address_str,"/"), 301);
            }

            $this->routes = Settings::Get("routes");

            if (!$this->routes){throw new RouteException("Отсутсвуют маршруты в базовых нстройках", 1);}//если маршруты не были получены

            $url = explode("/", substr($address_str, strlen(PATH))); //разбиваем строку занося элементы в массив

            if ($url[0] && $url[0] === $this->routes['admin']['alias']){ //если введен /admin в поиск.строку

                array_shift($url); //извлекаем 1 элемент так как это админ панель

                if ($url[0] && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . $this->routes['plugins']['path'] . $url[0])){ //проверка на плагин

                    $plugins = array_shift($url); //хранится сам плагин (пример - Shop);

                    $pluginsSettings = $this->routes['settings']['path'] . ucfirst($plugins . "Settings"); //файл настроек для плагина (пример - ShopSettings)

                    if(file_exists($_SERVER['DOCUMENT_ROOT'] . PATH . $pluginsSettings . ".php" )){
                        $pluginsSettings = str_replace("/","\\", $pluginsSettings);

                        $this->routes = $pluginsSettings::Get('routes');
                    }

                    $dir = $this->routes["plugins"]['dir'] ? "/". $this->routes["plugins"]['dir'] ."/" : "/"; //$dir создан для удобства строения директорий (по сути не нужен)
                    $dir = str_replace("//", "/", $dir);

                    $this->controller = $this->routes["plugins"]['path'] . $plugins . $dir;

                    $hrUrl = $this->routes['plugins']['hrUrl'];

                    $route = "plugins";

                }
                else{
                    $this->controller = $this->routes['admin']['path'];

                    $hrUrl = $this->routes['admin']['hrUrl'];

                    $route = "admin";
                }

            }

            else{
                $hrUrl = $this->routes['user']['hrUrl'];

                $this->controller = $this->routes['user']['path'];

                $route = "user";
            }

            $this->creatRoute($route,$url);

            if ($url[1]){

                $count = count($url);
                $key = "";

                if (!$hrUrl){
                    $i = 1;
                }
                else{
                    $this->parameters['alias'] = $url[1];
                    $i = 2;
                }

                for ( ; $i < $count; $i++){
                    if (!$key){
                        $key = $url[$i];
                        $this->parameters[$key] = "";

                    }
                    else{
                        $this->parameters[$key] =$url[$i];
                        $key = "";
                    }
                }

            }

        }
        else{

            throw new RouteException("Не корректная директория файла PATH",1);

        }
    }

    private function creatRoute($var, $arr){

        $route = [];

        if (!empty($arr[0])){
            if ($this->routes[$var]['routes'][$arr[0]]){

                $route = explode("/", $this->routes[$var]['routes'][$arr[0]]);

                $this->controller .= ucfirst($route[0]."Controller") ;
            }
            else{
                $this->controller .= ucfirst($arr[0]."Controller");
            }
        }
        else{
            $this->controller .= $this->routes['default']['controller'];
        }


        $this->InputMethod = $route[1] ? $route[1] : $this->routes['default']['InputMethod'];
        $this->OutputMethod = $route[2] ? $route[2] : $this->routes['default']['OutputMethod'];

        return;
    }

}

