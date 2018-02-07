<?php

/**
 * @Author: lichao
 * @Date:   2018-02-07 00:40:23
 * @Last Modified by:   lichao
 * @Last Modified time: 2018-02-08 05:05:57
 */
require_once('./include/init.php');


$arguement = array(
	'fields' => 'newsTitle,newsDate',
	'table' => 'news',
	'values' => 's,d',
	'where' => 'newsId = 11',
	'method' => ''
);
$mysql = new MySql($config,$arguement);
print_r($mysql->result).'<br/>';




?>