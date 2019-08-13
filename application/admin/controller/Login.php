<?php
    namespace app\admin\controller;
    use think\Controller;
    class Login extends Controller{
        //显示验证码
        public function captcha(){
            $obj = new \think\captcha\Captcha(['length'=>"3",'codeSet'=>'123456789']);
            return $obj -> entry();
        }
        //显示登陆表单
        public function login(){
            if(request()->isGet()){
                return $this -> fetch();
            }            
        }

        //ajax登陆验证
        public function dologin(){
            $postdata = input();
            $model = model('Admin');
            $res = $model -> login($postdata);
            if($res === false){
                return json(['code'=>0,'msg'=>$model->getError()]);
            }
            return json(['code'=>1,'msg'=>'登陆成功']);
        }

        //退出
        public function logout(){
            cookie('user_info',null);
            $this-> success('退出成功','login');
        }
    }