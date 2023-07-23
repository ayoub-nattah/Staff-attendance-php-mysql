<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Gestion Employés</title>

   
    <link rel="stylesheet" href="style.css">

</head>
<body>   
        <input type="checkbox" id="menu">
            <nav> 
               
                
                <ul>
                    <li>
                    <a href="logout.php" > <i  class="fa-solid fa-power-off"></i></a>
                        <a href="logout.php"><span class=""></span> Log Out</a>
                    </li>
                </ul> <label for="menu" class="menu-bar"> <i class="fa fa-bars"></i> </label>
            </nav>
            <div class="side-menu">
                <center><img src="./images/onda.png" alt="Logo" ><br><br>
                    <h2>Dakhla</h2>
                </center> <a href="dashboard.php"><i class="fa-solid fa-chart-line "
        ></i><span >Dashboard</span></a> 
        <a href="attendance.php"><i  class="fa fa-clock-o"></i><span >Attendance</span></a>
        <a href="attendancerecord.php"><i class="fas fa-clipboard-list"></i><span >Attendance Record</span></a>
        
        <a style="background-color: white;" href="#">
                <i  class="fa-solid fa-user-gear"  style="color: #015092 ;">
            </i  ><span style="color: #015092;">Manage Bénéficiaire</span></a>
            
            <a href="ajouter.php"><i class="fa-sharp fa-solid fa-user-plus">

            </i><span>Ajouter Bénéficiaire</span></a><a href="logout.php" class="Logout"><span>Logout</span></a>
            </div>
            <div class="data"> 
            <div class="container">
      
        
      
          <div >
          <div >
            <h2>MANAGER LES BENEFICIAIRE</h2>
          <span >Search</span>
          <input type="text" name="search_text" id="search_text" placeholder="Search by visitors Details"  />
          </div>
          <div id="result"></div>
      </div>



      
 
 
      
 
  </div>
            </div>

</body>
</html>
<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});
</script>





