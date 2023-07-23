<?php
// Check if the ID parameter was provided in the URL
if (!isset($_GET['id'])) {
    die("ID parameter not provided.");
}

// Get the ID parameter from the URL
$id = $_GET['id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "test");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Delete the user from the database
$sql = "DELETE FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Check for errors in the SQL query
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);

// Redirect back to the admin page
header("Location: register.php");
exit;
?>
