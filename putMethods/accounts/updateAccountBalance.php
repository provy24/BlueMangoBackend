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



//Customer Next of kin Table values in order
 $account_current_balance = $obj['account_current_balance'];
 $account_number = $obj['account_number'];



 //Applying User Login query with email and password.
 $Sql_Query = "UPDATE account SET account_current_balance = '$account_current_balance' WHERE account_number ='$account_number' ";

 // Executing SQL Query.
	 if(mysqli_query($con,$Sql_Query)){

		  // If the record inserted successfully then show the message.
		$MSG = 'Login Matched' ;

		// Converting the message into JSON format.
		$json = json_encode($MSG);

		// Echo the message.
		 echo $json ;


	 }
	 else{

				 // If Email and Password did not Matched.
		$InvalidMSG = 'Registration failed, please try again' ;

		// Converting the message into JSON format.
		$InvalidMSGJSon = json_encode($InvalidMSG);

		// Echo the message.
		 echo $InvalidMSGJSon ;

	 }

 mysqli_close($con);
?>