<?php

function connectDB() {

	$servername = "localhost";
	$username = "root";
	$password = "1234567890";
	$dbname = "exam_project";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	return $conn;

}

function disconnectDB( $conn ) {

	$conn->close();

}

?>