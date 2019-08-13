<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if(!function_exists('get_tree')){
    //数据进行格式化
    //$data 被格式化的数据
    //$id 指定寻找哪个分类的子分类
    //$lev 层次
    function get_tree($data, $id = 0, $lev = 0, $is_clear = false){
        //新建一个数组用于接收数据
        static $list = [];
        if($is_clear){
            $list=[];
        }
        foreach($data as $value){
            if($value['p_id'] === $id){
                $value['lev'] = $lev;
                $list[]= $value;
                get_tree($data, $value['id'], $lev+1,false);
            }
        }
        return $list;
    }
}

//发送验证码
if(!function_exists('send_msg')){

    function send_msg($to, $datas, $tempId=1){
        include_once("../extend/CCPRestSDK.php");

        //主帐号
        $accountSid= '8a216da86c282c6a016c382646060589';

        //主帐号Token
        $accountToken= '9d460c08f7f1469b979803982a6f2a1f';

        //应用Id
        $appId='8a216da86c282c6a016c3828cea80593';

        //请求地址，格式如下，不需要写https://
        $serverIP='app.cloopen.com';

        //请求端口 
        $serverPort='8883';

        //REST版本号
        $softVersion='2013-12-26';


        $rest = new \REST($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);
       
        // 发送模板短信
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL) {
            return false;
        }
        if($result->statusCode!=0) {
            return false;
        }
          return true;
            
   }
   
   //Demo调用,参数填入正确后，放开注释可以调用 
   //sendTemplateSMS("手机号码","内容数据","模板Id");
}

//发送邮件
if(!function_exists('send_email')){

    function send_email($title,$content,$address){
        require '../extend/email/class.phpmailer.php';
        $mail             = new \PHPMailer();
        /*服务器相关信息*/
        $mail->IsSMTP();   //启用smtp服务发送邮件                     
        $mail->SMTPAuth   = true;  //设置开启认证             
        $mail->Host       = 'smtp.163.com';   	 //指定smtp邮件服务器地址  
        $mail->Username   = 'impinxyz';  	//指定用户名	
        $mail->Password   = 'pingxinlianai1';		//邮箱的第三方客户端的授权密码
        /*内容信息*/
        $mail->IsHTML(true);
        $mail->CharSet    ="UTF-8";			
        $mail->From       = 'impinxyz@163.com';	 		
        $mail->FromName   ="myShop";	//发件人昵称
        $mail->Subject    = $title; //发件主题

        $mail->MsgHTML($content);	//邮件内容 支持HTML代码
        $mail->AddAddress($address);  //收件人邮箱地址
        //$mail->AddAttachment("test.png"); //附件
        $mail->Send();			//发送邮箱
    }
}

//封装CURL发送请求
if(!function_exists('http_curl')){
    function http_curl($url,$type='get',$postdata=[],$return_type='json'){
        //初始化curl
        $ch = curl_init();
        //设置返回结果不直接输出
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //判断请求类型
        if($type=='post'){
            // 设置发送post请求
            curl_setopt($ch,CURLOPT_POST,TRUE);
            //设置请求参数
            curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        }
        //设置请求地址
        curl_setopt($ch,CURLOPT_URL,$url);
        //发送请求
        $json = curl_exec($ch);
        //关闭会话
        curl_close($ch);
        if($return_type=='json'){
            return json_decode($json,true);
        }
        return $json;
    }
}