<?php
    namespace app\admin\model;
    class GoodsAttr extends Common{
        //商品属性入库
        public function addAll($goods_id, $attr_ids, $attr_values){
            // 保存最终结果数组
            $list = [];
            $tmp =[];//用于判断数据是否存在重复的一维数组
            // 以提交的属性循环,根据循环ID的个数组装二维数组
            foreach($attr_ids as $key => $value){
                //在tmp数组中每一个元素记录条件
                if(in_array($value.'-'.$attr_values[$key],$tmp)){
                    // 数据重复
                    continue;
                }
                $tem[] = $value.'-'.$attr_values[$key];
                $list[] = [
                    'goods_id' => $goods_id,
                    'attr_id' => $value,
                    'attr_value' => $attr_values[$key]
                ];
            }
            //批量写入
            $this -> saveAll($list);
        }
        
    }