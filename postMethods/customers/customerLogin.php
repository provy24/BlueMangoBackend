<?php

$db = "rightbank_db_v4"; //database name
$dbuser = "root"; //database username
$dbpassword = ""; //database password
$dbhost = "localhost"; //database host

$return["error"] = false;
$return["message"] = "";
$return["success"] = false;

$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);

if(isset($_POST["username"]) && isset($_POST["password"])){
    //checking if there is POST data

    $username = $_POST["username"];
    $password = $_POST["password"];


    $username = mysqli_real_escape_string($link, $username);
    //escape inverted comma query conflict from string

    $sql = "SELECT 
	customer_first_name,
    customer_last_name,
    customer_email,
    customer_phone,
    customer_national_id,
    customer.customer_id,
    account.account_id,
    account_current_balance,
    account_status,
    account_number,
    customer_title,
       local_currency_code,
    account_type_name,
       customer_created,
    account_type.account_type_id,
    username,
    password
FROM account_type
JOIN account
ON account_type.account_type_id = account.account_type_id
JOIN customer_has_account
ON account.account_id = customer_has_account.account_account_id
JOIN customer
ON customer.customer_id = customer_has_account.customer_customer_id
JOIN customer_security
ON customer_security.customer_id = customer.customer_id
WHERE username ='$username'";
    //building SQL query
    $res = mysqli_query($link, $sql);
    $numrows = mysqli_num_rows($res);
    //check if there is any row
    if($numrows > 0){
        //is there is any data with that username
        $obj = mysqli_fetch_object($res);
        //get row as object
        $verify = password_verify($password, $obj->password);
        if($verify){

            $return["success"] = true;
            $return["customer_first_name"] = $obj->customer_first_name;
            $return["customer_last_name"] = $obj->customer_last_name;
            $return["customer_email"] = $obj->customer_email;
            $return["customer_phone"] = $obj->customer_phone;
            $return["customer_national_id"] = $obj->customer_national_id;
            $return["account_id"] = $obj->account_id;
            $return["account_current_balance"] = $obj->account_current_balance;
            $return["account_status"] = $obj->account_status;
            $return["customer_title"] = $obj->customer_title;
            $return["account_type_name"] = $obj->account_type_name;
            $return["account_type_id"] = $obj->account_type_id;
            $return["customer_id"] = $obj->customer_id;
            $return["customer_created"] = $obj->customer_created;
            $return["local_currency_code"] = $obj->local_currency_code;
            $return["account_number"] = $obj->account_number;

            $return["message"] = "Login was successful";

        }else{
            $return["error"] = true;
            $return["message"] = "Your Password is Incorrect.";
        }
    }else{
        $return["error"] = true;
        $return["message"] = 'Sorry, i\'m failing to recognize your email address, please make you sure are providing the correct email address.Thank you';
    }
}else{
    $return["error"] = true;
    $return["message"] = 'Login failed !, please make sure you have internet access\nThank.';
}

mysqli_close($link);

header('Content-Type: application/json');
// tell browser that its a json data
echo json_encode($return);
//converting array to JSON string
?>
