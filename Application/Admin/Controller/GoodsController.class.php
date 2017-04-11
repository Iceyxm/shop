<?php
namespace Admin\Controller;
class GoodsController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','商品管理');
    }
    /**
     * 商品添加
     */
    public function goods_add(){
        if (IS_POST){
//            dump(I('post.'));die;
            $model = D('Goods');
            if ($model->create()){
                if($model->add()){
                    $this->success('商品添加成功！',U('Goods/goods_list'));
                }
            }else{
                $error = $model->getError();
                $this->error($error);
                die;
            }
        }else{
            //查询所有的分类
            $data = D('Category')->getData();
            $this->assign('data',$data);

            //查询出所有的类型
            $type_data = M('Type')->select();
            $this->assign('type_data',$type_data);

            $titles = array('name'=>'商品管理','sub'=>'商品添加');
            $this->assign('titles',$titles);
            $this->display();
        }
    }

    /**
     * 商品列表
     */
    public function goods_list(){
        $lst = M('Goods')
             ->alias('g')
             ->field('g.*,c.cat_name')
             ->join('LEFT JOIN __CATEGORY__ c ON g.cat_id = c.id')
             ->select();

        $titles = array('name'=>'商品管理','sub'=>'商品列表');
        $this->assign('titles',$titles);
        $this->assign('lst',$lst);//分配数据到模版
        $this->display('goods_list');
    }

    /**
     * 商品删除
     */
    public function goods_del(){
        $id = I('get.id');
        if(D('Goods')->delete($id)){
            $status = 1;
        }else{
            $status = 0;
        }
        echo json_encode(array('status'=>$status));
    }

    /**
     * 商品修改
     */
    public function goods_edit(){
        if (IS_POST){
//            dump($_FILES);die;
            $id = I('post.id');
            $model = D('Goods');
            if ($model->create()){
                if ($model->save()){
                    $this->success('修改成功！',U('goods_list'));
                    die;
                }else{
                    $error = $model->getError();
                    $this->error();
                }
            }else{
                $error = $model->getError();
                $this->error();
            }
        }else{
            $id = I('get.id');
            //商品信息
            $info = M('goods')->find($id);
            $this->assign('info',$info);

            //对应的商品相册信息
            $pics = M('goods_pic')->field('pic')->where(array('goods_id'=>$id))->select();
            $this->assign('pics',$pics);

            //查询所有的分类
            $data = D('Category')->getData();
            $this->assign('data',$data);

            //查询所有的类型
            $type_data = M('Type')->select();
            $this->assign('type_data',$type_data);

            $titles = array('name'=>'商品管理','sub'=>'商品修改');
            $this->assign('titles',$titles);
            $this->display();
        }
    }

    /**
     * 商品相册删除，Ajax方法
     */
    public function goods_ajax_del_pic(){
        //获取要删除的商品id
        $goods_id = I('post.gid');
        $src = I('post.g_p_path');
        //根据以上两个条件可以查询唯一一条图片信息
        $pic_data = M('goods_pic')->where(array('goods_id'=>$goods_id,'pic'=>$src))->find();
//        print_r($pic_data);die;

        //删除磁盘上存储的点击的图片
        @unlink(".".$pic_data['pic']);
        @unlink(".".$pic_data['sm_pic']);
        @unlink(".".$pic_data['mid_pic']);
        @unlink(".".$pic_data['big_pic']);

        //删除商品信息表相关数据
        if (M('goods_pic')->where(array('goods_id'=>$goods_id,'pic'=>$src))->delete()){
            echo json_encode(array('status'=>1));//删除成功时返回的状态码
            die;
        }
        echo json_encode(array('status'=>0));//删除失败时返回的状态码，客户端通过返回的信息对页面上的图片进行处理
    }

    /**
     * 根据用户所选的类型，查找出对应的属性【添加商品时】
     */
    public function get_attr_by_type(){
        $type_id = I('get.type_id');
        $attr_list = M('Attribute')->where(array('type_id'=>$type_id))->select();
        //print_r($attr_list);die;
        echo json_encode($attr_list);die;
    }

    /**
     * 根据用户所选的类型和当前商品，查找出对应的属性和添加时所选的属性值【修改商品时】
     */
    public function get_attr_by_type_edit(){
        $type_id    = I('get.type_id');
        $goods_id   = I('get.goods_id');
        $attr_list  = M('Attribute')
                    ->alias("a")
                    ->field("a.*,(select ga.attr_value  from jxshop_goods_attr ga where ga.attr_id = a.id and ga.goods_id={$goods_id}) as attr_value")
                    ->where(array('type_id'=>$type_id))
                    ->select();
//        print_r($attr_list);die;
        echo json_encode($attr_list);die;
    }



}