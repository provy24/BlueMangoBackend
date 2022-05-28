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

$transaction_reference      = $obj['transaction_reference'];
$transaction_amount         = $obj['transaction_amount'];
$transaction_charge         = $obj['transaction_charge'];
$transaction_new_bal        = $obj['transaction_new_bal'];
$transaction_account_other  = $obj['transaction_account_other'];
$transaction_account_holder = $obj['transaction_account_holder'];
$transaction_bank_other     = $obj['transaction_bank_other'];
$transaction_type_id        = $obj['transaction_type_id'];
$transaction_account_id     = $obj['transaction_account_id'];
$transaction_description    = $obj['transaction_description'];
$imtt                       = $obj['imtt'];
$debit_credit               = $obj['debit_credit'];

//Applying User Login query with email and password.
$Sql_Query = "INSERT INTO transactions(
        transaction_reference,
        transactions_date,
        transactions_amount,
        transactions_charge,
        transactions_new_bal,
        transactions_account_other,
        transaction_account_holder,
        transactions_bank_other,
        transaction_type_id,
        transaction_account_id,
        transaction_description,
        status,
        effective_datetime,
        imtt,
        debit_credit
        )
 values(
        '$transaction_reference',
        CURRENT_TIMESTAMP,
        '$transaction_amount',
        '$transaction_charge',
        '$transaction_new_bal',
        '$transaction_account_other',
        '$transaction_account_holder',
        '$transaction_bank_other',
        '$transaction_type_id',
        '$transaction_account_id',
        '$transaction_description',
        'Complete',
        CURRENT_TIMESTAMP,
        '$imtt',
        '$debit_credit'
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