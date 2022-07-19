<?php

namespace core\user\controllers;

use core\base\controllers\BaseController;

class IndexController extends BaseController{

    protected $name;

    protected function InputData(){
        $templater = $this->Render(TEMPLATE.'templater');
        return compact('templater');
    }


}