<?php
    namespace app\admin\model;
    use think\Db;
    class Goods extends Common{
        //查询所有商品
        public function getGoods($is_del = 0){
            $query = Db::name('goods');
            // 组装where子句
            $where = ['is_del'=>$is_del];//保存搜索的条件
             // 接收分类id
             $cate_id = input('cat_id');
             // 查询当前分类的所有子分类
             if($cate_id){
                 //将字符串转换成数字型
                $cate_id = (int)$cate_id;
                 $cate_ids = [$cate_id];//将当前分类加入到条件
                 $son = model("Category")->getCateTree($cate_id,true);
                 foreach($son as $v){
                    //  将子分类的ID加入到条件数组中
                     $cate_ids[] = $v->id;
                 }
                 $where['cate_id'] = ['in',$cate_ids];
             }

            $keyword = input('keyword');//接收提交的关键词
            if($keyword){
                //提交关键词作为条件
                $where['goods_name'] = ['like','%'.$keyword.'%'];
            }

            //接收提交的推荐,热卖等状态
            $intro_type = input('intro_type');
            if($intro_type){
                $where[$intro_type]=1;
            }
           

            // paginate方法自动完成数据分页功能,第一个参数指定每一页显示的数据条数
            //第二个参数控制是否为简单分页
            //第三个参数是针对地址的额外控制,需要传递数组
            //其中query元素指定生成的分页导航地址额外携带的参数
            $list = $query -> where($where) -> paginate(10, false, ['query'=>input()]);
            // dump($list);
            return $list;
        }
        public function addGoods($postdata){
            //获取提交数据时间
            $postdata['addtime'] = time();
            //开启事务
            Db::startTrans();
            try{
                
                //allowField为模型方法,可以根据数据表字段进行过滤
                $this->allowField(true)->isUpdate(FALSE)->save($postdata);
                //获取商品id
                $goods_id = $this -> getLastInsId();
                //获取属性ID
                $attr_ids = input('attr_ids/a',[]);
                
                //获取属性值
                $attr_values = input('attr_values/a',[]);
                //调用模型方法完成入库
                model("GoodsAttr")->addAll($goods_id,$attr_ids,$attr_values);
                //调用方法实现图片上传入库
                model('GoodsImgs') -> uploadImage($goods_id);
                //提交事务
                Db::commit();
            }catch(\Exception $e){
                Db::rollback();
                $this->error = $e;
                return false;
            }
           
        }

        //切换状态
        public function changeStatus($goods_id, $field){
            // 查询要修改状态的单条数据
            $single = $this -> get($goods_id);
            // dump($single);
            //计算出要修改的状态
            $status = $single -> $field ?0 :1;
            //修改状态
            $this -> where(['id'=>$goods_id]) -> setField($field,$status);
            return $status;
        }


        // 修改数据
        public function editGoods($editData){
            // dump($editData);
            $editData['is_hot'] = isset($editData['is_hot'])?$editData['is_hot']:0;
            $editData['is_res'] = isset($editData['is_res'])?$editData['is_res']:0;
            $editData['is_new'] = isset($editData['is_new'])?$editData['is_new']:0;
            // dump($editData);
            // 修改数据
            $this -> allowField(TRUE) -> isUpdate(TRUE) -> save($editData);
        }
     
        
    }