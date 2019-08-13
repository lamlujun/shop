<?php
    namespace app\admin\model;
    class Attribute extends Common{
        public function addAttr($postdata){
            //判断属性录入方式, 为1时清空属性默认值,为2 select时判断是否填写了属性默认值
            if($postdata['attr_input_type']==1){
                unset($postdata['attr_values']);
            }else{
                if(!$postdata['attr_values']){
                    $this -> error = '请填写属性默认值';
                    return false;
                }
            }
            return $this -> isUpdate(false) -> allowField(true) -> save($postdata);
        }

        //显示属性列表
        public function showIndex(){
            $list = db('attribute') -> alias('a') -> join('shop_type b','a.type_id=b.id','left') -> field('a.*,b.type_name') ->select();
            return $list;
        }

        //根据类型id查询属性信息
        public function getAttrs($type_id){
            $list = $this->where(['type_id'=>$type_id])->select();
            // return $list;
            foreach($list as $key => $value){
                if($value['attr_input_type']==2){
                    $list[$key]['attr_values']=explode(',',$value['attr_values']);
                }
            }
            return $list;

        }
    }