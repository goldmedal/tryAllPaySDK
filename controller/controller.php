<?php

	require_once("sdk/AllPay.Payment.Integration.php");
	require_once("oPayConfig.php");
	require_once("model/creditPayModel.php");

	class SubmitCreditPayController 
	{

		private $name;
		private $phone;
		private $email;
		private $vegetarian;
	//	private $oPayment = null;

		public function __construct(){

			$this->name = $_POST['name'];
			$this->phone = $_POST['phone'];
			$this->email = $_POST['email'];
			$this->vegetarian = $_POST['vegetarian'];


		}

		function __set($property_name, $value) {

			if(isset($value)){

				$this->$property_name = $value;

			}else{  // 資料未正確填寫

				die("the information is error.");

			}

		}

		public function submitToAllPay($id){

			global $oPayServiceURL;
			global $oPayHashKey;
			global $oPayHashIV;
			global $oPayMerchantID;

			// generate merchant trade number
			
			$merchantTradeNum = str_pad($id,3,'0',STR_PAD_LEFT);
			$merchantTradeNum = "A".$merchantTradeNum;

			try{

				$oPayment = new AllInOne();

				// 設定服務參數
				// 暫時使用測試帳號

				$oPayment->ServiceURL = $oPayServiceURL;
				$oPayment->HashKey = $oPayHashKey;
				$oPayment->HashIV = $oPayHashIV;
				$oPayment->MerchantID	= $oPayMerchantID;

				// 設定訂單參數
				
				$price = 5000;

				$oPayment->Send['ReturnURL'] = "http://52.127.231.73";
				$oPayment->Send['OrderResultURL'] = "http://52.127.231.73";
				$oPayment->Send['MerchantTradeNo'] = $merchantTradeNum;
				$oPayment->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
				$oPayment->Send['TotalAmount'] = $price;
				$oPayment->Send['ChoosePayment'] = PaymentMethod::ALL;
				$oPayment->Send['ChoosePayment'] = PaymentMethod::Credit;
				$oPayment->Send['ChooseSubPayment'] = PaymentMethodItem::None;
				$oPayment->Send['NeedExtraPaidInfo'] = ExtraPaymentInfo::No;
				$oPayment->Send['DeviceSource'] = DeviceType::PC;
				$oPayment->Send['TradeDesc'] = "credit card pay";  // 對於訂單之描述

				array_push($oPayment->Send['Items'], array(
					'Name' => '報名費', 'Price' => (int)  $price, 
					'Currency' => "TWD", 'Quantity' => (int) 1,
				));

				
				//	$oPayment->Send['Remark']; // 備註
				
				$oPayment->SendExtend['CreditInstallment'] = (int) 0;
				$oPayment->SendExtend['InstallmentAmount'] = (int) 0;

				$oPayment->CheckOut();  // 產生訂單
				$szHtml = $oPayment->CheckOutSring();   // 產生產生訂單 Html Code 的方法


			}
			catch (Exception $e)
			{

				// 例外錯誤處理
				throw $e;

			}
		}

		public function run(){

			$model = new CreditPayModel("mysql");
			$model->connectDB("localhost", "root", "123456");
			$model->select_db("all_pay_test");

			$merchantTradeNum = $model->newTradeReturnID(
				$this->name, $this->phone, 
				$this->email, $this->vegetarian );

			$this->submitToAllPay($merchantTradeNum);

		}

		

	}

?>