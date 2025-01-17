<?php
// API integrations for market data

function getMarketData($symbol, $interval) {
    $apiKey = "ENTER_YOUR_API_KEY";
    $url = "https://api.example.com/marketdata?symbol=$symbol&interval=$interval&apikey=$apiKey";

    $ch = curl_init();
    curl_setopt($ch, CURL_URL, $url);
    curl_setopt($ch, CURL_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno ($ch)) {
        echo "cURL error: " . curl_error($ch);
        curl_close($ch);
        return null;
    }

    curl_close($ch);
    return json_decode($response, true);
}
