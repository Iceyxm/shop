<?php
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model{
    //验证允许接受的字段（添加时）
    protected $insertFields="attr_name,attr_type,attr_option_value,type_id";
    protected $updateFields="id,attr_name,attr_type,attr_option_value,type_id";

    //对字段进行验证
    protected $_validate=array(
        array('attr_name','require',"属性名称必须填写！",1),
        array('attr_type','require',"属性对应类型必须填写！",1),
    );


    /**
     * tp中的钩子函数，在添加之前会自动执行！
     * @see \Think\Model::_before_insert()
     */
    protected function _before_insert(&$data,$option){
        $data['attr_option_value'] = str_replace('，',',',$data['attr_option_value']);

        if ($data['attr_type'] == "唯一"){
            $data['attr_option_value'] = '';
        }
    }



    /* 修改前的钩子函数 */
    public function _before_update(&$data,$option){
        $data['attr_option_value'] = str_replace('，',',',$data['attr_option_value']);

        if ($data['attr_type'] == "唯一"){
            $data['attr_option_value'] = '';
        }

    }






}