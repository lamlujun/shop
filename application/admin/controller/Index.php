<?php
    namespace app\admin\controller;
    
    // 使用view类
    use think\View;

    class Index extends Common{
        public function index(){
            return $this -> fetch();
        }
        public function main(){
            return $this -> fetch();
        }
        public function top(){
            return $this -> fetch();
        }
        public function menu(){
            $this -> assign('priv',$this->user['menus']);
            return $this -> fetch();
        }
    }