<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    #err_msj{
        color: red;
        position: fixed;
        margin-top: 65px;
        margin-left: 400px;
        font-size: 15px;

    }
</style>
<body>
<?php

//vérifier que le bouton ajouter a bien été cliqué
if(isset($_POST['button'])){
    //extraction des informations envoyé dans des variables par la methode POST
    extract($_POST);
    
    //verifier que tous les champs ont été remplis
    if( isset($nom) && isset($prenom) && $DateDb && $DateEx && $BadgeID && $CIN && $objvisit && $organisme && $Annee &&  $nomA &&  $prenomA &&  $BadgeIDA&& $macaron && isset($portes) && isset($secteur) ) {

        //connexion à la base de donnée
        include_once "connexion.php";
        
        // Check if the BadgeID already exists in the database
        $result = mysqli_query($con, "SELECT * FROM employeees WHERE BadgeID = '$BadgeID'");
        if(mysqli_num_rows($result) > 0){
            // If the BadgeID already exists, do not insert into the database and display an error message
            $message = "<p style='color:red;'>Le Badge ID déjà existe dans la base de données.</p>";
        } else {
            // If the BadgeID does not exist, proceed with inserting into the database
            $secteur=implode(",", $_POST['secteur']);
            $portes=implode(",", $_POST['portes']);
            $objvisit=addslashes($_POST['objvisit']);
            $macaron=addslashes($_POST['macaron']);
            //requête d'ajout
            $req = mysqli_query($con, "INSERT INTO employeees VALUES(NULL, '$nom', '$prenom', '$DateDb', '$DateEx', '$BadgeID', '$CIN', '$objvisit', '$organisme', '$Annee', '$portes', '$secteur', '$nomA', '$prenomA', '$BadgeIDA', '$macaron')");

            if($req) {//si la requête a été effectuée avec succès, on fait une redirection
                header("location: manage.php");
            }else{
                echo "Error: " . mysqli_error($con);
            }
        }
    }
}


?>


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
        <a href="attendance.php"><i  class="fa fa-clock-o"></i><span >Attendance</span></a>
        <a href="attendancerecord.php"><i class="fas fa-clipboard-list"></i><span >Attendance Record</span></a>
        
        
        <a href="manage.php"><i  class="fa-solid fa-user-gear"></i><span >Manage Employees</span></a> <a href="#" style="background-color: white;"><i class="fa-sharp fa-solid fa-user-plus" style="color: #015092"></i><span style="color: #0c4da3;">Ajouter Bénéficiaire</span></a><a href="logout.php" class="Logout"><span>Logout</span></a>
    </div>
    <div class="data"> 

    <div class="form">
        <form action="" method="POST">
        <p class="erreur_message">
           <?php 
              if(isset($message)){
                  echo $message ;
              }
           ?>
        </p>

                <legend><h3>Person info</h3></legend>
                <label>Nom :</label>
                <input type="text" name="nom">
                <label>Prenom :</label>
                <input type="text" name="prenom" >
                <label>CIN :</label>
                <input type="text" name="CIN" >
                <label>Organisme :</label>
                <input type="text" name="organisme">
                <label>objet visite :</label>
                <input type="text" name="objvisit"  style=" width:300px">
                <label>macaron :</label>
                <input type="text" name="macaron" >



                <legend><h3>Badge info</h3></legend>
                <label>Badge ID :</label>
                <input type="text" name="BadgeID">
                <label>Année :</label>
                <input type="text" name="Annee"></br>
                <label>Date Debut :</label>
                <input type="date" name="DateDb" ></input>
                <label>Date Fin :</label>
                <input type="date" name="DateEx"></input><br>
                <label>Porte d'accès :</label>
                <p>
                I <input type="checkbox" name="portes[]" value="I"></input> II <input type="checkbox" name="portes[]" value="II"></input> III <input type="checkbox" name="portes[]" value="III"></input>  IV <input type="checkbox" name="portes[]" value="IV"></input> V <input type="checkbox" name="portes[]" value="V"> VI <input type="checkbox" name="portes[]" value="VI">  VII <input type="checkbox" name="portes[]" value="VII"></input></input></input></p>
                <label>Secteur de sûreté :</label>
                <p>
                A <input type="checkbox" name="secteur[]" value="A"></input>  P <input type="checkbox" name="secteur[]" value="P"></input>  B <input type="checkbox" name="secteur[]" value="B"></input>  F <input type="checkbox" name="secteur[]" value="F"></input></p>
                

                <legend><h3>Accompagnateur</h3></legend>
                <label>nom :</label>
                <input type="text" name="nomA" >
                <label>prenom :</label>
                <input type="text" name="prenomA" ><br>
                <label>Badge ID :</label>
                <input type="text" name="BadgeIDA"><br>
                
                <input type="submit" value="Ajouter" name="button" > 
        </form>

   
</div>
    </div>
</body>

</html>