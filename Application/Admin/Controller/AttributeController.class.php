<?php
namespace Admin\Controller;
class AttributeController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','属性和属性管理');
    }
    //添加方法
    public function attr_add(){
        if(IS_POST){
            $model = D('Attribute');
            if($model->create()){
                if($model->add()){
                    $this->success('添加属性成功！',U("Attribute/attr_list",array("type_id"=>I('post.type_id')),false));
                    die;
                }
            }
            $this->error($model->getError());
            die;
            
        }else{
            $titles = array('name'=>'属性管理','sub'=>'属性添加页');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    
    public function attr_list(){
        $lst = M('Attribute')->where(array('type_id'=>I('get.type_id')))->select();
//        dump($lst);die;
        $this->assign('lst',$lst);
        $titles = array('name'=>'属性管理','sub'=>'属性列表页');
        $this->assign('titles',$titles);

        $this->display();
    }
    
    public function attr_edit(){
        $model = D('Attribute');
        if(IS_POST){
            if($model->create()){
                if($model->save()){
                    $this->success('修改属性成功！',U('Attribute/attr_list'));
                    die;
                }
            }
            $this->error($model->getError());
            die;
        }else{
            $info = $model->find(I('get.id'));
            $this->assign('info',$info);
            $titles = array('name'=>'属性管理','sub'=>'属性列表页');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    public function attr_del(){
        $model = D('Attribute');
        if($model->delete(I('get.id'))){
            echo json_encode(array('status'=>1));
            die;
        }
            echo json_encode(array('status'=>0));
    }
    
    
    
    
    
    
    
    
}