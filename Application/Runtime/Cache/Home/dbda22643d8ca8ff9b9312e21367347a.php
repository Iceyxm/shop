<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>京西商城</title>
    <link rel="stylesheet" href="<?php echo C('HOME_CSS_PATH');?>base.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('HOME_CSS_PATH');?>global.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('HOME_CSS_PATH');?>header.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('HOME_CSS_PATH');?>login.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('HOME_CSS_PATH');?>footer.css" type="text/css">
    <script type="text/javascript" src="<?php echo C('HOME_JS_PATH');?>jquery-1.8.3.min.js"></script>
</head>
<body>
    <!-- 顶部导航 start -->
    <div class="topnav">
        <div class="topnav_bd w990 bc">
            <div class="topnav_left">
                
            </div>
            <div class="topnav_right fr">
                <?php if(!empty($_SESSION['user_name'])): ?><ul>
                        <li>您好，<span style="font-size: 22px;color: #0b94ea;">【<?php echo (session('user_name')); ?>】</span>欢迎来到京西！[<a href="<?php echo U('User/logout');?>">退出系统</a>] [<a href="register.html">免费注册</a>] </li>
                        <li class="line">|</li>
                        <li>我的订单</li>
                        <li class="line">|</li>
                        <li>客户服务</li>
                    </ul>
                    <?php else: ?>
                    <ul>
                        <li>您好，欢迎来到京西！[<a href="<?php echo U('User/login');?>">登录</a>] [<a href="<?php echo U('User/regist');?>">免费注册</a>] </li>
                        <li class="line">|</li>
                        <li>我的订单</li>
                        <li class="line">|</li>
                        <li>客户服务</li>
                    </ul><?php endif; ?>
            </div>
        </div>
    </div>
    <!-- 顶部导航 end -->
    
    <div style="clear:both;"></div>

    <!-- 页面头部 start -->
    <div class="header w990 bc mt15">
        <div class="logo w990">
            <h2 class="fl"><a href="index.html"><img src="<?php echo C('HOME_IMAGE_PATH');?>logo.png" alt="京西商城"></a></h2>

            <!--控制器为Shop情况，就显示下边的div-->
            <?php if((CONTROLLER_NAME) == "Shop"): ?><div class="flow fr <?php echo (ACTION_NAME); ?>"><!--把当前"操作方法"名称设置为class类-->
                    <ul>
                        <li <?php if((ACTION_NAME) == "flow1"): ?>class="cur"<?php endif; ?> >1.我的购物车</li>
                        <li <?php if((ACTION_NAME) == "flow2"): ?>class="cur"<?php endif; ?> >2.填写核对订单信息</li>
                        <li <?php if((ACTION_NAME) == "flow3"): ?>class="cur"<?php endif; ?> >3.成功提交订单</li>
                    </ul>
                </div><?php endif; ?>

        </div>
    </div>
    <!-- 页面头部 end -->




<link rel="stylesheet" href="<?php echo C('HOME_CSS_PATH');?>cart.css" type="text/css">
<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="mycart w990 mt10 bc">
    <h2><span>我的购物车</span></h2>
    <table>
        <thead>
            <tr>
                <th class="col1">商品名称</th>
                <th class="col3">单价</th>
                <th class="col4">数量</th>    
                <th class="col5">小计</th>
                <th class="col6">操作</th>
            </tr>
        </thead>
        <tbody>
<?php if(is_array($cartinfo)): foreach($cartinfo as $key=>$v): ?><tr>
        <td class="col1" style="text-align:center;"><a href=""><img src="<?php echo ($v["logo"]); ?>" alt="" /></a>  <strong><a href=""><?php echo ($v["goods_name"]); ?></a></strong></td>
        <td class="col3">￥<span><?php echo ($v["goods_price"]); ?></span></td>
        <td class="col4">
            <a href="javascript:;" class="reduce_num"
                onclick="modify_number('red',<?php echo ($v["goods_id"]); ?>)"></a>
            <input type="text" name="amount" value="<?php echo ($v["goods_buy_number"]); ?>" class="amount" id="goods_number_<?php echo ($v["goods_id"]); ?>"
                onchange="modify_number('mod',<?php echo ($v["goods_id"]); ?>)"/>
            <a href="javascript:;" class="add_num"
                onclick="modify_number('add',<?php echo ($v["goods_id"]); ?>)"></a>
        </td>
        <td class="col5">￥<span id="goods_xiaoji_<?php echo ($v["goods_id"]); ?>"><?php echo ($v["goods_total_price"]); ?></span>
        </td>
        <td class="col6">
            <a href="javascript:if(confirm('确认要删除该商品么？')){del_goods(<?php echo ($v["goods_id"]); ?>)}">删除</a>
        </td>
    </tr><?php endforeach; endif; ?>
