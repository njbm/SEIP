<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form data
  $id = $_POST['id'];

  // Validate the form data (optional)

  // Establish a database connection (similar to previous steps)
  $host = 'localhost';
  $dbname = 'crud';
  $username = 'root';
  $password = '';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the delete query
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "Record deleted successfully!";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // Close the database connection (optional)
  $conn = null;
}
