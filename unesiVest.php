<?php

require_once 'baza.php';
$baza = new bazaDB();
?>
<html>
    <head>
        <link rel="stylesheet" href="stil.css">
    </head>
    <body>

<ul class='kategorije'>
    <li class='kategorijeLista'><a href='prikaz.php'>Pocetna</a></li>
    <li class='kategorijeLista''><a href='unesiNovinara.php'>Unesi novinara</a></li>
    <li class='kategorijeLista'><a href='unesiKategoriju.php'>Unesi kategoriju vesti</a></li>
</ul>
        
        <h1>Unos vesti</h1>
        <div class="centar">
<form action="unesiVest.php" method="post">
    <table>
        <tr>
            <td>Novinar:</td>
            <td>
                <select name="novinar">
                    <?php
                        $baza->vratiSveNovinare();
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kategorija vesti:</td>
            <td>
    <select name="kategorija">
        <?php
           $baza->vratiSvekategorije();
        ?>
    </select></td></tr>
        <tr>
            <td>Naslov vesti:</td>
            <td>    <textarea  type="textarea" name="vestNaslov" placeholder="Naslov vesti"></textarea></td>
        </tr> 
        <tr>
            <td>Godina vesti:</td>
            <td>   <input type="text" name="vestGodina" placeholder="Godina vesti"/></td>
        </tr>
        <tr>
            <td>Opis vesti:</td>
            <td>   <textarea  type="textarea" name="vestOpis" placeholder="Opis vesti"></textarea></td>
        </tr>
    
        <tr>
            <td>
                <input type="submit" name="dodaj" value="Dodaj"/>
            </td>
            <td></td>
        </tr>
    </table>
    
</form>
            </div>
    </body>
</html>

<?php

if(isset($_POST['dodaj']))
    {
        $ime = $_POST['novinar'];
        
        $kategorija = $_POST['kategorija'];
        
        $naslov= $_POST['vestNaslov'];
        $godina = $_POST['vestGodina'];
        $opis = $_POST['vestOpis'];
        if(empty($ime) || empty($kategorija) || empty($naslov) || empty($godina) || empty($opis))
        {
            echo "<b style='color:red'>Popunite formu!</b></style></br>";
        }
        else{
            if($baza->dodajVest($naslov, $opis, $godina, $kategorija, $ime))
            {
                echo "Uspesno dodato!<br><a href='prikaz.php'>Idi na pocetnu.</a><br>";
            }
            else
            {
                echo "Dodavanje nije uspelo, pokusajte ponovo.";
            }
        }
    }
