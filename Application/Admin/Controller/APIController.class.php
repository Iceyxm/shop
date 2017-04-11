<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * Class APIController 接口类
 * 注意，调用接口的远程文件放在phpwork文件夹下的curl里面
 * @package Admin\Controller
 */
class APIController extends Controller{
    /**
     * 定义方法用来根据商品名称获取符合条件的所有商品信息
     */
    public function getGoodsByCatAPI(){
        //获取get方式传递的分类名称
        //$catName = I('get.catName');
        $catName = I('post.catName');
        //判断分类是否传递
        if (!$catName){
            echo json_encode(array('status'=>'fail','data'=>0,'errMsg'=>'没有传递分类'));
            die;
        }
        //模糊查询获取对应的分类ID
        $cat_ids = M('Category')->field('group_concat(id) cat_ids')->where(array('cat_name'=>array('like',"%{$catName}%")))->find();
        //$cat_ids = M()->query("SELECT group_concat(id) cat_ids FROM `jxshop_category` WHERE `cat_name` LIKE '%魅%'");
        //echo M()->getLastSql();die;

        //判断分类存不存在
        if ($cat_ids['cat_ids'] == null){
            echo json_encode(array('status'=>'fail','data'=>0,'errMsg'=>'分类不存在'));
            die;
        }

        //根据查询出来的分类ID查询对应的商品信息
        /*$goods  = M('goods')
                ->alias('g')
                ->field("g.*,(select c.cat_name from jxshop_category c where c.id=g.cat_id) as cat_name")
                ->where(array('cat_id'=>array('in',$cat_ids['cat_ids'])))
                ->select();*/
        $goods = M()->query("select g.*,c.cat_name from __GOODS__ g JOIN __CATEGORY__ c ON g.cat_id = c.id WHERE g.cat_id in ($cat_ids[cat_ids]) ");
        //echo M()->getLastSql();die;

        if($goods){
            //status代表状态，data代表成功之后的数据 errMsg代表错误信息，0表示没错
            echo json_encode(array('status'=>'success','data'=>$goods,'errMsg'=>0));
        }else{
            echo json_encode(array('status'=>'fail','data'=>0,'errMsg'=>"没有查询到对应商品，请修改分类"));
        }

        die;
    }

    /**
     * 查询身份证信息
     */
    public function getIdCardService(){
        $IdCard = I('get.id');
        //尊敬的用户您好，您所申请的服务已正式开通，授权AuthKey：d88380332d744d78b165151807995f2e请您在一个工作日内完成测试，此AuthKey将于2017-04-11 00:00:00过期，如商用请您购买服务。
        $authkey = "67267768f44c48818e0f7d329de7dd2d";

        //接口请求地址
        $url = "http://api.36wu.com/IdCard/GetIdCardInfo?idcard=$IdCard&authkey=$authkey";
        //请求接口
        $info = file_get_contents($url);

        //请求成功是返回的json格式数据参数如下
        /*{
            "status": 200,
            "message": "OK",
            "data": {
                        "idcard": "21030319630118474X",
                        "sex": "女",
                        "birthday": "1963年1月18日",
                        "address": "辽宁省鞍山市铁西区"
                    }
        }*/
        if($info){
            echo json_encode(array('status'=>200,'message'=>'OK','data'=>$info));
        }else{
            echo json_encode(array('status'=>201,'message'=>'请求失败，参数异常或缺少参数!'));
        }
        die;
    }

