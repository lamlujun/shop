<?php
    namespace app\admin\validate;
    class Type extends Common{
        protected $rule = [
            'type_name|类型名称' => 'require|unique:type'
        ];
        

    }