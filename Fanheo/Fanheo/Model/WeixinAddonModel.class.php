<?php
        	
namespace Addons\Fanheo\Model;
use Home\Model\WeixinModel;
        	
/**
 * Fanheo的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Fanheo' ); // 获取后台插件的配置参数	
		//dump($config);
		//$this->replyText('欢迎呼叫饭小盒童鞋。请问您需要什么服务？');
		$param ['wecha_id'] = get_mid ();
		$param ['token'] = get_token ();
		$url = addons_url ( 'Fanheo://Fanheo/index', $param );
		if($config['cover']){
		$picurl = get_cover_url($config['cover']);
		}else {
		$picurl = SITE_URL . '/Addons/Shop/View/default/Index/css/images/ico.png';
		}
		// 组装微信需要的图文数据，格式是固定的
		$articles [0] = array (
				'Title' => $config ['title'],
				'Description' => $config ['intro'],
				'PicUrl' => $picurl,
				'Url' => $url 
		);
		$this->replyNews ( $articles );
	} 

	// 关注公众号事件
	public function subscribe() {
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}	
}
        	