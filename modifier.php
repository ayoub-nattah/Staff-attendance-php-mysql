

<html>
<title>SideBar Menu</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<?php

//connexion à la base de donnée
include_once "connexion.php";
//on récupère le id dans le lien
$id = $_GET['id'];
//requête pour afficher les infos d'un employé
$req = mysqli_query($con , "SELECT * FROM employeees WHERE id = $id");
$row = mysqli_fetch_assoc($req);
$portes = $row['portes'];
$portes1 = explode(",",$portes);
$secteur = $row['secteur'];
$secteur1 = explode(",",$secteur);

//vérifier que le bouton ajouter a bien été cliqué
if(isset($_POST['button'])){
    //extraction des informations envoyé dans des variables par la methode POST
    extract($_POST);
    //vérifier que tous les champs ont été remplis
    if(isset($nom) && isset($prenom) && $DateDb && $DateEx && $BadgeID && $CIN && $objvisit && $organisme && $Annee  && $nomA && $prenomA && $BadgeIDA && $portes && $secteur = implode(",",$_POST['secteur'])){

       
            //le BadgeID n'existe pas encore dans la base de données, on peut insérer la nouvelle entrée
            $portes = implode(",",$_POST['portes']);
            $objvisit = addslashes($_POST['objvisit']);

            //requête de modification
            $req = mysqli_query($con, "UPDATE employeees SET nom = '$nom' , prenom = '$prenom' ,  CIN = '$CIN' ,  organisme = '$organisme' , objvisit = '$objvisit' , BadgeID = '$BadgeID' ,  Annee = '$Annee' ,  DateDb = '$DateDb' ,  DateEx = '$DateEx', portes='$portes' , secteur='$secteur' , nomA = '$nomA', prenomA='$prenomA' , BadgeIDA='$BadgeIDA' , macaron='$macaron'   WHERE id = $id");
            if($req){
                //si la requête a été effectuée avec succès, on fait une redirection
                header("location: manage.php");
            }else{
                //si non
                $message = "Error" ;
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
        <center><img src="./images/onda.png" alt="Logo" ><br><br>
            <h2>DAKHLA</h2>
        </center> <br> <a href="dashboard.php"><i class="fa-solid fa-chart-line "
        ></i><span >Dashboard</span></a> 
        <a href="attendance.php"><i  class="fa fa-clock-o"></i><span >Attendance</span></a>
        <a href="attendancerecord.php"><i class="fas fa-clipboard-list"></i><span >Attendance Record</span></a>
        
        <a href="manage.php"><i  class="fa-solid fa-user-gear"></i><span >Manage Employees</span></a> <a href="ajouter.php"><i class="fa-sharp fa-solid fa-user-plus"></i><span>Ajouter Bénéficiaire</span></a><a href="logout.php" class="Logout"><span>Logout</span></a>
    </div>
    <div class="data">
    <div class="form">
       <br> <h2 style="color:#0c4da3;">Modifier le bénéficiaire : <?=$row['nom']?></h2>
        <p class="erreur_message">
           <?php 
              if(isset($message)){
                  echo $message ;
              }
           ?>
        </p>
                    <form action="" method="POST">
            <legend><h3>Person info</h3></legend>
            <label>Nom</label>
            <input type="text" name="nom" value="<?=$row['nom']?>">
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?=$row['prenom']?>">
            <label>CIN :</label>
            <input type="text" name="CIN" value="<?=$row['CIN']?>">
            <label>Organisme :</label>
            <input type="text" name="organisme" value="<?=$row['organisme']?>">
            <label>objet visite :</label>
            <input type="text" style=" width:300px" name="objvisit" value="<?=$row['objvisit']?>">
            <label>macaron :</label>
            <input type="text" name="macaron" value="<?=$row['macaron']?>">




            <legend><h3>Badge info</h3></legend>
            <label>Badge ID :</label>
            <input type="text" name="BadgeID" value="<?=$row['BadgeID']?>">
            <label>Année :</label>
            <input type="text" name="Annee" value="<?=$row['Annee']?>"></br>
            <label>Date Debut :</label>
            <input type="date" name="DateDb" value="<?=$row['DateDb']?>"></input>
            <label>Date Fin :</label>
            <input type="date" name="DateEx" value="<?=$row['DateEx']?>"></input><br>
            <label>Porte d'accès :</label>
            <p>
                I <input type="checkbox" name="portes[]" value="I"
                 <?php if (in_array('I',$portes1)) {
                    echo "checked";
                 } 
                ?>
                >
                II <input type="checkbox" name="portes[]" value="II" 
                <?php if (in_array('II',$portes1)) {
                    echo "checked";
                 } 
                ?>>
                III <input type="checkbox" name="portes[]" value="III"
                <?php if (in_array('III',$portes1)) {
                    echo "checked";
                 } 
                ?>>
                IV <input type="checkbox" name="portes[]" value="IV"
                <?php if (in_array('IV',$portes1)) {
                    echo "checked";
                 } 
                ?>>
                V <input type="checkbox" name="portes[]" value="V"
                <?php if (in_array('V',$portes1)) {
                    echo "checked";
                 } 
                ?>>
                VI <input type="checkbox" name="portes[]" value="VI"
                <?php if (in_array('VI',$portes1)) {
                    echo "checked";
                 } 
                ?>>
                VII <input type="checkbox" name="portes[]" value="VII"
                <?php if (in_array('VII',$portes1)) {
                    echo "checked";
                 } 
                ?>>
            </p>

                <label>Secteur de sûreté :</label>
                <p>
                    A <input type="checkbox" name="secteur[]" value="A"
                    <?php if (in_array('A',$secteur1)) {
                    echo "checked";
                 } 
                ?>>
                    P <input type="checkbox" name="secteur[]" value="P"
                    <?php if (in_array('P',$secteur1)) {
                    echo "checked";
                 } 
                ?>>
                    B <input type="checkbox" name="secteur[]" value="B" 
                    <?php if (in_array('B',$secteur1)) {
                    echo "checked";
                 } 
                ?>>
                    F <input type="checkbox" name="secteur[]" value="F"
                    <?php if (in_array('F',$secteur1)) {
                    echo "checked";
                 } 
                ?>>
            
                </p>

                <legend><h3>Accompagnateur</h3></legend>
                <label>nom :</label>
                <input type="text" name="nomA" value="<?=$row['nomA']?>">
                <label>prenom :</label>
                <input type="text" name="prenomA" value="<?=$row['prenomA']?>"></br>
                <label>Badge ID :</label>
                <input type="text" name="BadgeIDA" value="<?=$row['BadgeIDA']?>"></br>

            


            <input type="submit" value="Modifier" name="button">
            </form>
    </div>
 </div>

    
</body>

</html>