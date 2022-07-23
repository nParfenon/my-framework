<?php

namespace core\user\controllers;

use core\base\controllers\BaseController;

class IndexController extends BaseController{

    protected $name;

    protected function InputData(){
        $name = '123';
        return $this->render(TEMPLATE.'templater', compact('name'));
    }


}