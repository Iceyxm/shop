<?php
namespace Admin\Controller;
class TypeController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','类型和属性管理');
    }
    //添加方法
    public function type_add(){
        if(IS_POST){
            $model = D('type');
            if($model->create()){
                if($model->add()){
                    $this->success('添加类型成功！',U("Type/type_list"));
                    die;
                }
            }
            $this->error($model->getError());
            die;
            
        }else{
            $titles = array('name'=>'类型管理','sub'=>'类型添加页');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    
    public function type_list(){
        $lst = M('Type')->select();
        $this->assign('lst',$lst);
        $titles = array('name'=>'类型管理','sub'=>'类型列表页');
        $this->assign('titles',$titles);

        $this->display();
    }
    
    public function type_edit(){
        $model = D('Type');
        if(IS_POST){
            if($model->create()){
                if($model->save()){
                    $this->success('修改类型成功！',U('Type/type_list'));
                    die;
                }
            }
            $this->error($model->getError());
            die;
        }else{
            $info = $model->find(I('get.id'));
            $this->assign('info',$info);
            $titles = array('name'=>'类型管理','sub'=>'类型列表页');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    public function type_del(){
        $model = D('Type');
        if($model->delete(I('get.id'))){
            echo json_encode(array('status'=>1));
            die;
        }
            echo json_encode(array('status'=>0));
    }
    
    
    
    
    
    
    
    
}