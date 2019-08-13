<?php
    namespace app\admin\model;
    use think\Model;
    class Common extends Model{
        //默认获取所有数据的方法
        public function showIndex(){
            return $this -> all();
        }
        public function getCateTree($id = 0,$is_clear = FALSE){
            // 查询所有分类信息
            $data = $this -> all();//获得数组,数组每个元素是model对象
            $list = get_tree($data,$id,0,$is_clear);   
            return $list;//返回数据
        }
    }