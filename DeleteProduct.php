<?php
// Kiểm tra xem request method là POST và tồn tại biến id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Lấy id của sinh viên cần xóa từ biến POST
    $student_id = $_POST['id'];

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

    // Câu lệnh SQL để xóa sinh viên từ cơ sở dữ liệu
    $sql = "DELETE FROM register WHERE student_id = ?";

    // Chuẩn bị và thực thi câu lệnh SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo "Student deleted successfully";
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
