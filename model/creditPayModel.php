<?php

	require_once("model.php");

	class CreditPayModel extends Model
	{

		private $merchantID;
		
		public function newTradeReturnID($name, $phone, $email, $vegerarian){

			$insert_sql = "INSERT INTO `credit_pay`(`name`, `phone`, `email`, `vegetarian`) VALUES($name, $phone, $email, $vegetarian)";
			mysql_query($insert_sql) or die(mysql_error());
			$this->merchantID = mysql_insert_id();
			return $this->merchantID;

		}

		public function recordResult($success){

			$record_sql = "UPDATE `credit_pay` SET `success` = '$success'";
			mysql_query($record_sql);

		}

	}

?>