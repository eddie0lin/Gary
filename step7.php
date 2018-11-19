<?php
  $json_str = file_get_contents('php://input'); //接收request的body
  $json_obj = json_decode($json_str); //轉成json格式
  
  $myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt來印訊息
  fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  
  $sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
  $sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  $sender_replyToken = $json_obj->events[0]->replyToken; //取得訊息的replyToken
  
  $imageId = $json_obj->events[0]->message->id; //取得訊息編號
  $url = 'https://api.line.me/v2/bot/message/'.$imageId.'/content';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer jdZhCvbKzhF9eWFQv0SdQKfxa2PN2hVTTxFGFR+YMWC6vwUF4ZgNAE9niU165dTOU+8Ju4CgaXVAlMl6Yj9zrSkKvQvSaLWBSi3Sj7rj+okG8CkZaumQ4s14G/RmuM7gzsyEelQyOIODAPPBPzl/PgdB04t89/1O/w1cDnyilFU='
  ));
  $json_content = curl_exec($ch);
  curl_close($ch);
  $imagefile = fopen($imageId.".jpeg", "w+") or die("Unable to open file!");
  fwrite($imagefile, $json_content); 
  fclose($imagefile); //將圖片存在server上
			
  
?>
