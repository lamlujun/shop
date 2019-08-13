<?php
    namespace app\index\validate;

    use think\Validate;
    class Check extends Validate{
        protected $rule =[
            'username'=>'require|length:3,20|unique:user',
            'password'=> 'require|length:6,20',
            'passAgain'=>'require|checkSame',

        ];
        public function checkSame($value,$rules,$data){
            if($value!==$data['password']){
                return false;
            }
            return true;
            // dump($data);
        }
        //错误信息提示
        protected $message = [
            'passAgain.checkSame' => '密码不一致'
        ];

    }