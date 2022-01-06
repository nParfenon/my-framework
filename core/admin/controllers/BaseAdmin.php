<?php


namespace core\admin\controllers;


use core\admin\models\Models;
use core\base\controllers\BaseController;
use core\base\exceptions\RouteException;
use core\base\settings\Settings;

abstract class BaseAdmin extends BaseController
{

    protected $model;

    protected $table;
    protected $columns;
    protected $data;

    protected $AdminPath;

    protected $template;
    protected $menu; //меню админки
    protected $title;

    protected function InputData(){

        $this->init(true);

        $this->title = "VG engine";

        if (!$this->model){
            $this->model = Models::instance();
        }
        if (!$this->menu){
            $this->menu = Settings::Get("projectTables");
        }
        if (!$this->AdminPath){
            $this->AdminPath = PATH . Settings::Get("routes")["admin"]["alias"] . "/";
        }

        $this->sendNoCacheHeaders();

    }

    protected function OutputData(){

        $this->header = $this->render(ADMIN_TEMPLATE . "include/header");
        $this->footer = $this->render(ADMIN_TEMPLATE . "include/footer");

        return $this->render(ADMIN_TEMPLATE . "layout/default");

    }

    protected function sendNoCacheHeaders(){

        header("Last-Modified: " . gmdate("D, d m Y H:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: max-age=0");
        header("Cache-Control: post-check=0,pre-check=0");

    }

    protected function execBase(){
        self::InputData();
    }

    protected function createTableData(){

        if (!$this->table){

            if ($this->parameters){
                $this->table = array_keys($this->parameters)[0];
            }else{
                $this->table = Settings::Get("defaultTable");
            }

        }

        $this->columns = $this->model->showColumns($this->table);

        if (!$this->columns){
            new RouteException("Не найдены поля таблице - " . $this->table,2);
        }

        //exit();

    }

    protected function expansion($args = [], $settings = false){

        $filename = explode("_",$this->table);
        $className = "";

        foreach ($filename as $item){
            $className .= ucfirst($item);
        }

        if (!$settings){
            $path = Settings::Get("expansion");
        }elseif(is_object($settings)){
            $path= $settings::Get("expansion");
        }else{
            $path = $settings;
        }

        $class = $path . $className . "Expansion";

        if (is_readable($_SERVER["DOCUMENT_ROOT"] . PATH . $class . ".php")){

            $class = str_replace("/","\\",$class);

            $exp = $class::instance();

            foreach($this as $name => $value){
                $exp->$name = &$this->$name; //& - ссылка
            }

            return $exp->expansion($args);

        }else{

            $file = $_SERVER["DOCUMENT_ROOT"] . PATH . $path . $this->table . ".php";
            var_dump($path);
            extract($args);

            if (is_readable($file)) {return include $file;}

        }

        return false;

    }

}