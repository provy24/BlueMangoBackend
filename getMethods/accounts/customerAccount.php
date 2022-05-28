<?php
include 'conn.php';
$account_type_name = $_POST['account_type_name'];

$queryResult = $connect->query("
select * from account_type where account_type_name LIKE '$account_type_name%' ");

$result = array();

while ($fetchData = $queryResult->fetch_assoc()) {
    $result[] = $fetchData;
}

echo json_encode($result);
