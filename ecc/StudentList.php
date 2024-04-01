<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        caption {
            font-size: 70px;
            font-weight: bold;
        }
        th {
            background-color: antiquewhite;
            font-size: 30px;

        }
        tr {

        }
        td {
            width: 10%;
            height: 100px;
            font-size: 20px;
            text-align: center;
            font-weight: bold;

        }
        td:nth-last-child(1) {
            width: 40%;
        }
    </style>
</head>
<body>
    <?php
    $servername = "127.0.0.1";
    $username = "root"; // Đổi thành tên người dùng MySQL
    $password = ""; // Để trống nếu không có mật khẩu
    $dbname = "college";
    
    // Tạo kết nối đến MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Student";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table align='center' border='1px' cellpadding='0' cellspacing='0'>";
        echo "<caption align='center'>Student List</caption>";
        echo "<tr>
            <th>Rollno</th>
            <th>Student FullName</th>
            <th>Address</th>
            <th>Email</th>
            </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['Rollno'] . "</td><td>" . $row['Stname'] . "</td><td>" . $row['Address'] . "</td><td>" . $row['Email'] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
</body>
</html>
