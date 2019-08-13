<?php
namespace app\index\model;
class Order extends Common{
    public function addOrder($postdata){
        //获取用户id 
        $user_id = model('User') -> getUserId();
        //查询购物车数据
        $data = model('Cart') -> showIndex();
        $orderdata = [
            'user_id' => $user_id,
            'order_sn' => date('Ymd') .''. mt_rand(10000,99999),
            'money' => model('Cart') -> total($data),
            'addtime' => time(),
            'pay' => $postdata['pay'],
            'address_id' => $postdata['address_id']
        ];

        // 判断是否使用积分
        if(isset($postdata['is_use_score'])){
            // dump($orderdata);exit;    
            //查找用户信息,获取用户积分 
            $user_info = db('user') -> find($user_id);
            // 计算商品全部用积分兑换,需要多少积分
            $goods_score = $orderdata['money'] *100;
            // dump($goods_score);exit;
            // 判断积分
            if($user_info['score']>=$goods_score){
                $orderdata['score'] = $goods_score;
                //实际付款数
                $orderdata['last_money'] = 0;
                
                // 修改用户表中的积分数量
                $user_score = db('user') -> where('id',$user_id) -> setDec('score', $orderdata['score']);
                //修改积分日志表
                $score_log = [
                    'user_id' => $user_id,
                    'type' => 2,
                    'before_score' => $user_info['score'],
                    'after_score' => $user_info['score'] - $orderdata['score'],
                    'score' =>  $orderdata['score'],
                    'remark' => '购买商品消耗'.$orderdata['score'].'积分',
                    'way' => 2,
                    'addtime' => time(),
                ];
                // 写入积分日志表
                db("score_log") -> insert($score_log);
            }else{
                $orderdata['score'] = $user_info['score'];
                //实际付款金额
                $orderdata['last_money'] = $orderdata['money'] - $orderdata['score']/100;
                // dump($orderdata['last_money']);exit;

            }
            $orderdata['is_use_score'] = 1;
        }
        // 将数据存入订单表
        $this -> allowField(true) -> isUpdate(false) -> insert($orderdata);
        $order = $this -> getLastInsId();
        $order = (int)$order;

        // 订单详情表信息
        $detail = [];
        // 遍历数据库中的数据
        foreach($data as $value){
            $detail[] = [
                'order_id' => $order,
                'goods_id' => $value['goods_id'],
                'goods_count' => $value['goods_count'],
                'goods_ids' => $value['goods_attr_ids']
            ];
            //减少库存
            model('Goods')->decNumber($value['goods_id'],$value['goods_count'],$value['goods_attr_ids']);
        }
        db('order_detail') -> insertAll($detail);

        //清除该用户的购物车数据
        model('Cart') -> clear();
        
        //返回订单主表
         return $orderdata;
    }

    //显示订单列表
    public function showIndex(){
        //获取用户id
        $user_id = model('User') -> getUserId();
        //查询订单数据和收货人数据
        $list = db('order') -> alias('a') -> join('eshop_address b','a.address_id=b.id','left') -> field('a.*,b.people') -> where('a.user_id',$user_id) ->select();
        return $list;
    }



    //取消订单,修改支付方式字段为0,修改订单状态status为3,修改is_cancel字段为1,根据id查询订单信息,将商品数量存入商品库存
    public function cancelOrder($order_id){
        //根据订单id修改字段
        $this -> save([
            'pay'=>0,
            'status'=>3,
            'is_cancel'=>1
        ],['id'=>$order_id]);
        //根据id查询订单详情
        $goods_info = db('order_detail') -> where('order_id',$order_id) -> select();
        // dump($goods_info);
        //遍历数据
        foreach($goods_info as $value){
            db('goods') -> where('id',$value['goods_id']) -> setInc('goods_number', $value['goods_count']);
        }
        
    }

}