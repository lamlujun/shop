<?php
    namespace app\admin\controller;
    class Privilege extends Common{
        //显示添加权限页面
        public function add(){
            $model = model('Privilege');
            if(request()->isGet()){
                // 查询所有权限
                $privilege = $model -> getCateTree();
                // dump($privilege);
                $this-> assign('priv',$privilege);
                return $this -> fetch();
            }
            //添加权限
            $res = $model-> save(input());
            if($res===false){
                $this -> error($model->getError());
            }
            $this-> success('新增成功');
        }
        //显示权限列表
        public function index(){
            //查询所有权限信息
            $model = model('Privilege');
            $privilege = $model -> getCateTree();
            $this-> assign('priv',$privilege);
            return $this -> fetch();
        }
    }