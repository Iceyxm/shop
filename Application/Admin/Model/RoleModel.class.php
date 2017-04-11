<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model{
    //验证允许接受的字段（添加时）
   protected $insertFields="role_name,pri_ids";
   protected $updateFields="id,role_name,pri_ids";
    
    //对字段进行验证
    protected $_validate=array(
        array('role_name','require',"角色名称必须填写！",1),
    );
    
    
    /**
     * tp中的钩子函数，在添加之前会自动执行！
     * @see \Think\Model::_before_insert()
     */
    protected function _before_insert(&$data,$option){
        //接收权限数组，转换成字符串
        $data['pri_ids'] = implode(',',$data['pri_ids']); 
    }
    

    /* 修改前的钩子函数 */
    public function _before_update(&$data,$option){
        $data['pri_ids'] = implode(',',$data['pri_ids']);
    }
    
    
    
    
    
    
    
    
    
}