<?php
namespace Admin\Controller;
class AdminController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','管理员管理');
    }
    /**
     * 管理员添加
     */
    public function admin_add(){
        if (IS_POST){
            $model = D('Admin');
            if ($model->create()){
                if($model->add()){
                    $this->success('管理员添加成功！',U('Admin/admin_list'));
                    die;
                }
            }
            $this->error($model->getError());
            die;
        }else{
            $roles = M('Role')->select();
            $this->assign('roles',$roles);

            $titles = array('name'=>'管理员管理','sub'=>'管理员添加');
            $this->assign('titles',$titles);
            $this->display();
        }
    }

    /**
     * 管理员列表
     */
    public function admin_list(){
        $lst = M('Admin')->select();
        $r_model = M('Role');
        foreach($lst as $k=>$v){
            $lst[$k]['roles'] = $r_model->where(array('id'=>array('in',$v['role_ids'])))->getField("group_concat(role_name)");

        }
        $titles = array('name'=>'管理员管理','sub'=>'管理员列表');
        $this->assign('titles',$titles);
        $this->assign('lst',$lst);//分配数据到模版
        $this->display('admin_list');
    }

    /**
     * 管理员删除
     */
    public function admin_del(){
        $id = I('get.id');
        if(D('Admin')->delete($id)){
            $status = 1;
        }else{
            $status = 0;
        }
        echo json_encode(array('status'=>$status));
    }

    /**
     * 管理员修改
     */
    public function admin_edit(){
        $model = D('Admin');
        if (IS_POST){
            $id = I('post.id');
            if ($model->create()){
                if ($model->save()){
                    $this->success('管理员修改成功！',U('admin_list'));
                    die;
                }
            }
            $this->error($model->getError());
            die;
        }else{
            $info = $model->find(I('get.id'));
            $info['role_ids'] = explode(',',$info['role_ids']);
            $this->assign('info',$info);

            //查询出所有的角色：
            $roles = M('Role')->select();
            $this->assign('roles',$roles);

            $titles = array('name'=>'管理员管理','sub'=>'管理员修改');
            $this->assign('titles',$titles);
            $this->display();
        }
    }

    /**
     * 管理员退出登录
     */
    public function logout(){
        session(null);
        $this->redirect('Admin/Login/login');
        die;
    }
}