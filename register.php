<!DOCTYPE html>
<html>
<head>
	<title>User Management</title>

</head>
<style>

body {
    background-color: #f2f2f2;
}
.container {
  display: flex;
  text-align: center;
  margin-top: 130px;
  margin-left: 40px;
  font-size: 20px;
  font-family: Arial, Helvetica, sans-serif;

}

.form {
  width: 50%;
  display: inline-block;
  vertical-align: top;
  margin-right: 50px;
}

.table {
  width: 50%;
  display: inline-block;
  vertical-align: top;
}

table {
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
  font-size: 30px;
}

th {
  background-color: #0c4da3;
  color: white;
}
label, input {
  font-size: 30px;
}
input[type="text"] {
  font-size: 30px;
}
input[type="text"], input[type="password"] {
  width: 300px;
  height: 40px;
  font-size: 24px;
}


</style>
<body>
	<div class="container">
		<div class="form">
			<h2>User Registration Form</h2>
			<form action="register.php" method="post">
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" required>
				<br><br>
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" required>
				<br><br>
				<input type="submit" name="register" value="Register">
                <p><a href="index.php">Log in</a></p>

			</form>
		</div>
		<div class="table">
			<table>
				<thead>
					<tr>
						<th>Username</th>
						<th>Password</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
        <?php
				// Connect to the database
				$conn = mysqli_connect("localhost", "root", "", "test");
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}

				// Select all users with delete access
				$sql = "SELECT * FROM users";
				$result = mysqli_query($conn, $sql);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
            
                // Check if the form has been submitted
                if (isset($_POST['submit'])) {
                    // Retrieve the form data
                    $username = $_POST['username'];
                    $password = $_POST['password'];
            
                    // Insert the user into the database
                    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
                    $result = mysqli_query($conn, $sql);
            
                    // Check for errors in the SQL query
                    if (!$result) {
                        die("Error: " . mysqli_error($conn));
                    }
            
                    // Redirect to the confirmation page
                    header("Location: confirmation.php");
                    exit;
                }
            
                // Select all users from the database
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
            
                // Check for errors in the SQL query
                if (!$result) {
                    die("Error: " . mysqli_error($conn));
                }
            
                // Close the database connection
                mysqli_close($conn);
            
				// Loop through the results and display them in a table
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["password"] . "</td>";
					echo "<td><a href='delete_user.php?id=" . $row["id"] . "'>Delete</a></td>";
					echo "</tr>";
				}
                // register php :

                if(isset($_POST['register'])) {
                    // sanitize user inputs
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                
                    // Connect to the database
                    $conn = mysqli_connect("localhost", "root", "", "test");
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                
                    // escape user inputs to prevent SQL injection
                    $username = mysqli_real_escape_string($conn, $username);
                    $password = mysqli_real_escape_string($conn, $password);

                
                    // check if the username already exists in the database
                    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
                    $result = mysqli_query($conn, $user_check_query);
                    $user = mysqli_fetch_assoc($result);
                
                    if ($user) { // if user exists
                        echo "Username already exists";
                    } else { // if user doesn't exist, insert the user's details into the database
                        $query = "INSERT INTO users (username, password) VALUES('$username', '$password')";
                        mysqli_query($conn, $query);
                        echo "User registered successfully";
                        // redirect the user to a confirmation page
                        header('location: confirmation.php');
                    }
                
                    // Close the database connection
                    mysqli_close($conn);
                }
                

			?>
            
		</tbody>
	</table>
    </div>

	<script>
		// Add event listeners to delete buttons
		var deleteButtons = document.querySelectorAll(".delete");
		for (var i = 0; i < deleteButtons.length; i++) {
			deleteButtons[i].addEventListener("click", function() {
				if (confirm("Are you sure you want to delete this user?")) {
					var id = this.getAttribute("data-id");
					window.location.href = "delete_user.php?id=" + id;
				}
			});
		}
	</script>
</body>
</html>
