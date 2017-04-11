<?php
namespace Home\Controller;
use Think\Controller;
class ShopController extends Controller {
    /**
     * 将商品加入购物车，此处使用的Cart类是cookie_Cart
     */
    function addCart(){
        if (IS_AJAX){
            $goods_id = I('get.goods_id');
            //根据添加商品的ID获取该商品的详细信息
            $info = D('Goods')->find($goods_id);
            //把商品信息组成数组的形式
            $data['goods_id'] = $info['id'];
            $data['goods_name'] = $info['goods_name'];
            $data['goods_price'] = $info['goods_price'];
            $data['goods_buy_number'] = 1;
            $data['goods_total_price'] = $info['goods_price'];

            //将商品加入购物车
            $cart = new \Home\Common\Cart();
            $cart->add($data);

            //返回添加商品的总数量和总价格
            $number_price = $cart->getNumberPrice();
            /*array(2) {
                ["number"] => int(1)
                ["price"] => int(0)
            }*/
            //将最新的购物车商品总数量和总价返回给客户端
            echo json_encode($number_price);
        }
    }

    /**
     * 购物车列表信息展示
     */
    function flow1(){
        $cart = new \Home\Common\Cart();
        //获得购物车里的商品信息
        $cartinfo = $cart->getCartInfo();

        //获得购物车商品的图片信息，根据商品的ID
        $goods_ids = implode(',',array_keys($cartinfo));
        $logoinfo = D('Goods')->field('id,sm_logo')->select($goods_ids);

        //整合logo信息加入到cartinfo里面，才能在购物车列表页显示
        foreach($cartinfo as $k=>$v){
            foreach($logoinfo as $vv){
                if ($k == $vv['id']){
                    $cartinfo[$k]['logo'] = $vv['sm_logo'];
                }
            }
        }
        //dump($cartinfo);die;
        $this->assign('cartinfo',$cartinfo);
        //获得购物车商品金额总计
        $number_price = $cart->getNumberPrice();
        $this->assign('number_price',$number_price);

        $this->display();
    }

    /**
     * 改变购物车商品数量
     */
    function changeNumber(){
        if (IS_AJAX){
            //获取客户端传递过来的goods_id和商品num
            $goods_id = I('post.goods_id');
            $num = I('post.num');

            //改变购物车商品数量
            $cart = new \Home\Common\Cart();
            $xiaoji_price = $cart->changeNumber($num,$goods_id);

            //更新当前购物车商品总价
            $number_price = $cart->getNumberPrice();

            //返回数据给客户端，Ajax更新购物车商品数量和总价
            echo json_encode(array(
                'total_price'=>$number_price['price'],
                'xiaoji_price'=>$xiaoji_price
            ));
        }
    }

    /**
     * 根据商品ID删除指定商品
     */
    function delGoods(){
        //得到被删除商品的ID
        $goods_id = I('get.goods_id');

        //根据传递的商品ID删除购物车指定的商品
        $cart = new \Home\Common\Cart();
        $cart->del($goods_id);

        //从新获取删除商品后购物车商品的总价
        $number_price = $cart->getNumberPrice();
        echo json_encode($number_price);
    }

    /**
     * 订单结算，结算时要求用户必须登录，跳转到登录页面，登陆后再跳回结算页面
     */
    function flow2(){
        if(IS_POST){
            /*收集表单信息
            给jxshop_order和jxshop_order_goods表形成记录
            之后要清空购物车信息*/

            /**  *****************生成order表的记录**********************/
            $cart = new \Home\Common\Cart();
            //获取购物车商品数量和总价
            $number_price = $cart->getNumberPrice();

            $data = I('post.');//获取表单提交内容
            //拼接数据表必须的表单无法直接获取的数据
            $data['user_id'] = session('user_id');
            //组建订单标识，每个订单有唯一的订单号
            $data['order_number'] = "jxshop-".date("Y-m-d",time())."-".mt_rand(1000,9999);
            $data['order_price'] = $number_price['price'];
            $data['add_time'] = $data['upd_time'] = time();
            //生成订单记录
            $order_id = D('Order')->add($data);
            /**  *****************end 生成order表的记录**********************/


            /**  *****************生成order_goods表的记录**********************/
            $cartinfo = $cart->getCartInfo();
            $data2 = array();//定义一个存储订单关联的商品信息数组
            foreach($cartinfo as $k=>$v){
                $data2['order_id'] = $order_id;
                $data2['goods_id'] = $k;
                $data2['goods_price'] = $v['goods_price'];
                $data2['goods_number'] = $v['goods_buy_number'];
                $data2['goods_total_price'] = $v['goods_total_price'];
                D('OrderGoods')->add($data2);
            }
            //清空购物车信息
            $cart->delall();
            /**  *****************end 生成order_goods表的记录**********************/
            echo "订单形成中。。。。";

            /**************支付宝支付功能块********************/
            /*①签约产品的账号必须是“公司账号”
            ② 商城系统必须是“线上”项目
            ③ 签约产品使用的域名 与 项目域名必须一致*/

            /**************请求参数***********/
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $WIDout_trade_no = $data['order_number'];
            //订单名称，必填
            $WIDsubject = $data['order_number'];
            //付款金额，必填
            $WIDtotal_fee = $number_price['price'];
            $fm = <<<eof
        <form action="/Application/Common/Plugins/alipay/alipayapi.php" method="post">
            <input type="hidden" name="WIDout_trade_no" value="$WIDout_trade_no" />
            <input type="hidden" name="WIDsubject" value="$WIDsubject" />
            <input type="hidden" name="WIDtotal_fee" value="$WIDtotal_fee" />
            <input type="hidden" name="WIDbody" value="" />
        </form>
        <script type="text/javascript">
            document.getElementsByTagName('form')[0].submit();
        </script>
eof;
            echo $fm;
            /**************end 请求参数***********/
            /**************end 支付宝支付功能块********************/

        }else{
            //取出session里面的user_name或user_id，判断用户登陆状态
            $user_id = session('user_id');
            if (empty($user_id)){
                //定义回跳地址
                session('back_url','Shop/flow2');
                //跳转到登录页
                $this->redirect('User/login');
            }

            $cart = new \Home\Common\Cart();
            //获得购物车里的商品信息
            $cartinfo = $cart->getCartInfo();

            //获取该会员用户对应的收货人信息,在订单结算页面动态显示该会员对应的收货人地址
            $cgninfo    = D('Consignee')
                        ->alias('c')
                        ->join('__USER__ u on u.user_id = c.user_id')
                        ->field('u.user_id,c.*')
                        ->where(array('c.user_id'=>$user_id))
                        ->select();
            //dump($cgninfo);die;
            $this->assign('cgninfo',$cgninfo);

            //获得购物车商品的图片信息，根据商品的ID
            $goods_ids = implode(',',array_keys($cartinfo));
            $logoinfo = D('Goods')->field('id,sm_logo')->select($goods_ids);

            //整合logo信息加入到cartinfo里面，才能在购物车列表页显示
            foreach($cartinfo as $k=>$v){
                foreach($logoinfo as $vv){
                    if ($k == $vv['id']){
                        $cartinfo[$k]['logo'] = $vv['sm_logo'];
                    }
                }
            }
            //dump($cartinfo);die;
            $this->assign('cartinfo',$cartinfo);
            //获得购物车商品金额总计
            $number_price = $cart->getNumberPrice();
            $this->assign('number_price',$number_price);
            $this->display();
        }

    }
}