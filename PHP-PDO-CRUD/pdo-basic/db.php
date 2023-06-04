<!-- // Create a database and table
CREATE DATABASE my_database;
USE my_database;
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  email VARCHAR(255),
  PRIMARY KEY (id)
); -->

 <!-- Create a PHP file to connect to the database and create a PDO object -->
<?php

// Create a PDO object
$pdo = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>


<html>
<head>
<title>CRUD with PHP PDO</title>
</head>
<body>

<h1>CRUD with PHP PDO</h1>

<h2>Create a record</h2>

<form action="create.php" method="post">
  Name: <input type="text" name="name" />
  Email: <input type="text" name="email" />
  <input type="submit" value="Create" />
</form>

<h2>Read all records</h2>

<table border="2">
  <tr>
    <Th>ID</Th>
    <th>Name</th>
    <th>Email</th>
  </tr>

<?php

// Get all records from the users table
$sql = 'SELECT * FROM users';
$stmt = $pdo->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch()) {
  echo '<tr>';
  echo '<td>' . $row['id'] . '</td>';
  echo '<td>' . $row['name'] . '</td>';
  echo '<td>' . $row['email'] . '</td>';
  echo '</tr>';
}

?>

</table>

<h2>Update a record</h2>

<form action="update.php" method="post">
  ID: <input type="text" name="id" />
  Name: <input type="text" name="name" />
  Email: <input type="text" name="email" />
  <input type="submit" value="Update" />
</form>

<h2>Delete a record</h2>

<form action="delete.php" method="post">
  ID: <input type="text" name="id" />
  <input type="submit" value="Delete" />
</form>

</body>
</html>
