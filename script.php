<?php

$db = mysqli_connect("127.0.0.1","DB_USERNAME","DB_PASS","ogreTrack");
    if (!$db) {
            die();
    }
mysqli_set_charset($db,"utf8mb4");



function saveCoinState($pair,$totalBaseCoin,$db) {

    $time = time();
    $stmt = $db->stmt_init();

    $stmt->prepare("INSERT INTO buybook (checkDate, tradePair, totalBuy) VALUES (? , ? , ?)");
    $stmt->bind_param("sss",$time,$pair,$totalBaseCoin);
    $stmt->execute();

}

function getOgrePairs($db) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_URL,"https://tradeogre.com/api/v1/markets");
    $data = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($data);

    foreach ($data as $key => $value) {
        foreach ($value as $pair => $tradeData) {
            $totalBaseCoin = getOrderBook($pair);
            saveCoinState($pair,$totalBaseCoin,$db);
        }

        sleep(1);
    }

}

function getOrderBook($pair) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_URL,"https://tradeogre.com/api/v1/orders/$pair");
    $data = curl_exec($curl);
    curl_close($curl);
    
    $data = json_decode($data);
    $buy = $data->buy;

    $totalBaseCoin = 0;

    foreach ($buy as $price => $amount) {

        $totalBaseCoin+= $price * $amount;

    }

    return $totalBaseCoin;

}

while ( true ) {
    getOgrePairs($db);
    sleep(600);
}


?>