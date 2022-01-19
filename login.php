<?php
    require_once 'baza.php';
    $baza = new bazaDB();
?>

<html>
    <head>
        <link rel="stylesheet" href="stil.css">
    <head>
    <body>
<form action="login.php" method="post">
    <div class='login'>
<!--        <p>Prijavite se</p>-->
    <table>
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
            <td></td>
            <td><input type="submit" name="loginPosalji" value="Log in"/></td>
        </tr>
        </table>
        </br></br>
        <table>
        <tr>
            <td>Nemate nalog?</td>
            <td><a href='register.php'>Kreirajte ga.</a></td>
        </tr>
    </table></br>
</form>

<?php

    if(isset($_POST['loginPosalji']))
    {
        $email = $_POST['email'];
        $sifra = $_POST['password'];
        
        if(empty($email) ||empty($sifra) )
        {
            echo "<b style='color:red'>Popunite formu!</b><br><br>";
        }
        else
        {
            $korisnik = $baza->vratiKorisnika($email, $sifra);
            if(isset($_COOKIE['user']) && $_COOKIE['user']!=$korisnik['id'])
            {
                setcookie("user",null, mktime()-3600);
                setcookie("rola",null, mktime()-3600);

                setcookie("user",$korisnik['id'], time()+(86400*2));
                setcookie("rola",$korisnik['rola'], time()+(86400*2));
            }
            else if(!isset($_COOKIE['user'])){
                setcookie("user",$korisnik['id'], time()+(86400*2));
                setcookie("rola",$korisnik['rola'], time()+(86400*2));
            }

            session_start();
            
            if($korisnik)
            {
                header("Location: prikaz.php");
            }
            else
            {
                echo "<b style='color:red'>Netacna kombinacija email-a i sifre.</b><br><br>";
            }
        }
    }
?>

</div>
    </body>
</html>