<?php
    namespace app\admin\validate;


    class Goods extends Common{
        //数据验证规则
        protected $rule = [
            'goods_name' => 'require',      //商品名称不能为空
            'cate_id' => 'gt:0',            //商品的cate_id不能为0
            'shop_price' => 'require|egt:0',         //商品的价格大于等于零
            'market_price' => "require|checkShop",  //检测市场售价是否大于本店售价
            'goods_number' => 'require|egt:0'
        ];

        //错误信息提示
        protected $message = [
            'goods_name.require' => '商品名称不能为空',
            'cate_id.gt' => '请选择商品分类',
            'shop_price.require' => "请填写商品价格",
            'shop_price.egt' => '请正确填写商品价格',
            'market_price' =>'市场售价需大于本店售价',
            'goods_number' =>'请正确填写总库存'
        ];
        

        // 检查价格规则
        public function checkShop($value, $rules, $data){
            if($value < $data['shop_price']){
                return false;
            }            
            return true;
        }

        
    }