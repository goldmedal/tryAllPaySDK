<?php

		include_once("sdk/AllPay.Payment.Integration.php");
	/*
	* 產生訂單的範例程式碼。
	*/
	try
	{
	 $oPayment = new AllInOne();
	 /* 服務參數 */
	 $oPayment->ServiceURL = "http://payment-stage.allpay.com.tw/Cashier/AioCheckOut";
	 $oPayment->HashKey = "5294y06JbISpM5x9";
	$oPayment->HashIV="v77hoKGq4kWxNNIS";
	$oPayment->MerchantID="2000132";

	 /* 基本參數 */
	 $oPayment->Send['ReturnURL'] = "114.39.130.207";
	// $oPayment->Send['ClientBackURL'] = "114.39.130.207";
	// $oPayment->Send['OrderResultURL'] = "114.39.130.207";
	 $oPayment->Send['MerchantTradeNo'] = "1";
	 $oPayment->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
	 $oPayment->Send['TotalAmount'] = (int) "1000";
	 $oPayment->Send['TradeDesc'] = "<<您該筆訂單的描述>>";
	 $oPayment->Send['ChoosePayment'] = PaymentMethod::ALL;
	 $oPayment->Send['Remark'] = "<<您要填寫的其他備註>>";
	 $oPayment->Send['ChooseSubPayment'] = PaymentMethodItem::None;
	 $oPayment->Send['NeedExtraPaidInfo'] = ExtraPaymentInfo::No;
	 $oPayment->Send['DeviceSource'] = DeviceType::PC;
//	 $oPayment->Send['IgnorePayment'] = "ATM"; // 例(排除支付寶與財富通): Alipay#Tenpay
	 // 加入選購商品資料。
	 array_push($oPayment->Send['Items'], array('Name' => "<<產品A>>", 'Price' => (int)"100",
	'Currency' => "TWD", 'Quantity' => (int) "1", 'URL' => "114.39.130.207"));
	/* array_push($oPayment->Send['Items'], array('Name' => "<<產品B>>", 'Price' => (int)"<<單價>>",
	'Currency' => "<<幣別>>", 'Quantity' => (int) "<<數量>>", 'URL' => "<<產品說明位址>>"));
	 array_push($oPayment->Send['Items'], array('Name' => "<<產品C>>", 'Price' => (int)"<<單價>>",
	'Currency' => "<<幣別>>", 'Quantity' => (int) "<<數量>>", 'URL' => "<<產品說明位址>>"));
*/
	 /* 產生訂單 */
	 $oPayment->CheckOut();
	 /* 產生產生訂單 Html Code 的方法 */
	 $szHtml = $oPayment->CheckOutString();
	}
	catch (Exception $e)
	{
	 // 例外錯誤處理。
	 throw $e;
	}


?>