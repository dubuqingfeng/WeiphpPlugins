<?php

namespace Addons\Fanheo;
use Common\Controller\Addon;

/**
 * 饭小盒插件
 * @author 独步清风
 */

    class FanheoAddon extends Addon{

        public $info = array(
            'name'=>'Fanheo',
            'title'=>'饭小盒',
            'description'=>'一个叫做饭小盒的孩子，总是想找点好吃的，渴望与其他人交流饮食心得。',
            'status'=>1,
            'author'=>'独步清风',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Fanheo/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Fanheo/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }