<?php
include 'conn.php';
$loan_types_idFK = $_POST['loan_types_idFK'];

$queryResult = $connect->query("
select * from loan_payment_period where loan_types_idFK = '$loan_types_idFK' ");

$result = array();

while ($fetchData = $queryResult->fetch_assoc()) {
    $result[] = $fetchData;
}

echo json_encode($result);
