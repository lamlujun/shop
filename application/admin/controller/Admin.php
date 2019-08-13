<?php
    namespace app\admin\controller;
    class Admin extends Common{
        //添加管理员页面
        public function add(){
            if(request()->isGet()){
                // 查询所有的角色
                $role = db('role') ->select();
                $this -> assign('role',$role);
                return $this->fetch();
            }
            // 添加管理员
            $user = input();
            $res = model('Admin')->addUser($user);
            if($res === false){
                $this-> error('添加管理员失败');
            }
            $this->success('入库成功');
        }
        //管理员列表
        public function index(){
            // 查询用户名,角色
            $list = db('admin') -> alias('a') -> field('a.*,b.role_name') -> join('role b','a.role_id=b.id','left') ->select();
            $this -> assign('list',$list);
            return $this -> fetch();
            // echo $sql;
        }
    }