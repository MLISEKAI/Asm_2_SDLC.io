<?php
// Bắt đầu phiên
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['student_id'])) {
    // Nếu chưa, chuyển hướng đến trang đăng nhập
    header("Location: LoginProduct.php");
    exit;
}

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$db_password = "";
$dbname = "account";

$conn = new mysqli($servername, $username, $db_password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy thông tin sinh viên từ cơ sở dữ liệu dựa trên student_id lưu trong phiên
$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM register WHERE student_id = $student_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Hiển thị thông tin của sinh viên
    
    echo "<div class='container'>";
    echo "<h2>Welcome back, {$row['Name']}!</h2>";
    echo "<p>Email: {$row['Email']}</p>";
    echo "<p>Address: {$row['Address']}</p>";
    echo "<p>Sex: {$row['Sex']}</p>";
    echo "<p>Age: {$row['Age']}</p>";
    echo "<p>Phone: {$row['Phone']}</p>";

    // Nút sửa
    echo "<form action='EditProduct.php' method='get'>";
    echo "<input type='hidden' name='id' value='$student_id'>";
    echo "<button type='submit'>Edit</button>";
    echo "</form>";
    echo "</div>";
} else {
    // Không tìm thấy thông tin sinh viên
    echo "<div class='container'>";
    echo "Error retrieving student information.";
    echo "</div>";
}

// Đóng kết nối
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
    }

    p {
        margin: 10px 0;
    }

    form {
        margin-top: 20px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    </style>
</head>
<body>
    <!-- Button to logout -->
    <form action="LoginProduct.php" method="post">
        <button type="submit">Back to Login</button>
    </form>
</body>
</html>
