<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
    public function __construct(){
        //如果子类有自己的构造方法，那么必须先运行父类的构造方法
        parent::__construct();
        
        $admin_id = session('admin_id');
        $admin_name = M('Admin')->where(array('id'=>$admin_id))->select();
        if(!$admin_id){
            $this->error("请登录！",U("Admin/Login/login"));
            die;
        }
        /*说明：
         *admin_id =1 的人登录了 之后 ，没有退出，也没有清空  admin_pri就会一直在session中
         *此时，这个人在当前浏览器，重新打开一个页面，登录了普通管理员
         */
        
        //管理员进入系统，需要根据自己的ID，判断是否在session已经存入了权限，如果有，则直接使用，没有，进行查询
        $pris = session("admin_pri_".$admin_id);
        if(!$pris){
                if($admin_id == 1){
                    $pris = M("Privilege")->select();
                }else{
                    //查出当前管理员拥有的角色ID们
                    $role_ids = M('Admin')->where(array('id'=>$admin_id))->getField("role_ids");
                    //查询出角色表中拥有的权限ID们，条件是：角色的ID，在$role_ids里面
                    $roles = M('Role')->where(array('id'=>array('in',$role_ids)))->getField("group_concat(pri_ids)");
                    $roles = array_unique(explode(",",$roles));//去重，用array_unique()对数组中重复的值去重
                   //根据角色表中这些权限的ID，取出所拥有的权限
                    $pris = M("Privilege")->where(array('id'=>array('in',$roles)))->select();
                    session("admin_allow_pri_".$admin_id,$roles);//把当前管理员拥有的权限ID们（数组），存入session
                }
                    //权限查询完毕后，存入session
                    session("admin_pri_".$admin_id,$pris);//  权限列表
        }
        
        //处理越权访问
        if(CONTROLLER_NAME != "Index"){
            if($admin_id!=1){//超级管理员拥有所有权限
                //拿到该管理员所拥有的权限
                $pri_ids_ad=session("admin_allow_pri_".$admin_id);
                //根据用户所访问的页面，得到模块名、控制器名、方法名，去权限表中，能够确认唯一一条数据---我们要得到这条数据的ID，
                $p_id = M('Privilege')->where(array('module_name'=>MODULE_NAME,'controller_name'=>CONTROLLER_NAME,'action_name'=>ACTION_NAME))->getField('id');
                //拿到这个ID后，和这个管理员所拥有的权限进行比对，如果在拥有的权限里面，说明没问题，反之，则越权访问
               if(!in_array($p_id,$pri_ids_ad)){
                   $this->error('请登录',U("Admin/Login/login"));
                   die;
               }
            }
        }
//         dump($pris);die;
        //将权限全部读取出来分配到layout公用布局，作为菜单显示
        $pris = $this->_getMenu($pris);//调用_getMenu方法限定读取权限的前两级，菜单只显示前两级
        $this->assign('menu',$pris);//把所有的权限分配到页面，做为菜单使用
       
        
    }
    
    /*
     * 取出权限的前两级
     */
    private function _getMenu($menus){
        $ret = array();
        //没有使用递归调用，之循环读取一遍，找到父级下的一级子菜单就停止遍历了
        foreach($menus as $k=>$v){
            if($v['parent_id'] == 0){//第一级
                foreach($menus as $k1=>$v1){
                   if($v1['parent_id'] == $v['id']){
                       $v['children'][] = $v1;
                   }
                }
                $ret[]=$v;
            }
        }
        
        return $ret;
    }
    
    
    
    
    
    
    
    
    
    
    
    
}