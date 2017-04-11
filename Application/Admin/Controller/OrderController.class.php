<?php
namespace Admin\Controller;
class OrderController extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->assign('sel_name','订单管理');
    }

    /**
     * 订单列表显示
     */
    public function showlist(){
        $titles = array('name'=>'订单管理','sub'=>'订单列表');
        $this->assign('titles',$titles);

        $info = D('Order')->order('order_id desc')->select();
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * 订单详情显示
     */
    public function detail(){
        $titles = array('name'=>'订单管理','sub'=>'订单详情');
        $this->assign('titles',$titles);

        //获取当前点击的订单ID
        $order_id = I('get.order_id');
        //获取订单信息以及订单对应的会员名称和收货人信息
        $orderinfo  = D('Order')
                    ->alias('o')
                    ->join('__USER__ u on u.user_id = o.user_id')
                    ->join('__CONSIGNEE__ c on c.cgn_id = o.cgn_id')
                    ->field('o.*,u.user_name,c.*')
                    ->find($order_id);
        $this->assign('orderinfo',$orderinfo);

        //获取与订单相关联的商品信息
        $goodsinfo  = D('OrderGoods')
                    ->alias('og')
                    ->join('__GOODS__ g on og.goods_id = g.id ')
                    ->field('og.*,g.goods_name')
                    ->where(array('order_id'=>$order_id))
                    ->select();
        $this->assign('goodsinfo',$goodsinfo);
        //dump($orderinfo);
        //dump($goodsinfo);die;
        //支付方式定义,下标为$orderinfo['order_pay']
        $this -> assign('paymethods',array('0'=>'支付宝','1'=>'微信','2'=>'银行卡'));

        $this->display();
    }

    /**
     * 订单删除操作
     */
    function order_del(){
        $model = D('Order');
        if($model->delete(I('get.id'))){
            echo json_encode(array('status'=>1));
            die;
        }
        echo json_encode(array('status'=>0));
        die;
    }

    /**
     * PHP导出订单数据为excel格式
     */
    public function putExcel(){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=php02_order_".time().".xls");//设置文件名
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        $title = array('订单号','总金额','是否付款','是否发货','下单时间');//表头
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        $data = M('order')->field('order_number,order_price,order_pay,is_send,add_time')->select();
        //$data = array(array(1,2,3,4,5),array('a','b','c','e','f'));//取出数据
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);

            }
            echo implode("\n",$data);
            die;
        }

    }
}