<?php
$db = "rightbank_db_v4"; //database name
$dbuser = "root"; //database username
$dbpassword = ""; //database password
$dbhost = "localhost"; //database host

$return["error"] = false;
$return["message"] = "";
$return["success"] = false;

$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);

if(isset($_POST["local_currency_code"]) ){
    //checking if there is POST data

    $local_currency_code = $_POST["local_currency_code"];
    $transaction_type_hint = $_POST["transaction_type_hint"];

    //escape inverted comma query conflict from string

    $sql = "SELECT
transaction_type_fee,
transaction_imtt,
transaction_type_id,
transaction_type_desc
FROM  transaction_type
WHERE local_currency_code = '$local_currency_code' and transaction_type_desc LIKE '$transaction_type_hint%'";
    //building SQL query
    $res = mysqli_query($link, $sql);
    $numrows = mysqli_num_rows($res);
    //check if there is any row
    if($numrows > 0){
        //is there is any data with that username
        $obj = mysqli_fetch_object($res);
        //get row as object

        $return["success"] = true;
        $return["transaction_type_fee"] = $obj->transaction_type_fee;
        $return["transaction_imtt"] = $obj->transaction_imtt;
        $return["transaction_type_id"] = $obj->transaction_type_id;
        $return["transaction_type_desc"] = $obj->transaction_type_desc;
    }else{
        $return["error"] = true;
        $return["message"] = 'Transaction Fee Not Found';
    }
}
else{
    $return["error"] = true;
    $return["message"] = 'Transaction Fee not found.';
}

mysqli_close($link);

header('Content-Type: application/json');
// tell browser that its a json data
echo json_encode($return);
//converting array to JSON string
?>