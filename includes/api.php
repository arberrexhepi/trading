<?php
// API integrations for market data

function getMarketData($symbol, $interval) {
    $apiKey = "ENTER_YOUR_API_KEY";
    $cacheFile = __DIR__ . "/../logs/cache_{symbol}_{interval}.json";
    $cacheTime = 300; // Cache duration in seconds

    // Check if a cache file exists and is valid
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        return json_decode(file_get_contents($cacheFile), true);
    }

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

    $data = json_decode($response, true);

    // Cache the API response
    if ($data) {
        file_put_contents($cacheFile, json_encode($data));
    }

    return $data;
}

?>