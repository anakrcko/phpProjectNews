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
</ul>
<h1>Unos novinara</h1>
<form action="unesiNovinara.php" method="post">
    
    <table>
        
        <tr>
            <td>Ime:</td> <td><input name="ime" type="text" size="20"> </td>
        </tr>
        <tr>
            <td>Prezime:</td> <td> <input name="prezime" type="text" size="20"></td>
        </tr>    
        <tr>
            <td>Adresa</td> <td> <input name="adresa" type="text" size="20"> </td>
        </tr>
        <tr>
             <td><input type="submit" name="dodajNovinara" value='Dodaj' /> </td><td></td>
        </tr>
    </table>
    
</form>

    </body>
</html>

<?php
if(isset($_POST['dodajNovinara']))
    {
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $adresa = $_POST['adresa'];
        
        if(empty($ime) || empty($prezime) || empty($adresa))
        {
            echo "<b style='color:red'>Popunite formu!</b></style></br>";
        }
        else{
            if($baza->unesiNovinara($ime, $prezime, $adresa))
            {
                echo "Uspesno dodato!<br><a href='prikaz.php'>Idi na pocetnu.</a><br>";
            }
            else
            {
                echo "Dodavanje nije uspelo, pokusajte ponovo.";
            }
        }
    }
?>