</tbody>
<tfoot>
<tr>
    <td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php echo ($number_price["price"]); ?></span></strong></td>
</tr>
</tfoot>
    </table>
    <div class="cart_btn w990 bc mt10">
        <a href="" class="continue">继续购物</a>
        <a href="<?php echo U('flow2');?>" class="checkout">结 算</a>
    </div>
</div>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
<script type="text/javascript">
//给购物车商品数量实现"增、减、修改"操作
//flag:red/mod/add
function modify_number(flag,goods_id){
    //获得当前被修改商品的数量
    var num = $('#goods_number_'+goods_id).val();

    if(flag=='red'){
        if(num==1){
            alert('单件商品的购买数量不能少于1个，或直接删除');
            return false;
        }
        num--;
    }else if(flag=='mod'){
        //修改的数量就是1-20之间的数字
        var reg = /^([1-9]|1\d|20)$/;//严格匹配1-20之间的数字

        if(num.match(reg)===null){
            alert('修改的数量参数不合法，要求是1-20之间的数字');
            window.location.href=window.location.href;//页面刷新
            return false;
        }
    }else if(flag=='add'){
        num++;
    }else{
        alert('参数不合法');
        return false;
    }

    //Ajax方式修改服务器端购物车数量数量
    $.ajax({
        url:"<?php echo U('Shop/changeNumber');?>",
        data:{'goods_id':goods_id,'num':num},
        dataType:'json',
        type:'post',
        success:function(msg){
            //使得数量、小计价格、总价格得到更新
            $('#goods_number_'+goods_id).val(num);
            $('#goods_xiaoji_'+goods_id).html(msg.xiaoji_price);
            $('#total').html(msg.total_price);
        }
    });
}


//删除购物车商品
function del_goods(goods_id){
    //Ajax方式删除
    $.ajax({
        url:"<?php echo U('Shop/delGoods');?>",
        data:{'goods_id':goods_id},
        dataType:'json',
        type:'get',
        success:function(msg){
            //msg: {price:xxx,number:xxx}
            //删除页面商品对应的tr元素
            $('#goods_xiaoji_'+goods_id).parent().parent().remove();
            //更新购物车商品总金额
            $('#total').html(msg.price);
        }
    });
}
</script>


    <!-- 底部版权 start -->
    <div class="footer w1210 bc mt15">
        <p class="links">
            <a href="">关于我们</a> |
            <a href="">联系我们</a> |
            <a href="">人才招聘</a> |
            <a href="">商家入驻</a> |
            <a href="">千寻网</a> |
            <a href="">奢侈品网</a> |
            <a href="">广告服务</a> |
            <a href="">移动终端</a> |
            <a href="">友情链接</a> |
            <a href="">销售联盟</a> |
            <a href="">京西论坛</a>
        </p>
        <p class="copyright">
             © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
        </p>
        <p class="auth">
            <a href=""><img src="<?php echo C('HOME_IMAGE_PATH');?>xin.png" alt="" /></a>
            <a href=""><img src="<?php echo C('HOME_IMAGE_PATH');?>kexin.jpg" alt="" /></a>
            <a href=""><img src="<?php echo C('HOME_IMAGE_PATH');?>police.jpg" alt="" /></a>
            <a href=""><img src="<?php echo C('HOME_IMAGE_PATH');?>beian.gif" alt="" /></a>
        </p>
    </div>
    <!-- 底部版权 end -->

</body>
</html>