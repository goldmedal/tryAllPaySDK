<?php

	include_once("sdk/AllPay.Payment.Integration.php");
	include_once("checkMacValue.php");
	try {

	$oPayment = new AllinOne();

	// 服務參數

//	$oPayment->ServiceMethod = HttpMethod::HttpPOST;
	$oPayment->ServiceURL= "http://payment-stage.allpay.com.tw/Cashier/AioCheckOut";
	$oPayment->HashKey="5294y06JbISpM5x9";
	$oPayment->HashIV="v77hoKGq4kWxNNIS";
	$oPayment->MerchantID="2000132";

	/* 基本參數 */
	 $oPayment->Send['ReturnURL'] = "http://114.39.130.207";
//	 $oPayment->Send['ClientBackURL'] = "<<您要歐付寶返回按鈕導向的瀏覽器端網址>>";
//	 $oPayment->Send['OrderResultURL'] = "<<您要收到付款完成通知的瀏覽器端網址>>";
	 $oPayment->Send['MerchantTradeNo'] = "1";
	 $oPayment->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');
	 $oPayment->Send['TotalAmount'] = (int) 5000;
	 $oPayment->Send['TradeDesc'] = "Test";
	 $oPayment->Send['ChoosePayment'] = PaymentMethod::Credit;
//	 $oPayment->Send['Remark'] = "<<您要填寫的其他備註>>";
	 $oPayment->Send['ChooseSubPayment'] = PaymentMethodItem::None;  
	 $oPayment->Send['NeedExtraPaidInfo'] = ExtraPaymentInfo::No;
	 $oPayment->Send['DeviceSource'] = DeviceType::PC;
	 // 加入選購商品資料。
	 array_push($oPayment->Send['Items'], array('Name' => "ProductA", 'Price' => (int)"5000",
	'Currency' => "TWD", 'Quantity' => (int) "1", 'URL' => ""));
/*	 array_push($oPayment->Send['Items'], array('Name' => "<<產品B>>", 'Price' => (int)"<<單價>>",
	'Currency' => "<<幣別>>", 'Quantity' => (int) "<<數量>>", 'URL' => "<<產品說明位址>>"));
	 array_push($oPayment->Send['Items'], array('Name' => "<<產品C>>", 'Price' => (int)"<<單價>>",
	'Currency' => "<<幣別>>", 'Quantity' => (int) "<<數量>>", 'URL' => "<<產品說明位址>>"));
	 /* Credit 分期延伸參數 */
	 $oPayment->SendExtend['CreditInstallment'] = (int) 0;
	 $oPayment->SendExtend['InstallmentAmount'] = (int) 0;
//	 $oPayment->SendExtend['Redeem'] = (bool)"<<是否使用紅利折抵>>";
//	 $oPayment->SendExtend['UnionPay'] = (bool) "<<是否為聯營卡>>";

	// generate CheckMacValue 
	 /*
	 $checkMacRow = array_merge($oPayment->SendExtend, $oPayment->Send);
	 $checkMacRow['MerchantID'] = $oPayment->MerchantID;
	 $checkMacValue = formatRowToCheck($checkMacRow, $oPayment->HashKey, $oPayment->HashIV);
	 $oPayment->CheckMacValue = $checkMacValue;

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