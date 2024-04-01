<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
    <form method="post" action="">
        <input type="text" name="num1" placeholder="Enter first number" required /><br><br>
        <input type="text" name="num2" placeholder="Enter second number" required /><br><br>
        <select name="operator">
            <option value="add">Addition (+)</option>
            <option value="subtract">Subtraction (-)</option>
            <option value="multiply">Multiplication (*)</option>
            <option value="divide">Division (/)</option>
        </select><br><br>
        <input type="submit" name="calculate" value="Calculate" />
    </form>

    <?php
    if (isset($_POST["calculate"])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operator = $_POST['operator'];

        switch ($operator) {
            case "add":
                $result = $num1 + $num2;
                echo "Result: $num1 + $num2 = $result";
                break;
            case "subtract":
                $result = $num1 - $num2;
                echo "Result: $num1 - $num2 = $result";
                break;
            case "multiply":
                $result = $num1 * $num2;
                echo "Result: $num1 * $num2 = $result";
                break;
            case "divide":
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                    echo "Result: $num1 / $num2 = $result";
                } else {
                    echo "Error: Division by zero!";
                }
                break;
            default:
                echo "Invalid operator";
        }
    }
    ?>
</body>
</html>

