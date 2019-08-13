<?php
    namespace app\admin\controller;
    use think\Request;

    class Type extends Common{
        //类型列表
        public function index(){
            $list = model('Type') -> showIndex();
            $this -> assign('list',$list);
            return $this -> fetch();
        }
        //新增页面
        public function add(){
            if(request()->isGet()){
                return $this -> fetch();
            }
            $type = input();
            $result = $this -> validate($type,'Type');
            if($result !==true){
                $this -> error($result);
            }
            $res = model('Type')->add($type);
            if(!$res){
                $this->error(model("Type")->getError());
            }
            $this -> success('ok');
        }

        
    }