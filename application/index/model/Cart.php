<?php
namespace app\index\model;
class Cart extends Common{
    public function addCart($goods_id,$goods_attr_ids,$goods_count){
        //判断商品库存
        if(model('Goods')->checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids)===false){
            $this -> error = '库存不足';
            return false;
        }
        //判断用户是否登录,如果登录 ,获取用户id 将数据存入数据库,没有登录将购物车数据存入cookie
        $user_id =model('User') -> getUserId();
        if($user_id){
            //用户已登录
            //判断购物车是否有相同的商品,如果没有,追加数据,如果有,增加数量
            $map = [
                'goods_id'=>$goods_id,
                'goods_attr_ids' => $goods_attr_ids,
                'user_id' => $user_id
            ];
            $data = $this -> where($map) -> find();
            //数据存在,增加数量
            if($data){
                $this->where($map)->setInc('goods_count',$goods_count);
            }else{
                //数据不存在,追加数据
                $map['goods_count'] = $goods_count;
                $this->insert($map);
            }
            return true;
        }
        // echo '未登录';
        //未登录,将数据存入cookie  
        //判断cookie中是否有相同商品,没有追加,有则添加数量
        $cart_info = cookie('cart_info')?cookie('cart_info'):[];
        // 组装数组下标
        $key = $goods_id .'-'. $goods_attr_ids;
        // 判断数据是否存在
        if(!array_key_exists($key,$cart_info)){
            // 不存在则追加数据
            $cart_info[$key] = $goods_count;
        }else{
            // 存在添加数量
            $cart_info[$key] +=$goods_count;
        }
        // 将数据存入cookie
        cookie('cart_info',$cart_info,3600*24*7);
    }
    
    public function showIndex(){
        // 判断用户是否登录
        $user_id =model('User') -> getUserId();
        $list = [];
        if($user_id){
            //用户已登录,查询数据库信息
            $list = $this->where(['user_id'=>$user_id])->select();
            // dump($list);
        }else{
            // 用户未登录,查询cookie信息
            $cart_info = cookie("cart_info")?cookie("cart_info"):[];
            // dump($list);
            // 格式化cookie信息
            foreach($cart_info as $key => $value){
                //将$key使用 - 分隔
                $key = explode('-',$key);
                $list[] = [
                    'goods_id'=>$key[0],
                    'goods_count'=>$value,
                    'goods_attr_ids'=>$key[1]
                ];
            }
        }
        // dump($list);
        // 遍历$list
        foreach($list as $key => $value){
            //根据商品id查询商品数据
            $list[$key]['goods_info'] = db('goods')->find($value['goods_id']);
            //查询属性数据
            $list[$key]['attrs'] = db('attribute') -> alias('a') -> join('eshop_goods_attr b', 'a.id=b.attr_id', 'left') -> field('a.attr_name,b.attr_value') -> where('b.id','in',$value['goods_attr_ids']) -> select();
            // $list[$key]['attrs'] = db('goods_attr') -> alias('a') -> join('shop_attribute b', 'a.attr_id=b.id', 'left') -> field('b.attr_name,a.attr_value') -> where('a.id','in',$value['goods_attr_ids']) -> select();
        }
        // dump($list);
        return $list;
    }
    
    //计算总金额
    public function total($data){
        $total = 0;
        foreach($data as $value){
            $total += $value['goods_count']*$value['goods_info']['shop_price'];
        }
        return $total;
    }

    //删除购物车商品
    public function remove($deldata){
        // 判断用户登录,没有登录删除cookie,登录删除数据库
        $user_id =model('User') -> getUserId();
        if($user_id){
            //用户已登录
            // 组装条件
            $map = [
                'goods_id' => $deldata['id'],
                'user_id' => $user_id,
                'goods_attr_ids' => $deldata['ids']
            ];
            $res = $this -> where($map) ->delete();
            if(!$res){
                $this -> error ='删除失败';
                return false;
            }
            return true;
        }
        //用户无登录,删除cookie,先获取cookie中的数据
        $cart_info = cookie('cart_info') ? cookie('cart_info') :[];
        // dump($cart_info);
        // 根据cookie数组格式拼接数据
        $key = $deldata['id'].'-'.$deldata['ids'];
        // dump($key);
        // 判断数组是否有相同的索引
        if(array_key_exists($key,$cart_info)){
            unset($cart_info[$key]);
        }
        //将新数据存入cookie
        cookie('cart_info',$cart_info);
    }

    //修改购物车商品数量
    public function changeCount($data){
        // 判断用户登录
        $user_id =model('User') -> getUserId();
        if($user_id){
            //用户已登录,修改数据库数量
            $map = [
                'goods_id'=>$data['goods_id'],
                'user_id' =>$user_id,
                'goods_attr_ids' => $data['goods_attr_ids']
            ];
            db('cart')->where($map)->setField('goods_count',$data['goods_count']);
            return true;
        }
        //用户未登录
        //取出cookie数据
        $cart_info = cookie('cart_info');
        // 组装下标
        $key = $data['goods_id'] .'-'. $data['goods_attr_ids'];
        //修改数量
        $cart_info[$key] = $data['goods_count'];
        // 保存cookieshuju
        cookie("cart_info",$cart_info);
    }
    //将cookie中的购物车数据存入数据库
    public function cookieToDb(){
        // 取出cookie中的数据
        $cart_info = cookie('cart_info')?cookie('cart_info'):[];
        //获取用户id
        $user_id =model('User') -> getUserId();
        if(!$user_id){
            return false;
        }
        //遍历数据
        foreach($cart_info as $key => $value){
            $tmp = explode('-',$key);
            $map =[
                'goods_id'=>$tmp[0],
                'user_id' =>$user_id,
                'goods_attr_ids'=>$tmp[1],
            ];
            // dump($map);
            // 判断数据库中是否有相同商品,如果有则增加数量,没有则追加数据
            if($this->where($map)->find()){
                $this->where($map)->setField('goods_count', $value);
            }else{
                //追加数据
                $map['goods_count']=$value;
                $this->insert($map);
            }
        }
        // 销毁cookie数据
        cookie('cart_info',null);
    }

    //下单完成删除该用户数据库数据
    public function clear(){
        //获取用户id
        $user_id =model('User') -> getUserId();
        if($user_id){
            $this -> where('user_id',$user_id) -> delete();
        }else{
            cookie('cart_info',null);
        }
    }

}