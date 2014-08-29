<?php

namespace Addons\Fanheo\Controller;
use Home\Controller\AddonsController;

class FanheoCenterController extends FanheoBaseController{
	public function _initialize(){
		//登陆判断
		/* if(isset($_SESSION['AdminUser']) && $_SESSION['LoginTime'] != ''){
			$this->assign('AdminUser',session('AdminUser'));
			$this->assign('LoginTime',session('LoginTime'));
		}elseif(CONTROLLER_NAME != 'Login' ){
			$this->redirect('FanheoCenter/Index');
		} */
		//if(mc_user_id()) {
	        //$this->success('您已经登陆',U('user/index/edit?id='.mc_user_id()));
       // } else {
			//$this->redirect('FanheoCenter/Index');
	        //$this->display('User/login');
       // }
	}
	//登录界面
	public function index(){
		$this->wecha_id = get_mid ();
		$this->token = get_token ();
		$this->display();
	}
	//我的地址
	public function myaddress(){
		$this->wecha_id = get_mid ();
		$this->token = get_token ();
		$this->display();
	}
	//我的订单
	public function myorder(){
		$this->wecha_id = get_mid ();
		$this->token = get_token ();
		$this->display('');
	}
}