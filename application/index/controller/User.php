<?php
namespace app\index\controller;
use think\Loader;
use think\File;
class User extends Common
{
    //弹出登录
    public function login2(){
        if (request()->isAjax()) {
            # code...
             // dump(input());
            $postdata = input();
            $model =model('User');
            $res = $model -> checkUser($postdata);
            if($res ===false){
                return json(['code'=>0,'msg'=>$model->getError()]);
            }
            return json(['code'=>1,'msg'=>'ok']);
        }else{
            return $this -> fetch();
        }
    }


    public function register(){
        //判断请求类型
        if(request()->isGet()){
            return $this-> fetch();
        }
        //提交注册表单,检验数据
        $postdata = input();
        $validate = Loader::validate('User');
        $result = $validate->check($postdata);
        // dump($result);
        if(!$result){
            $this->error($validate->getError());
        }
        //检验验证码是否正确
        $obj = new \think\captcha\Captcha();
        if(!$obj -> check($postdata['checkcde'])){
            $this->error('验证码错误');
        }
        // 检验手机验证码,将验证码从session中取出
        $code = session('phone_code');
        //将手机号从session中取出
        $phone_num = session('phone_num');
        // 比对表单数据
        if(!$code || $code['phone_code'] != $postdata['phonecode'] || $postdata['phone'] != $phone_num){
            $this -> error('短信验证码或手机号错误');
        }
        //验证短信验证码是否过期
        if(time()-$code['time']>600){
            $this -> error('短信验证码过期');
        }

        // 调用模型方法添加数据
        $res = model('User')->addUser($postdata);
        if($res===false){
            $this->error('失败');
        }
        //删除cookie中的数据
        cookie('phone_code',null);
        cookie('phone_num',null);
        $this -> success('注册成功','login');
    }

    //ajax发送短信验证码方法
    public function send(){
        // 获取手机号
        $phone = input('phone');
        // 随机生成验证码
        $code = rand(1000,9999);
        // 调用短信验证码方法
        $res = send_msg($phone, [$code,10]);
        if($res===false){
            return json(['code'=>1,'msg'=>'网络异常']);
        }
        // 将发送的验证码存入session
        session('phone_code',['phone_code'=>$code,'time'=>time()]);
        //将手机号存入session
        session('phone_num',$phone);
        return json(['code'=>0,'msg'=>'ok']);
    }

    public function captcha(){
        $obj = new \think\captcha\Captcha(['codeSet'=>'123456','length'=>3]);
        return $obj -> entry();
    }

    //登录界面
    public function login(){
        if(request()->isGet()){
            return $this-> fetch();
        }
        // dump(input());
        $postdata = input();
        $model =model('User');
        $res = $model -> checkUser($postdata);
        if($res ===false){
            $this -> error($model->getError());
        }
       
        // echo 'ok';
        $this->redirect('index/index');

    }

    //退出登录
    public function logout(){
        session('index_info',null);
        $this->redirect('index/index/index');
    }

    //邮箱注册
    public function registerEmail(){
        //判断请求类型
        if(request()->isGet()){
            return $this -> fetch();
        }

         //提交注册表单,检验数据
         $postdata = input();
         $validate = Loader::validate('Check');
         $result = $validate->check($postdata);
         // dump($result);
         if(!$result){
             $this->error($validate->getError());
         }
         //检验验证码是否正确
         $obj = new \think\captcha\Captcha();
         if(!$obj -> check($postdata['checkcde'])){
             $this->error('验证码错误');
         }

        $res = model('User') -> addEmail($postdata);
        if($res === false){
            $this -> error(model('User')->getError());
        }
        $this -> success('注册成功','index/user/login');

    }

    //账号 激活
    public function active(){
        //获取地址栏中key参数的值,并读取缓存
        $key = input('key');
        $active_id = cache($key);
        if(!$active_id){
            return '非法请求';
        }
        // 根据获得的id,修改激活状态
        db('user') -> where('id',$active_id) -> setField('status', 1);
        $this -> success('激活成功','index/user/login');
        //销毁缓存
        cache($key,null);
    }

    //用户信息展示
    public function user(){
        //判断请求类型
        //检查与用户是否登录,强制登录
        $user_id = model('User') ->getUserId();
        if(request()->isGet()){
            if(!$user_id){
                $this -> error('请先登录','index/user/login');
            }
            // 查询用户头像
            $header = db('user_img') -> where(['user_id'=>$user_id,'status'=>1]) -> find();
            // dump($header);
            // 根据id查询用户信息并渲染模板
            $user = db('user') -> where('id',$user_id) -> find();
            $this -> assign('user',$user);
            $this -> assign('head',$header);
            // dump($user);exit;
            return $this -> fetch();
        }
        // 提交用户修改信息
        $msg = input();
        // dump($msg);
        // 修改昵称
        db('user') -> where('id',$user_id) -> setField('nickname', $msg['nickname']);

        $header=[];
        // 处理用户上传的头像
        $this -> uploadHeader($header);
        $header['user_id'] = $user_id;
        // dump($header);
        // 将其他的使用状态改为0
        db('user_img') ->where('user_id',$user_id) -> setField('status', 0);
        // 将头像数据入库   
        db('user_img') -> insert($header);
        $this->success('修改成功');
    }


    // 处理头像
    public function uploadHeader(&$header){
        $file = request()->file('photo');
        // dump($file);
        // 存储文件原图
        // 计算存储目录
        $upload_root = config('upload_root').'/header';
        $info = $file->validate(['ext'=>'jpg,png,bmp'])->move($upload_root);
        //获取文件存放地址
        $path = $info -> getpathName();
        // // 获取文件名
        $filename = $info -> getFilename();
        // //将地址中的\转换成/再存入$postdata数据中
        $header['user_img'] = str_replace('\\','/',$path);
        
        //使用image打开上传的文件并生成缩略图
        // 获取图片对象
        $img = \think\Image::open($header['user_img']);
        // // 计算缩略图存储地址
        $header['user_thumb'] = $upload_root. '/' .date('Ymd').'/thumb_'.$filename;
        // 存储缩略图
        $img -> thumb(100,100) -> save($header['user_thumb']);
    }



    //用户头像展示
    public function userheader(){
        // 获取用户id
        $user_id = model('User') ->getUserId();
        $tmp_name = $_FILES['myFile']['tmp_name'];
        // return $tmp_name;
        $current_time = date("Ymd").''.mt_rand(1000,9999);
        
        
        if(is_uploaded_file($tmp_name)){
            //文件保存地址
            $filename = config('upload_root').'/header/'.$current_time.'.jpg';

            $return = move_uploaded_file($tmp_name,$filename);
            $sql_file = '/'.$filename;
            // 将数据存入数据库
            return  $sql_file;
        }

    }


}