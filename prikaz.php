<?php
    require_once 'baza.php';
    $baza = new bazaDB();
?>

<html>
    <head>
        <link rel="stylesheet" href="stil.css">
    </head>
    <body>
        <?php
            if(isset($_COOKIE['user']) )
            {
        ?>
                <ul class='kategorije'>
                    <li class='kategorijeLista'><a href='prikaz.php'>SVE</a></li>     
            <?php
                $baza->dajkategorije();
                
                echo "<li class='kategorijeLista' style='float:right'><a href='odjava.php'>Odjavi se</a></li>";
                if(isset($_COOKIE['rola']) && $_COOKIE['rola'] == 'admin')
                {
                    echo "<li class='kategorijeLista' style='float:right'><a href='unesiVest.php'>Unesi vest</a></li>";
                }
            ?>
                </ul>
        
                <div class="row">
            
            <?php
                //ako nista nije setovano prikazujemo sve vesti sa oznakom kategorije
                if (isset($_GET['idKategorije']) == null && isset($_GET['idNovinara']) == null)
                {
                    $baza->dajSveNovinare();
                    $baza->dajSveVesti();
                }
                //ako kliknemo na kategoriju treba nam spisak novinara
                if (isset($_GET['idKategorije']))
                {
                    $idKategorije = $_GET['idKategorije'];
                    $baza->dajNovinareKat($idKategorije);
                }
                //ako smo kliknuli i na novinara onda nam treba samo njegovo
                if(isset($_GET['idKategorije']) && isset($_GET['idNovinara']))
                {
                    $idKategorije = $_GET['idKategorije'];
                    $idNovinara = $_GET['idNovinara'];

                    $baza->dajVestiNovinaraKategorija($idKategorije, $idNovinara);
                }
                else if (isset($_GET['idKategorije']))  //inace sve vesti za tu kategoriju 
                {
                    //prikaz svih vesti za tu kategoriju + ime novinara koji je objavio
                    $idKategorije = $_GET['idKategorije'];
                    $baza->dajSveVestiPoKategoriji($idKategorije);
                }
                else if(isset($_GET['idNovinara'])) //inace sve vesti za tog novinara
                {
                    $baza->dajSveNovinare();
                    $idNovinara = $_GET['idNovinara'];
                    $baza->dajVestiNovinara($idNovinara);
                }
            }
            else if(!isset($_GET['usernameId']))
            {
               echo "<b style='color:red'>Greska: neautorizovan pristup!</b></br></br>";
               echo "<a href='login.php'>Prijavite se!</a>";
            }
        ?>
                </div>
    </body>
</html>