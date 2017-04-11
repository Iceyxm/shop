<?php
namespace Admin\Controller;
class IndexController extends BaseController {
    public function index(){
        $titles = array('name'=>'首页','sub'=>'首页');
        $this->assign('titles',$titles);
        $this->display();
    }
}