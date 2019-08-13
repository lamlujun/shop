<?php
    namespace app\admin\model;
    use think\Db;

    class Type extends Common{
        //新增类型
        public function add($type){
            return $this->allowField(true)->save($type);
        }
    }