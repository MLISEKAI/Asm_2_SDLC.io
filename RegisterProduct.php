<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $confirmPassword = $_POST['ConfirmPassword'];
    $address = $_POST['Address'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];
    $phone = $_POST['Phone'];

    if (!empty($password) && !empty($confirmPassword)) {
        if ($password !== $confirmPassword) {
            echo "Passwords do not match!";
            exit;
        }
    } else {
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "account";

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO register (Name, Email, Password, Address, Sex, Age, Phone) 
            VALUES ('$name', '$email', '$hashed_password', '$address', '$sex', '$age', '$phone')";

    if ($conn->query($sql) === TRUE) {
        header("Location: LoginProduct.php");
        exit;
    } else {
        echo "Error: " . $sql . "" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl text-center font-bold mb-4">Registration</h2>

        <form action="RegisterProduct.php" method="post">
            <label for="Name" class="block mb-2">Name:</label>
            <input type="text" id="Name" name="Name" required class="w-full px-3 py-2 border rounded-md mb-4">

            <label for="Email" class="block mb-2">Email:</label>
            <input type="email" id="Email" name="Email" required class="w-full px-3 py-2 border rounded-md mb-4">

            <label for="Password" class="block mb-2">Password:</label>
            <input type="password" id="Password" name="Password" required class="w-full px-3 py-2 border rounded-md mb-4">

            <label for="ConfirmPassword" class="block mb-2">Confirm Password:</label>
            <input type="password" id="ConfirmPassword" name="ConfirmPassword" required class="w-full px-3 py-2 border rounded-md mb-4">

            <label for="Age" class="block mb-2">Age:</label>
            <input type="number" id="Age" name="Age" required class="w-full px-3 py-2 border rounded-md mb-4">

            <label for="Phone" class="block mb-2">Phone:</label>
            <input type="text" id="Phone" name="Phone" required class="w-full px-3 py-2 border rounded-md mb-4">

            <div class="flex mb-4">
                <label for="Male" class="flex items-center mr-4">
                    <input type="radio" id="Male" name="Sex" value="Male" required class="mr-2">
                    Male
                </label>
                <label for="Female" class="flex items-center">
                    <input type="radio" id="Female" name="Sex" value="Female" class="mr-2">
                    Female
                </label>
            </div>

            <label for="Address" class="block mb-2">Address:</label>
            <textarea id="Address" name="Address" rows="2" cols="50" required class="w-full px-3 py-2 border rounded-md mb-4"></textarea>

            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Register</button>
        </form>
        <p class="text-center mt-4">Already have an account? <a href="LoginProduct.php" class="text-green-500 hover:underline">Login here</a>.</p>
    </div>
</body>
</html>
