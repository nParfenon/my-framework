<?php

namespace core\admin\controllers;

use core\base\controllers\BaseController;
use core\admin\models\Models;
use core\base\settings\Settings;

class IndexController extends BaseController
{
    protected function InputData(){

        $redirect = PATH. Settings::Get("routes")["admin"]["alias"]."/show";

        $this->redirect($redirect);

       // exit();

    }
}