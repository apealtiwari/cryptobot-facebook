<?php
function getMarketData($receivedText)
{
 $url="https://api.coinmarketcap.com/v1/ticker/".$receivedText;
 $json = file_get_contents($url);
 $data = json_decode($json, TRUE);
 $price = $data[0]["price_usd"];
 $marketCapital= $data[0]["market_cap_usd"];
 $changeLast24Hour=$data[0]["percent_change_24h"];
 $marketCapital=number_format($marketCapital);
 
 $marketData=array($price,$changeLast24Hour,$marketCapital);
 
 return $marketData;
}
?>
