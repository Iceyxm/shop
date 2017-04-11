<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    /**
     * 会员登录
     */
    public function login(){
        if(IS_POST){
            //收集表单信息
            $name = I('post.user_name');
            $pwd = I('post.password');
            $pwd = md5($pwd);//加密密码，用户注册时插入数据表中的密码是加密过的
            $error_info = '用户名或密码错误';

            //根据用户所填信息查询该用户
            $info = D('User')->where(array('user_name'=>$name,'password'=>$pwd))->find();
            if($info !== null){
                if($info['is_active'] == 1){
                    //持久化用户信息
                    session('user_name',$info['user_name']);
                    session('user_id',$info['user_id']);
                    //判断是否有定义回跳地址，并做跳转
                    $back_url = session('back_url'); // Shop/flow2
                    if(!empty($back_url)){
                        session('back_url',null);//清除回跳地址
                        $this -> redirect($back_url);
                    }
                    $this->redirect('Index/index');
                }
                $error_info = '请先激活用户账号';
            }
            //将错误信息回馈到模板页面显示
            $this->assign('errorinfo',$error_info);
        }
        $this->display();
    }

    /**
     * QQ登录弹框
     */
    function qqloginshow(){
        require_once("./Application/Common/Plugins/qq/API/qqConnectAPI.php");
        $qc = new \QC();
        $qc->qq_login();
    }

    /**
     * QQ登录后回调处理
     */
    function callback(){
        require_once("./Application/Common/Plugins/qq/API/qqConnectAPI.php");
        $qc = new \QC();
        $access_token = $qc->qq_callback();
        $openid = $qc->get_openid();

        //重复实例化QC对象，会员登录后退出重新登陆，如果会员信息发生变化可以实现更新，不然会报错
        $qc = new \QC($access_token,$openid);

        //获得qq账号的信息
        $qqinfo = $qc->get_user_info();

        $user = D('User');

        //判断当前qq账号是否登陆过系统
        $havelogin = $user->where(array('openid'=>$openid))->find();

        if ($havelogin){//如果数据表有该会员记录则表示曾将这个qq账号登录过
            //旧用户,更新会员信息
            $data['user_name']  = $qqinfo['nickname'];
            $data['last_time']  = time();
            $data['user_id']    = $havelogin['user_id'];
            if ($user->save($data)){
                //持久化会员信息
                session('user_name',$data['user_name']);
                session('user_id',$data['user_id']);
            }else{
                $this->error('更新会员信息失败');
            }
        }else{
            //新用户，将用户信息插入到user表，增加新会员纪录
            //将获得的qq账号信息维护到user表
            $data['user_name'] = $qqinfo['nickname'];
            $data['is_active'] = 1;//表示该账户已激活
            $data['openid'] = $openid;
            $data['user_time'] = $data['last_time'] = time();
            if ($newid = $user->add($data)){
                //持久化会员信息
                session('user_name',$data['user_name']);
                session('user_id',$data['user_id']);
                //本应该页面跳转，但是qq登录触发的是qq登录框，属于新的窗口，应该关闭，在原窗口登录页面实现跳转
                //关闭当前的小窗口，父级大窗口跳转到首页面
                echo <<<eof
                <script type="text/javascript">
                    window.opener.location.href="/";
                    window.close();
                </script>
eof;
            }else{
                //$this -> error('qq登录失败',U('User/login'));
                //关闭当前的小窗口，父级大窗口跳转到首页面
                echo <<<eof
                <script type="text/javascript">
                    window.opener.location.href="{:U('User/login')}";
                    window.close();
                </script>
eof;
            }
        }
    }

    /**
     * 会员注册
     */
    public function regist(){
        $user = D('User');
        if(IS_POST){
            //校验短信验证码
            $checkcode = I('post.checkcode');//获取用户输入的验证码
            $data = session('data');//取出session里面的数据
            $limittimes = $data['limittime']*60;//将限制时间转换成以秒为单位
            $nowtime = time();//当前的时间

            if(($nowtime-$limittimes) > $data['now']){
                $this->assign('error','短信验证码已经过期');
            }elseif ($checkcode != $data['code']){
                $this->assign('error','验证码输入错误');
            }else{
                session('data',null);
                $data = $user->create();
                //收集表单数据，插入数据表
                $data['password'] = md5($_POST['password']);

                //防止人为修改ID而导致随意激活账号，每次生成的秘钥都是唯一的，不能只通过ID就可激活该ID
                $data['token'] = md5(time()+mt_rand(0,9999));

                $res = M('User')->where(array('user_name'=>I('post.user_name')))->find();
                if (!$res){
                    if($id = M('User')->add($data)){
                        $email = I('post.user_email');
                        $href = "http://jxshop.com/index.php/Home/User/user_active/id/".$id."/token/".$data['token'];
                        $content = "您好，激活账号请点击 <b><a href=".$href.">链接</a></b> 进行激活。";
                        dump(sendMail($email,$content));
                        die;
                    }
                    $this->success("注册成功,请前往您注册邮箱激活该账户！",U('Home/User/login'));
                    die;
                }else{
                    $this->error('该用户已存在！');
                }
            }
        }else{
            $this->display();
        }
    }

    /**
     * 发送手机验证码
     */
    function sendCode(){
        if (IS_AJAX){
            //获取页面填写的手机号
            $tel = I('get.tel');
            //制作要发送的验证码，一般手机验证码为四位随机数字
            $data['code'] = mt_rand(1000,9999);
            //设置验证码的有效时间
            $data['limittime'] = 1;
            //获取当前时间
            $data['now'] = time();

            //将信息存入session，便于验证码的校验
            session('data',$data);

            //发短信并返回结果
            $res = sendSMS($tel,array($data['code'],$data['limittime']));

            if ($res){
                echo json_encode(array('status'=>1));
            }else{
                echo json_encode(array('status'=>0));
            }
        }
    }

    /**
     * 会员账号激活
     */
    public function user_active(){
        $id = I('get.id');
        $token = I('get.token');
        $db_token = M('User')->where(array('user_id'=>$id))->getField('token');
        if($token === $db_token){
            M('user')->where(array('user_id'=>$id))->setField(array('is_active'=>1,'token'=>''));
            $this->success('激活成功！',U('Home/User/login'));
        }else{
            $this->error('激活失败！');
        }
        die;
    }


    /**
     * 退出并清除session保存的信息
     */
    public function logout(){
        session(null);
        $this->redirect("User/login");
    }
}