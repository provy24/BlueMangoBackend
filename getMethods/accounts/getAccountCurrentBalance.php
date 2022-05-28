<?php
$db = "rightbank_db_v4"; //database name
$dbuser = "root"; //database username
$dbpassword = ""; //database password
$dbhost = "localhost"; //database host

$return["error"] = false;
$return["message"] = "";
$return["success"] = false;

$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);

if(isset($_POST["account_number"]) ){
    //checking if there is POST data

    $account_number = $_POST["account_number"];

    //escape inverted comma query conflict from string

    $sql = "SELECT 
account_current_balance, 
account_id,
customer_first_name,
customer_last_name,
local_currency_code
FROM account_type 
JOIN account 
ON account.account_type_id = account_type.account_type_id
JOIN customer_has_account
ON customer_has_account.account_account_id = account.account_id
JOIN customer
ON customer.customer_id = customer_has_account.customer_customer_id
 WHERE account_number = '$account_number'";
    //building SQL query
    $res = mysqli_query($link, $sql);
    $numrows = mysqli_num_rows($res);
    //check if there is any row
    if($numrows > 0){
        //is there is any data with that username
        $obj = mysqli_fetch_object($res);
        //get row as object

        $return["success"] = true;
        $return["account_current_balance"] = $obj->account_current_balance;
        $return["account_id"] = $obj->account_id;
        $return["local_currency_code"] = $obj->local_currency_code;
        $return["customer_first_name"] = $obj->customer_first_name;
        $return["customer_last_name"] = $obj->customer_last_name;
    }else{
        $return["error"] = true;
        $return["message"] = 'Account Number Not Found';
    }
}
else{
    $return["error"] = true;
    $return["message"] = 'Account number not found.';
}

mysqli_close($link);

header('Content-Type: application/json');
// tell browser that its a json data
echo json_encode($return);
//converting array to JSON string
?>