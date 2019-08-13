<?php
    namespace app\admin\model;
    class GoodsImgs extends Common{
        public function uploadImage($goods_id){
            // 获取图片对象(多文件上传,为一个数组)
            $files = request()->file('imgs');
            //保存批量写入的数据
            $list=[];
            //遍历该数组对象
            foreach($files as $value){
                // 将图片保存
                $info = $value -> validate(['ext'=>'png,jpg,jpeg']) -> move(config('upload_root'));
                if(!$info){
                    continue;
                }
                //获取图片上传的地址
                $goods_img = str_replace('\\','/',$info->getPathName());
                //打开图片生成中图和小图
                $img = \think\Image::open($goods_img);
                // 计算中图存储地址
                $goods_mid = config('upload_root').'/'.date('Ymd').'/mid_'.$info->getFileName();
                // 计算小图存储地址
                $goods_thumb = config('upload_root').'/'.date('Ymd').'/thumb_'.$info->getFileName();
                // 生成中图
                $img -> thumb(350,350) -> save($goods_mid);
                $img -> thumb(150,150) -> save($goods_thumb);
                //保存数据
                $list[] = [
                    'goods_id'=>$goods_id,
                    'goods_img'=>$goods_img,
                    'goods_mid'=>$goods_mid,
                    'goods_thumb'=>$goods_thumb
                ];
            }
            // 将数据写入数据库
            $this->saveAll($list);
        }
    }