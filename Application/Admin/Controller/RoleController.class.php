<?php
namespace Admin\Controller;
class RoleController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','角色管理');
    }
    //添加方法
    public function role_add(){
        if(IS_POST){
            $model = D('Role');
            if($model->create()){
                if($model->add()){
                    $this->success('添加角色成功！',U("Role/role_list"));
                    die;
                }
            }
            $this->error($model->getError());
            die;
            
        }else{
            //查出所有的权限，列在页面上
            $pris = D('Privilege')->getData();
            $this->assign('pris',$pris);
            
            $titles = array('name'=>'角色管理','sub'=>'角色添加页');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    
    public function role_list(){
        $lst = M('Role')->select();
        //SELECT GROUP_CONCAT(pri_name) FROM `jxshop_privilege` WHERE id IN(1,2,4,5,3,9)
        $pri_model = M("Privilege");
        foreach($lst as $k=>$v){
            $lst[$k]['pri_name']=$pri_model->where(array('id'=>array("in",$v['pri_ids'])))->getField("GROUP_CONCAT(pri_name)");
        }
        $this->assign('lst',$lst);
        $titles = array('name'=>'角色管理','sub'=>'角色列表页');
        $this->assign('titles',$titles);
        $this->display();
    }
    
    public function role_edit(){
        $model = D('Role');
        if(IS_POST){
            if($model->create()){
                if($model->save()){
                    $this->success('修改成功！',U('Role/role_list'));
                    die;
                }
            }
            $this->error($model->getError());
            die;
        }else{
            $info = $model->find(I('get.id'));
            $this->assign('info',$info);

            //查出所有的权限，列在页面上
            $pris = D('Privilege')->getData();
            $this->assign('pris',$pris);

            $data = D('Role')->field('pri_ids')->find(I('get.id'));
            $pri_ids = explode(",",$data['pri_ids']);
            $this->assign('pri_ids',$pri_ids);

            $titles = array('name'=>'角色管理','sub'=>'角色列表页');
            $this->assign('titles',$titles);
            $this->display();
        }
    }
    
    public function role_del(){
        $model = D('Role');
        if($model->delete(I('get.id'))){
            echo json_encode(array('status'=>1));
            die;
        }
            echo json_encode(array('status'=>0));
    }
    
    
    
    
    
    
    
    
}