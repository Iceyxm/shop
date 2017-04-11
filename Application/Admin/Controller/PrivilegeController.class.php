<?php
namespace Admin\Controller;
class PrivilegeController extends BaseController{
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','权限管理');
    }
    public function pri_list(){
//         $data = M('Privilege')->select();
        $data = D('Privilege')->getData();
//         dump($data);die;
        $this->assign('data',$data);
        $titles = array('name'=>'分类管理','sub'=>'分类列表');
        $this->assign('titles',$titles);
        
        $this->display();
    }
    
    public function pri_add(){
        $pri_model = D('Privilege');
        if(IS_POST){
           if($pri_model->create()){
               if($pri_model->add()){
                   $this->success('添加成功！',U('pri_list'));
                   die;
               }
           }
           //调用create方法，如果失败，则走到这里，获取错误信息，进行页面跳转。
           //create方法验证成功，但是添加出错，也走到这里，获取错误信息，进行页面的跳转。
           $error = $pri_model->getError();
           $this->error($error);
           die;
        }else{
            $data = $pri_model->getData();//取出所有的父分类
            $this->assign('data',$data);
            $titles = array('name'=>'权限管理','sub'=>'权限添加');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    
    public function pri_edit(){
        $model = D('Privilege');
        if(IS_POST){
//             dump(I('post.'));die;
            if($model->create()){
                if($model->save()){
                    $this->success('修改成功！',U('pri_list'));
                    die;
                }
            }
            $error = $model->getError();
            $this->error($error);
            die;
        }else{
            
            $data = $model->getData();//取出所有的父分类
            $this->assign('data',$data);
            
            //查询分类的数据（根据主键ID）
            $info = $model->find(I('get.id'));
            $this->assign('info',$info);
            $titles = array('name'=>'权限管理','sub'=>'权限修改');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    
    public function pri_del(){
        $id = I('get.id');
        $model = D('Privilege');
        $resut = $model->isDel($id);
        if($resut){
            echo json_encode(array('status'=>0,'errMsg'=>'请删除这个分类下的所有子分类后，再进行删除'));
            die;
        }else{
            if($model->delete($id)){
                echo json_encode(array('status'=>1));
                die;
            }else{
                echo json_encode(array('status'=>0,'errMsg'=>'删除失败，请联系管理员'));
                die;
            }
        }
    }
    
    
}















