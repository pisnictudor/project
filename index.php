<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mycrudapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create
    if (isset($_POST["create"])) {
        $name = $_POST["name"];
        $sql = "INSERT INTO users (name) VALUES ('$name')";
        $conn->query($sql);
    }

    // Update
    if (isset($_POST["update"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $sql = "UPDATE users SET name='$name' WHERE id=$id";
        $conn->query($sql);
    }

    // Delete
    if (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $sql = "DELETE FROM users WHERE id=$id";
        $conn->query($sql);
    }
}

// Read
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Application</title>
</head>
<body>
    <h1>CRUD Application</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Name">
        <button type="submit" name="create">Create</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                        <input type="text" name="name" value="<?php echo $row["name"]; ?>">
                        <button type="submit" name="update">Update</button>
                    </form>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
