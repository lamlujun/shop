<?php
    namespace app\admin\model;
    class Order extends Common{
        public function showIndex(){
            $list = db('order') -> alias('a') -> join('eshop_user b','a.user_id=b.id','left') -> field('a.*,b.username') ->order('pay_status desc') -> select();
            return $list;
        }

        //商品详情数据
        public function getDetail($order_id){
            // 连表查询商品数据
            $goods_info = db('order') -> alias('a') -> join('eshop_order_detail b','a.id=b.order_id','left') -> field('a.*,b.goods_id,b.goods_ids,b.goods_count')-> where('a.id',$order_id) -> select();
            //遍历数据
            foreach($goods_info as $key => $value){
                $goods_info[$key]['goods_name']=db('goods') ->field('goods_name')-> where('id',$value['goods_id'])-> find();
                $goods_info[$key]['attr'] = db('attribute')->alias('a') -> join('eshop_goods_attr b','a.id = b.attr_id','left') -> field('a.attr_name,b.attr_value') -> where('b.id','in',$value['goods_ids']) ->select();
                // dump($value);
            }
            return $goods_info;
        }


        //查询退货退款数据
        public function getRegoods($order_id){
           
            //根据订单id查询退款数据
            return db('order') -> alias('a') -> join('eshop_user b','a.user_id=b.id','left') -> field('a.*,b.username') -> where(['a.is_return'=>1]) -> select();

        }

        //退款 ,查询用户订单详情
        public function reMoney($order_id){
            //修改订单status为9,
            db('order') -> where('id',$order_id) -> update(['status'=>9]);
            //根据订单id查询订单表用户id和商品金额
            $user_money = db('order') -> where('id',$order_id) -> field('user_id,money') -> find();
            // dump($user_money);
            //查询用户当前的积分
            $before_score = db('user') -> where('id',$user_money['user_id']) -> field('score') -> find();
            
            $before_score = (int)$before_score['score'];
            // 计算积分
            $integer = $user_money['money'] *1000;
            // 将积分存入用户积分字段
            db('user') -> where('id',$user_money['user_id']) -> setInc('score', $integer);

            //根据订单id查询订单详情
            $order_detail = db('order_detail') -> where('order_id',$order_id) -> select();
            // dump($order_detail);
            // 遍历查询到的订单详情
            foreach($order_detail as $value){
                //将库存存入商品表
                db('goods') -> where('id',$value['goods_id']) -> setInc('goods_number', $value['goods_count']);
            }

            //修改积分日志表
            $score_log = [
                "user_id" => $user_money['user_id'],
                'type' => 3,
                'before_score' => $before_score,
                'after_score' => $before_score + $integer,
                'score' => $integer,
                'remark' => '用户退款返回'.$integer.'积分',
                'way' => 3,
                'addtime' => time(),
            ]; 
            db("score_log") -> insert($score_log);



        }




    }