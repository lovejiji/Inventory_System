<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "borrowers";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $studentId = $_POST['student_id'];
    $toolId = $_POST['id_tool'];
    $quantity = $_POST['quan'];
    $borrowedDate = $_POST['borrowed_date'];
    $returnedDate = $_POST['returned_date']; // Optional, might be empty if not returned yet
    $returnedTime = $_POST['returned_time']; // Optional, might be empty if not returned yet

    // Basic validation (optional, improve based on your needs)
    if (!is_numeric($studentId) || !is_numeric($toolId) || !is_numeric($quantity) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $borrowedDate) || ($returnedDate && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $returnedDate))) {
        echo "Invalid data submitted.";
        exit;
    }

    // Insert statement
    $sql = "INSERT INTO borrowed_items (student_id, id_tool, quan, borrowed_date, returned_date, returned_time) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("iiisss", $studentId, $toolId, $quantity, $borrowedDate, $returnedDate, $returnedTime);

        if ($stmt->execute()) {
            echo "Successfully borrowed a tool!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $db->error;
    }

    // Close connection
    $db->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Tool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 40px;
        }

        h1, h2 {
            margin-bottom: 10px;
        }

        header {
            background-color: #800000; /* Maroon */
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-bottom: 20px;
        }

        header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        header nav a:hover {
            text-decoration: underline;
        }

        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px; /* Adjust the max width as needed */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #800000; /* Maroon */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="homepage_student.php">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <h2>Borrow a Tool</h2>
    <?php if (!empty($success_message)): ?>
        <div class="success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="error">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="process_borrow.php" method="POST">
        <label for="student_id">Student ID:</label>
        <input type="number" id="student_id" name="student_id" required><br><br>

        <label for="id_tool">Tool ID:</label>
        <input type="number" id="id_tool" name="id_tool" required><br><br>

        <label for="quan">Quantity:</label>
        <input type="number" id="quan" name="quan" required><br><br>

        <label for="borrowed_date">Borrowed Date:</label>
        <input type="date" id="borrowed_date" name="borrowed_date" required><br><br>

        <label for="returned_date">Return Date:</label>
        <input type="date" id="returned_date" name="returned_date"><br><br>

        <label for="returned_time">Return Time:</label>
        <input type="time" id="returned_time" name="returned_time"><br><br>

        <input type="submit" value="Borrow Tool">
    </form>

    <h2>Borrowed Items</h2>
    <?php
    // Reconnect to the database to display the borrowed items
    $db = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Retrieve existing records
    $sql = "SELECT * FROM borrowed_items";
    $result = mysqli_query($db, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div class="table-container">';
        echo "<table>";
        echo "<tr><th>Student ID</th><th>Tool ID</th><th>Quantity</th><th>Borrowed Date</th><th>Return Date</th><th>Return Time</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['student_id'] . "</td>";
            echo "<td>" . $row['id_tool'] . "</td>";
            echo "<td>" . $row['quan'] . "</td>";
            echo "<td>" . $row['borrowed_date'] . "</td>";
            echo "<td>" . $row['returned_date'] . "</td>";
            echo "<td>" . $row['returned_time'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo '</div>';
    } else {
        echo "No records found.";
    }

    // Close connection
    mysqli_close($db);
    ?>
</body>
</html>