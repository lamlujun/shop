<?php
namespace app\index\controller;

class Pay extends Common
{
    public $is_check_login = true;
    public function checkout(){ 
        // 查询地址数据
        $addr = model('Address') -> showAddr();
        //查询默认地址
        $deAddr = db('address') -> where('default_address',1) ->find();
        // 查询数据库中的购物车数据
        $data = model("Cart") -> showIndex();
        //获取总价格
        $total = model('Cart') -> total($data);
        $this ->assign('data',$data);
        $this ->assign('addr',$addr);
        $this ->assign('deaddr',$deAddr);
        $this ->assign('total',$total);
        return $this -> fetch();
    }
    public function order(){
        // dump(input());
        // 获取收货信息,支付方式等信息
        $postdata = input();
        // dump($postdata);
        //调用模型方法,将数据入库
        $order = model('Order') -> addOrder($postdata);
        //判断支付状态
        if($postdata['pay']==1){
            // 货到付款
            $this -> redirect('pay/cash');
        }else{
            if($order['is_use_score']==1 && $order['last_money']==0){
                $this -> redirect('pay/cash');
            }else{
                $this -> alipay($order);
            }
        }

    }
    public function cash(){
        return $this -> fetch();
    }

    //调用支付宝接口
    public function alipay($order){
        require_once '../extend/alipay/config.php';
        require_once '../extend/alipay/pagepay/service/AlipayTradeService.php';
        require_once '../extend/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $order['order_sn'];

            //订单名称，必填
            $subject = '笔记本电脑';

            if(isset($order['last_money'])){
                //付款金额，必填
                $total_amount = $order['last_money'];
            }else{
                $total_amount = $order['money'];
            }

            //商品描述，可空
            $body = '笔记本电脑';

            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);

            $aop = new \AlipayTradeService($config);

            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
            */
            $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            
    }
}