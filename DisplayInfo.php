<?php

	$inData = getRequestInfo();
	
    $userId = 0;
	$firstName = "";
    $lastName = "";
    $email = "";
    $phone = "";
    $addr = "";

	$conn = new mysqli("localhost", "Obelisk", "TheTormentorOfCOP4331!", "COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
		$sql = "SELECT FirstName,LastName,Email,PhoneNumber,Address FROM Contacts where UserId=" . $inData["UserId"] . " ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$firstName = $row["FirstName"];
            $lastName = $row["LastName"];
            $email = $row["Email"];
            $phone = $row["PhoneNumber"];
            $addr = $row["Address"];
			$userId = $row["UserId"];
			
			returnWithInfo($firstName, $lastName, $email, $phone, $addr, $userid );
		}
		else
		{
			returnWithError( "No Records Found" );
		}
		$conn->close();
	}
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"UserId":0,"FirstName":"","LastName":"","Email":"","PhoneNumber":"","Address":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $firstName, $lastName, $id )
	{
		$retValue = '{"UserId":' . $id . ',"FirstName":"' . $firstName . '","LastName":"' . $lastName . '","Email":"' . $email . '","PhoneNumber":"' . $phone . '","Address":"' . $addr . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>