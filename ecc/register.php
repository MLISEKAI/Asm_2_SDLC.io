<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "btec-db";
    $conn = new mysqli($servername,$dbname,$password,$username);
    if ($conn->connect_error) {
        die("connection failed". $conn->connect_error);
    }
    $email = $_POST["email"];
    $password = $_POST["psw"];$hashedPassword = password_hash($passwordFromForm, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(email,password) VALUES ('$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "User registered succses";
    } else {
        echo "Error" .$sql ."<br>" . $conn->error;
    }
?>