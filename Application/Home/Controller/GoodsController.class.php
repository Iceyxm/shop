<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    /**
     * 商品列表
     */
    public function showlist(){
//        $goodsinfo   =  M('Goods')
//                    ->  order('id desc')
//                    ->  field('id,goods_name,goods_price,sm_logo')
//                    ->  select();
        $goodsinfo  = M('goods')
                    ->query("select id,goods_name,goods_price,sm_logo from __GOODS__ order by id desc");
        $this->assign('goodsinfo',$goodsinfo);
        $this->display();
    }

    /**
     * 商品详情
     */
    public function detail(){
        $goods_id = I('get.goods_id');
        //点击查看的商品的基本信息
        $goodsinfo = D('Goods')->find($goods_id);
        $this->assign('goodsinfo',$goodsinfo);

        //获得商品的唯一属性
        /*$onlyinfo   = D('goods_attr')
                    ->alias('ga')
                    ->join('__ATTRIBUTE__ a on ga.attr_id=a.id')
                    ->where(array('ga.goods_id'=>$goods_id,'a.attr_type'=>'唯一'))
                    ->field('ga.attr_id,a.attr_name,ga.attr_value')
                    ->select();*/
        $onlyinfo   = D('goods_attr')
                    ->query("select ga.attr_id,a.attr_name,ga.attr_value from jxshop.jxshop_goods_attr ga INNER JOIN jxshop.jxshop_attribute a
                on a.id=ga.attr_id WHERE ga.goods_id=$goods_id and a.attr_type='唯一'");
        $this->assign('onlyinfo',$onlyinfo);

        //获得商品的可选属性
        /*$manyinfo = D('goods_attr')
            ->alias('ga')
            ->join('__ATTRIBUTE__ a on ga.attr_id=a.id')
            ->where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'可选'))
            ->field('ga.attr_id,a.attr_name,group_concat(ga.attr_value) attr_values')
            ->group('ga.attr_id')
            ->select();*/
        $manyinfo   = D('goods_attr')
            ->query("select ga.attr_id,a.attr_name,group_concat(ga.attr_value) attr_value from jxshop.jxshop_goods_attr ga INNER JOIN jxshop.jxshop_attribute a
                on a.id=ga.attr_id WHERE ga.goods_id=$goods_id and a.attr_type='可选' GROUP BY ga.attr_id");
        foreach($manyinfo as $k=>$v){
            $manyinfo[$k]['values'] = explode(',',$v['attr_value']);
        }
        $this->assign('manyinfo',$manyinfo);

        //展示商品相册
        $picsinfo = D('goods_pic')->where(array('goods_id'=>$goods_id))->select();
        $this->assign('picsinfo',$picsinfo);

        $this->display();
    }
}