<?php
    namespace app\index\model;
    class Goods extends Common{ 
        //下单减少库存
        public function decNumber($goods_id,$goods_count,$goods_attr_ids){
            $this -> where('id',$goods_id) -> setDec('goods_number',$goods_count);
        }
        //获取商品数据
        public function getGoodsInfo($goods_id){
            $where = [
                'id' => $goods_id,
                'is_del' => 0
            ];
            $goods = db('goods')->where($where)->find();
            $goods['imgs'] = db('goods_imgs') ->where('goods_id',$goods_id) -> field('goods_img,goods_mid,goods_thumb') -> select();
            //获取当前商品的单选属性和唯一属性
            $attrs = db('goods_attr')->alias('a')->join('attribute b','a.attr_id=b.id','left')->field('a.*,b.attr_name,b.attr_type')->where(['a.goods_id'=>$goods_id])->select();
            // dump($attrs);
            // 存储唯一属性
            $goods['unique']=[];
            foreach($attrs as $value){
                // 如果商品的attr_type为1,则为唯一属性
                if($value['attr_type']==1){
                    //将结果存入$goods['unique']中
                    $goods['unique'][]=$value;
                }else{
                    //单选属性
                    $goods['sigle'][$value['attr_id']][]=$value;
                }
            }
            return $goods;
        }
        //商品加入购物车,检查库存
        public function checkGoodsNumber($goods_id,$goods_count,$goods_attr_id){
            // 根据goods_id查询数据
            $goods = $this -> where(['id'=>$goods_id]) -> find();
            // 比较加购数量
            if(!$goods || $goods['goods_number']<$goods_count){
                $this -> error = '库存不足';
                return false;
            }
        }

        public function getFloor(){
            // 查询分类表中被推荐的顶级分类
            $cate_info = db('category') -> where(['p_id'=>0,'is_rec'=>1]) -> select();
            $list = [];
            foreach($cate_info as $value){
                //获取顶级分类下所有的二级分类
                $value['son'] = db('category') -> where(['p_id'=>$value['id']]) -> select();
                //获取顶级分类下被推荐的二级分类
                $value['rec_son'] = db('category') -> where(['p_id'=>$value['id'],'is_rec'=>1]) -> limit(5) -> select();

                //取出推荐分类下的商品数据
                foreach($value['rec_son'] as $k => $v){
                    $value['rec_son'][$k]['goods_info'] = $this -> getGoods($v['id']);
                }
                
                $list[] = $value;
            }
            // dump($list);exit;
            return $list;
        }

        public function getGoods($id){
            //存储分类id
            $cate_ids = [];
            // 根据id查询子分类
            $cate_list = db('category') -> field('id') -> where(['p_id'=>$id]) -> select();
            //遍历数组,将id存入变量
            foreach($cate_list as $value){
                $cate_ids[] = $value['id'];
            }
            // dump($cate_ids);exit;
            //根据分类id查询商品数据    
            return db('goods') -> where('cate_id','in',$cate_ids) -> limit(8) -> select();
        }

        
    }