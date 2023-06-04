<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
  // Retrieve the form data
  $id = $_POST['id'];
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

    // Prepare and execute the update query
    $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "Record updated successfully!";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  // Close the database connection (optional)
  $conn = null;
}
