<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h2>Add</h2>
    <form action="AddProduct.php" method="post">
        <label for="Name">Name:</label><br>
        <input type="text" id="Name" name="Name" required><br><br>

        <label for="Email">Email:</label><br>
        <input type="email" id="Email" name="Email" required><br><br>

        <label for="Password">Password:</label><br>
        <input type="password" id="Password" name="Password" required><br><br>

        <label for="Address">Address:</label><br>
        <input type="text" id="Address" name="Address" required><br><br>

        <label for="Sex">Sex:</label><br>
        <input type="text" id="Sex" name="Sex" required><br><br>

        <label for="Age">Age:</label><br>
        <input type="number" id="Age" name="Age" required><br><br>

        <label for="Phone">Phone:</label><br>
        <input type="text" id="Phone" name="Phone" required><br><br>

        <button type="submit">Register</button>
    </form>
    <form action="StudentManagement.php">
        <button type="submit">Back to Student Management</button>
    </form>
</body>
</html>


<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "account";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $address = $_POST['Address'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];
    $phone = $_POST['Phone'];

    // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Chuẩn bị truy vấn SQL để thêm sinh viên mới vào bảng đăng ký
    $sql = "INSERT INTO register (Name, Email, Password, Address, Sex, Age, Phone) VALUES ('$name', '$email', '$hashed_password', '$address', '$sex', '$age', '$phone')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng người dùng đến trang thông tin sinh viên sau khi đăng ký thành công
        header("Location: StudentManagement.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
