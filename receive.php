<?php
  $json_str = file_get_contents('php://input'); // 接收 request 的 body
  $json_obj = json_decode($json_str); // 轉 json
  $myfile = fopen("log.txt","w+") or die("unable to open file!"); // 設定一個 txt 來列印訊息
  fwrite($myfile,"\xEF\xBB\xBF".$json_str);  // 轉utf-8
  $sender_userid = $json_obj->events[0]->source->userId; //取得訊息發送者的id
  $sender_txt = $json_obj->events[0]->message->text; //取得訊息內容
  
  $response = array (
    "to" => $sender_userid,
    "messages" => array (
      array (
        "type" => "text",
        "text" => "Hello. You say". $sender_txt
      )
    )
  );
  
 fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前面加上\xEF\xBB\xBF轉成utf8格式
  $header[] = "Content-Type: application/json";
  $header[] = "Authorization: Bearer jdZhCvbKzhF9eWFQv0SdQKfxa2PN2hVTTxFGFR+YMWC6vwUF4ZgNAE9niU165dTOU+8Ju4CgaXVAlMl6Yj9zrSkKvQvSaLWBSi3Sj7rj+okG8CkZaumQ4s14G/RmuM7gzsyEelQyOIODAPPBPzl/PgdB04t89/1O/w1cDnyilFU=";
  $ch = curl_init("https://api.line.me/v2/bot/message/push");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
  $result = curl_exec($ch);
  curl_close($ch);
?>
