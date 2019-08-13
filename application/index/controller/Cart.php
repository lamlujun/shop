<?php
namespace app\index\controller;

class Cart extends Common
{
    public function addCart(){
        // 接收参数
        //商品ID 
        $goods_id = input('goods_id/d',0);
        //购买数量
        $goods_count = input('goods_conut/d',0);
        //商品属性集合,接收到为一个数组
        $goods_attr_ids = input('attr_ids/a',[]);
        // 将商品属性数组转换成字符串
        $goods_attr_ids = implode(',' ,$goods_attr_ids);

        // 调用模型方法,将数据存入数据库
        $res = model('Cart') -> addCart($goods_id, $goods_attr_ids, $goods_count);
        if($res === false){
            $this -> error(model('Cart')->getError());
        }
        $this -> success('加入购物车成功','index/cart/index');
    }
    public function index(){
        //调用模型方法获取购物车数据
        $data = model('Cart') -> showIndex();   
        //获取总价格
        $total = model('Cart') -> total($data);
        $this -> assign('total',$total);
        $this -> assign('data',$data);
        return $this -> fetch();
    }
    public function del(){
        //接收要删除的数据参数
        $deldata = input();
        // 调用模型方法删除数据
        $res = model('Cart') -> remove($deldata);
        if($res===false){
            $this->error(model('Cart')->getError());
        }
        $this->success('删除成功');
    }
    public function changeCount(){
        // 接收ajax请求的参数
        $data = input();
        // return $data['goods_count'];
        // return json(['code'=>$data]);

        //调用模型方法
        $res = model('Cart') -> changeCount($data);
        if($res===false){
            return json(['code'=>0,'msg'=>model('Cart')->getError()]);
        }
        return json(['code'=>1,'msg'=>'ok']);
    }


}