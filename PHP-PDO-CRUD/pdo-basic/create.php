<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form data
  $id = null;
  $name = $_POST['name'];
  $email = $_POST['email'];

  // Validate the form data (optional)
  // ...

  // Establish a database connection (similar to previous steps)
  $host = 'localhost';
  $dbname = 'crud';
  $username = 'root';
  $password = '';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the insert query
    $sql = "INSERT INTO users (id, name, email) VALUES (:id, :name, :email)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "Record created successfully!";
    
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // Close the database connection (optional)
  $conn = null;
}
