<?php
// Bắt đầu phiên
session_start();

// Kiểm tra xác thực đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Email']) && isset($_POST['Password'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "account";

    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch student information
    $sql = "SELECT student_id, Name, Email, Password FROM register WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['Password'];

        // Xác minh mật khẩu
        if (password_verify($password, $stored_password)) {
            // Lưu student_id vào phiên
            $_SESSION['student_id'] = $row['student_id'];

            // Chuyển hướng đến trang StudentInformation.php
            header("Location: StudentInformation.php");
            exit;
        } else {
            // Mật khẩu không chính     
            echo "Invalid email or password";
        }
    } else {
        // Nếu không tìm thấy người dùng, kiểm tra xem có phải là admin không
        $admin_email = "admin@gmail.com"; // Thay bằng email của admin
        $admin_password_hash = password_hash("123", PASSWORD_DEFAULT); // Thay bằng mật khẩu của admin đã được băm

        if ($email === $admin_email && password_verify($password, $admin_password_hash)) {
            // Nếu là admin, chuyển hướng đến trang quản lý
            header("Location: StudentManagement.php");
            exit;
        } else {
            // Nếu không phải là admin và cũng không phải người dùng thông thường, hiển thị thông báo lỗi
            echo "Invalid email or password";
            exit;
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl text-center font-bold mb-4">Login</h2>
        <form action="" method="post">
            <div class="mb-4">
                <label for="Email" class="block mb-2">Email:</label>
                <input type="email" id="Email" name="Email" required class="w-full px-3 py-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="Password" class="block mb-2">Password:</label>
                <input type="password" id="Password" name="Password" required class="w-full px-3 py-2 border rounded-md">
            </div>
            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Login</button>
        </form>
        <p class="text-center mt-4">Don't have an account? <a href="RegisterProduct.php" class="text-green-500 hover:underline">Register here</a>.</p>
    </div>
</body>
</html>
