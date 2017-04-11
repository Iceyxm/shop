<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 23:14
 */
namespace Admin\Controller;
class CategoryController extends BaseController{
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','分类管理');
    }
    public function cat_list(){
//        $data = M('Category')->select();
        $data = D('Category')->getData();
        $this->assign('data',$data);
        $titles = array('name'=>'分类管理','sub'=>'分类列表');
        $this->assign('titles',$titles);

        $this->display();
    }

    public function cat_add(){
        $cat_model = D('Category');
        if (IS_POST){
            if ($cat_model->create()){
                if ($cat_model->add()){
                    $this->success('添加成功！',U('cat_list'));
                    die;
                }
            }
            $error = $cat_model->getError();
            $this->error($error);
            die;
        }else{
            $data = $cat_model->getData();
            $this->assign('data',$data);
            $titles = array('name'=>'分类管理','sub'=>'分类添加');
            $this->assign('titles',$titles);

            $this->display();
        }

    }

    public function cat_edit(){
        $cat_model = D('Category');
        if (IS_POST){
            if ($cat_model->create()){
                if ($cat_model->save()){
                    $this->success('修改成功！',U('cat_list'));
                    die;
                }
            }
            $error = $cat_model->getError();
            $this->error($error);
            die;

        }else{
            $model = D('Category');
            $data = $model->getData();
            $this->assign('data',$data);

            $titles = array('name'=>'分类管理','sub'=>'修改分类');
            $this->assign('titles',$titles);

            $info = $model->find(I('get.id'));
            $this->assign('info',$info);

            $this->display();
        }

    }

    public function cat_del(){
        $id = I('get.id');
        $model = D('Category');
        $result = $model->isDel($id);
        if($result){
            echo json_encode(array('status'=>0,'errMsg'=>'请删除这个分类下的所有子分类后再进行删除！'));
            die;
        }else{
            if($model->delete($id)){
                echo json_encode(array('status'=>1));
                die;
            }
        }
    }
}