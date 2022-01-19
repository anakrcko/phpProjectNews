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
<h1>Unos kategorije vesti</h1>
<form action="unesiKategoriju.php" method="post">
    
    <table>
        
        <tr>
            <td>Naziv:</td> <td><input name="naziv" type="text" size="20"> </td>
        </tr>
        <tr>
             <td><input type="submit" name="dodajKat" value='Dodaj' /> </td><td></td>
        </tr>
    </table>
    
</form>

    </body>
</html>

<?php
if(isset($_POST['dodajKat']))
    {
        $naziv = $_POST['naziv'];
        
        if(empty($naziv))
        {
            echo "<b style='color:red'>Popunite formu!</b></style></br>";
        }
        else{
            if($baza->unesiKategoriju($naziv))
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