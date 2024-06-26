<?php
// Include connection details
include "admin_connect1.php";

$sql = "CREATE TABLE IF NOT EXISTS borrowed_items (
  student_id INT(11),
  FOREIGN KEY (student_id) REFERENCES users(id),
  id_tool INT NOT NULL,
  FOREIGN KEY (id_tool) REFERENCES tools(id),
  quan INT NOT NULL,
  FOREIGN KEY (quan) REFERENCES tools(quantity),
  borrowed_date DATE NOT NULL,
  returned_date DATE NOT NULL,
  returned_time TIME NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table Borrower's Lists created successfully";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrowed Items Form</title>
  
  <style>
    /* Basic form styling */
    form {
      width: fit-content;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="time"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 15px;
    }

    button[type="submit"] {
      background-color: #4CAF50; /* Green */
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    /* Center the table */
  .table-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  /* Table Styles */
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

</style>

</head>
<body>
  <h1>Borrowed Items Form</h1>

  <form method="post" action="process_borrow.php">
    <label for="student_id">Student ID:</label>
    <input type="number" name="student_id" id="student_id" required>
    <br>

    <label for="id_tool">Tool ID:</label>
    <input type="number" name="id_tool" id="id_tool" required>
    <br>

    <label for="quan">Quantity:</label>
    <input type="number" name="quan" id="quan" min="1" required> (Enter 1 for borrowing a single tool)
    <br>

    <label for="borrowed_date">Borrowed Date:</label>
    <input type="date" name="borrowed_date" id="borrowed_date" value="<?php echo date('Y-m-d'); ?>" readonly>  <br>

    <label for="returned_date">Returned Date:</label>
    <input type="date" name="returned_date" id="returned_date">
    <br>

    <label for="returned_time">Returned Time:</label>
    <input type="time" name="returned_time" id="returned_time">
    <br>

    <button type="submit">Submit</button>
  </form>
  <?php

  // Retrieve existing records (optional)
$sql = "SELECT * FROM borrowed_items";
$result = mysqli_query($db, $sql);

  ?>
</body>
</html>