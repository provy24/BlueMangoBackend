
<?php

$HostName = "localhost";
$DatabaseName = "rightbank_db_v4";
$HostUser = "root";
$HostPass = "";

$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);

$customer_employer_name = $obj['customer_employer_name'];
$employment_start = $obj['employment_start'];
$customer_id = $obj['customer_id'];

//Applying User Login query with email and password.
$Sql_Query = "INSERT INTO customer_employment_detail(
                                        customer_employer_name,
                                        customer_position,
                                        employment_start,
                                        employment_end,
                                        customer_pay_frequency,
                                        customer_pay_amount,
                                        pay_into_rightbank,
                                        customer_id
                                        )
 values(
        '$customer_employer_name',
        NULL,
        '$employment_start',
        NULL,
        NULL,
        NULL,
        0,
        '$customer_id'
        )";

// Executing SQL Query.
if (mysqli_query($con, $Sql_Query)) {

    // If the record inserted successfully then show the message.
    $MSG = 'Success';

    // Converting the message into JSON format.
    $json = json_encode($MSG);

    // Echo the message.
    echo $json;

} else {

    // If Email and Password did not Matched.
    $InvalidMSG = (mysqli_error($con));

    // Converting the message into JSON format.
    $InvalidMSGJSon = json_encode($InvalidMSG);

    // Echo the message.
    echo $InvalidMSGJSon;

}

mysqli_close($con);
?>