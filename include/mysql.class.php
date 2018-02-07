<?php

/**
 * @Author: lichao
 * @Date:   2018-02-06 19:34:42
 * @Last Modified by:   lichao
 * @Last Modified time: 2018-02-08 05:06:33
 */

/**
* 
*/
class MySql
{
	protected $conn;
	protected $sql;
	public $result;
	public function __construct($config,$arguement) {
		$this->connect($config);
		$this->getSql($arguement);
	}

	protected function connect($config) {
		$conn = mysqli_connect(
			$config->host,
			$config->username,
			$config->password,
			$config->database,
			$config->port
		) or die(
			'Database connect fail'
		);
		$this->conn = $conn;
		$this->sql = 'SET NAMES UTF8';
		$this->getQuery();

	}

	/**
	 * getNomallTrans($arguement) 执行SQL字段、值的转换
	 * @param  Array $arguement SQL语句分解(带',')
	 * @return 抛回修改后的$arguement
	 */
	protected function getNomallTrans($arguement) {
		if (array_key_exists('fields',$arguement)) {
			//转换列名为数组$fieldArray
			$fieldTemp = explode(',', $arguement['fields']);
			$fieldArgTemp = array();
			foreach ($fieldTemp as $key => $value) {
				array_push($fieldArgTemp, '`' . $value . '`');
			}
			array_push($arguement, implode(',', $fieldArgTemp));
		}
		
		if (array_key_exists('values',$arguement)) {
			//转换列值为数组$valueArray
			$valueTemp = explode(',', $arguement['values']);
			$valueArgTemp = array();
			foreach ($valueTemp as $key => $value) {
				array_push($valueArgTemp, "'" . $value . "'");
			}
			array_push($arguement, implode(',', $valueArgTemp));
		}
		return $arguement;
		//return $arguement;
	}

	/**
	 * getUpdateTrans($arguement) 执行SQL字段、值的转换
	 * @param  Array $arguement SQL语句分解(不带',')
	 * @return 抛回修改后的$arguement
	 */
	protected function getUpdateTrans($arguement) {
		//SET项目转换
		$updateSql = array();
		$fieldTemp = explode(',', $arguement['fields']);
		$valueTemp = explode(',', $arguement['values']);
		for ($i = 0; $i < count($fieldTemp); $i++) { 
			$temp = '`' . $fieldTemp[$i] . '`' . '=' . "'" . $valueTemp[$i] . "'";
			array_push($updateSql, $temp);
		}
		array_push($arguement, implode(',', $updateSql));
		return $arguement;
		//return $arguement;
	}

	protected function getSql($arguement) {
		//$arguement = array('fields','table','values','where','method');
		switch ($arguement['method']) {
			case 'getAll':
				echo "ga";
				$arguement = $this->getNomallTrans($arguement);
				$this->sql = "SELECT {$arguement[0]} FROM {$arguement['table']}";
				#echo $this->sql;
				$this->getSrcResult();
				break;

			case 'getRow':
				echo 'gr';
				$arguement = $this->getNomallTrans($arguement);
				$this->sql = "SELECT {$arguement[0]} FROM {$arguement['table']} WHERE {$arguement['where']}";
				#echo $this->sql;
				$this->getSrcResult();
				break;

			case 'getInsert':
				echo "gi";
				$arguement = $this->getNomallTrans($arguement);
				$this->getNomallTrans($arguement);
				$this->sql = "INSERT INTO {$arguement['table']}({$arguement[0]}) VALUES ({$arguement[1]})";
				#echo $this->sql;
				$this->getBoolResult();
				break;

			case 'getUpdate':
				echo 'gu';
				$arguement = $this->getUpdateTrans($arguement);
				print_r($arguement);
				$this->sql = "UPDATE {$arguement['table']} SET {$arguement[0]} WHERE {$arguement['where']}";
				#echo $this->sql;
				$this->getBoolResult();
				break;

			case 'getDelete':
				echo "gd";
				$this->sql = "DELETE FROM {$arguement['table']} WHERE {$arguement['where']}";
				#echo $this->sql;
				$this->getBoolResult();
				break;

			default:
				echo 'Mysql class expect one arguement for operating database at this [getAll][getRow][getOne][getInsert][getUpdate][getDelete]';
				break;
		}
	}

	protected function getQuery() {
		return mysqli_query($this->conn,$this->sql);
	}

	protected function getSrcResult() {
		$getQuery = $this->getQuery();
		return $this->result = mysqli_fetch_assoc($getQuery);
	}

	protected function getBoolResult() {
		if ($this->getQuery()) {
		 	return $this->result = true;
		 }else{
		 	return $this->result = false;
		 }
	}
}

?>