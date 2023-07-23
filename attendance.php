<?php
session_start();
//return to login if not logged in
if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	header('location:index.php');
}
include_once('User.php');

$user = new User();

//fetch user data
$sql = "SELECT * FROM users WHERE id = '".$_SESSION['user']."'";
$row = $user->details($sql);

?>
<html>
<title>Attendance</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<style>

  table {
    position: fixed;
    left: 54%;
    margin-top: 160px;    
    color: black; 
    grid-template-rows: 1.25rem 1fr;
    grid-template-columns: 1fr;
    height: 300px;
    display: block;
    overflow: auto;
    
  }
  #h22{
    position: fixed;
    left: 55%;
    font-weight: bold;
    margin-top: 87px;  
    
  }
  h1{
    position: fixed;
    font-weight: bold;
    margin-top: 60px; 
    font-size: 24px; 
  }
  a {
    color: #3f51b5;
    text-decoration: none;
  }
  
  a:hover {
    color: #555;
  }

  form {
    margin-top: 100px;
    padding: 20px;
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    width: 400px;
    margin-top:120px;
  }
  

  input[type=text], input[type=submit] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: 2px solid #3f51b5;
    border-radius: 4px;
  }
  
  input[type=radio] {
    margin: 8px;
    -ms-transform: scale(1.5); /* IE 9 */
    -webkit-transform: scale(1.5); /* Chrome, Safari, Opera */
    transform: scale(1.5);
    
  }
  
  input[type=submit] {
    background-color: #0c4da3;
    color: white;
    cursor: pointer;
  }
  
  input[type=submit]:hover {
    background-color: #555;
  }
  .containerr {

    align-items: center;
    position: fixed;
    min-height: 100vh;
    margin-top: 60px;
    margin-left: 40px;
}
</style>
<body> 
    
  <input type="checkbox" id="menu">
    <nav> <label></label>
        <ul>
            <li>
               <a href="logout.php" > <i  class="fa-solid fa-power-off"></i></a>
                <a href="logout.php"><span class=""></span> Log Out</a>
            </li>
        </ul> <label for="menu" class="menu-bar"> <i class="fa fa-bars"></i> </label>
    </nav>
    <div class="side-menu">
        <center><img src="./images/onda.png" alt="Logo"><br><br>

            <h2>Dakhla</h2>
        </center> <a href="dashboard.php"><i class="fa-solid fa-chart-line "
        ></i><span >Dashboard</span></a> 
        <a href="#" style="background-color: #fff"><i class="fa fa-clock-o" style="color: #015092"></i><span style="color: #015092" >Attendance</span></a>
        <a href="attendancerecord.php"><i class="fas fa-clipboard-list"></i><span >Attendance Record</span></a>
        
        <a href="manage.php"><i  class="fa-solid fa-user-gear"></i><span >Manage Bénéficiaire</span></a> 
        <a href="ajouter.php"><i class="fa-sharp fa-solid fa-user-plus"></i><span>Ajouter Bénéficiaire</span></a>
        <a href="logout.php" class="Logout"><span>Logout</span></a>
    </div>





    <div class="data"> 
        <div class="containerr"> 
         
        
        <?php
	// Connect to the database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "employeees";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Record entry or exit time
	if (isset($_POST['submit'])) {
		if (empty($_POST['BadgeID'])) {
			echo "<p style='color:red;'>Error: Badge ID is required</p>";
		} else {
			$BadgeID = $_POST['BadgeID'];
			$action = $_POST['action'];

			// Check if the BadgeID exists in the employees table
			$sql_check = "SELECT * FROM employeees WHERE BadgeID='$BadgeID'";
			$result_check = mysqli_query($conn, $sql_check);

			if (mysqli_num_rows($result_check) == 0) {
				echo "<p style='color:red;'>Error: Badge ID not found</p>";
			} else {
				if ($action == "entry") {
					$sql = "INSERT INTO entry_exit_record (BadgeID, entry_time) VALUES ('$BadgeID', NOW())";
				} else {
					$sql = "UPDATE entry_exit_record SET exit_time=NOW() WHERE BadgeID='$BadgeID' AND exit_time IS NULL";
				}

				if (mysqli_query($conn, $sql)) {
					echo "";
				} else {
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			}
		}
	}

	// Display current record
	$sql = "SELECT * FROM entry_exit_record,employeees WHERE entry_exit_record.BadgeID = employeees.BadgeID AND DATE(entry_time)=CURDATE() AND exit_time IS NULL";
	$result = mysqli_query($conn, $sql);

	if ($result->num_rows > 0) {
		echo "<h2 id='h22'>ENREGISTREMENT DES ENTRÉES/SORTIES ACTUELLES :</h2><br>";
		echo "<table>";
		echo "<tr><th>BadgeID</th><th>Entry Time</th><th>prenom</th><th>nom</th><th>CIN</th></tr>";

		while($row = mysqli_fetch_assoc($result)) {
			echo "<tr><td>".$row["BadgeID"]."</td><td>".$row["entry_time"]."</td><td>".$row["prenom"]."</td><td>".$row["nom"]."</td><td>".$row["CIN"]."</td></tr>";
		}

		echo "</table>";
	} else {
		echo "<h2 id='h22'>PERSONNE N'EST ACTUELLEMENT DANS Le batiment.</h2><br>";
	}

	mysqli_close($conn);
?>

<h1>Enregistrer l'heure entrée/de sortie</h1><br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	Badge ID: <input type="text" name="BadgeID"><br><br>
	Action: 
	<input type="radio" name="action" value="entry" checked> Entry
	<input type="radio" name="action" value="exit"> Exit<br><br>
	<input type="submit" name="submit" value="Submit">
</form>







    </div>


</body>
</html>