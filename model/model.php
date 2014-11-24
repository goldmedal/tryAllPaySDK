<?php

	abstract class Model
	{

		private $dbType;

		public function __construct($userDB){

			$this->dbType = empty($userDB) ? "mysql" : $userDB;

		}

		function __set($property_name, $value) {

			$this->$property_name = $value;

		}

		function __get($property_name) {

			return isset($this->$property_name) ? $this->$property_name : null;
		}

		public function connectDB($server, $user, $pwd){

			switch($this->dbType){

				case "mysql" :
					mysql_connect($server, $user, $pwd);break;
				default:
					die("Can't support this database");

			}

		}

		public function select_db($dbName){

			switch($this->dbType){

				case "mysql" :
					mysql_select_db($dbName);break;
				default:
					die("Can't support this database");

			}

		}

		public function __destruct(){

			$this->dbType = null;

		}

	}


?>