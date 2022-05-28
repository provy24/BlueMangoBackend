<?php
include 'conn.php';
$exchange_rate_id = $_POST['exchange_rate_id'];

$queryResult = $connect->query("
select exchange_rate_date, exchange_buy_rate,exchange_sell_rate,currency_pair_name from exchange_rate join currency_pair on exchange_rate.exchange_currency_pair_id = currency_pair.currency_pair_id where exchange_rate_id >'$exchange_rate_id' ");

$result = array();

while ($fetchData = $queryResult->fetch_assoc()) {
    $result[] = $fetchData;
}

echo json_encode($result);
