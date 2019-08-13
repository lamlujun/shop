<?php
namespace app\index\controller;

class Index extends Common
{
    public function index()
    {
        $data['is_res'] = model('Category') -> getRecGoods('is_res');
        $data['is_new'] = model('Category') -> getRecGoods('is_new');
        $data['is_hot'] = model('Category') -> getRecGoods('is_hot');
        $this -> assign('is_index',1);
        $this -> assign('data',$data);
        
        // 显示楼层数据
        $floor = model('Goods') -> getFloor();
        $this -> assign('floor',$floor);

        return $this-> fetch();
    }
    public function test(){
        return $this -> fetch();
        // $check = input();

    }
}
