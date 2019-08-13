<?php
namespace app\index\controller;

class Goods extends Common
{
    public function detail(){
        // 根据id查询商品数据
        $goods_id = input('id/d');
        $goods_info = model('Goods')->getGoodsInfo($goods_id);
        if($goods_info===false){
            $this->redirect('index/index/index');
        }
        $this->assign('goods',$goods_info);
        return $this -> fetch();
    }

    public function list(){
        //接收分类id
        $cate_id = input('cate_id/d');
        $page=input('page/d');
        // 查询当前分类下的所有子分类
        $cate = model('Category')->getCate();
        $data = get_tree($cate,$cate_id);
        $res= [];
        $id = [];
        //遍历子分类,取出id
        foreach($data as $key => $value){
            $id[] = $value['id'];
        }
        $id[] =$cate_id;
        // 根据id查询数据库中的商品信息
        $res[] = db('goods') -> where('cate_id','in',$id) ->page("$page,8") ->select();
        //数据总数
        $count = db('goods') -> where('cate_id','in',$id) -> count();
        
        //计算页数
        $pagenum = ceil($count/8);
        
        $this -> assign('data',$res);
        $this -> assign('page',$page);
        $this -> assign('cate_id',$cate_id);
        $this -> assign('toPage',$pagenum);
        return $this -> fetch();
        // dump($res);
    }


    public function ajaxList(){
        $page = input('page/d');
        $cate_id = input('cate_id/d');
        // $this -> list($page);
        // dump($cate_id);
        // 查询当前分类下的所有子分类
        $cate = model('Category')->getCate();
        $data = get_tree($cate,$cate_id);
        $id = [];
        //遍历子分类,取出id
        foreach($data as $key => $value){
            $id[] = $value['id'];
        }
        $id[] =$cate_id;
        // 根据id查询数据库中的商品信息
        $res = db('goods') -> where('cate_id','in',$id) ->page("$page,8") ->select();
        //数据总数
        $count = db('goods') -> where('cate_id','in',$id) -> count();
        
        //计算页数
        $pagenum = ceil($count/8);

        $ajax1['goods'] = $res;
        
        // $ajax1['count'] = $count;
        
        // $ajax1['pagenum'] = $pagenum;
        
        return json(['code'=>1,"data"=>$ajax1]);
        // dump($ajax1);

    }


   
}