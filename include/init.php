<?php

/**
 * @Author: lichao
 * @Date:   2018-02-06 19:29:11
 * @Last Modified by:   lichao
 * @Last Modified time: 2018-02-07 02:17:26
 */

//定义程序根目录绝对路径
define('APPPATH', str_replace('\\','/',dirname(dirname(__FILE__)) . '/'));

//定义调试选项
define('DEBUG', true);

//定义报错级别
defined('DEBUG') ? error_reporting(E_ALL) : error_reporting(0);

date_default_timezone_set('PRC');

//引入类
require_once(APPPATH . 'include/config.class.php');
require_once(APPPATH . 'include/mysql.class.php');
require_once(APPPATH . 'include/log.class.php');



?>