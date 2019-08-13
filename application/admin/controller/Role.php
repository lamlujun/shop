<?php
    namespace app\admin\controller;
    class Role extends Common{
        //显示添加角色页面
        public function add(){
            if(request()->isGet()){
                return $this -> fetch();
            }
            $model = model('Role');
            //角色名称入库
            $model->save(input());
            $this->success('新增成功');
        }
        
        //显示角色列表
        public function index(){
            $list = db('role')->select();
            $this -> assign('list',$list);
            return $this -> fetch();

        }
        
        public function disfetch(){
             // 获取分配权限的id
             $r_id = input("id/d");
            if(request()->isGet()){
                //显示用户已有的权限信息
                $role_info = db('role')->find($r_id);
                $this -> assign('role_info',$role_info);
                //查询所有权限
                $priv = model("Privilege")->all();
                $this -> assign("priv", $priv);
                return $this -> fetch();
            }
            //获取rule中的CheckBox值
            $rules = input('rule/a');
            // 使用 逗号 分隔数组,变成字符串
            $rules = implode(',',$rules);

            // 将数据存入权限表中的p_ids字段
            db('role')->where('id',$r_id)->setField('p_ids',$rules);
            $this -> success('ok');
        }
    }