<?php
namespace app\index\model;
class Sign extends Common{
    public function signin(){
        //获取用户id
        $user_id = model('User') -> getUserId();
        
        if(!$user_id){
            $this -> error='请先登录';
            return false;
        }
        // 查询当前用户信息
        $user_info = db('user') -> find($user_id);
        // dump($user_info);
        //获取当前签到日期
        $date = date('Ymd');
        //判断当天用户是否已签到
        if(db('sign') -> where(['user_id'=>$user_id,'date'=>$date])->find()){
            $this -> error='已签到';
            return false;
        }
        // 组装数据入sign库
        $sign_data = [
            'user_id'=> $user_id,
            "date" => $date,
            'addtime'=> time()
        ];
        //入库
        $this-> save($sign_data);

        //签到一次增加100积分
        $score = 100;
        // 用户信息表增加积分
        db('user')->where('id',$user_id) -> setInc('score', $score);

        //组装积分日志表数据
        $score_log = [
            'user_id' => $user_id,
            'type' => 1,
            'before_score' => $user_info['score'],
            'after_score' => $user_info['score']+$score,
            'score' => $score,
            'remark' => '签到增加'.$score.'积分',
            'way' => 1,
            'addtime' => time()
        ];

        //入库
        db('score_log') -> insert($score_log);

    }
}