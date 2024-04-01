<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['student_id'])) {
    header("Location: LoginProduct.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "account";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối đến cơ sở dữ liệu
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy id sinh viên từ tham số URL
$student_id = $_GET['id'];

// Truy vấn để lấy thông tin sinh viên dựa trên student_id
$sql = "SELECT * FROM register WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Lưu thông tin sinh viên vào một mảng
$student = $result->fetch_assoc();
$stmt->close();

// Xử lý form khi được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $address = $_POST['Address'];
    $sex = $_POST['Sex'];
    $age = $_POST['Age'];
    $phone = $_POST['Phone'];

    // Băm mật khẩu mới
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Truy vấn để cập nhật thông tin sinh viên
    $sql = "UPDATE register SET Name=?, Email=?, Password=?, Address=?, Sex=?, Age=?, Phone=? WHERE student_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $name, $email, $hashed_password, $address, $sex, $age, $phone, $student_id);

    if ($stmt->execute()) {
            header("Location: StudentManagement.php");
    }
    } else {
        echo "Error updating student information: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $student_id); ?>" method="post">
        <label for="Name">Name:</label><br>
        <input type="text" id="Name" name="Name" value="<?php echo $student['Name']; ?>" required><br><br>

        <label for="Email">Email:</label><br>
        <input type="email" id="Email" name="Email" value="<?php echo $student['Email']; ?>" required><br><br>

        <label for="Password">Password:</label><br>
        <input type="password" id="Password" name="Password" value="<?php echo $student['Password']; ?>" required><br><br>

        <label for="Address">Address:</label><br>
        <input type="text" id="Address" name="Address" value="<?php echo $student['Address']; ?>" required><br><br>

        <label for="Sex">Sex:</label><br>
        <input type="text" id="Sex" name="Sex" value="<?php echo $student['Sex']; ?>" required><br><br>

        <label for="Age">Age:</label><br>
        <input type="number" id="Age" name="Age" value="<?php echo $student['Age']; ?>" required><br><br>

        <label for="Phone">Phone:</label><br>
        <input type="text" id="Phone" name="Phone" value="<?php echo $student['Phone']; ?>" required><br><br>

        <button type="submit">Update</button>
    </form>

    <form action="StudentManagement.php">
        <button type="submit">Back to Student Management</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
