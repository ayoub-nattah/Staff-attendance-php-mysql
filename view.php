<html>
<title>SideBar Menu</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

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
        <center><img src="./images/onda.png" alt="Logo" ><br><br>
            <h2>DAKHLA</h2>
        </center>  <a href="dashboard.php"><i class="fa-solid fa-chart-line "
        ></i><span >Dashboard</span></a> 

        <a href="attendance.php"><i  class="fa fa-clock-o"></i><span >Attendance</span></a>
        <a href="attendancerecord.php"><i class="fas fa-clipboard-list"></i><span >Attendance Record</span></a>
        
        <a href="manage.php"><i  class="fa-solid fa-user-gear"></i><span >Manage Bénéficiaire</span></a> <a href="ajouter.php"><i class="fa-sharp fa-solid fa-user-plus"></i><span>Ajouter Bénéficiaire</span></a><a href="logout.php" class="Logout"><span>Logout</span></a>
    </div>
    <div class="data">
    <?php

//connexion à la base de donnée
 include_once "connexion.php";
//on récupère le id dans le lien
 $id = $_GET['id'];
 //requête pour afficher les infos d'un employé
 $req = mysqli_query($con , "SELECT * FROM employeees WHERE id = $id");
 $row = mysqli_fetch_assoc($req);


?> 
         <div class="formview">
            <div class="table-responsive">
                <a href="index.php" class="back_btn"><img src="images/back.png"> Retour</a>
                <h2>Information de : <?=$row['nom']?>  <?=$row['prenom']?> </h2>
                <table class="table table bordered">
                <tr>


                <tr><td colspan="2" style=" background-color: #0c4da3; color:white;"><b>Bénéficiaire</b></td></tr>

                <tr> <th>nom </th>
                <td><?=$row['nom']?></td></tr>

                <tr><th>prenom </th>
                <td><?=$row['prenom']?></td></tr>

                <tr><th>CIN </th>
                <td><?=$row['CIN']?></td></tr>

                <th>Macaron </th>
                <td><?=$row['macaron']?></td></tr>

                <th>Badge ID </th>
                <td><?=$row['BadgeID']?></td></tr>

                <tr><th>Date Debut </th>
                <td><?php echo $date1 = $row['DateDb'];?></td></tr>

                <tr><th>Date Fin </th>
                <td><?php echo $date2 = $row['DateEx'];?></td></tr>

                <tr><th>Statut </th>
                <td ><?php if(strtotime("now") < strtotime($date2)) echo "<p class='p1' >Active</p>"; else { echo "<p class='p2' >Expired</p>";} ?></td></tr>

                <tr><th>Organisme </th>
                <td><?=$row['organisme']?></td></tr>

                <tr><th>Objet visite </th>
                <td><?=$row['objvisit']?></td></tr>

                <tr><th>Secteur </th>
                <td><?=$row['secteur']?></td></tr>

                <tr><th>Portes </th>
                <td><?=$row['portes']?></td></tr>

                <tr><th>Année </th>
                <td><?=$row['Annee']?></td></tr>
                
                <tr><td colspan="2" style=" background-color: #0c4da3; color:white;"><b>Accompagnateur</b></td></tr>
                <th>nom </th>
                <td><?=$row['nomA']?></td></tr>

                <th>prenom</th>
                <td><?=$row['prenomA']?></td></tr>

                <th>Badge ID</th>
                <td><?=$row['BadgeIDA']?></td></tr>


                    
            </div>

        </div>     
        

</div>
</body>

</html>