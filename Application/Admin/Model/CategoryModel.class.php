<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/28
 * Time: 23:23
 */
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    //验证允许接受的字段（添加时）
    protected $insertFields = "cat_name,parent_id";
    protected $updateFields = "id,cat_name";

    protected $_validate = array(
        array('cat_name','require','分类名称必须填写',1),
    );

    public function getData(){
        $data = $this->select();
        return $this->_getTree($data);
    }

    private function _getTree($data,$parent_id=0,$level=0){
        static $_result = array();
        foreach($data as $v){
            if ($v['parent_id']==$parent_id){
                $v['level'] = $level;
                $_result[] = $v;
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_result;
    }

    public function isDel($id){
        $count = $this->where(array('parent_id'=>$id))->count();
        return $count;
    }
}