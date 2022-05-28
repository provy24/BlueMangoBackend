
<?php

$HostName = "localhost";
$DatabaseName = "rightbank_db_v4";
$HostUser = "root";
$HostPass = "";


$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

// Getting the received JSON into $json variable.
$json = file_get_contents('php://input');

// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json,true);

// Getting User email from JSON $obj array and store into $email.



// Getting Password from JSON $obj array and store into $password.
//Customer Table Values on theie order
$account_account_id = $obj['account_account_id'];
$customer_customer_id = $obj['customer_customer_id'];


//Applying User Login query with email and password.
$loginQuery = "select * from customer_has_account where customer_customer_id='$customer_customer_id'";
$Sql_Query = "INSERT INTO customer_has_account(customer_customer_id,account_account_id) values('$customer_customer_id','$account_account_id')";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con,$loginQuery));

if(isset($check)){

    // If Email and Password did not Matched.
    $InvalidMSG = 'Failed to insert into customer has account' ;

    // Converting the message into JSON format.
    $InvalidMSGJSon = json_encode($InvalidMSG);

    // Echo the message.
    echo $InvalidMSGJSon ;

}

else{

    if(mysqli_query($con,$Sql_Query)){

        // If the record inserted successfully then show the message.
        $MSG = 'Success' ;

        // Converting the message into JSON format.
        $json = json_encode($MSG);

        // Echo the message.
        echo $json ;

    }
    else{

        // If Email and Password did not Matched.
        $InvalidMSG = 'Failed to insert into customer has account, please try again' ;

        // Converting the message into JSON format.
        $InvalidMSGJSon = json_encode($InvalidMSG);

        // Echo the message.
        echo $InvalidMSGJSon ;

    }
}

mysqli_close($con);
?>