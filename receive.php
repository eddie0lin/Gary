<?php
  $json_str = file_get_contents('php://input'); // 接收 request 的 body
  $json_obj = json_decode(@json_str); // 轉 json
  $myfile = fopen("log.txt","w+") or die("unable to open file!"); // 設定一個 txt 來列印訊息
  fwrite($myfile,"\xEF\xBB\xBF".$json_str);  // 轉utf-8
?>
