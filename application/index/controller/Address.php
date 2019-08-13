<?php
namespace app\index\controller;

class Address extends Common
{   
    public function address(){
        //判断请求类型
        if(request()->isGet()){
            // 查询地址数据,渲染模板
            $address = db('address') -> limit(3) -> order('default_address','desc') -> select();
            $this -> assign('addr',$address);
            return $this -> fetch();
        }
        //判断用户是否登录,强制登录
        $user_id = model('User') -> getUserId();
        if(!$user_id){
            //无登录无法添加地址
            $this -> error('没有登录无法添加地址','index/user/login');
        }
        $locaData = input();
        //用户id
        $locaData['user_id'] = $user_id;
        //添加时间
        $locaData['addtime'] = time();
        $locaData['default_address'] = (int)$locaData['default_address'];
        // dump($locaData);
        // 调用模型将数据存入数据库
        $res = model('Address')->add($locaData);
        if($res===false){
            $this -> error(model('Address')->getError());
        }
        $this -> success('添加成功');

    }
    //修改地址
    public function default(){
        // 接收id
        $defult_id = input('id/d',0);
        // 将所有地址默认字段改为0
        db('address') -> where('default_address',1) -> update(['default_address'=>0]);
        db('address') -> where(['id'=>$defult_id]) -> update(['default_address'=>1]);
        $this->success('设置成功','address','',1);
    }

    //结算页面添加地址
    public function payAdd(){
        $add = input();
        $add['addtime'] = time();
        $user_id = model('User') -> getUserId();
        $add['user_id'] = $user_id;
        //将地址入库
        $res = model('Address')->payAddress($add);
        return $res;
    }
}