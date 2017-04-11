<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/26
 * Time: 20:21
 */
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
    protected $insertFields = "user_name,password,user_logo,role_ids";
    protected $updateFields = "id,user_name,password,user_logo,role_ids";

    protected $_validate = array(
        array('user_name','require','商品名称必须填写',1),
        array('password','require','商品价格格式不对',1),
        array('password','6,12','密码长度要在6~12个字符之间',2,'length'),
    );

    //定义login模块的验证规则
    protected $_login_validate = array(
        array('user_name','require','商品名称必须填写',1),
        array('password','require','商品价格格式不对',1),
        array('password','6,12','密码长度要在6~12个字符之间',2,'length'),
    );

    public function checkVerify(){
        if (!I('post.verifycode')){
            $this->error('请填写正确的验证码');
            return false;
        }
        //判断验证码是否正确
        $verify = new \Think\Verify();
        if(!$verify->check(I('post.verifycode'))){
            $this->error = "验证码错误！！";
            return false;
        }
        return true;
    }

    /**
     * 判断用户是否存在
     * @return int
     */
    public function checkUser(){
        //获取用户名和密码
        $user_name = I('post.user_name');
        $password = md5(I('post.password'));

        $user_info = $this->where(array('user_name'=>$user_name))->find();//查询用户是否存在

        if($user_info){//核对密码
            if($user_info['password'] === $password){
                //登录成功后：1  把用户的ID/名字/头像存入session
                //2 完善需要添加的字段
                session('admin_id',$user_info['id']);
                session('admin_name',$user_info['user_name']);
                session('admin_logo',$user_info['user_logo']);
                $data['login_time'] = time();
                //将IP地址转换成字符串
                $data['last_login_ip'] = ip2long(get_client_ip());
                //setField 更新某个或某几个字段
                M('Admin')->where(array('id'=>$user_info['id']))->setField($data);

                return 3;//登录成功
            }else{
                return 2;//密码错误
            }

        }else{
            return 1;//用户名错误
        }

    }
    /**
     * thinkphp中的钩子函数，在Model基类中
     * 该方法在执行添加之前执行
     * Time: 20:21
     */
    protected function _before_insert(&$data,$option){
        $data['password'] = md5($data['password']);
        $data['create_time'] = time();//补上创建时间
        //把所选择的角色，变成字符串，逗号分割，存入数据库
        $data['role_ids'] = implode(',',$data['role_ids']);

        //处理管理员头像上传
        if ($_FILES['user_logo']['error'] === 0){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传目录
            $upload->savePath  =      'Admin/Admin_pic/'; // 设置附件上传目录
            // 上传单个文件
            $info   =   $upload->uploadOne($_FILES['user_logo']);
            if($info) {// 上传成功 获取上传文件信息，失败不作处理，不然不上传图片时error会报错$this->error($upload->getError())
                $data['user_logo'] = "/Public/Uploads/".$info['savepath'].$info['savename'];
            }
        }

    }

    /**
     * thinkphp中的钩子函数，在Model基类中
     * 该方法在删除操作之前执行
     * Time: 20:21
     */
    public function _before_delete($options){
//        print_r($options);
//        die;
        $admin_pic = M('Admin')->where(array('id'=>$options['where']['id']))->getField('user_logo');
        @unlink(".".$admin_pic);
    }

    /**
     * thinkphp中的钩子函数，在Model基类中
     * 该方法在更新操作之前执行
     * Time: 20:21
     */
    public function _before_update(&$data,$option){
        /*
         * option中 array(3) {["where"] => array(1) {["id"] => int(1)}
         */
        $data['password'] = md5($data['password']);
        //把所选择的角色，变成字符串，逗号分割，存入数据库
        $data['role_ids'] = implode(',',$data['role_ids']);


        //先删除硬盘上的图片，图片的错误不为0
        if($_FILES['user_logo']['error'] === 0) {//进行图片的修改
            //删除硬盘上原来的图片
            //getField() ：获取一张表中的某一个字段
            $pics = $this->where(array('id' => $option['where']['id']))->getField('user_logo');
//             echo $pics;die;
            @unlink("." . $pics);

            //把修改后的图片存入数据库和硬盘
            //???扩展，这里可以判断$_FILES['goods_logo']['error']的值，如果为0，则可以进行处理，否则不处理。
            /* **** 处理商品logo**/
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Public/Uploads/'; // 设置附件上传的根路径
            $upload->savePath = 'Admin/Admin_pic/'; // 设置附件上传目录

            $info = $upload->uploadOne($_FILES['user_logo']);
            if ($info) {// 上传错误提示错误信息
                $data['user_logo'] = "/Public/Uploads/" . $info['savepath'] . $info['savename'];
            }
        }
    }
}