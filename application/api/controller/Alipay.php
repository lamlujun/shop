<?php 
namespace app\api\controller;
/**
* 
*/
class Alipay
    {
        public function returnurl(){
            require_once("../extend/alipay/config.php");
            require_once '../extend/alipay/pagepay/service/AlipayTradeService.php';


            $arr=$_GET;
            $alipaySevice = new \AlipayTradeService($config); 
            $result = $alipaySevice->check($arr);
            if(!$result) {
                return '支付异常';
            }
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //请在这里加上商户的业务逻辑程序代码
                
                //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
                //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

                //商户订单号
                $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

                //支付宝交易号
                $trade_no = htmlspecialchars($_GET['trade_no']);
                    
                // 查询订单信息
                $order_info = db('order') -> where('order_sn',$out_trade_no) ->find();
                if(!$order_info){
                    return '支付异常';
                }
                if($order_info['is_use_score'] ==1){
                    // 使用积分
                    // 查询用户信息
                    $user = db('user') -> where('id',$order_info['user_id']) ->find();
                    // 修改用户表中的积分数量
                    $user_score = db('user') -> where('id',$order_info['user_id']) -> setDec('score', $order_info['score']);
                    //修改积分日志表
                    $score_log = [
                        'user_id' => $order_info['user_id'],
                        'type' => 2,
                        'before_score' => $user['score'],
                        'after_score' => $user['score'] - $order_info['score'],
                        'score' => $order_info['score'],
                        'remark' => '购买商品消耗'.$order_info['score'].'积分',
                        'way' => 2,
                        'addtime' => time(),
                    ];
                    // 写入积分日志表
                    db("score_log") -> insert($score_log);
                }
                db('order') -> where('order_sn',$out_trade_no) ->setField('pay_status',1);
                // return 'ok';


                

                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           
        }
    }
    