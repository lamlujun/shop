<?php
    namespace app\index\model;
    class User extends Common{
        //获取用户id
        public function getUserId(){
            $user_info = session('index_info');
            if($user_info){
                //如果有数据,返回id值,没有数据返回false
                return $user_info['id'];
            }
            return false;
        }
        public function addUser($postdata){
            // dump($postdata);
            // 生成盐值            
            $salt = mt_rand(100000,999999);
            $postdata['salt'] =$salt;
            // 加密密码
            $postdata['password'] = md5(md5($postdata['password']).$salt);
            $postdata['status'] = 1;
            //数据入库
            $this->allowField(TRUE)->save($postdata);
        }
        public function checkUser($postdata){
            // dump($postdata);
            $user = $this -> where('username',$postdata['username'])->whereOr('phone',$postdata['username'])->whereOr('email',$postdata['username'])->find();
            if(!$user){
                $this -> error = '用户名错误';
                return false;
            }
            if($user['status']==0){
                $this -> error = '账号未激活';
                return false;
            }
            $salt = $user['salt'];
            // 密码加密,与数据库密码比较
            $postdata['password'] = md5(md5($postdata['password']).$salt);
            if($postdata['password']!=$user['password']){
                $this -> error = '密码错误';
                return false;
            }

            //验证码设置
            $obj = new \think\captcha\Captcha();
            if(!$obj -> check($postdata['checkcode'])){
                $this -> error = '验证码错误';
                return false;
            }
            
            //判断是否保存用户数据
            // if(!empty($postdata['save'])){
            session('index_info',$user);
            // }
            //将cookie中的购物车数据存入数据库
            model('Cart')->cookieToDb();
        }
        
        //邮箱注册
        public function addEmail($postdata){
            // 生成盐值            
            $salt = mt_rand(100000,999999);
            $postdata['salt'] =$salt;
            // 加密密码
            $postdata['password'] = md5(md5($postdata['password']).$salt);
            //数据入库
            $this->allowField(TRUE)->save($postdata);

            //发送邮件激活
            //生成随机码
            $active_code = uniqid();
            //组装链接
            $href = url('index/user/active','key='.$active_code,true,true);
            //使用缓存保存用户数据
            cache($active_code,$this->getLastInsId());

            //发送内容
            $content = "<a href='$href'>点击访问激活账号</a>";
            $title = '京西商城';
            send_email($title, $content, $postdata['email']);
        }
    }