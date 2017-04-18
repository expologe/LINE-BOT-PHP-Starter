<?php
 $strAccessToken = "YnRblhPl23C4S1wgG+7WFs+JGaE/6tjJlATu1e4JZxBXheh95ZLv4ueULTUB3hH6vfohOUeFEBbazjHkrrXliu+rXKOKjmEup7H3iXY+BrchjKs03m76tYN+A/jjnIYifOBIa8cSR9I7BTrbRbHCoQdB04t89/1O/w1cDnyilFU==";
 
$content = file_get_contents('php://input');
$arrJson = json_decode($content, true);
 
$strUrl = "https://api.line.me/v2/bot/message/reply";
 
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";

$strWord = $arrJson['events'][0]['message']['text'];
 
if($arrJson['events'][0]['message']['text'] == "สวัสดี"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "สวัสดี ID คุณคือ ".$arrJson['events'][0]['source']['userId'];
}else if($arrJson['events'][0]['message']['text'] == "nh"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ฉันยังไม่มีชื่อนะ";
  
  
  $data = file_get_contents("https://www.nicehash.com/api?method=stats.provider.ex&addr=1CGpMeXVJM2prxC1qgoVkBuXiiNSgxbBPW");
  $obj = json_decode($data,true);

  $arrPostData['messages'][0]['text'] = $obj['result']['current'][3]['name'];
   
  $resTxt = "ข้อมูล...";
  try {
 foreach($obj['result']['current'] as $algo){
		  $resTxt .= "\r\nName : " . $algo['name'];
		  if (!empty($algo['data'][0])){
			  $resTxt .= "\r\nHash rate : " . $algo['data'][0]['a'];
		  }
		$resTxt .= "\r\nBTC : " . $algo['data'][1];
	  
  }
  }
  catch (Exception $e) {
        $resTxt .= "\r\n พัง...!! ครับเจ้านาย";
        $resTxt .= $e->getMessage();
  }
  $arrPostData['messages'][0]['text'] = $resTxt;
  
  
}else if($strWord == "เฮ้ย" || $strWord == "เห้ย"){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ครับเจ้านาย  มีอะไรให้ช่วยครับ";

}else if( strpos($strWord,"btc") !== false ){	//&& (strpos($strWord,"หน่อย") !== false || strpos($strWord,"ได้ไหม") !== false || strpos($strWord,"ได้มั้ย") !== false)){
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "มึงยังทำกูไม่เสร็จสัสอย่าเมา";
}else{
  $arrPostData = array();
  $arrPostData['replyToken'] = $arrJson['events'][0]['replyToken'];
  $arrPostData['messages'][0]['type'] = "text";
  $arrPostData['messages'][0]['text'] = "ฉันไม่เข้าใจคำสั่ง";
}
 
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);
 
 /*
$strAccessToken = "JFCJd5w9SIGDUE5LU1rKPhgF98r2rHAOESrVQGmd/o+EhZFkaJJc7T6L2/7cSzufwF/yjhXw9Ijn5/JTMiM5oRfh7egBq7VZpYqCPZMJkLpkrjQGGzEYd8Z/keX4hMhCeUjIp7tkhxRyf62UFXKH2gdB04t89/1O/w1cDnyilFU=";
 
$strUrl = "https://api.line.me/v2/bot/message/push";
 
$arrHeader = array();
$arrHeader[] = "Content-Type: application/json";
$arrHeader[] = "Authorization: Bearer {$strAccessToken}";
 
$arrPostData = array();
$arrPostData['to'] = "USER_ID";
$arrPostData['messages'][0]['type'] = "text";
$arrPostData['messages'][0]['text'] = "นี้คือการทดสอบ Push Message";
 
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$strUrl);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrPostData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close ($ch);
*/
 
?>
