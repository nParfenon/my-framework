<?php

namespace core\admin\controllers;

use core\base\controllers\BaseController;
use core\admin\models\Models;
use core\base\settings\Settings;

class IndexController extends BaseController
{

    /**
    $select = $db->get('products',[
        'fields'            => ['*'],
        'where'             => ['id' => 1, 'name' => 'Телефон'],
        'operand'           => ['='],
        'condition'         => ['AND'],
        'order'             => ['name'],
        'order_direction'   => ['DESC'],
        'limit'             => 1,
        'join' => [
            'join_table1' => [
                'table'     => 'join_table1',
                'fields'    => ['id as j_id', 'name as j_name'],
                'type'      => 'left',
                'where'     => ['name' => 'Компьютер'],
                'operand'   => ['='],
                'condition' => ['AND'],
                'on'        => [
                    'table'     => 'products', //по дефолту предыдущая таблица
                    'fields'    => ['id', 'parent_id']
                ]
            ],
            'join_table2' => [
                'table'     => 'join_table2',
                'fields'    => ['id as j2_id', 'name as j2_name'],
                'type'      => 'left',
                'where'     => ['name' => 'Компьютер'],
                'operand'   => ['='],
                'condition' => ['AND'],
                'on'        => [
                    'table'     => 'products', //по дефолту предыдущая табдица
                    'fields'    => ['id', 'parent_id']
                ]
            ]
        ]
    ]);
     */
    protected function InputData(){
        $db = Models::instance();

        $select = $db->get('products',[
            'fields'            => ['*'],
            'where'             => ['id' => 1, 'name' => 'Телефон'],
            'operand'           => ['='],
            'condition'         => ['AND'],
            'order'             => ['name'],
            'order_direction'   => ['DESC'],
            'limit'             => 1,
            'join' => [
                'join_table1' => [
                    'table'     => 'join_table1',
                    'fields'    => ['id as j_id', 'name as j_name'],
                    'type'      => 'left',
                    'where'     => ['name' => 'Компьютер'],
                    'operand'   => ['='],
                    'condition' => ['AND'],
                    'on'        => [
                        'table'     => 'products', //по дефолту предыдущая таблица
                        'fields'    => ['id', 'parent_id']
                    ]
                ],
                'join_table2' => [
                    'table'     => 'join_table2',
                    'fields'    => ['id as j2_id', 'name as j2_name'],
                    'type'      => 'left',
                    'where'     => ['name' => 'Компьютер'],
                    'operand'   => ['='],
                    'condition' => ['AND'],
                    'on'        => [
                        'table'     => 'products', //по дефолту предыдущая табдица
                        'fields'    => ['id', 'parent_id']
                    ]
                ]
            ]
        ]);
        print_r($select);
        die();

       // exit();

    }
}