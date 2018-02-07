<?php

/**
 * @Author: lichao
 * @Date:   2018-02-07 01:17:50
 * @Last Modified by:   lichao
 * @Last Modified time: 2018-02-07 22:22:34
 */

/**
* 日志记录、读取、备份类
*/
class log
{
	//默认记录中的日志文件名
	const LOGFILE = 'current.log';

	/**
	 * write 写日志内容方法 
	 * @param  mixed $content 日志内容
	 * @return [type]          [description]
	 */
	public static function write($content) {
		//判断日志文件大小
		$logFile = self::isBackup();
		//执行写日志
		$fsrc = fopen($logFile, 'ab');
		fwrite($fsrc, $content . "\r\n");
		fclose($fsrc);
	}
	/**
	 * read 读日志内容方法
	 * @return [type] [description]
	 */
	public static function read() {

	}

	/**
	 * backup 将超过1MB的日志进行备份
	 * @param  String $logFile 旧log文件路径
	 * @return null 无return值
	 */
	public static function backup($logFile) {
		$newLogName = dirname($logFile) . '/LOG_' . date('YmdHis', filectime($logFile)) . '-' . date('YmdHis') . '.logbak';
		rename($logFile,$newLogName);
		touch($logFile);
		clearstatcache();
	}

	/**
	 * isBackup 判断日志文件大小方法
	 * @return String $logFile 日志路径
	 */
	public static function isBackup() {
		$logFile = APPPATH . 'data/log/' . self::LOGFILE;
		//判断日志文件是否存在，用于初次运行或清除过日志文件后
		if (file_exists($logFile)) {
			//清除filesizi()缓存，避免产生日志超过1MB的情况
			clearstatcache(true,$logFile);
			//检测日志文件大小，并备份超过1MB的文件
			if (filesize($logFile) >= 1024 * 1024) {
				self::backup($logFile);
				return $logFile;
			}else {
				return $logFile;
			}
		}else{
			//文件不存在就直接创建默认初始文件
			touch($logFile);
			return $logFile;
		}
	}
}



?>