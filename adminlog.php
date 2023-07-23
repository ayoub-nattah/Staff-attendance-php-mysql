<?php
// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'test');

// check if the form has been submitted
if (isset($_POST['login'])) {
  // sanitize and validate the user input
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // check if the username exists in the database
  $user_check_query = "SELECT * FROM admin_user WHERE username='$username'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    // verify the password using password_verify() function
    if (password_verify($password, $user['password'])) {
      echo "Login successful";
      // redirect the user to the register.php page
      header('location: register.php');
      exit();
    } else {
      $error_message = "Invalid password";
    }
  } else { // if user doesn't exist
    $error_message = "Invalid username";
  }
}
?>

<style>
  form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: auto;
    width: 50%;
    max-width: 500px;
  }

  label {
    font-size: 1.2em;
  }

  input[type="text"],
  input[type="password"] {
    font-size: 1.2em;
    padding: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  button[name="login"] {
    font-size: 1.2em;
    padding: 5px 15px;
    border: none;
    border-radius: 4px;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
  }

  .error {
    color: red;
    margin-bottom: 10px;
  }
</style>
<form action="adminlogin.php" method="post">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username">

  <label for="password">Password:</label>
  <input type="password" id="password" name="password">

  <?php if (isset($error_message)) { ?>
    <p class="error"><?php echo $error_message; ?></p>
  <?php } ?>

  <button name="login" type="submit">Login</button>
</form>
