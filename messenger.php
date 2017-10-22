<?php

file_put_contents("file.txt",file_get_contents("php://input"));
$fb=file_get_contents("file.txt");


$fb= json_decode($fb);

$receiverId = $fb->entry[0]->messaging[0]->sender->id;
$receivedText = $fb->entry[0]->messaging[0]->message->text;

$receivedText=strtoupper($receivedText);

include "textfilter.php";
include "getdata.php";
$receivedText=shortCodeToLongForm($receivedText);

if(!empty($receivedText))
{
 $marketData=getmarketData($receivedText);
 $price = $marketData[0];
  $changeLast24Hour=$marketData[1];
 $marketCapital= $marketData[2];

 
if(!empty($price))
{ 
    if($changeLast24Hour<0){
 $responseText= "1 ". $receivedText ." => USD " . $price ."\n 24 Hour Change : ". $changeLast24Hour."%". "↓". "\n Market Cap: $marketCapital "; 
    }
    
   else if($changeLast24Hour>0){
 $responseText= "1 ". $receivedText ." => USD " . $price ."\n 24 Hour Change : ". $changeLast24Hour."%". "↑". "\n Market Cap: $marketCapital "; 
    }
    
    else{
 $responseText= "1 ". $receivedText ." => USD " . $price ."\n 24 Hour Change : ". $changeLast24Hour."%" . "\n Market Cap: $marketCapital "; 
}
}
else{
     $responseText= "Please Use Valid command!\n". "-> Use Fullname for Coin\n"."-> Do Not Use Any Symbol or leave extra spaces\n" . "-> use dash (-) for coins having two or more words in name. Example : Bitcoin-Cash, Ethereum-Classic etc.";
}
}
else{
  $responseText= "Please Use Valid command!\n". "-> Use Fullname for Coin\n"."-> Do Not Use Any Symbol or leave extra spaces\n" . "-> use dash (-) for coins having two or more words in name. Example : Bitcoin-Cash, Ethereum-Classic etc.";
}

$token="PAGE_TOKEN_HERE";

$data= array(
      "recipient"=> array("id"=>"$receiverId"),
      "message"=> array("text"=>"$responseText")
);


$options=array('http' => 
    array(
    'method'=> 'POST',
    'content'=> json_encode($data),
    'header'=> "Content-Type: application/json\n"
    )
);

$context=stream_context_create($options);
file_get_contents("https://graph.facebook.com/v2.6/me/messages?access_token=$token",false,$context);


?>
