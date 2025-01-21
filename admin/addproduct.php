<?php

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price =$_POST['price'];

	// Database connection
	$conn = new mysqli('localhost','root','','registration');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into product(title, description, price) values(?, ?, ?)");
		$stmt->bind_param("ssi", $title, $description, $price);
		$execval = $stmt->execute();
		echo $execval;
		echo "Product Entered";
		$stmt->close();
		$conn->close();
	}
?>