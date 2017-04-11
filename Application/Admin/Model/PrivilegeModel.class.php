<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model{
    //验证允许接受的字段（添加时）
   protected $insertFields="pri_name,module_name,controller_name,action_name,parent_id";
   protected $updateFields="id,pri_name,module_name,controller_name,action_name,parent_id";
    
    //对字段进行验证
    protected $_validate=array(
        array('pri_name','require',"权限名称 必须填写！！",1),
    );
    
    
    /*
     * 获取数据，并进行排序，返回给控制器
     */
    public function getData(){
        $data = $this->select();//在当前模型中，查询当前数据表，得到所有数据
        return $this->_getTree($data);
    }
    
    /*
     * 对数据进行排序
     */
    private function _getTree($data,$parent_id=0,$level=0){
        static $_result = array();
        
        foreach($data as $k=>$v){
            if($v['parent_id'] == $parent_id){
                $v['level'] = $level;
                $_result[]=$v;
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_result;
    }
    
    
    //判断这个权限是否能被删除
    public function isDel($id){
        $count = $this->where(array("parent_id"=>$id))->count();
        return $count;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}