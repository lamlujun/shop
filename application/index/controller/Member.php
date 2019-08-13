<?php
    namespace app\index\controller;
    class Member extends Common{
        public function index(){

            $model = model('Sign');
            $res = $model -> signin();
            if($res === false){
                return json(['code'=>1,'msg'=>$model->getError()]);
            }
            return json(['code'=>0,'msg'=>'ok']);

           
        }
    }