<?php
    namespace app\admin\controller;
    use think\Controller;
    class Common extends Controller{
        //保存用户信息
        public $user =[];
        public function __construct(){
            parent::__construct();
            //判断登录时是否有用户数据
            // 判断用户信息是否在cookie内
            $user_info = cookie('user_info');
            if(!$user_info){
                $this -> error('请先登陆','login/login');
            }
            //用户已登录,将数据存进用户信息
            $this -> user = $user_info;
            //根据角色id查询权限
            if($this -> user['role_id'] == 1){
                // 如果角色id为1,为超级管理员,则拥有所有权限
                $privilege = db('privilege') -> select();
            }else{
                //普通用户
                //获取角色拥有的权限id
                $role_info = db('role') -> where(['id'=> $user_info['role_id']]) -> find();
                // dump($role_info);
                // 查询该角色拥有的权限
                $privilege = db('privilege') -> where('id','in',$role_info['p_ids']) -> select();
            }
            //对数据进行格式化
            foreach($privilege as $key => $value){
                //使用user属性中privilege元素保存用户角色对应的权限信息
                $this -> user['privilege'][] = strtolower($value['controller_name'].'/'.$value['action_name']);
                //判断是否在左侧栏导航栏中显示
                if($value['is_show']==1){
                    $this -> user['menus'][] = $value;
                }
            }
            // dump($this->user['menus']);exit;
            //验证访问权限
            // 判断当前用户是超级管理员还是普通用户
            if($this -> user['role_id'] != 1){
                //所有用户都可以使用首页
                $this->user['privilege'][] = 'index/index';
                $this->user['privilege'][] = 'index/top';
                $this->user['privilege'][] = 'index/main';
                $this->user['privilege'][] = 'index/menu';
                //普通用户需要验证权限
                $request = request();
                // 获取用户访问的地址
                $path_info = strtolower($request->controller().'/'.$request->action());
                // dump($path_info);
                // 判断用户访问的地址是否在权限地址内
                if(!in_array($path_info,$this->user['privilege'])){
                    if($request->isAjax()){
                        echo json_encode(['code'=>0,'msg'=>'权限不足']);exit;
                    }else{
                        $this->error('权限不足','index/main');
                    }
                }

            }
        }
    }