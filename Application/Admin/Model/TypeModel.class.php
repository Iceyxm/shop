<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model{
    //验证允许接受的字段（添加时）
    protected $insertFields="type_name";
    protected $updateFields="id,type_name";

    //对字段进行验证
    protected $_validate=array(
        array('type_name','require',"类型名称必须填写！",1),
    );


    /**
     * tp中的钩子函数，在添加之前会自动执行！
     * @see \Think\Model::_before_insert()
     */
    protected function _before_insert(&$data,$option){

    }



    /* 修改前的钩子函数 */
    public function _before_update(&$data,$option){


    }






}