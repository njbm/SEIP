<?php
// Database configuration
$host = 'localhost';
$dbname = 'crud';
$username = 'root';
$password = '';

// Establish a database connection
try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}

// Functions for CRUD operations

function createRecord($name, $email)
{
  global $conn;

  $sql = "INSERT INTO crud (name, email) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$name, $email]);
}

function readRecords()
{
  global $conn;

  $sql = "SELECT * FROM crud";
  $stmt = $conn->query($sql);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateRecord($id, $name, $email)
{
  global $conn;

  $sql = "UPDATE crud SET name = ?, email = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$name, $email, $id]);
}

function deleteRecord($id)
{
  global $conn;

  $sql = "DELETE FROM crud WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id]);
}

// Handle form submissions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    createRecord($name, $email);
  } elseif (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    updateRecord($id, $name, $email);
  } elseif (isset($_POST['delete'])) {
    $id = $_POST['id'];

    deleteRecord($id);
  }
}

// Retrieve records from the database
$records = readRecords();
?>

<!DOCTYPE html>
<html>

<head>
  <title>PHP PDO CRUD Example</title>

 <style>
  tr,td,th{padding: 20px;}
 </style>
</head>

<body>
  <h1>PHP PDO CRUD Example</h1>

  <!-- Create Form -->
  <h2>Create Record</h2>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    
    <input type="submit" name="create" value="Create">
  </form>

  <!-- Read Records -->
  <h2>Records</h2>
  <table align="center" border="2" style="border-collapse: collapse; border-color:aquamarine;">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Action</th>
    </tr>
    <?php foreach ($records as $record) : ?>
      <tr>
        <td><?php echo $record['id']; ?></td>
        <td><?php echo $record['name']; ?></td>
        <td><?php echo $record['email']; ?></td>
        <td>
          <a href="?edit=<?php echo $record['id']; ?>">Edit</a> |
          <a href="?delete=<?php echo $record['id']; ?>">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <?php
  // Edit Record
  if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editRecord = null;

    foreach ($records as $record) {
      if ($record['id'] == $editId) {
        $editRecord = $record;
        break;
      }
    }
  ?>
    <!-- Update Form -->
    <h2>Edit Record</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <input type="hidden" name="id" value="<?php echo $editRecord['id']; ?>">
      <label for="name">Name:</label>
      <input type="text" name="name" value="<?php echo $editRecord['name']; ?>" required>
      
      <label for="email">Email:</label>
      <input type="email" name="email" value="<?php echo $editRecord['email']; ?>" required>
     
      <input type="submit" name="update" value="Update">
    </form>
  <?php } ?>

  <?php
  // Delete Record
  if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];

    deleteRecord($deleteId);
  }
  ?>
</body>

</html>