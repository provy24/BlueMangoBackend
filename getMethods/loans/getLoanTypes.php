<?php
include 'conn.php';
$loan_local_currency_code = $_POST['loan_local_currency_code'];

$queryResult = $connect->query("
select * from loan_types where loan_local_currency_code = '$loan_local_currency_code' ");

$result = array();

while ($fetchData = $queryResult->fetch_assoc()) {
    $result[] = $fetchData;
}

echo json_encode($result);
