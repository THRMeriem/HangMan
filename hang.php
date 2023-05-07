<?php 

session_start();
if ( isset($_POST['Sub']) && isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['database']) && !empty($_POST['database']))
{
    if(!isset($_SESSION["guess"]) )
    {
        unset($_SESSION["guess"]);
    }
    $_SESSION['name']=$_POST['name'];
    $_SESSION['database']=$_POST['database'];
    if ($_SESSION['database']== "country")
    {
        $_SESSION['db'] = file("country.txt");
    }
    elseif($_SESSION['database']== "animal")
    {
        $_SESSION['db'] = file("animal.txt");
    }
    elseif ($_SESSION['database']== "sport")
    {
        $_SESSION['db'] = file("sport.txt");
    }
    $Nmbr = count($_SESSION['db']); 
    $_SESSION["rand"]  = rand(0,$Nmbr);
    $_SESSION['Majword']= strtoupper($_SESSION['db'][$_SESSION["rand"]]);
    $_SESSION['word']= trim( $_SESSION['Majword']);
    $_SESSION['distinctword']=array_unique(str_split( $_SESSION['word']));
    global $size_word;
    $_SESSION['t']=time();
    $size_word=strlen($_SESSION['word']);
     
    
}
if (!isset($_SESSION['name']) && !isset($_SESSION['database']))
{
    header('Location: hangman.php');
    exit();
}
function getpicture()
{
    return "Hangman-".$_SESSION['erreur']. ".png";
}


?>
<?php 
                
                $let="";
                if(isset($_POST['guess']))               
                {
                    $_SESSION['guess']=$_POST['guess'];
                    $let=$_SESSION['guess'];  
                    $_SESSION['lettresJouees'][]=$let ;
                    if ( in_array($_SESSION['guess'],str_split($_SESSION['word'])) || in_array(" ",str_split($_SESSION['word'])))
                    {
                        $_SESSION['len']++;   
                    }
                    else
                    {
                        $_SESSION['tentatives']--;
                        $_SESSION['erreur']=$_SESSION['erreur']+1;
                    } 
                }
                if(isset($_POST['guess']))               
                {
                    
                    
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
    
    <p> You still have    :<span> <?php echo $_SESSION['tentatives'] ?></span> tries  <span>Max (<?php echo 6 ?>)</span></p> 
    <p> The word length   :<span> <?php echo strlen($_SESSION['word'])?></span></p> 
    <p> The guess    :<span> <?php  if(isset($_POST['guess'])){echo $_POST['guess']; } ?></span></p> 
    <p> <?php if($_SESSION['erreur']!=0){ echo "Erreur";}?><span> 
        <?php if($_SESSION['erreur']!=0)
        { echo $_SESSION['erreur'];}?></span></p>
    <p >  <span><img  src="<?= getpicture() ?>"></span> </p>
</div>
<hr>
    <hr> 
    <div style=" text-align: center; margin-top:20px; padding:15px; background: #9de0bd; color: #fcf8e3">
                <!-- Display the current guesses -->
                <?php 
                 $guess=array();
                if(isset($_POST['guess']))
                {   
                    $_SESSION['lettresJouees'][]= $_POST['guess'];
                    $_SESSION['guess']=$_POST['guess'];
                }
                if ($_SESSION['erreur']>=0 && $_SESSION['erreur'] <6 )
                {
                    $_SESSION['distinctword']= str_split($_SESSION['word']);
                    $max=count(array_unique($_SESSION['distinctword'] ));
                    if($_SESSION['len']< $max  )
                    {
                         for($j=0; $j<=strlen($_SESSION['word'])-1; $j++)
                        {
                            $mot= str_split($_SESSION['word']);
                            
                            if (in_array($mot[$j],$_SESSION['lettresJouees']))
                            {
                                $guess[$j]=$mot[$j];
                            }
                            elseif (in_array(" ",$mot))
                            {
                                $guess[$j]=" ";
                            }
                            else 
                            {
                                $guess[$j]=" _ ";
                            }
                        }
                    }
                    else 
                    {
                        $_SESSION['ok']=1;
                        file_put_contents('Time.txt', "\n".$_SESSION['f'], FILE_APPEND);
                        file_put_contents('ERR.txt', "\n".$_SESSION['erreur'], FILE_APPEND);
                        file_put_contents('Users.txt', "\n".$_SESSION['name'], FILE_APPEND);
                        file_put_contents('DBs.txt', "\n".$_SESSION['database'], FILE_APPEND);
                        file_put_contents('Word.txt', "\n".$_SESSION['word'], FILE_APPEND);
                        $_SESSION['statut']='<p> Congratulation  (◕‿◕) </p>  Time :';
                        header('Location: fin_jeu.php');
                        exit();
                    }
                }
                else
                {
                    $_SESSION['Nok']=1;
                    file_put_contents('Time.txt', "\n".$_SESSION['f'], FILE_APPEND);
                    file_put_contents('ERR.txt', "\n".$_SESSION['erreur'], FILE_APPEND);
                    file_put_contents('Users.txt', "\n".$_SESSION['name'], FILE_APPEND);
                    file_put_contents('DBs.txt', "\n".$_SESSION['database'], FILE_APPEND);
                    file_put_contents('Word.txt', "\n".$_SESSION['word'], FILE_APPEND);
                    $_SESSION['statut']=' <p> No tries left  (!◕-◕) </p> Time :';
                    header('Location: fin_jeu.php');
                    exit();
                }
                ?>
                <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;"><?php foreach($guess as $val){echo $val;}?></span>
                


    </div>
<div>
    <hr><hr>
    <form method="post" action ="">
        <?php
            for ($i=0;$i<strlen($_SESSION["MAJ"]);$i++)
            {
                $alpha=$_SESSION["MAJ"][$i] ;
               
                    if (in_array($alpha,$_SESSION['lettresJouees']))
                    {
                        echo '<button type="submit"  disabled  style=" color: rgb(36, 87, 169); " class="button-33" name="guess" value="'.$_SESSION["MAJ"][$i].'">'.$_SESSION["MAJ"][$i].' </button>';
                    }
                    else 
                    {
                        echo '<button type="submit" enabled   class="button-33"  style=" color: color: rgb(25, 105, 112);" name="guess" value="'.$_SESSION["MAJ"][$i].'">'.$_SESSION["MAJ"][$i].' </button>';
                    }
                }
                
        ?>
    </form>
    </div>
    <hr><hr>
</div>
</body>
</html>