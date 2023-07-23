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
<title>SideBar Menu</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="icon.png" type="image/x-icon">
</head>
<style>

    .container {
      display: flex;
      flex-wrap: wrap;
      margin-top: 20px;
        margin-left: 40px;
        
    }

    .card {
      background-color: #eaeaea ;
      box-shadow: 0px 2px 8px silver;
      border-radius: 7px;
      padding: 17px;
      text-align: center;
      flex: 1 1 300px;
      max-width: 300px;
      margin: 10px;
      
      
    }

    .card h2 {
      font-size: 20px;
      font-weight: 600;

      
    }

    .card p {
      font-size: 26px;
      font-weight: 100;
      color:  #0c4da3;
      margin: 0;
      font-weight: bold;
    }
    .chart-container {
      text-align: center;
    }

    #current-month {
      font-weight: bold;
    }


    .chart-container {
      width: 650px;
      align-items: center;
      margin-top: -60px;
        margin-left: 120px;
        
    }

    #myChart {
      width: 100%;
    }

    /* customize chart colors */
    :root {
      --color-primary: #0077c2;
      --color-secondary: #f48024;
      --color-tertiary: #65b045;
    }

    /* customize chart legends */
    .chart-legend {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      justify-content: center;
    }

    .chart-legend__item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .chart-legend__color {
      width: 1rem;
      height: 1rem;
      border-radius: 50%;
    }

    /* customize chart tooltips */
    .chart-tooltip {
      background-color: rgba(0, 0, 0, 0.8);
      color: #fff;
      padding: 0.5rem;
      border-radius: 0.5rem;
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

            <h2>Dakhla </h2>
        </center><a href="#" style="background-color: white;"><i class="fa-solid fa-chart-line "
        style="color: #015092"></i><span style="color: #015092" >Dashboard</span></a> 
        <a href="attendance.php"><i  class="fa fa-clock-o"></i><span >Attendance</span></a>
        <a href="attendancerecord.php"><i class="fas fa-clipboard-list"></i><span >Attendance Record</span></a>
        
        <a href="manage.php"><i  class="fa-solid fa-user-gear"></i><span >Manage Bénéficiaire</span></a> 
        <a href="ajouter.php"><i class="fa-sharp fa-solid fa-user-plus"></i><span>Ajouter Bénéficiaire</span></a>
        <a href="logout.php" class="Logout"><span>Logout</span></a>
    </div>
    <div class="data"> 
    <?php

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employeees";

$conn = new mysqli($servername, $username, $password, $dbname);
// Function to get the number of employees present today
function get_num_employees_today($mysqli) {
    $date = date("Y-m-d");
    $query = "SELECT COUNT(*) as total FROM entry_exit_record WHERE DATE(entry_time) = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        // there was an error with the query
        echo "Error: " . mysqli_error($mysqli);
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
    return $total;
}

function get_num_employees_this_month($conn) {
  $year = date('Y');
  $month = date('m');
  $sql = "SELECT COUNT(*) as num FROM (SELECT DISTINCT BadgeID, DATE(entry_time) as entry_date FROM entry_exit_record WHERE YEAR(entry_time)=$year AND MONTH(entry_time)=$month) as entries";
  $result = mysqli_query($conn, $sql);

  if (!$result) {
      // there was an error with the query
      echo "Error: " . mysqli_error($conn);
      return false;
  }

  $row = mysqli_fetch_assoc($result);
  return $row['num'];
}

// Function to get the total number of employees who have attended the building
function get_num_employees_all_time($conn) {
    $sql = "SELECT COUNT(DISTINCT BadgeID) as num FROM employeees";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // there was an error with the query
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    return $row['num'];
}



// Get the numbers
$num_employees_today = get_num_employees_today($conn);
$num_employees_this_month = get_num_employees_this_month($conn);
$num_employees_all_time = get_num_employees_all_time($conn);



// Function to get the number of employees present on a specific date
function get_num_employees_on_date($mysqli, $date) {
    $query = "SELECT COUNT(*) as total FROM entry_exit_record WHERE DATE(entry_time) = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        // there was an error with the query
        echo "Error: " . mysqli_error($mysqli);
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    $total = $row['total'];
    return $total;
}

// Get the current year and month
$current_year = date('Y');
$current_month = date('m');

// Get the number of days in the current month
$num_days = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

// Initialize an array to store the data
$data = array();

// Loop through each day of the current month
for ($day = 1; $day <= $num_days; $day++) {
    // Build the date string in the format "YYYY-MM-DD"
    $date_str = sprintf("%04d-%02d-%02d", $current_year, $current_month, $day);

    // Get the number of employees for this day
    $num_employees = get_num_employees_on_date($conn, $date_str);

    // Add the data for this day to the array
    $data[] = $num_employees;
}

// Set the chart data
$chartData = array(
    'labels' => range(1, $num_days),
    'datasets' => array(
        array(
            'label' => 'Nombre de Bénéficiaires ',
            'data' => $data,
            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
            'borderWidth' => 1,
        ),
    ),
);


mysqli_close($conn);

?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<div class="container">
		<div class="card">
        
			<h2>Nombre des Bénéficiaires aujourd'hui</h2>
			<p><?php echo $num_employees_today; ?></p>
		</div>
		<div class="card">
			<h2>Nombre de Bénéficiaires qui sont entrèrent ce mois-ci</h2>
			<p><?php echo $num_employees_this_month; ?></p>
		</div>
		<div class="card">
			<h2>Nombre total des Bénéficiaires</h2>
			<p><?php echo $num_employees_all_time; ?></p>
		</div>

        <div class="chart-container">
        <div>
           <p>Le mois en cours est : <span id="current-month"></span></p>
            <canvas id="myChart"></canvas>
        </div>
	</div>
	</div>

    


	

    <!-- ////// -->
    

    
    <script>
// Get the data from PHP
const chartData = <?php echo json_encode($chartData); ?>;

// Create a new chart object
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
  type: 'bar',
  data: chartData,
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
      }
    }
  }
});

// Update the chart data every minute
setInterval(function() {
  // Send an AJAX request to the server to get the updated data
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // Parse the response data as JSON
      const newData = JSON.parse(this.responseText);

      // Update the chart data
      myChart.data.datasets[0].data = newData.datasets[0].data;

      // Update the chart title with the new total number of employees
      const totalEmployees = newData.totalEmployees;
      myChart.options.plugins.title.text = `Total Employees: ${totalEmployees}`;

      // Redraw the chart
      myChart.update();
    }
  };
  xhttp.open("GET", "updateChartData.php", true);
  xhttp.send();
}, 60000);

// Get current month
const months = [
    "Janvier",
    "Février",
    "Mars",
    "Avril",
    "Mai",
    "Juin",
    "Juillet",
    "Août",
    "Septembre",
    "Octobre",
    "Novembre",
    "Décembre"
      ];
      const currentDate = new Date();
      const currentMonth = months[currentDate.getMonth()];

      // Set current month in the HTML
      document.getElementById("current-month").textContent = currentMonth;




</script>



    
</div>

</body>

</html>