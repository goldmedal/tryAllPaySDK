<?php

	require_once("../sdk/AllPay.Payment.Integration.php")
	require_once("../oPayConfig.php")

	class view 
	{

		private $arFeedback;

		public function __construct(){

			// include global variables

			global $oPayServiceURL;
			global $oPayHashKey;
			global $oPayHashIV;
			global $oPayMerchantID;

			// 設定服務參數

			$this->oPayment = new AllInOne();
			$this->oPayment->HashKey = $oPayHashKey;
			$this->oPayment->HashIV = $oPayHashIV;
			$this->oPayment->MerchantID = $oPayMerchantID;

			// get feedback

			$this->arFeedback = $this->oPayment->CheckOutFeedback();

			if(sizeof($this->arFeedback) < 0) die("Trade Fail !");

		}

		public function outputResult(){

			// get feedback information

			foreach($this->arFeedback as $key => $value){

				echo $key." = ".$value."<br>";

				switch($key){
					case "MerchantID": $szMerchantID = $value; break;
					case "MerchantTradeNo": $szMerchantTradeNo = $value; break;
					case "RtnCode": $szRtnCode = $value; break;
					case "RtnMsg": $szRtnMsg = $value; break;
					case "PeriodType": $szPeriodType = $value; break;
					case "Frequency": $szFrequency = $value; break;
					case "ExecTimes": $szExecTimes = $value; break;
					case "Amount": $szAmount = $value; break;
					case "Gwsr": $szGwsr = $value; break;
					case "ProcessDate": $szProcessDate = $value; break;
					case "AuthCode": $szAuthCode = $value; break;
					case "FirstAuthAmount": $szFirstAuthAmount = $value; break;
					case "TotalSuccessTimes": $szTotalSuccessTimes = $value; break;
					default: break;
				}

			}

		}



	}

?>