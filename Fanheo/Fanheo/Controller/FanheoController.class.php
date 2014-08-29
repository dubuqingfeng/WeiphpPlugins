<?php

namespace Addons\Fanheo\Controller;
use Home\Controller\AddonsController;

class FanheoController extends FanheoBaseController{
		
	//首页,选择商家,
	public function index($page=1){
		if(!is_numeric($page)) {
	        $this->error('参数错误');
        }
		$condition['type'] = 'local';
		$this->page = M('page')->where($condition)->order('id desc')->page($page,mc_option('page_size'))->select();
		$count = M('page')->where($condition)->count();
		$this->terms = M('page')->where('type="term_local"')->order('id desc')->select();
		$this->assign('count',$count);
		$this->assign('page_now',$page);
		$this->wecha_id = get_mid ();
		$this->token = get_token ();
	    //$this->theme(mc_option('theme'))->display('Store/index');
		$this->display();
		
	}
	//商家分类
	public function term($id,$page=1){
			if(is_numeric($page)) {
			$id = I('get.id');
   //	if(is_numeric($id) && is_numeric($page)) {
			$this->terms = M('page')->where('type="term_local"')->order('id desc')->select();
	    	$condition['type'] = 'local';
        	$args_id = M('meta')->where("meta_key='local' AND meta_value='$id' AND type='basic'")->getField('page_id',true);
        	$condition['id']  = array('in',$args_id);
	    	$this->page = M('page')->where($condition)->order('date desc')->page($page,mc_option('page_size'))->select();
		    $count = M('page')->where($condition)->count();
		    $this->assign('id',$id);
		    $this->assign('count',$count);
		    $this->assign('page_now',$page);
			//$this->theme(mc_option('theme'))->display('Store/term');
			$this->display();
		} else {
			$this->error('参数错误！');
		}
	}
    public function single($id=1){
    	$args_id = M('meta')->where("meta_key='term' AND type='basic'")->getField('page_id',true);
        if(!is_numeric($id)) {
	        $this->error('参数错误');
        }
		$condition['type'] = 'local';
		// mc_set_views($id);
        $this->page = M('page')->field('id,title,content,type,date')->where($condition)->where("id='$id'")->select();
        mc_set_views($id);
        $this->page = M('page')->field('id,title,content,type,date')->where("id='$id'")->select();
        //$this->theme(mc_option('theme'))->display('Store/single');
		$this->display();
    }
	//菜品列表
	public function indexSort($page=1){
		$this->terms = M('page')->where('type="term_pro"')->order('id desc')->select();
		$condition['type'] = 'pro';
		$this->page = M('page')->where($condition)->order('id desc')->page($page,mc_option('page_size'))->select();
		$count = M('page')->where($condition)->count();
		$this->assign('count',$count);
		$this->assign('page_now',$page);
		//var_dump($this->page);
		$this->display();
	}
	//商铺菜品列表
	public function indexsingleSort($page=1){
		$id = I('get.cid');
		//$condition['type'] = 'pro';
        $args_id = M('meta')->where("meta_key='term' AND meta_value='$id' AND type='basic'")->getField('page_id',true);
        $condition['id']  = array('in',$args_id);
		$this->terms = M('page')->where($condition)->where('type="term_pro"')->order('id desc')->select();
	    $this->page = M('page')->where($condition)->order('date desc')->page($page,mc_option('page_size'))->select();
	    $count = M('page')->where($condition)->where('type="pro"')->count();
	    $this->assign('id',$id);
		$this->assign('count',$count);
		$this->assign('page_now',$page);
		/* $this->terms = M('page')->where('type="term_pro"')->order('id desc')->select();
		$condition['type'] = 'pro';
		$this->page = M('page')->where($condition)->order('id desc')->page($page,mc_option('page_size'))->select();
		$count = M('page')->where($condition)->count();
		$this->assign('count',$count);
		$this->assign('page_now',$page); */
		var_dump($this->page);
		var_dump($this->terms);
		//$this->display();
	}
	function GetDishList(){
		$terms = M('page')->where('type="term_pro"')->order('id desc')->select();
		foreach ( $terms as $v ) {
			$extra .= $v ['id'] . ':' . $v ['title'] . "\r\n";
		}
		echo $extra;
		return $extra;
	}
	// 获取所属分类
	function getCateData() {
		//$map ['is_show'] = 1;
		$map ['token'] = get_token ();
		$list = M ( 'aywndinner_sort' )->where ( $map )->select ();
		foreach ( $list as $v ) {
			$extra .= $v ['id'] . ':' . $v ['name'] . "\r\n";
		}
		return $extra;
	}
	//我的地址
	public function myaddress(){
		if(mc_user_id()) {
	        $this->wecha_id = get_mid ();
		$this->token = get_token ();
		$this->display();
        } else {
			$this->redirect('login');
	        //$this->display('User/login');
      }
	}
	//我的订单
	public function myorder(){
		if(mc_user_id()) {
			$this->wecha_id = get_mid ();
			$this->token = get_token ();
			$this->display('');
        } else {
			$this->redirect('login');
	        //$this->display('User/login');
        }
	}
	//登录界面
	public function login(){
		$this->wecha_id = get_mid ();
		$this->token = get_token ();
		$this->display();
	}
	//登录处理
	public function loginhandler(){
        $ip_false = M('option')->where("meta_key='ip_false' AND type='user'")->getField('meta_value',true);
        if($ip_false && in_array(mc_user_ip(), $ip_false)) {
        	$this->error('您的IP被永久禁止登陆！');
        } else {
	        $page_id = M('meta')->where("meta_key='user_name' AND meta_value='".I('param.user_name')."' AND type='user'")->getField('page_id');
	        $user_pass_true = mc_get_meta($page_id,'user_pass',true,'user');
	        if($_POST['user_name'] && $_POST['user_pass'] && md5($_POST['user_pass'].mc_option('site_key')) == $user_pass_true) {
		        session('user_name',I('param.user_name'));
		        session('user_pass',md5(I('param.user_pass').mc_option('site_key')));
		        $ip_array = M('action')->where("page_id='".mc_user_id()."' AND action_key='ip'")->getField('action_value',true);
		        if($ip_array && in_array(mc_user_ip(), $ip_array)) {
			        
		        } else {
			        if(!mc_is_admin()) {
				        mc_add_action(mc_user_id(),'ip',mc_user_ip());
			        };
		        };
		        $this->success('登陆成功',U('index'));
	        } else {
	        	$this->error('用户名与密码不符！');
	        };
        };
    }
	//退出登录
	public function logout(){
        session('user_name','user_name');
        session('user_pass','user_pass');
        $this->success('您已经成功退出登陆',U('index'));
    }
}
