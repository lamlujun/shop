<?php
    namespace app\admin\controller;
    
    class Attribute extends Common{
        //属性列表
        public function index(){
            $data = model('Attribute') -> showIndex();
            $this -> assign('data',$data);
            return $this -> fetch();
        }
        //添加属性页面
        public function add(){
            if(request()->isGet()){
                //查询所有类型,并渲染模板
                $type = model('Type') -> showIndex();
                $this -> assign('type',$type);
                return $this -> fetch();
            }
            $postdata = input();
            // 验证数据
            $result = $this -> validate($postdata,'Attribute');
            // $model -> addAttr(input());
            if($result !== true){
                $this-> error($result);
            }
            //调用模型方法
            $model = model('Attribute');
            $res = $model -> addAttr($postdata);
            if($res===false){
                $this -> error($model->getError());
            }
            $this -> success('ok','','',1);
        }
    }