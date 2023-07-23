
<html>
<title>Attendance record</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>

  button[type='submit'] {
   display: inline-block;
  padding: 6px 12px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  background-color: #237cf1;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 5px;
    
  }

  button[type='submit']:hover {
    background-color: #45a049;
  }
  .print-button:hover {
    background-color:  #237cf1;
  }
.print-button {
  display: inline-block;
  padding: 6px 12px;
  font-size: 16px;
  font-weight: bold;
  color: #fff;
  background-color: #0c4da3;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  position: relative;
  left: 530px;
}
.print-button i {
  padding-right: 5px;
}




</style>
<body> <input type="checkbox" id="menu">
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
        <a href="attendance.php"><i  class="fa fa-clock-o"></i><span >Attendance</span></a>
        <a href="#" style="background-color: white"><i class="fas fa-clipboard-list" style="color: #015092"></i><span style="color: #015092" >Attendance Record</span></a>
        
        <a href="manage.php"><i  class="fa-solid fa-user-gear"></i><span >Manage Bénéficiaire</span></a> 
        <a href="ajouter.php"><i class="fa-sharp fa-solid fa-user-plus"></i><span>Ajouter Bénéficiaire</span></a>
        <a href="logout.php" class="Logout"><span>Logout</span></a>
    </div>



    <div class="data"> 
        <div class="container">
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

// Handle filter search
$filter_date = '';
if (isset($_GET['filter_date'])) {
    $filter_date = mysqli_real_escape_string($conn, $_GET['filter_date']);
    $sql_filter_date = "AND DATE(entry_time) = '$filter_date'";
} else{
    $sql_filter_date = "AND DATE(entry_time) = CURDATE()";
}

// Check if there are any records for the filtered date
$sql_check_records = "SELECT * FROM entry_exit_record WHERE DATE(entry_time) = '$filter_date' OR DATE(entry_time) = CURDATE()";
$result_check_records = mysqli_query($conn, $sql_check_records);
$num_rows_check_records = mysqli_num_rows($result_check_records);

if ($num_rows_check_records > 0) {
    // Display current record
    $sql = "SELECT * FROM entry_exit_record,employeees WHERE 1 $sql_filter_date and entry_exit_record.BadgeID = employeees.BadgeID";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<form action='' method='get'>";
        echo "<table id='attendance-table'>";
        echo "<div>";
        echo "<h2>Attendance record :</h2>";
        echo "<input type='date' id='filter_date' name='filter_date' value='" . htmlspecialchars($filter_date) . "'>";
        echo "<button type='submit'>Filter</button>";
        echo "<button class='print-button' onclick='printTable()'><i class='fa fa-print'></i>Print</button>";
        echo "</div>";
        echo "<tr><th>Badge ID</th><th>prenom</th><th>nom</th><th>CIN</th><th>Entry Time</th><th>Exit Time</th></tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$row["BadgeID"]."</td><td>".$row["prenom"]."</td><td>".$row["nom"]."</td><td>".$row["CIN"]."</td><td>".$row["entry_time"]."</td><td>".$row["exit_time"]."</td></tr>";
        }

        echo "</table>";
        echo "</form>";
    } else {
        echo "<form action='' method='get'>";
        echo "<div>";
        echo "<h2>Attendance record :</h2>";
        echo "<input type='date' id='filter_date' name='filter_date' value='" . htmlspecialchars($filter_date) . "'>";
        echo "<button type='submit'>Filter</button>";
        echo "</div>";
        echo "<br>Aucun enregistrement trouvé pour la date sélectionnée.";
        echo "</form>";
        }
} else {
    echo "<form action='' method='get'>";
        echo "<div>";
        echo "<h2>Attendance record :</h2>";
        echo "<input type='date' id='filter_date' name='filter_date' value='" . htmlspecialchars($filter_date) . "'>";
        echo "<button type='submit'>Filter</button>";
        echo "</div>";
        echo "<br>Aucun enregistrement trouvé pour la date sélectionnée.";
        echo "</form>";
    // nothing
 
}
   
    $conn->close();
?>
        </div>       
    </div>
</body>

</html>
<script>

function printTable() {
    var table = document.getElementById("attendance-table");
    var logoSrc = "./images/onda.png"; 
    var printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>Attendance Record</title>');
    printWindow.document.write('<style>body{font-family: Arial, sans-serif;}.header{display: flex; justify-content: center; align-items: center; margin-bottom: 20px;}.header img{width: 100px; height: auto; margin-right: 20px;}.title{text-align: center; font-size: 24px; font-weight: bold; color: #0c4da3; margin-bottom: 20px;}.table-container{border: 1px solid #ccc;}.table-container table{width: 100%; border-collapse: collapse;}.table-container th, .table-container td{border: 1px solid #ccc; padding: 8px; text-align: center;}.table-container th{background-color: #0c4da3;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="header"><img src="'+logoSrc+'" alt="Logo"><div class="title">Attendance Record</div></div>');
    printWindow.document.write('<div class="table-container">'+table.outerHTML+'</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

</script>




