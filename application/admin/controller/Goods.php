<?php
    namespace app\admin\controller;
    use think\Request;
    use app\admin\model\Category;
    use think\Db;
    class Goods extends Common
    {
        //商品首页
        public function index(){
            //获取所有分类
            $cate = model("Category")->getCateTree();
            $this -> assign('cate',$cate);

            //获取所有商品列表
            $goods = model('Goods')->getGoods();
            if(!$goods){
                $this->error(model('Goods')->getError());
            }
            $this -> assign('list',$goods);
            return $this -> fetch();
        }

        //修改状态
        public function changeStatus(){
            $goods_id = input('goods_id/d',0);
            $field = input('field','is_hot');
            $model = model('Goods');
            $res = $model -> changeStatus($goods_id,$field);
            if($res===false){
                echo json_encode(['code'=>0,'msg'=>$model->getError()]);exit();
            }
            echo json_encode(['code'=>1,'msg'=>'ok','status'=>$res]);exit();

        }

        //显示修改界面
        public function edit(Request $request){
            //判断请求类型
            $edId = input('id');
            if(request()->isGet()){
                // echo $edId;
                // 根据要修改的ID查询单条数据
                $query= Db::name('goods');
                $single = $query -> find($edId);

                // 将查询到的数据显示在表单上
                $this -> assign('row',$single);
                $this -> assign('id',$edId);
                // dump($single);
                // 获取商品分类数据
                $model = new Category();
                $list = $model -> getCateTree();
                $this->assign('list',$list);
                return $this -> fetch();
            }
            //接收数据
            $editData = $request->param();
            // 使用数据验证
            $res = $this -> validate($editData,'Goods');
            if($res !== TRUE){
                $this->error($res);
            }
            // 查询货号或生成货号
            $this ->checkGoodSn($editData,true);
            // 图片处理
            $this->imageToThumb($editData,false);

            // dump($editData);
            //调用模型方法完成修改数据入库
            $result = model("Goods")->editGoods($editData);
            if($result === false){
                $this->error(model('Goods')->getError());
            }
            $this-> success('修改成功','index');
        }

        
        //商品添加
        public function add(){
            //判断是否为GET请求
            if(request()->isGet()){
                
                //实例化模型类
                $model = new Category();
                //获取所有类型
                $type = model('Type') -> showIndex();
                $this->assign('type',$type);
                //模型对象调用方法获取所有分类数据
                $list = $model -> getCateTree();
                $this -> assign('list',$list);
                return $this -> fetch();
            }
            // 表单提交获取表单数据
            $postdata = input();
            // 使用数据验证
            $res = $this -> validate($postdata,'Goods');
            if($res !== TRUE){
                $this->error($res);
            }
            // 查询货号或生成货号
            $this ->checkGoodSn($postdata,false);
            // 图片处理
            $this->imageToThumb($postdata,true);

            //数据入库,调用模型中的addGoods方法
            $result = model('Goods')->addGoods($postdata);
            
            if($result===false){
                $this->error(model('Goods')->getError());
            }
            $this->success('数据添加成功');
        }

        //接收ajax
        public function showAttr(){
            //获取类型id
            $type_id = input('type_id/d',0);
            //获取类型下的属性信息
            $attrs = model('Attribute') -> getAttrs($type_id);
            $this -> assign('attrs',$attrs);
            return $this -> fetch();

        }

        //检查货号
        private function checkGoodSn(&$postdata, $is_update = false){
            // 检测数据是否唯一
            if($postdata['goods_sn']){
                $where = ['goods_sn'=>$postdata['goods_sn']];
                if($is_update){
                    $where['id'] = ['neq',$postdata['id']];
                }
                if(model('Goods')->get($where)){
                    $this->error('货号已存在');
                }
              
            }else{//没有提交货号
                //随机生成货号
                $name = uniqid();
                $name = substr($name,6);
                $postdata['goods_sn'] = strtoupper($name);
            }
        }

        //图片处理 
        private function imageToThumb(&$postdata, $is_must=true){
            $file = request()->file('goods_img');
            //判断是否上传了图片,如果没有上传图片则拒绝提交数据
            if(!$file){
                // if($is_update){
                //     return true;
                // }
                // $this->error('请上传图片');
                if($is_must){
                    $this->error('请上传图片');
                }else{
                    return TRUE;
                }

            }
            // 设置图片上传地址
            $upload_root = config('upload_root');
            $info = $file->validate(['ext'=>'jpg,png,bmp'])->move($upload_root);
            //获取文件存放地址
            $path = $info -> getpathName();
            // 获取文件名
            $filename = $info -> getFilename();
            //将地址中的\转换成/再存入$postdata数据中
            $postdata['goods_img'] = str_replace('\\','/',$path);

            //使用image打开上传的文件并生成缩略图
            // 获取图片对象
            $img = \think\Image::open($postdata['goods_img']);
            // 计算缩略图存储地址
            $postdata['goods_thumb'] = $upload_root. '/' .date('Ymd').'/thumb_'.$filename;
            // 存储缩略图
            $img -> thumb(200,200) -> save($postdata['goods_thumb']);

        }

        //商品软删除
        public function del($id){
            //根据ID修改is_del的值
            // 获取query对象
            $query = Db::name('Goods');
            $res = $query -> update(['is_del'=>1,"id"=>$id]);
            if($res){
                $this -> success("ok","index",'',1);
            }
        }

        //回收站
        public function recycle(){
             //获取被删除的商品列表
             $goods = model('Goods')->getGoods(1);
             if(!$goods){
                 $this->error(model('Goods')->getError());
             }
             
             $this -> assign('list',$goods);
             return $this -> fetch();
        }

        //还原回收站数据
        public function rollback($id){
            // 获取query对象
            $query = Db::name('Goods');
            $res = $query -> update(['is_del'=>0,"id"=>$id]);
            if($res){
                $this -> success("ok","recycle",'',1);
            }
        }

        //彻底删除数据
        public function deepDel($id){
            // 获取query对象
            $query = Db::name('Goods');
            $res = $query -> delete(["id"=>$id]);
            if($res){
                $this -> success("ok","recycle",'',1);
            }
        }
    }
    