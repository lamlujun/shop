<?php
    namespace app\admin\controller;
    class Order extends Common
    {
        public function index(){
            //调用模型方法查询订单信息
            $order_info = model("Order") -> showIndex();
            $this -> assign('order',$order_info);
            // dump($order_info);
            return $this -> fetch();
        }

        //显示发货页面
        public function send(){
            // 接收订单id
            $order_id = input('id/d');
            // 判断请求类型
            if(request()->isGet()){
                // 调用模型方法查询订单详细数据并渲染发货表单
                $detail = model('Order') -> getDetail($order_id);
                //查询收件人信息
                $people = db('address') -> where('id',$detail[0]['address_id']) -> find();
                dump($people);
                $this -> assign('people',$people);
                $this -> assign('order',$detail);
                return $this -> fetch();
            }
            // 接收快递数据
            $exp = input();
            // 将status改为已发货状态
            $exp['status'] =2;
            model('Order') -> isUpdate(true) -> save($exp);
        }


        //退货退款订单列表
        public function reGoods(){
            // 接收订单id;
            $order_id = input('id/d');
            $re_order = model('Order') -> getRegoods($order_id);
            // dump($re_order);exit;
            $this->assign('order',$re_order);
            return $this -> fetch();
        }

        //同意退货退款, 修改订单表status字段为6
        public function agree(){
            // 接收订单id
            $order_id = input('id/d');
            // 修改字段
            $res = db('order') -> where('id',$order_id) -> update(['status'=>6]);
            if(!$res){
                return json(['code'=>0,"msg"=>'操作失败']);
            }
            return json(['code'=>1,"msg"=>'ok']);
        }


        //同意退款 status=8
        public function reMoney(){
            // 接收订单id
            $order_id = input('id/d');
            //调用模型方法
            $res = model('Order') -> reMoney($order_id);
            if($res === false){
                $this -> error(model('Order')->getError());
            }
            $this -> error('退款成功');
        }
    }
    