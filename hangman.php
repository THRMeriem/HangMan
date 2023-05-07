<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangmane</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3274/3274156.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="style.jeu.css" rel="stylesheet">
</head>
<body>
<?php 
session_unset();
session_start();
unset($_SESSION['err']);
$_SESSION['erreur']=0;
$_SESSION['ta']=array();
$_SESSION['tentatives']=6;
$_SESSION['len']=0;
$_SESSION["MAJ"]="AZERTYUIOPQSDFGHJKLMWXCVBN";
$_SESSION['lettresJouees'] =array();
$_SESSION['Nok']=0;
$_SESSION['ok']=0;

?>
<div class="formulaire ">
<h1>Hangman</h1>
<form method="post" action ="hang.php">
    <div class="account-type">
        <input type="text" name="name" id="name" placeholder="User Name" value="<?php if(isset ($_SESSION['name'])){ echo $_SESSION['name'];} ?>"  required/>
        <hr>
        <input type="radio" value="country" id="country" name="database" checked/>
        <label for="country" class="radio">Country Database</label>
        <br> 
        <input type="radio" value="animal" id="animal" name="database" />
        <label for="animal" class="radio">Animal Database</label>
        <br>
        <input type="radio" value="sport" id="sport" name="database" />
        <label for="sport" class="radio">Sport Database</label>
        <br> 
        <hr><hr><hr>
    <div class="btn-block">
        <input type="Submit" value="Start !" name="Sub"/>
   </div>
    </div>
</form>

   
</div>
<div class="container">

    <table>
    <caption>List of scores</caption>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Database</th>
            <th>Times</th>
            <th>Number of Errors</th>
            <th>Word</th>
        </tr>
        <?php 
         $u = file("Users.txt");
         $D = file("Dbs.txt");
         $w = file("Word.txt");
         $t = file("Time.txt");
         $e = file("ERR.txt");
        
        for($i=0;$i<=count($u)-1;$i++)
        {
            echo '<tr>';
            echo '<td> '.$i.'</td>';
            echo '<td>'.$u[$i].'</td>';
            echo '<td>'.$D[$i].'</td>';
            echo '<td>'.$t[$i].'</td>';
            echo '<td>'.$e[$i].'</td>';
            echo '<td>'.$w[$i].'</td>';
            echo '</tr>';
        }
    

         
        ?>
    </table>

 </div>
 
</body>
</html>