<?php
    namespace app\admin\controller;
    //使用数据库类
    use think\Db;
    //使用Request类
    use think\Request;

    class Category extends Common
    {
        //显示分类首页
        public function index(){
            //获取query对象
            $query = Db::name('category');
            //使用query对象查询所有数据
            $data = $query -> select();
            //格式化数据
            $list = get_tree($data);
            // 使用模板引擎渲染数据
            $this -> assign('data',$list);
            return $this -> fetch();
        }
        
        //显示添加分类页面
        public function add(Request $request){
            //判断请求是否为get请求,如果为GET请求,则显示添加分类页面
            if($request->isGet()){
                //获取数据库query对象
                $query = Db::name('category');
                //查询所有数据
                $data = $query -> select();

                $list = get_tree($data);

                $this -> assign('data',$list);
                return $this -> fetch(); 
            }else{//如果不是get请求,则为post请求,添加分类入数据库
                //接收表单数据
                $data = input();
                //获取数据库query对象
                $query = Db::name('category');
                //使用insert方法添加数据
                $res = $query -> insert($data);
                //如果添加失败
                if(!$res){
                    $this -> error('数据写入失败');
                }
                $this -> success('数据写入成功');
            }
            
        }

        //删除分类
        public function delete(){
            // 获取要删除分类的id
            $delId = input('id');
            //获取query对象
            $query = Db::name('category');
            //查询该分类是否有子分类
            if($query -> where(['p_id'=>$delId]) -> find() ){
                //如果有子分类则取消删除
                $this -> error('该分类有子分类,无法删除');
            }
            //如果没有子分类则直接删除
            $query -> delete($delId);
            $this -> success('删除成功');
        }

        //显示编辑分类
        public function edit(Request $request){
            // 获取query对象
            $query = Db::name('category');
            //获取要修改的id
            $edId = input('id');
            // 判断请求类型,如果为get请求,显示修改表单,如果是post请求,则提交数据并更新数据库
            //查询改id所有数据并渲染
            if($request -> isGet()){
                $data = $query -> find($edId);
                //查询所有分类 
                $cate  = get_tree($query -> select());
                $this -> assign('cate',$cate);
                // dump($data);
                $this -> assign('data',$data);
                return $this -> fetch();
            }
            // 获取表单数据
            $upId = input('p_id');
            $edId = (int)$edId;
            if($upId == $edId){
                $this->error('上级分类选择错误');                
            }
            //获得当前分类下的所有子分类
            $data = $query ->select();

            $son = get_tree($data,$edId);
            // dump($son);
            foreach($son as $v){
                if($v['id']==$upId){
                    $this->error('上级分类不能设置为子分类');
                }
            }
            $name = input('cname');

            
            // 修改数据
            $query -> update(['cname'=>$name,'p_id'=>$upId,'id'=>$edId]);
            $this->success('修改成功', 'index','',1);
           
        }

    }