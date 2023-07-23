<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    
<div class="">
    <table class="">
        <thead>
        <tr>
        <th>Badge ID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Date Debut</th>
        <th>Date Fin</th>
        <th>Statut</th>
        <th>Modifier</th>
        <th>Supprimer</th>
        <th>Show</th>

        </tr>
        </thead>
       
        
<?php
//fetch.php
include "connexion.php";
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($con, $_POST["query"]);
 $query = "
  SELECT * FROM employeees 
  WHERE nom LIKE '%".$search."%'
  OR prenom LIKE '%".$search."%' 
  OR DateDb LIKE '%".$search."%'
  OR DateEx LIKE '%".$search."%'
  OR BadgeID LIKE '%".$search."%'



 
 ";
}
else
{
 $query = "
  SELECT * FROM employeees ORDER BY id 
 ";
}



$result = mysqli_query($con, $query);
if(mysqli_num_rows($result) > 0)
{

while($row=mysqli_fetch_assoc($result)){
    
?>
    <tbody>
    <tr>
        <td><?=$row['BadgeID']?></td>
        <td><?=$row['nom']?></td>
        <td><?=$row['prenom']?></td>
        <td><?php echo $date1 = $row['DateDb'];?></td>
         <td><?php echo $date2 = $row['DateEx'];?></td>
         <td ><?php if(strtotime("now") < strtotime($date2)) echo "<p class='p1' >Active</p>"; else { echo "<p class='p2' >expiré</p>";} ?></td>
        <!--Nous alons mettre l'id de chaque employé dans ce lien -->
        <td><a href="modifier.php?id=<?=$row['id']?>"><img src="images/pen.png"></a></td>
        <td><a href="supprimer.php?id=<?=$row['id']?>" ><img src="images/trash.png"></a></td>
        <td><a href="view.php?id=<?=$row['id']?>"><img src="images/view.png"></a></td>


    </tr>
    <?php
}
            

    
}else {
    echo "<br>Il n'y a pas encore d'employé ajouter !" ;


}



?>
      </tbody>
    
</body>

</html>
