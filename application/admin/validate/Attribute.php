<?php
    namespace app\admin\validate;

    class Attribute extends Common{
        protected $rule = [
            'attr_name|属性名称' => 'require',
        ];
    }