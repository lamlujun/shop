<?php
    namespace app\index\model;
    class Category extends Common{
        public function getCate(){
            // 获取所有分类信息
            return $this -> all();
        }
        // 查询热卖,推荐,新品
        public function getRecGoods($field){
            $where = [
                $field =>1,
                'is_del'=>0
            ];
            return db('goods')->where($where)->limit(5)->order('id asc')->select();
        }
    }