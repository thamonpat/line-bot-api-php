<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'H/fJ4VEyHjSod+z7I0pQnVVSYswv/NvsNXBV4BiPzSLnqfAFZagrsZ/GEggyb6iJSpPEHBLfxfmfT/hBENXV3NYfocIPUi0G9RgJmpQN1gtNH6zUlLX7JfrM3wr0E88qwuz7zBkkKGSsDqTEed/evwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

if ( sizeof($request_array['events']) > 0 )
{

 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   
   if( $event['message']['type'] == 'text' )
   {
		$text = $event['message']['text'];
		$name_dev = "Thamonpat Danchaodang";
	   	$id_dev = "59160655";
		if(($text == "ขอทราบยอด covid-19")||($text == "covid-19")||($text == "อยากทราบยอด COVID-19 ครับ")){
			$patient = 100;
			$remedied = 50;
			$deceased = 25;
			$reply_message = '"รายงานสถานการณ์ ยอดผู้ติดเชื้อไวรัสโคโรนา 2019 (COVID-19) ในประเทศไทย" ผู้ป่วยสะสม จำนวน '.$patient.' ราย ผู้เสียชีวิต จำนวน '.$deceased.' ราย รักษาหาย จำนวน '.$remedied.' ราย ผู้รายงานข้อมูล: '.$name_dev;
		}
		else if(($text== "ข้อมูลส่วนตัว")||($text== "ข้อมูล")||($text== "ข้อมูลส่วนตัวของผู้พัฒนาระบบ")){
			$reply_message = 'ชื่อ : '.$name_dev.' รหัสนิสิต : '.$id_dev.'อายุ 22 ปี น้ำหนัก 42 kg. ส่วนสูง 160 cm. ขนาดรองเท้าเบอร์ 7 ใช้หน่วย US';
		}
		else
		{
			$reply_message = 'ระบบได้รับข้อความ ('.$text.') ของคุณแล้ว';
    		}
   
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

?>
