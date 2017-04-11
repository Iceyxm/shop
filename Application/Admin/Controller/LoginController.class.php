<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    
    public function login(){
        if(IS_POST){
            //验证码验证：
            $model = D('Admin');
            if($model->validate($model->_login_validate)->create()){
                //验证 验证码
                if($model->checkVerify()){
                    //验证码通过
                    $res = $model->checkUser();//检测用户名和密码
                    if($res == 1){
                        $this->error('用户名不存在');
                    }elseif($res == 2){
                        $this->error('密码错误');
                    }elseif($res ==3){
                        $this->success('登录成功！',U('Admin/Index/index'));
                    }
                    die;
                }
            }
            $this->error($model->getError());
            die;
        }else{
            $this->display();
        }
    }
    
    public function verify_code(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 30;
        $Verify->length   = 1;
//        $Verify->codeSet = '0123456789';//设置验证码为纯数字
        $Verify->useNoise = false;
        $Verify->useImgBg = true;
        $Verify->fontttf = '5.ttf';
        $Verify->imageW = 140;
        $Verify->imageH = 60;
        $Verify->entry();
    }
    
    
    
    
    
}