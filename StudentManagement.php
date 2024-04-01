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


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "account";

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO register (Name, Email, Password, Address, Sex, Age, Phone) VALUES ('$name', '$email', '$hashed_password', '$address', '$sex', '$age', '$phone')";

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
    <title>Student Management</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            font-size: 62.5%;
            padding: 20px;
        }

        h2 {
            color: #4a5568;
            font-size: 3rem;
            text-align: center;
            margin: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 100px;
        }
        
        th, td {
            border: 1px solid #cbd5e0;
            padding: 8px;
            text-align: left;
            font-size: 1.2rem;
        }
        
        th {
            background-color: #e2e8f0;
            color: #2d3748;
            font-size: 1.4rem;
        }
        
        tr:nth-child(even) {
            background-color: #edf2f7;
        }
        
        form {
        }
        
        button {
            padding: 10px 20px;
            background-color: #4a5568;
            color: white;
            border: none;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #2d3748;
        }
    </style>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
</head>
<body>
    <h2>Welcome to Student Management</h2>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search_id">Search by ID:</label>
        <input type="text" id="search_id" name="search_id">
        <button type="submit">Search</button>
    </form>

    <!-- CSS Search -->
    <style>
    form[method="get"] {
        display: flex;
        justify-content: center;
        align-items: center;

    }

    label[for="search_id"]{
        margin-right: 10px;
        font-size: 1.4rem;
    }

    input[type="text"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        width: 70%;
    }

    button[type="submit"] {
        margin: 0 20px;
        background-color: #4a5568;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        width: 10%;
    }

    button[type="submit"]:hover {
        background-color: #2d3748;
    }
</style>
 

<?php
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

   // Xử lý yêu cầu tìm kiếm
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search_id'])) {
    $search_id = $_GET['search_id'];
    $sql = "SELECT student_id, Name, Email, Password, Address, Sex, Age, Phone FROM register WHERE student_id = $search_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Address</th><th>Sex</th><th>Age</th><th>Phone</th><th>Action</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['student_id'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Password'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['Sex'] . "</td>";
            echo "<td>" . $row['Age'] . "</td>";
            echo "<td>" . $row['Phone'] . "</td>";
            echo "<td><form action='EditProduct.php' method='get'><input type='hidden' name='id' value='" . $row['student_id'] . "'><button type='submit'>Edit</button></form></td>";
            echo "<td>";
            echo "<form action='DeleteProduct.php' method='post' onsubmit='return confirmDelete()'>";
            echo "<input type='hidden' name='id' value='" . $row['student_id'] . "'>";
            echo "<button type='submit'>Delete</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
}
// Nếu không có yêu cầu tìm kiếm, hiển thị toàn bộ dữ liệu
else {
    $sql = "SELECT student_id, Name, Email, Password, Address, Sex, Age, Phone FROM register";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Address</th><th>Sex</th><th>Age</th><th>Phone</th><th>Action</th><th>Action</th></tr>";
        // Hiển thị dữ liệu đăng ký
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['student_id'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Password'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['Sex'] . "</td>";
            echo "<td>" . $row['Age'] . "</td>";
            echo "<td>" . $row['Phone'] . "</td>";
            echo "<td><form action='EditProduct.php' method='get'><input type='hidden' name='id' value='" . $row['student_id'] . "'><button type='submit'>Edit</button></form></td>";
            echo "<td>";
            echo "<form action='DeleteProduct.php' method='post' onsubmit='return confirmDelete()'>";
            echo "<input type='hidden' name='id' value='" . $row['student_id'] . "'>";
            echo "<button type='submit'>Delete</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}
$conn->close();
?>
    <form action="AddProduct.php">
        <button type="submit" id='btn-add'>Add</button>
    </form>

    <!-- CSS Add -->
    <style>
        #btn-add {

        }
    </style>

    <form action="LoginProduct.php">
        <button type="submit" id="btn-login">Back to Login</button>
    </form>

    <!-- CSS Login -->
    <style>
        #btn-login {

        }
    </style>

</body>
</html>
