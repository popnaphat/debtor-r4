<?php
// ที่อยู่ของเอกสาร WSDL ของเว็บเซอร์วิส ปตท"); 
$wsdl = 'http://www.pttplc.com/pttinfo.asmx?WSDL';

// สร้างออปเจกต์ SoapClient เพื่อเรียกใช้เว็บเซอร์วิส
$client = new SoapClient($wsdl);

// เรียกเว็บเซอร์วิสผ่าน proxy ของมหาวิทยาลัยขอนแก่น
// $client = new SoapClient($wsdl,
// array('proxy_host' => "202.12.97.116",
// 'proxy_port' => 8088));

// เมธอดที่ต้องการเรียกใช้ CurrentOilPrice
$methodName = 'CurrentOilPrice';

// อินพุตพารามิเตอร์ของเมธอด CurrentOilPrice คือ
// Language ซึ่งเราตั้งค่าให้เป็น EN
$params = array('Language'=>'EN');

// ระบุค่าของ SOAP Action URI
$soapAction = 'http://www.pttplc.com/ptt_webservice/CurrentOilPrice';

// ใช้ฟังก์ชัน _soapCall ในการเรียกเมธอดที่ระบุ
// ต้องระบุพารามิเตอร์และ SOAP Action
$objectResult = $client->__soapCall($methodName, array('parameters' => $params), array('soapaction' => $soapAction));

// จะต้องดูค่าฟิลด์ที่ชื่อตรงกับชื่อของอิลิเมนต์ที่ระบุใน
// Output Message ซึ่งในที่นี้ก็คือ
// CurrentOilPriceResult
echo $objectResult->CurrentOilPriceResult;
?>