    /**
     * 获取城市上映的影片影讯信息
     */
    public function getMovieInfoService(){
        //post方式接收数据
        $city = I('post.city');
        $authkey = "67267768f44c48818e0f7d329de7dd2d";
        //接口请求地址
        $url = "http://api.36wu.com/Movie/GetHotMovie?location=$city&authkey=$authkey";
        //请求接口
        $info = file_get_contents($url);

        //请求成功时返回的json格式数据参数如下
        /*{
            "status": 200,
            "message": "OK",
            "data": {
            "cityname": "北京市",
                    "location": {
                "lng": 116.3975,
                        "lat": 39.9085464
                    },
            "movie": [
                {
                    "movie_id": "7104",
                    "movie_name": "放手爱",
                    "movie_type": "普通",
                    "movie_release_date": "2014-04-30",
                    "movie_nation": "中国大陆",
                    "movie_starring": "杜汶泽/蔡卓妍/洛诗/念贤儿/黄雅莉",
                    "movie_length": "93分钟",
                    "movie_picture": "http://Img.wangpiao.com/NewsImage/20144/f9a4cb49-2d30-4c7f-9585-d08d903e802d.jpg",
                    "movie_score": 8.3,
                    "movie_director": "张敏",
                    "movie_tags": "喜剧",
                    "movie_message": "用音乐讲述爱情故事，“放手去爱”OR“放爱自由”？",
                    "is_imax": 0,
                    "is_new": 1,
                    "movies_wd": "放手爱 热门电影"
                },
                {
                    "movie_id": "245",
                    "movie_name": "冰封：重生之门",
                    "movie_type": "3D",
                    "movie_release_date": "2014-04-25",
                    "movie_nation": "中国大陆,港澳台",
                    "movie_starring": "甄子丹/王宝强/任达华/黄圣依/喻亢/林雪/张少华/陈浩民/胡明/王宗尧/庄思敏/胡耀辉/雨侨/陈炜/卢海鹏/黄文慧/陈慧慧/包雨萌",
                    "movie_length": "91分钟",
                    "movie_picture": "http://Img.wangpiao.com/NewsImage/20144/e896d245-d60d-49fe-b583-a06589fc39fe.jpg",
                    "movie_score": 9.2,
                    "movie_director": "罗永昌",
                    "movie_tags": "动作,奇幻",
                    "movie_message": "古今史诗大战一触即发,3D特效出自《地心引力》团队",
                    "is_imax": 0,
                    "is_new": 0,
                    "movies_wd": "冰封：重生之门 热门电影"
                }
            ]
        }*/

        if($info){
            echo json_encode(array('status'=>200,'message'=>'OK','data'=>$info));
        }else{
            echo json_encode(array('status'=>201,'message'=>'请求失败，参数异常或缺少参数!'));
        }
        die;
    }

    public function getWeatherService(){
        $ip = I('get.ip');
        //尊敬的用户您好，您所申请的服务已正式开通，授权AuthKey：d88380332d744d78b165151807995f2e请您在一个工作日内完成测试，此AuthKey将于2017-04-11 00:00:00过期，如商用请您购买服务。
        $authkey = "67267768f44c48818e0f7d329de7dd2d";

        //接口请求地址
        $url = "http://api.36wu.com/Weather/GetMoreWeatherByIp?ip=$ip&authkey=$authkey";
        //请求接口
        $weather = file_get_contents($url);

        //请求成功是返回的json格式数据参数如下
        /*{
            "status": 200,
            "message": "OK",
            "data": {
                    "city": "北京",
                "date_1": "2014年3月4日",
                "temp_1": "8℃~-3℃",
                "weather_1": "晴",
                "wind_1": "北风4-5级转微风",
                "fl_1": "4-5级转小于3级",
                "img_1": "0",
                "img_2": "99",
                "date_2": "2014年3月5日",
                "temp_2": "8℃~-3℃",
                "weather_2": "晴",
                "wind_2": "微风",
                "fl_2": "小于3级",
                "img_3": "0",
                "img_4": "99",
                "date_3": "2014年3月6日",
                "temp_3": "7℃~-3℃",
                "weather_3": "晴",
                "wind_3": "微风",
                "fl_3": "小于3级",
                "img_5": "0",
                "img_6": "99",
                "date_4": "2014年3月7日",
                "temp_4": "8℃~-1℃",
                "weather_4": "晴转多云",
                "wind_4": "微风",
                "fl_4": "小于3级",
                "img_7": "0",
                "img_8": "1",
                "date_5": "2014年3月8日",
                "temp_5": "10℃~1℃",
                "weather_5": "多云",
                "wind_5": "微风",
                "fl_5": "小于3级",
                "img_9": "1",
                "img_10": "99",
                "date_6": "2014年3月9日",
                "temp_6": "10℃~2℃",
                "weather_6": "多云",
                "wind_6": "微风",
                "fl_6": "小于3级",
                "img_11": "1",
                "img_12": "99",
                "index_d": "天气寒冷，建议着厚羽绒服、毛皮大衣加厚毛衣等隆冬服装。年老体弱者尤其要注意保暖防冻。"
            }
        }*/
        if($weather){
            echo json_encode(array('status'=>200,'message'=>'OK','data'=>$weather));
        }else{
            echo json_encode(array('status'=>201,'message'=>'请求失败，参数异常或缺少参数!'));
        }
        die;
    }
}