<?php 
session_start();
if ( isset($_POST['Sub']) && isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['database']) && !empty($_POST['database']))
{
    $Nmbr = count($_SESSION['db']); 
    $_SESSION["rand"]  = rand(0,$Nmbr);
    $_SESSION['Majword']= strtoupper($_SESSION['db'][$_SESSION["rand"]]);
    $_SESSION['word']= trim( $_SESSION['Majword']);
    global $size_word;
    $size_word=strlen($_SESSION['word']);
}

/*$t=0;
$t= time()-$_SESSION['t'];
$_SESSION['f']=date( "H:i:s", $t );*/
$end_time = time();
        $total_time_seconds = $end_time - $_SESSION['t'];
        $total_time_hours = floor($total_time_seconds / 3600);
        $total_time_minutes = floor(($total_time_seconds % 3600) / 60);
        $total_time_seconds = $total_time_seconds % 60;
        $_SESSION['f'] = sprintf("%02d:%02d:%02d", $total_time_hours, $total_time_minutes, $total_time_seconds);
        
// echo $times;
if($_SESSION['ok']==1)
{
    $_SESSION['statut']='<p> Congratulation  (◕‿◕) <span>'.$_SESSION['f'].'</span></p>';
}
if ($_SESSION['Nok']==1)
{
    $_SESSION['statut']='<p> No tries left  (!!◕-◕) <span>'.$_SESSION['f'].'</span></p>';
}
function getpicture()
{
    return "Hangman-".$_SESSION['erreur']. ".png";
}
if(isset($_POST['Restart']))
{   
    unset($_SESSION['tentatives']);
    unset($_SESSION['len']);
    unset($_SESSION['lettresJouees']);
    unset($_SESSION['word']);
    unset($_SESSION['guess']);
    $_SESSION['erreur']=0;
    $_SESSION['guess']="";
    $_SESSION['tentatives']=6;
    $_SESSION['len']=0;
    $_SESSION['lettresJouees'] =array();
    $Nmbr = count($_SESSION['db']); 
    $_SESSION["rand"]  = rand(0,$Nmbr);
    $_SESSION['Majword']= strtoupper($_SESSION['db'][$_SESSION["rand"]]);
    $_SESSION['word']= trim( $_SESSION['Majword']);
    echo $_SESSION['word'];
    $_SESSION['t']=time();
    header('Location: hang.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HanGman</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3274/3274156.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="style.jeu.css" rel="stylesheet">
</head>
<body>
<div class="formulaire ">
<h1>Hangman</h1>
<div class="account-type">
    <p><i class="glyphicon glyphicon-user"></i> <span> <?php echo $_SESSION['name'] ;?></span></p> 
    <p> The Database      :<span> <?php echo $_SESSION['database']?></span></p>
    <p> You still have    :<span> <?php echo $_SESSION['tentatives']  ?></span> tries  <span>Max (<?php echo 6 ?>)</span></p> 
    <p> The word length   :<span> <?php echo strlen($_SESSION['word']) ?></span></p> 
    <p> Erreur            :<span> <?php echo $_SESSION['erreur'];?></span></p>
    <p >  <span><img  src="<?= getpicture() ?>"></span> </p>
</div>
    <hr>
    <hr> 
<div style=" text-align: center; margin-top:20px; padding:15px; background: #9de0bd; color: #fcf8e3">
    <p> The Word          :<span> <?php echo $_SESSION['word']?></span></p> 
</div>
<hr><hr>
<div>
    <form method="post" action ="">
        <?php   
            for ($i=1;$i<strlen($_SESSION["MAJ"]);$i++)
            {
                echo '<button type="submit" disabled  class="button-33"  name="guess" value="'.$_SESSION["MAJ"][$i].'">'.$_SESSION["MAJ"][$i].' </button>';
            }   
        ?>
        <div class="btn-block">
            <input type="Submit" value="Restart" name="Restart"/>
        </div>
    </form>
    </div>
    <hr><hr>
    <?php 
    echo $_SESSION['statut'];
    
    ?>
</div>
</body>
</html>