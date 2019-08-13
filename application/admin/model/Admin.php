<?php
    namespace app\admin\model;
    use think\Db;
    class Admin extends Common
    {
        public function login($postdata)
        {
          
            // 检查账号密码
            $where = [
                'username'=>$postdata['username'],
                'password'=>md5($postdata['password'])
            ];
            $user_info = $this -> get($where);
            if(!$user_info){
                $this -> error = '账号密码错误';
                return false;
            }
            // 检查验证码
            $obj = new \think\captcha\Captcha;
            if(!$obj -> check($postdata['captcha'])){
                $this -> error ='验证码错误';
                return false;
            }
            //检查是否保存用户数据
            $time = 0;
            if($postdata['remember']==1){
                $time = 3600;
            }
            //保存用户数据
            cookie("user_info",$user_info->toArray(),$time);
        }

        //添加后台用户
        public function addUser($user){
            // 验证用户名不唯一
            if($this->get(['username'=>$user['username']])){
                $this -> error = '用户名重复';
                return false;
            }

            // 加密密码
            $user['password'] = md5($user['password']);
            // 数据入库
            $this -> save($user);
        }
    }