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

function createRecord($title, $alt, $caption, $src)
{
    global $conn;

    $sql = "INSERT INTO crud3 (title, alt, caption, src) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$title, $alt, $caption, $src]);
}


function readRecords()
{
    global $conn;

    $sql = "SELECT * FROM crud2";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateRecord($id, $title, $alt, $caption, $src)
{
    global $conn;

    $sql = "UPDATE crud3 SET title = ?, alt = ?, caption=?, src=?  WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id, $title, $alt, $caption, $src]);
}

function deleteRecord($id)
{
    global $conn;

    $sql = "DELETE FROM crud3 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}

// Handle form submissions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $title = $_POST['title'];
        $alt = $_POST['alt'];
        $caption = $_POST['caption'];


        // Check if a file was uploaded
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $src = $_FILES['picture']['name'];
            $tempFile = $_FILES['picture']['tmp_name'];
            $targetPath = "uploads/"; // Specify the folder to save the uploaded picture

            // Move the uploaded picture to the target folder
            move_uploaded_file($tempFile, $targetPath . $src);
        }

        createRecord($title, $alt, $caption, $src);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $alt = $_POST['alt'];
        $caption = $_POST['caption'];
        $src = $_POST['picture'];

        updateRecord($id, $title, $alt, $caption, $src);
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
        tr, td, th { padding: 20px; }
    </style>
</head>

<body>
    <h1>PHP PDO CRUD Example</h1>

    <!-- Create Form -->
    <h2>Create Record</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="title" class="form-control" placeholder="Give a Title">

        <label for="email">Email:</label>
        <input type="text" name="alt" class="form-control" placeholder="Alternative Name">

        <input type="text" name="caption" class="form-control" placeholder="Add a Caption">

        <label for="picture">Picture:</label>
        <input type="file" name="picture" class="form-control" placeholder="Choose a file">

        <input type="submit" name="create" value="Create">
    </form>


    <!-- Read Records -->
    <h2>Records</h2>
    <table align="center" border="2" style="border-collapse: collapse; border-color:aquamarine;">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Picture</th>
            <th>Action</th>
        </tr>
        <?php foreach ($records as $record) : ?>
            <tr>
                <td><?php echo $record['id']; ?></td>
                <td><?php echo $record['name']; ?></td>
                <td><?php echo $record['email']; ?></td>
                <td>
                    <?php if (!empty($record['picture'])) : ?>
                        <img src="uploads/<?php echo $record['picture']; ?>" alt="Picture" height="100">
                    <?php endif; ?>
                </td>
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
            <label for="name">Name:</label>
            <input type="text" name="title" class="form-control" placeholder="Give a Title">

            <label for="email">Email:</label>
            <input type="text" name="alt" class="form-control" placeholder="Alternative Name">

            <input type="text" name="caption" class="form-control" placeholder="Add a Caption">

            <label for="picture">Picture:</label>
            <input type="file" name="picture" class="form-control" placeholder="Choose a file">

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