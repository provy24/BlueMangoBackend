<?php

$HostName = "localhost";
$DatabaseName = "rightbank_db_v4";
$HostUser = "root";
$HostPass = "";
$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

$json = file_get_contents('php://input');

// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);

$loan_application_reference = $obj['loan_application_reference'];
$loan_application_amount = $obj['loan_application_amount'];
$loan_application_type = $obj['loan_application_type'];
$loan_application_customer_id = $obj['loan_application_customer_id'];


$charged_interest_rates = $obj['charged_interest_rates'];
$payback_period = $obj['payback_period'];
$payback_amount = $obj['payback_amount'];
$monthly_installments = $obj['monthly_installments'];
$last_installment_date = $obj['last_installment_date'];

$loginQuery = "select * from loan_application where loan_application_customer_id = '$loan_application_customer_id' and loan_payment_due='yes' ";
$Sql_Query = "INSERT INTO loan_application (
	 loan_application_reference,
	 loan_application_branch_id,
     loan_application_customer_id,
     loan_application_date,
     loan_application_amount,
     loan_application_type,
     loan_application_status,
     charged_interest_rates,
     payback_period,
     payback_amount,
     monthly_installments,
     last_installment_date,
     loan_payment_due
) values (
	'$loan_application_reference',
	1,
	'$loan_application_customer_id',
	CURRENT_TIMESTAMP,
     '$loan_application_amount',
     '$loan_application_type',
     'Pending',
     '$charged_interest_rates',
     '$payback_period',
     '$payback_amount',
     '$monthly_installments',
     '$last_installment_date',
     'yes'
	)";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $loginQuery));

if (isset($check)) {
    // If Email and Password did not Matched.
    $InvalidMSG = 'Please you still have another loan payment that you have not completed to payback yet';
    // Converting the message into JSON format.
    $InvalidMSGJSon = json_encode($InvalidMSG);

    echo $InvalidMSGJSon;

} else {

    if (mysqli_query($con, $Sql_Query)) {

        // If the record inserted successfully then show the message.
        $MSG = 0;
        $last_id = mysqli_insert_id($con);

        // Converting the message into JSON format.
        $json = json_encode($MSG);
        $ppl = json_encode($last_id);

        // Echo the message.
        echo $ppl;
    } else {
        $InvalidMSG = (mysqli_error($con));

        // Converting the message into JSON format.
        $InvalidMSGJSon = json_encode($InvalidMSG);

        // Echo the message.
        echo $InvalidMSGJSon;

    }
}

mysqli_close($con);
