<?php
include 'conn.php';
$currency_local_currency_code = $_POST['currency_local_currency_code'];

$queryResult = $connect->query("select * from currency_pair where currency_local_currency_code != '$currency_local_currency_code' ");

$result = array();

while ($fetchData = $queryResult->fetch_assoc()) {
    $result[] = $fetchData;
}

echo json_encode($result);
