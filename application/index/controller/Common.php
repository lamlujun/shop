<?php
    namespace app\index\controller;
    use think\Controller;
    class Common extends Controller{
        public $is_check_login = false;
        public function __construct(){
            parent::__construct();
            //获取分类数据
            $cate = model('Category')->getCate();
            $this -> assign('cate',$cate);
            if(!session('index_info') && $this->is_check_login){
                $this -> error("没有登录,请登录",'index/user/login');
            }
        }

    }