<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/27
 * Time: 20:06
 */
function my_filter($string)
{
    require_once './Application/Common/Plugins/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg->set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg->set('HTML.Allowed','div,b,i,em,a[href|title],ul,ol,li,br,span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg->set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj->purify($string);
}

/**
 * @param $to 收件人
 * @param $content 发送的邮件内容
 * @return bool 发送邮件是否成功
 */
function sendMail($to,$content){
    require_once('./Application/Common/Plugins/PHPMailer/class.phpmailer.php');
    $mail = new PHPMailer();
    // 设置为要发邮件
    $mail->IsSMTP();
    // 是否允许发送“HTML代码”做为邮件的内容
    $mail->IsHTML(TRUE);
    $mail->CharSet='UTF-8';
    // 是否需要身份验证
    $mail->SMTPAuth=TRUE;
    /*  邮件服务器上发送方账号设置 start*/
    $mail->From="m18715006811@163.com"; //发送方邮件地址
    $mail->FromName="jx商城用户的激活邮件";  //发送方名称，会显示在邮件的内容中，可以自定义
    $mail->Host="smtp.163.com";  //发送邮件的服务协议地址，中转邮件服务器地址
    $mail->Username="m18715006811";  //发送方帐号
    $mail->Password="19960406xm"; //发送方帐号密码
    /*  邮件服务器上发送方账号设置 end*/
    // 发邮件端口号默认25
    $mail->Port = 25;
    // 收件人,可以多次设置，显示名称,表示给多人发送邮件
    $mail->AddAddress($to);
    //$mail->AddAddress('1252951132@qq.com','云起');
    // 邮件标题
    $mail->Subject="jx商城用户的激活邮件";
    // 邮件内容
    $mail->Body=$content;
    return($mail->Send());//发送邮件
}

/**
 * 发送模板短信
 * @param to 手机号码集合,用英文逗号分开
 * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
 * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
 */
function sendSMS($to,$datas,$tempId='1')
{
    // 初始化REST SDK
    global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
    //主帐号,对应开官网发者主账号下的 ACCOUNT SID
    $accountSid= '8a216da85b3c225d015b42193bc703ba';
    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    $accountToken= '5d0738fd7797452babfdd1b27a93cddd';
    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    $appId='8a216da85b3c225d015b42193d7f03c0';
    //请求地址
    //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
    //生产环境（用户应用上线使用）：app.cloopen.com
    $serverIP='app.cloopen.com';
    //请求端口，生产环境和沙盒环境一致
    $serverPort='8883';
    //REST版本号，在官网文档REST介绍中获得。
    $softVersion='2013-12-26';
    //引入发送短信的接口文件
    include_once("./Application/Common/Plugins/sms/CCPRestSmsSDK.php");

    $rest = new REST($serverIP,$serverPort,$softVersion);
    $rest->setAccount($accountSid,$accountToken);
    $rest->setAppId($appId);

    // 发送模板短信
    $result = $rest->sendTemplateSMS($to,$datas,$tempId);
    if($result == NULL ) {
        return false;
    }
    if($result->statusCode!=0) {
        return false;
    }else{
        return true;
    }
}
