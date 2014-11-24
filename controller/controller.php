<?php

	require_once("../sdk/AllPay.Payment.Integration.php");
	require_once("../oPayConfig.php")

	class SubmitCreditPayController 
	{

		private $name;
		private $phone;
		private $email;
		private $vegetarian;
		private $oPayment = null;

		public function __construct(){

			$this->name = $_POST['name'];
			$this->phone = $_POST['phone'];
			$this->email = $_POST['email'];
			$this->vegetarian = $_POST['vegetarian'];
			$oPayment = new AllInOne();

		}

		function __set($property_name, $value) {

			if(isset($value)){

				$this->$property_name = $value;

			}else{  // 資料未正確填寫

				die("the information is error.")

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

				// 設定服務參數
				// 暫時使用測試帳號

				$this->oPayment->ServiceURL = $oPayServiceURL;
				$this->oPayment->HashKey = $oPayHashKey;
				$this->oPayment->HashIV = $oPayHashIV;
				$this->oPayment->merchantID	= $oPayMerchantID;

				// 設定訂單參數
				
				$price = 5000;

				$this->oPayment->Send['ReturnURL'] = "";
				$this->oPayment->Send['OrderResultURL'] = "";
				$this->oPayment->Send['MerchantTradeNo'] = $merchantTradeNum;
				$this->oPayment->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
				$this->oPayment->Send['TotalAmount'] = $price;
				$this->oPayment->Send['ChoosePayment'] = PaymentMethod::ALL;
				$this->oPayment->Send['ChooseSubPayment'] = PaymentMethodItem::None;
				$this->oPayment->Send['NeedExtraPaidInfo'] = ExtraPaymentInfo::No;
				$this->oPayment->Send['DeviceSource'] = DeviceType::PC;


				array_push($this->oPayment->Send['Items'], array(
					'Name' => '報名費', 'Price' => (int) "", 
					'Currency' => "TWD", 'Quantity' => (int) $price,
					'URL' => ""
				));

				//	$this->oPayment->Send['TradeDesc'] = "";  // 對於訂單之描述
				//	$this->oPayment->Send['Remark']; // 備註
				
				$this->oPayment->SendExtend['CreditInstallment'] = (int) 0;
				$this->oPayment->SendExtend['InstallmentAmount'] = (int) 0;

				$this->oPayment->CheckOut();  // 產生訂單
				$szHtml = $oPayment0->CheckOutSring();   // 產生產生訂單 Html Code 的方法

			}
			catch (Exception $e)
			{

				// 例外錯誤處理
				throw $e;

			}
		}

		

	}

?>