<?php

namespace Addons\Fanheo\Controller;
use Home\Controller\AddonsController;

class FanheoBaseController extends AddonsController{
	//public function 
	var $config;
	function _initialize() {
		parent::_initialize();
		
		$controller = strtolower ( _CONTROLLER );

		// 定义模板常量
		$act = strtolower ( _ACTION );
		$temp = $config ['template_' . $act];
		$act = ucfirst ( $act );
		
		define ( 'CUSTOM_TEMPLATE_PATH', ONETHINK_ADDON_PATH . 'Fanheo/View/default/');
	}
}
