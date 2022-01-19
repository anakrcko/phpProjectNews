<?php
    require_once 'baza.php';
    $baza = new bazaDB();
?>

<html>
    <head>
        <link rel="stylesheet" href="stil.css">
    <head>
    <body>
    <div class='login'>
<form action="register.php" method="post">
    <table>
        <tr>
            <td>Ime:</td>
            <td><input type="text" name="ime"/></td>
        </tr>
        <tr>
            <td>Prezime:</td>
            <td><input type="text" name="prezime"/></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="email"/></td>
        </tr>
        <tr>
            <td>Sifra:</td>
            <td>
                <input type="password" name="password"/>
            </td>
        </tr>
        <tr>
            <td>Ponovi sifru:</td>
            <td>
                <input type="password" name="password2"/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="registerPosalji" value="Register"/></td>
        </tr>
        </table>
        </br></br>
        <table>
        <tr>
            <td>Imate nalog?</td>
            <td><a href='login.php'>Prijavite se.</a></td>
        </tr>
    </table></br>
</form>


<?php
    if(isset($_POST['registerPosalji']))
    {
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email = $_POST['email'];
        $sifra = $_POST['password'];
        $sifra2 = $_POST['password2'];
        
        if(empty($ime) || empty($prezime) || empty($email) || empty($sifra2) ||empty($sifra) )
        {
            echo "<b style='color:red'>Popunite formu!</b><br><br>";
        }
        else
        {
            if($sifra != $sifra2)
            {
                echo "<b style='color:red'>Sifre nisu jednake!</b><br><br>";
            }
            else
            {
                if($baza->kreirajKorisnika($ime,$prezime,$email,$sifra))
                {
                    echo "Uspesna registracija!<br><a href='login.php'>Idi na login.</a><br>";
                }
                else
                {
                    echo "Registracija nije uspela, pokusajte ponovo.";
                }
            }
        }
    }
    
    ?>
    </div>
</body>
</html>