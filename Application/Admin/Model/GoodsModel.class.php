<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/26
 * Time: 20:21
 */
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {
    protected $insertFields = "goods_name,goods_price,logo,sm_logo,mid_logo,goods_desc,cat_id,type_id";
    protected $updateFields = "id,goods_name,goods_price,logo,sm_logo,mid_logo,goods_desc,cat_id,type_id";

    protected $_validate = array(
        array('goods_name','require','商品名称必须填写',1),
        array('goods_price','currency','商品价格格式不对',1),
        array('cat_id','require','商品分类必须选择！',1),
    );

    /**
     * thinkphp中的钩子函数，在Model基类中
     * 该方法在执行添加之前执行
     * Time: 20:21
     */
    protected function _before_insert(&$data,$option){
        $data['add_time'] = time();
        $data['upd_time'] = time();
        $data['goods_desc'] = my_filter($_POST['goods_desc']);

        //处理商品logo上传
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传目录
        $upload->savePath  =      'Admin/Goods/Logo/'; // 设置附件上传目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['logo']);
        if($info) {// 上传成功 获取上传文件信息，失败不作处理，不然不上传图片时error会报错$this->error($upload->getError())
            $data['logo'] = "/Public/Uploads/".$info['savepath'].$info['savename'];
        }

        //上传图片的缩略图处理
        if($data['logo']){
            $image = new \Think\Image();
            $image->open('.'.$data['logo']);
            //生成中小两种缩略图
            $data['sm_logo'] = "/Public/Uploads/".$info['savepath']."sm_".$info['savename'];
            $data['mid_logo'] = "/Public/Uploads/".$info['savepath']."mid_".$info['savename'];
            $image->thumb(580,500,6)->save('.'.$data['mid_logo']);
            $image->thumb(160,130,6)->save('.'.$data['sm_logo']);
        }

    }

    /**
     * 插入成功后的回调方法
     * @param $data 新增商品的ID
     */
    public function _after_insert($data){
        $id = $data['id'];

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传目录
        $upload->savePath  =      'Admin/Goods/Goods_pic/'; // 设置附件上传目录

        //上传多张图片,用数组收集
        $info = $upload->upload(array($_FILES['goods_pics']));
//        dump($info);die;

        $image = new \Think\Image();
        $gpModel = M('goods_pic');
        $datainfo['goods_id'] = $id;
        //循环遍历info,每次生成对应的缩略图，再将缩略图入库
        foreach($info as $v){
            $image->open($upload->rootPath.$v['savepath'].$v['savename']);
            //正常大小图片
            $datainfo['pic'] = "/Public/Uploads/".$v['savepath'].$v['savename'];
            //生成大中小三种缩略图
            $datainfo['sm_pic'] = "/Public/Uploads/".$v['savepath']."sm_".$v['savename'];
            $datainfo['mid_pic'] = "/Public/Uploads/".$v['savepath']."mid_".$v['savename'];
            $datainfo['big_pic'] = "/Public/Uploads/".$v['savepath']."big_".$v['savename'];
            $image->thumb(800,800,6)->save('.'.$datainfo['big_pic']);
            $image->thumb(350,350,6)->save('.'.$datainfo['mid_pic']);
            $image->thumb(50,50,6)->save('.'.$datainfo['sm_pic']);
            $gpModel->add($datainfo);
        }


        /* ***********商品属性*****************/
        $goods_attr_model = M('goods_attr');
        $g_a_data['goods_id'] = $id;
        //取出提交的属性值：
        $attr_val = I('post.attr_val');
        //dump($attr_val);die;
        foreach ($attr_val as $k=>$v){
            $g_a_data['attr_id'] = $k;
            $g_a_data['attr_value'] = implode(",",$v);
            //把数据存入goods_attr表
            if($g_a_data['attr_value']){//如果attr_value有东西，则添加，否则不添加
                $goods_attr_model->add($g_a_data);
            }
        }
//        dump($g_a_data);die;
        /* ***********end 商品属性*************/
    }

    /**
     * thinkphp中的钩子函数，在Model基类中
     * 该方法在删除操作之前执行
     * Time: 20:21
     */
    public function _before_delete($options){
//        print_r($options);
//        die;
        $logo_pic = M('goods')->field('logo,sm_logo,mid_logo')->find($options['where']['id']);
        foreach($logo_pic as $v){
            @unlink(".".$v);
        }

        //根据ID获取要删除的商品在商品相册中对应的信息
        $goods_pic = M('goods_pic')->where(array('goods_id'=>$options['where']['id']))->select();
        foreach($goods_pic as $v){
            @unlink(".".$v['pic']);
            @unlink(".".$v['sm_pic']);
            @unlink(".".$v['mid_pic']);
            @unlink(".".$v['big_pic']);
        }
        //删除数据库中的内容
        M('goods_pic')->where(array('goods_id'=>$options['where']['id']))->delete();
        //删除商品对应的属性
        M('goods_attr')->where(array('goods_id'=>$options['where']['id']))->delete();
    }

    /**
     * thinkphp中的钩子函数，在Model基类中
     * 该方法在更新操作之前执行
     * Time: 20:21
     */
    public function _before_update(&$data,$option){
        $data['upd_time'] = time();
        /*
         * option中 array(3) {["where"] => array(1) {["id"] => int(1)}
         */
        //先删除硬盘上的图片，图片的错误不为0
        if($_FILES['logo']['error'] === 0){//进行图片的修改
            //删除硬盘上原来的图片
            $pics = M('goods')->field('logo,sm_logo,mid_logo')->find($option['where']['id']);
            foreach($pics as $v){
                @unlink(".".$v);
            }

            //把修改后的图片存入数据库和硬盘
            /* **** 处理商品logo**/
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传的根路径
            $upload->savePath  =      'Admin/Goods/Logo/'; // 设置附件上传目录

            $info   =   $upload->uploadOne($_FILES['logo']);
            if($info) {// 上传错误提示错误信息
                $data['logo'] = "/Public/Uploads/".$info['savepath'].$info['savename'];
            }
            /* *** end  处理商品logo*/

            /* *********logo 缩略图***************/
            if($data['logo']){//判断是否有logo图片上传成功
                $image = new \Think\Image();
                $image->open('.'.$data['logo']);//打开图片

                $data['sm_logo'] = "/Public/Uploads/".$info['savepath'].'sm_'.$info['savename'];
                $data['mid_logo'] = "/Public/Uploads/".$info['savepath'].'mid_'.$info['savename'];
                $image->thumb(650, 650,6)->save(".".$data['mid_logo']);//生成中等缩略图图片 save后面是新图片的路径
                $image->thumb(130, 130,6)->save(".".$data['sm_logo']);//生成小的缩略图 save后面是新图片的路径
            }
            /* *********   end logo缩略图***************/
        }

        /* ***********************处理商品相册*************************/
        /* ****************商品相册******************/
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './Public/Uploads/'; // 设置附件上传的根路径
        $upload->savePath  =      'Admin/Goods/Goods_pic/'; // 设置附件上传目录

        $info   =   $upload->upload(array($_FILES['goods_pics']));//上传多张图片（图片的数组）

        //循环结果$info，每次循环，生成缩略图，并且把数据入库
        $image = new \Think\Image();
        $gpModel = M('goods_pic');
        foreach($info as $v){
            $image->open($upload->rootPath.$v['savepath'].$v['savename']);//打开图片
            $datainfo['goods_id'] = $option['where']['id'];
            $datainfo['pic'] = "/Public/Uploads/".$v['savepath'].$v['savename'];
            $datainfo['sm_pic'] = "/Public/Uploads/".$v['savepath'].'sm_'.$v['savename'];
            $datainfo['mid_pic'] = "/Public/Uploads/".$v['savepath'].'mid_'.$v['savename'];
            $datainfo['big_pic'] = "/Public/Uploads/".$v['savepath'].'big_'.$v['savename'];
            $image->thumb(800, 800,6)->save(".".$datainfo['big_pic']);//
            $image->thumb(350, 350,6)->save(".".$datainfo['mid_pic']);//
            $image->thumb(50, 50,6)->save(".".$datainfo['sm_pic']);//生成小的缩略图 save后面是新图片的路径


            $gpModel->add($datainfo);
        }
        /* **************************** end 商品相册****************************/

        /*****************************处理商品属性******************************/
        $goods_attr_model = M('goods_attr');
        $g_a_data['goods_id'] = $option['where']['id'];

        //将原来该商品对应的全部属性删掉，下面的操作相当于给商品添加属性
        $goods_attr_model->where(array('goods_id'=>$option['where']['id']))->delete();


        //取出提交的属性值：
        $attr_val = I('post.attr_val');
        foreach ($attr_val as $k=>$v){
            $g_a_data['attr_id'] = $k;
            $g_a_data['attr_value'] = implode(",",$v);
            //把数据存入goods_attr表
            if($g_a_data['attr_value']){//如果attr_value有东西，则添加，否则不添加
                $goods_attr_model->add($g_a_data);
            }
        }
        /****************************end处理商品属性***************************/
    }
}