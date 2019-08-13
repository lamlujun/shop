<?php
namespace app\index\controller;
use think\Cache;
class Order extends Common
{   
    public $is_check_login = true;
    //显示订单列表
    public function index(){
        //调用模型方法查询数据
        $order = model('Order') -> showIndex();
        $this -> assign('order',$order);
        return $this -> fetch();
    } 

    //查看物流信息
    public function express(){
        // 接收查询的订单id
        $order_id = input('id/d');
        // 判断订单是否发货
        $order = db('order')->find($order_id);
        if($order['status']!=2){
            $this->error('商品未发货');
        }
        

        //设置缓存标识
        $cache = 'order_express_id_'.$order['id'];
        //读取缓存中的数据
        $data = cache($cache);
        if(!$data){
            // appid
            $key = '3d5ff4d377cb4096e2c15a1a0088a6c8';
            //快递公司
            $com =  $order['com'];
            //快递单号
            $no = $order['no'];
            $url = "http://v.juhe.cn/exp/index?key=$key&com=$com&no=$no";
            //curl发送请求
            $data = http_curl($url);
            // 将数据缓存
            cache($cache,$data,3600);
        }
        // $data = collection($data)->toArray();
        $this->assign('exp',$data);
        return $this -> fetch();
    }

    //取消订单
    public function cancel(){
        //获取订单id
        $order_id = input('id/d');
        // 调用模型方法
        $res = model('Order') -> cancelOrder($order_id);
        if($res === false){
            return json(['code'=>0,'msg'=>model('Order')->getError()]);
        }
        return json(['code'=>1,'msg'=>$res]);
    }

    //申请退货退款,修改 status值为5,is_return值为1
    public function reGoods(){
        // 接收商品id值
        $order_id = input('id/d');
        // 根据id修改字段
        $res = db('order') -> where('id',$order_id) -> update(['status'=>5,'is_return'=>1]);
        if(!$res){
            return json(['code'=>0,'msg'=>'申请失败']);
        }
        return json(['code'=>1,'msg'=>'ok']);
    }


    // 用户点击退回商品 修改 status值为7
    public function sendGoods(){
        // 接收商品id值
        $order_id = input('id/d');
        // 根据id修改字段
        $res = db('order') -> where('id',$order_id) -> update(['status'=>7]);
        if(!$res){
            return json(['code'=>0,'msg'=>'申请失败']);
        }
        return json(['code'=>1,'msg'=>'ok']);
    }
    
}